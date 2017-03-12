<?php
$title = 'Travel : View Applications';//Heading of page
require 'head.php';// requires header information
require_once 'config.php';//settings file for database
session_start();
$results = $pdo->query('SELECT * FROM jobs');

function autoload($name) {//autoloaders to load objects/classes
 require strtolower($name) . '.php';
}

spl_autoload_register('autoload');   

$tableGenerator = new TableGenerator();//app table
$tableGenerator->setHeadings(['First Name', 'Surname', 'Address', 'Phone Number', 'Email Address', 'Cover Letter']);
?>

<h1>View Applications</h1>

<?php require 'nav_bar.php'; /*Navigation bar */ ?>

<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>		

<main>
	<br>
	<form action="view_app.php" method="POST"> 
		<table style="width:500px">
			<tr>
				<td> <label for="myinput">Job :</label> </td>
				<td>				
					<select  name="job"required > 
					<option value = "">Please Select...</option>
					<?php foreach ($results as $row) {
						 echo '<option value="'.$row['refrence_code'].'">' . $row['title'] .  '</option>';
						} ?>
					</select>
				</td>
				<td>
				<input type="submit" name="submit" value="Search" style="width: 70px; height: 40px; ">
				</td>
			</tr>		  
		</table>
	</form>	
	
	<?php
	
	if (isset($_POST['job'])) {
		$id = $_POST['job'];
		$results_j = $pdo->query('SELECT * from applications WHERE job_id = "'.$id.'";');
		
	echo'<P>All applications made for your chosen job are displayed below</P> <br>';	
		foreach ($results_j as $row) {			
		$app = new Application($row['name'],$row['surname'],$row['address'],$row['phone_number'],$row['email'],$row['cover_letter']);
		$app_info = array($app->getName(), $app->getSurname(), $app->getAddress(), $app->getNumber(), $app->getEmail(), $app->getCover());
 
		 $tableGenerator->addRow($app_info);	 		 
		}
	echo $tableGenerator->getHTML();
	} else {
	echo'<P>Please select a job to view all applications...</P><br>';
	}
	?>
</main>

<?php
} else {
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