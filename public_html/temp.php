<?php
session_start();
$title = 'Travel : TEMP PAGE';
require 'head.php';
header("Refresh: 2;url=index.php");
//echo $_SESSION['loggedin'];
?>

	<h1>Travel - Thank you</h1><BR>
		<main>
			<p>Your Changes Have Been Applied... You will Shortly Be Redirected To The Homepage... </p>
		</main>

<?php
require 'footer.php';
?>