<?php
require 'config.php';//settings file for database
session_start();
$title = 'Travel : View Files';//Heading of page
require 'head.php';// requires header information

function autoload($name) {//autoloaders to load objects/classes
 require strtolower($name) . '.php';
}

spl_autoload_register('autoload');  
$tableGenerator = new TableGenerator();
$tableGenerator->setHeadings(['File Name', 'File Type', 'File Size(KB)', 'Download']); 
?>

<h1>View CV Files</h1>

<?php require 'nav_bar.php'; /*Navigation bar */ 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

?>	
<main>
<p>All files on the system are displayed below. To search for a specific file<br>please 
		enter the applicants name in the search bar below.</p>

	<form action="view_files.php" method="POST"> 
		<table>
			<tr>
				<td> <label for="myinput">Keyword Search :</label> </td>
				<td>				
					<input type="text" id="myinput" name="search" />
				</td>
				<td>
				<input type="submit" name="submit" value="Search" style="width: 70px; height: 40px; ">
				</td>
			</tr>		  
		</table>
	</form>	<br>

<?php

if (isset ($_POST['search'])){
		$search = $_POST['search'];
		$results = $pdo->prepare('SELECT * FROM uploads 
								WHERE file LIKE "%" :search "%"');
		$criteria = [
		'search' => $search
		];

		$results ->execute ($criteria);								

		foreach ($results as $row){	
		$file_1 = new FileView($row['file'], $row['type'], $row['size'], 
			'<a href="uploads/'.$row['file'].'">Download_File</a>');
			
		$file_info = array ($file_1->getName(), $file_1->getType(), $file_1->getSize(), $file_1->getLink());	
			$tableGenerator->addRow($file_info);		
		}
 echo $tableGenerator->getHTML();
echo '</main>';
} else {//if not logged in 
	$results = $pdo->query('SELECT * FROM uploads');								

		foreach ($results as $row){	
		$file_1 = new FileView($row['file'], $row['type'], $row['size'], 
			'<a href="uploads/'.$row['file'].'">Download_File</a>');
		$file_info = array ($file_1->getName(), $file_1->getType(), $file_1->getSize(), $file_1->getLink());	
			$tableGenerator->addRow($file_info);		
		}
 echo $tableGenerator->getHTML();

echo '</main>';

}
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