<?php
$title = 'Travel : Add Job';//Heading of page
require 'head.php';// requires header information
require_once 'config.php';//settings file for database
session_start();
$results = $pdo->query('SELECT * FROM categories');
?>

<h1>Travel - Add Job </h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>		

<main>

	<P>To create a job please fill out the form below</P>	
	
	<form action="add_job.php" method="POST"> 	 
		 <table style="width:500px">
	 
		  <tr>
				<td><label for="myinput">Title Of Job:</label></td>
				<td><input type="text"  name="title" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Salary :</label> </td>
				<td><input type="text"  name="salary" required  /></td>
		  </tr>		  
		   <tr>
				<td> <label for="myinput">Location :</label></td>
				<td><input type="text" name="location" required  /></td>
		  </tr>
		  
		   <tr>
				<td> <label for="myinput">Description: </label> </td>
				<td><textarea name="mytextarea" required /></textarea></td>
		  </tr>
		  
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
			</tr>
		  
		</table> <br>
	<input type="submit" value="Submit" name="submit" /> 	 
	</form>
</main>

<?php
} else {//if not logged this will be displayed
	echo '
	<main>
		<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>
		
	</main>
	';
header("Refresh: 2;url=index.php");	//redirection to homepage
}

if ((isset($_POST['title']) && $_POST['salary'] && $_POST['location'] && $_POST['mytextarea'] && $_POST['category'])) {
	//prepare statement	
	$stmt = $pdo->prepare('INSERT INTO jobs VALUES(DEFAULT, :jobTitle, :jobSalary, :jobLocation, :jobDescription, :jobCategory)
	');
//prepare statement entry data
		$criteria = [	
				'jobTitle' => $_POST['title'],
				'jobSalary' => $_POST['salary'],
				'jobLocation' => $_POST['location'],
				'jobDescription' => $_POST['mytextarea'],
				'jobCategory' => $_POST['category']
		];

	$stmt ->execute ($criteria);//executes the prepare statement
	 
	
	$id_user = $_SESSION['loggedin'];
	$type_info = 'CREATE';
	$description = 'A New Job Was Added';
		
	$id_user = $_SESSION['loggedin'];
	$type_info = 'CREATE';
	$description = 'A New Job Was Added - ' . $_POST['title'] ;
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
	
	header('Location: temp.php'); //redirection
}

require 'footer.php';//footer information
?>