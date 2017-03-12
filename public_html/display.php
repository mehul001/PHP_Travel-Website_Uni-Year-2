<?php
$title = 'Travel : Browse Jobs';//Heading of page
require 'head.php';// requires header information
require_once 'config.php';
session_start();
$results = $pdo->query('SELECT * FROM categories');

function autoload($name) {//autoloaders to load objects/classes
 require strtolower($name) . '.php';
}

spl_autoload_register('autoload');   

$tableGenerator = new TableGenerator(); //applicant view
$tableGenerator2 = new TableGenerator(); //admin view

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
$tableGenerator2->setHeadings(['Job Title', 'Salary', 'Category Name', 'Description', 'Edit/Delete']);
} else {
	$tableGenerator->setHeadings(['Job Title', 'Salary', 'Category Name', 'Description']); //using the tableGenerator
}
?>

<h1>Browse Jobs  </h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<main>
	<p>Search jobs by category or by keyword</p>
	<br>
	<form action="display.php" method="POST"> 
		<table style="width:1000px">
			<tr>
				<td> <label for="myinput">Category :</label> </td>
				<td>				
					<select  name="category"required > 
					<option value = "">Please Select...</option>
					<?php foreach ($results as $row) {
						 echo '<option value="'.$row['cat_id'].'">' . $row['cat_name'] .  '</option>';
						} ?>
					</select>
				</td>
				<td>
				<input type="submit" name="submit" value="Search" style="width: 70px; height: 40px; ">
				</td>  		
	</form>
	
	<form action="display.php" method="POST"> 		
				<td> <label for="myinput">Keyword Search :</label> </td>
				<td>				
					<input type="text" id="myinput" name="search" />
				</td>
				<td>
				<input type="submit" name="submit" value="Search" style="width: 70px; height: 40px; ">
				</td>
			</tr>		  
		</table>
	</form>	
	
	<?php
	
	if (isset ($_GET['edit_id'])){
		$_SESSION['edit_id_post'] = $_GET['edit_id'];
		//echo $_SESSION['edit_id_post'];
		header("Refresh: 0;url=edit_job.php");
}

if(isset($_GET['id'])){
			$_SESSION['delete_j_id_post'] = $_GET['id'];
			header("Refresh: 0;url=delete_j.php");
		}
	
	if (isset($_POST['category'])) {
		$id = $_POST['category'];
		$results_j = $pdo->query('SELECT j.refrence_code, j.title, j.salary, j.decription, c.cat_name
							FROM jobs j
							JOIN categories c
							on j.category_id = c.cat_id
							WHERE j.category_id = "'.$id.'";');
	foreach ($results_j as $row) {
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {	//if logged in			
				$job_1 = new Job_Admin($row['title'], '&pound'.$row['salary'], $row['cat_name'], $row['decription'], 
				'<a href="?id= '.$row['refrence_code'].'">Delete</a>/<a href="?edit_id= '.$row['refrence_code'].'">Edit</a>' );
				$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc(), $job_1->getLink());
					$tableGenerator2->addRow($job_info);//using the tableGenerator
				} else {	//if not logged this will be displayed				
					$job_1 = new Job($row['title'], $row['salary'], $row['cat_name'], $row['decription']);//job object
					$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc());
					$tableGenerator->addRow($job_info);//using the tableGenerator
				}
			}
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
				 echo $tableGenerator2->getHTML(); } else {echo $tableGenerator->getHTML();}//using the tableGenerator
	} else if (isset ($_POST['search'])){
		$search = $_POST['search'];
		$results = $pdo->prepare('SELECT j.refrence_code, j.title, j.salary, j.decription, c.cat_name 
								FROM jobs j
								JOIN categories c
								on j.category_id = c.cat_id
								WHERE title LIKE "%" :search "%"');
		$criteria = [
		'search' => $search
		];

		$results ->execute ($criteria);	
								
			foreach ($results as $row) {
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {	//if logged in			
				$job_1 = new Job_Admin($row['title'], $row['salary'], $row['cat_name'], $row['decription'], 
				'<a href="?id= '.$row['refrence_code'].'">Delete</a>/<a href="?edit_id= '.$row['refrence_code'].'">Edit</a>' );
				$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc(), $job_1->getLink());
					$tableGenerator2->addRow($job_info);
				} else {		//if not logged this will be displayed			
					$job_1 = new Job($row['title'], $row['salary'], $row['cat_name'], $row['decription']);
					$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc());
					$tableGenerator->addRow($job_info);
				}
			}
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
				 echo $tableGenerator2->getHTML(); } else {echo $tableGenerator->getHTML();}
		} else{
		echo'<P>All current jobs are displayed below...</P><br>';
		$results = $pdo->query('SELECT j.refrence_code, j.title, j.salary, j.decription, c.cat_name
								FROM jobs j
								JOIN categories c
								on j.category_id = c.cat_id;');
			foreach ($results as $row) {
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {	//if logged in			
				$job_1 = new Job_Admin($row['title'], $row['salary'], $row['cat_name'], $row['decription'], 
				'<a href="?id= '.$row['refrence_code'].'">Delete</a>/<a href="?edit_id= '.$row['refrence_code'].'">Edit</a>' );
				$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc(), $job_1->getLink());
					$tableGenerator2->addRow($job_info);
				} else {		//if not logged this will be displayed			
					$job_1 = new Job($row['title'], $row['salary'], $row['cat_name'], $row['decription']);
					$job_info = array($job_1->getTitle(), $job_1->getSalary(), $job_1->getCat(), $job_1->getDesc());
					$tableGenerator->addRow($job_info);
				}
			}
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
				 echo $tableGenerator2->getHTML(); } else {echo $tableGenerator->getHTML();}	
	}	
	?>
</main>

<?php
if (isset ($_GET['edit_id'])){
		$_SESSION['edit_id_post'] = $_GET['edit_id'];
		header("Refresh: 0;url=edit_job.php");//redirection
}

if(isset($_GET['id'])){
			$_SESSION['delete_j_id_post'] = $_GET['id'];
			header("Refresh: 0;url=delete_j.php");//redirection
		}
		
		
require 'footer.php';//footer information
?>