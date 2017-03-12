<?php
$title = 'Travel : Edit Job';//Heading of page
require 'head.php';// requires header information
require_once 'config.php';//settings file for database
session_start();
$edit = $_SESSION['edit_id_post'];
$results_c = $pdo->query('SELECT * FROM categories');
$results = $pdo->query('SELECT * FROM jobs WHERE refrence_code = "'.$edit.'"');
foreach ($results as $row){};
?>

<h1>Travel - Add Job </h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>
	
<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>		

<main>

	<P>To create a job please fill out the form below</P>	
	
	<form action="edit_job.php" method="POST"> 	 
		 <table style="width:500px">
	 
		  <tr>
				<td><label for="myinput">Title Of Job:</label></td>
				<?php
					echo '<td><input type="text"  name="title" value="'.$row['title'].'" required  /></td>';
				?>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Salary :</label> </td>
				
				<?php
					echo '<td><input type="text"  name="salary" value="'.$row['salary'].'" required  /></td>';
				?>
		  </tr>		  
		   <tr>
				<td> <label for="myinput">Location :</label></td>
				<?php
					echo '<td><input type="text"  name="location" value="'.$row['location'].'" required  /></td>';
				?>
		  </tr>
		  
		   <tr>
				<td> <label for="myinput">Description: </label> </td>
				<?php
				echo '<td><textarea name="mytextarea" required/>'. $row['decription'] .'</textarea></td>';
				?>
		  </tr>
		  
			<tr>
				<td> <label for="myinput">Category :</label> </td>
				<td>
				
				<select  name="category"required > 
					<option value = "">Please Select...</option>
					<?php foreach ($results_c as $row) {
						 echo '<option value="'.$row['cat_id'].'">' . $row['cat_name'] .  ' </option>';
						}
						?>
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
header("Refresh: 2;url=index.php");	
}

if ((isset($_POST['title']) && $_POST['salary'] && $_POST['location'] && $_POST['mytextarea'] && $_POST['category'])) {
	$stmt = $pdo->prepare('UPDATE jobs SET title=:jobTitle, salary=:jobSalary, location=:jobLocation, decription=:jobDescription, category_id=:jobCategory
		WHERE refrence_code ="'.$edit.'"
	');

$criteria = [	
				'jobTitle' => $_POST['title'],
				'jobSalary' => $_POST['salary'],
				'jobLocation' => $_POST['location'],
				'jobDescription' => $_POST['mytextarea'],
				'jobCategory' => $_POST['category']
		];

$stmt ->execute ($criteria);
$_SESSION['edit_id_post'] = 0;	

$id_user = $_SESSION['loggedin'];
	$type_info = 'UPDATE';
	$description = 'A Category Was Updated';
		//prepare statement	
	$entry = $pdo->prepare('INSERT INTO edit VALUES(DEFAULT, :date, :type, :desc, :author)');
	//prepare statement entry data
	$criteria_1 = [	
				'date' => date("d-m-Y"),
				'type' => $type_info,
				'desc' => $description,
				'author' => $id_user
		];
	//executes the prepare statement
	$entry ->execute ($criteria_1);
header('Location: temp.php'); 	//redirection
}	

require 'footer.php';//footer information
?>