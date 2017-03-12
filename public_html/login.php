<?php
$title = "Travel : Login";
require 'head.php';
require_once 'config.php';
session_start();

?>

<h1>Login Page</h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<main>
	<P>To Login Please Enter Your Credentials Below...</P>
	
	<form action="login.php" method="POST"> 	 
		 <table style="width:500px">
	 
		  <tr>
				<td><label for="myinput">E-mail Address :</label></td>
				<td><input type="email"  name="email" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Password :</label> </td>
				<td><input type="password"  name="password" required  /></td>
		  </tr>		  		  
		</table> <br>
		<input type="submit" value="Submit" name="submit" /> 	 
	</form>
</main>

<?php
if ((isset($_POST['email']) && $_POST['password'])){
		//prepare statement	
	$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
	//prepare statement entry data
	$criteria = [
	 'email' => $_POST['email'],
	];
	//executes the prepare statement
	$stmt->execute($criteria);

	$user = $stmt->fetch();

	if (password_verify($_POST['password'], $user['password'])) {
	 $_SESSION['loggedin'] = $user['id'];
	  header('Location: index.php');  
	}
	else {//if not logged this will be displayed
	 echo '<p>Sorry, your account could not be found...Please Try Again</p>';
	}
}

require 'footer.php';//footer information
?>