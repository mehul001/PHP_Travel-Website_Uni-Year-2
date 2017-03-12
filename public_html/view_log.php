<?php
$title = 'Travel : Log';//Heading of page
require 'head.php';// requires header information
require_once 'config.php';//settings file for database
session_start();
$results = $pdo->query('SELECT * FROM edit');
function autoload($name) {//autoloaders to load objects/classes
 require strtolower($name) . '.php';
}

spl_autoload_register('autoload');   

$tableGenerator = new TableGenerator();
$tableGenerator->setHeadings(['Edit Date', 'Edit Type', 'Description', 'User ID', 'Name']);
//using the tableGenerator
?>

<h1>Log History</h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

?>		

<main>
	<p>Here below are the logs for when which activity was taken place on the system. The logs are ordered by the most recent activity</p>
	<?php
		$results = $pdo->query('SELECT e.edit_datetime, e.edit_type, e.edit_desc, e.author_id, u.name
								FROM edit e
								JOIN users u
								on e.author_id = u.id
								ORDER BY edit_id desc;');	
		foreach ($results as $row) {				
			$log_1 = new Log($row['edit_datetime'], $row['edit_type'], $row['edit_desc'], $row['author_id'],
			$row['name'] );	
			$log_info = array ($log_1->getDate(), $log_1->getType(), $log_1->getDesc(), $log_1->getId(), $log_1->getName());	
			$tableGenerator->addRow($log_info);	 		 
		}
		echo $tableGenerator->getHTML();	//using the tableGenerator	
		 ?>
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
	
require 'footer.php';//footer information
?>