<?php
$title = 'Travel : Delete Category'; //Heading of page
require 'head.php';// requires header information
require_once 'config.php';//settings file for database
session_start();
echo '<h1>Travel - Delete Category</h1>';
	function autoload($name) { //autoloaders to load objects/classes
 require strtolower($name) . '.php';
}

spl_autoload_register('autoload');   

$tableGenerator = new TableGenerator(); //category table
$tableGenerator->setHeadings(['Category Name', 'Category Description']);

$tableGenerator2 = new TableGenerator();//job table
$tableGenerator2->setHeadings(['Job Title', 'Salary', 'Category Name', 'Description']);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
$delete_id = $_SESSION['delete_id_post'];
$results = $pdo->query('SELECT * FROM categories WHERE cat_id = "'.$delete_id.'"');
$results_j = $pdo->query('SELECT j.refrence_code, j.title, j.salary, j.decription, c.cat_name
							FROM jobs j
							JOIN categories c
							on j.category_id = c.cat_id
							WHERE j.category_id = "'.$delete_id.'";');

 require 'nav_bar.php'; /*Navigation bar */ 

	echo'
	<main>
		<p>Are You Sure You Want To <b>DELETE</b> This Category? <br> Warning This Will Also <b>DELETE ALL JOBS</b> Associated Within This Category</p>';			 
				foreach ($results as $row) {//categories to be displayed here
				$cat_1 = new Category($row['cat_name'], $row['cat_desc']);	
					$name = $row['cat_name'];
					$cat_info = array($cat_1->getName(), $cat_1->getDesc());
					$tableGenerator->addRow($cat_info);	//using the tableGenerator
				}//for loop ends here
				echo $tableGenerator->getHTML();//using the tableGenerator
		
		echo '<p>Here Are The Jobs Associated Within The Category Displayed Above :</p>';
		
		foreach ($results_j as $row) {	
		$job_1 = new Job($row['title'], $row['salary'], $row['cat_name'], $row['decription']);
		$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc());
			$tableGenerator2->addRow($job_info);		//using the tableGenerator
		}
		echo $tableGenerator2->getHTML();//using the tableGenerator
		
	echo'	<form action="delete_c.php" method="POST" >
		<input type="submit" name="submit" value="DELETE" style="width: 130px; height: 40px; ">
		</form>	
	</main>';

	if (isset($_POST['submit'])) {
		$results = $pdo->query('DELETE FROM categories WHERE cat_id = "'.$delete_id.'"');
		$results = $pdo->query('DELETE FROM jobs WHERE category_id = "'.$delete_id.'"');
		
	$id_user = $_SESSION['loggedin'];
	$type_info = 'DELETE';
	$description = 'A Category Was Deleted - ' . $name;
	//prepare statement	
	$entry = $pdo->prepare('INSERT INTO edit VALUES(DEFAULT, :date, :type, :desc, :author)');
	//prepare statement entry data
	$criteria_1 = [	
				'date' => date("d-m-Y"),
				'type' => $type_info,
				'desc' => $description,
				'author' => $id_user
		];

	$entry ->execute ($criteria_1);//executes the prepare statement

		header('Location: temp.php');   
	}
	
} else {//if not logged this will be displayed
	echo '
	<main>
		<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>
		
	</main>
	';
header("Refresh: 2;url=index.php");	//redirection to homepage
}

require 'footer.php';//footer information
?>