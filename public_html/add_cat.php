<?php
$title = 'Travel : Add Category '; //Heading of page
require 'head.php';// requires header information
require 'config.php';//settings file for database
session_start();
$results = $pdo->query('SELECT * FROM categories');

?>
<h1>Travel - Add Category </h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>


<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>	
<main>
	<P>To create a category please fill out the form below</P>
	
	<form action="add_cat.php" method="POST"> 		
			<table style="width:500px">
				<tr>
					<td><label for="myinput">Category Name:</label></td>
					<td><input type="text"  name="name1" required  /></td>
				</tr>
				<tr>
					<td><label for="myinput">Description: </label></td>
					<td><textarea name="mytextarea" required/></textarea></td>
				</tr>	
			</table><br>
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

if ((isset($_POST['name1']) && $_POST['mytextarea'])) {
	//prepare statement	
	$stmt = $pdo->prepare('INSERT INTO categories VALUES(DEFAULT, :catName, :catDescription)
	');
//prepare statement entry data
	$criteria = [
			'catName' => $_POST['name1'],
			'catDescription' => $_POST['mytextarea']
	];

	$stmt ->execute ($criteria);//executes the prepare statement
	
	$id_user = $_SESSION['loggedin'];
	$type_info = 'CREATE';
	$description = 'A New Category Was Added - ' . $_POST['name1'];
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
