<?php
$title = "Travel : Sign Up";//Heading of page
require 'head.php';// requires header information
require_once 'config.php';//settings file for database
session_start();
?>

<h1>Sign Up</h1>

<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<main>
	<P>Please Fill Out the Fields Below To Add an Admin User</P>
	
	<form action="signup.php" method="POST"> 	 
		<table style="width:500px">
			<tr>
				<td><label for="myinput">Firstname :</label> </td>
				<td><input type="text"  name="name" required  /></td>
		  </tr>
			<tr>
				<td><label for="myinput">Surname :</label> </td>
				<td><input type="text"  name="surname" required  /></td>
		  </tr>	
		    <tr>
				<td><label for="myinput">E-mail Address :</label></td>
				<td><input type="email"  name="email" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Password :</label> </td>
				<td><input type="password"  name="password" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Password Confirmation :</label> </td>
				<td><input type="password"  name="password_c" required  /></td>
		  </tr>	 
		   		  
		</table> <br>
	<input type="submit" value="Submit" name="submit" /> 	 
	</form>
</main>

<?php
} else {
	echo '
	<main>
		<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>
		
	</main>
	';
header("Refresh: 2;url=index.php");	
}

if ((isset($_POST['name']) && $_POST['surname'] && $_POST['email'] && $_POST['password']) && $_POST['password_c']) {
	//prepare statement	
	$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
	//prepare statement entry data
	$criteria = [
	 'email' => $_POST['email']
	];
	//executes the prepare statement
	$stmt->execute($criteria);

	if ($stmt->rowCount() <= 0) {

		if ($_POST['password'] == $_POST['password_c']){	
		//prepare statement	
			$stmt = $pdo->prepare('INSERT INTO users VALUES(DEFAULT, :email, :password, :name, :surname)
			');
			
			$password = $_POST['password'];
			$hash = password_hash($password, PASSWORD_DEFAULT);
		//prepare statement entry data
			$criteria = [
					'name' => $_POST['name'],
					'surname' => $_POST['surname'],
					'email' => $_POST['email'],
					'password' => $hash
			];
			//executes the prepare statement
			$stmt ->execute ($criteria);
			header('Location: temp.php'); 	
		} else {
			echo '<p>ERROR: Passwords Don\'t Match <br> Account Was NOT Created... Please Try Again</p>';
			}
	}else {
			echo '<p>ERROR: E-mail Address Already In Use<br> Account Was NOT Created... Please Try Again</p>';
			//header('Location: signup.php'); 
			}
}
require 'footer.php';
?>