<?php
$title = 'Travel : Homepage';
require 'head.php';
require_once 'config.php';
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {


$results = $pdo->query('SELECT * FROM users WHERE id = "'.$_SESSION['loggedin'].'"');
	foreach ($results as $row) {
					$name = 'Welcome Back '. $row['name'] . ' ' . $row['surname'];
	} 
}
else $name = 'Welcome To The Website';
?>

	<h1>Travel - Homepage</h1>
	
	<?php require 'nav_bar.php'; /*Navigation bar */ ?>
	
	<main>	
		<p>
		 <?php echo $name; ?>
		</p>		
	</main>

<?php
require 'footer.php';
?>