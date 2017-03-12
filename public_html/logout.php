<?php
session_start();
$title = 'Travel : Logout';
require('head.php');
echo '<h1>Travel - Logout</h1>';
unset($_SESSION['loggedin']);

echo '<main>
			<p>You Have Been Successfully Logged Out... You will Shortly Be Redirected To The Homepage... </p>
		</main>';

header("Refresh: 2;url=index.php");
require('footer.php');
?>