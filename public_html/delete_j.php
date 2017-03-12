<?php
$title = 'Travel : Delete Category';//Heading of page
require 'head.php';// requires header information
require_once 'config.php';
session_start();
echo '<h1>Travel - Delete Job</h1>';

	function autoload($name) {//autoloaders to load objects/classes
 require strtolower($name) . '.php';
}

spl_autoload_register('autoload');   
$tableGenerator = new TableGenerator();//job table
$tableGenerator->setHeadings(['Job Title', 'Salary', 'Category Name', 'Description']);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
$delete_j_id = $_SESSION['delete_j_id_post'];

 require 'nav_bar.php'; /*Navigation bar */ 
	echo'
	<main>
		<p>Are You Sure You Want To <b>DELETE</b> This Job?</p>';
		
		$results = $pdo->query('SELECT j.refrence_code, j.title, j.salary, j.decription, c.cat_name
							FROM jobs j
							JOIN categories c
							on j.category_id = c.cat_id
							WHERE refrence_code = "'.$delete_j_id.'";');
							
		foreach ($results as $row) {	
			$job_delete = new Job($row['title'], $row['salary'], $row['cat_name'], $row['decription']);
			$job_info = array($job_delete->getTitle(), $job_delete->getSalary(), $job_delete->getCat(), $job_delete->getDesc());
				$tableGenerator->addRow($job_info);//using the tableGenerator
		}
		echo $tableGenerator->getHTML();//using the tableGenerator
		
	
	echo'	<form action="delete_j.php" method="POST" >
		<input type="submit" name="submit" value="DELETE" style="width: 130px; height: 40px; ">
		</form>	
	</main>';

	if (isset($_POST['submit'])) {
		$results = $pdo->query('DELETE FROM jobs WHERE refrence_code = "'.$delete_j_id.'"');
		
		$id_user = $_SESSION['loggedin'];
	$type_info = 'DELETE';
	$description = 'A Job Was Deleted - '. $name;
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