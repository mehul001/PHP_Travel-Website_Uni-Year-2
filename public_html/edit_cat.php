<?php
$title = 'Travel : Edit Category ';
require 'head.php';
require 'config.php';
session_start();
$results = $pdo->query('SELECT * FROM categories WHERE cat_id = "'.$_SESSION['edit_id_post'].'"');
$edit = $_SESSION['edit_id_post'];
//echo $_SESSION['loggedin'];
?>
<h1>Travel - Edit Category </h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>	
	
<main>
	<P>Please Make Your Changes Below</P>
	
	<form action="edit_cat.php" method="POST"> 		
			<table style="width:500px">
				<tr>
					<td><label for="myinput">Category Name:</label></td>
					<?php 
					foreach ($results as $row) {
					echo '<td><input type="text"  name="name1" value="'.$row['cat_name'].'" required  /></td>'; 
					}//'. $row['cat_desc'] .'
					?>
				</tr>
				<tr>
					<td><label for="myinput">Description: </label></td>
					
					<?php
					//foreach ($results as $row) {
					echo '<td><textarea name="mytextarea" required/>'. $row['cat_desc'] .'</textarea></td>';
					//}
					?>
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
	$stmt = $pdo->prepare('UPDATE categories SET cat_name=:catName, cat_desc=:catDescription WHERE cat_id = "'.$edit.'"
	');
//prepare statement entry data
	$criteria = [
			'catName' => $_POST['name1'],
			'catDescription' => $_POST['mytextarea']
	];
//executes the prepare statement
	$stmt ->execute ($criteria);
	
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
	
	$_SESSION['edit_id_post'] = 0;
	header('Location: temp.php'); //redirection
} 

require 'footer.php';//footer information
?>