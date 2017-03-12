<?php 
session_start();
require 'config.php';
$title = 'Travel : Apply For A Job ';//Heading of page
require 'head.php';// requires header information


$results = $pdo->query('SELECT * FROM jobs');

echo'<h1>Apply For Job</h1>';
 require 'nav_bar.php';
?>

<main>
<p>Please fill in the details below to apply for your desired job...</p>

<form action="apply.php" method="POST" enctype="multipart/form-data"> 	 
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
			</tr>
			
		  <tr>
				<td><label for="myinput">Firstname :</label></td>
				<td><input type="text"  name="firstname" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Surname :</label> </td>
				<td><input type="text"  name="surname" required  /></td>
		  </tr>		  
		   <tr>
				<td> <label for="myinput">Address :</label></td>
				<td><input type="text" name="address" required  /></td>
		  </tr>
		  
		   <tr>
				<td> <label for="myinput">Phone Number: </label> </td>
				<td><input type="text" name="phonenumber" required  /></textarea></td>
		  </tr>
		  
		  <tr>
				<td> <label for="myinput">Email: </label> </td>
				<td><input type="email" name="email" required  /></textarea></td>
		  </tr>
		  
		  <tr>
				<td> <label for="myinput">Cover Letter: </label> </td>
				<td><textarea name="cover" required /></textarea></td>
		  </tr>		  
		 
		  <tr>
			<td><label for="myinput">Upload CV </label></td>
			<td><input type="file" name="upload_file" required ></td>
		  </tr> 
		</table> <br>
	<input type="submit" value="Submit" name="submit" /> 	 
	</form>
</main>



<?php

if ((isset($_POST['job']) && $_POST['firstname'] && $_POST['surname'] && $_POST['address'] && $_POST['phonenumber'] && $_POST['email'] && $_POST['cover'])) {
	$stmt = $pdo->prepare('INSERT INTO applications VALUES(DEFAULT, :app_job, :app_firstname, :app_surname, :app_address, :app_phonenumber, :app_email, :app_cover)
	');

		$criteria = [	
				'app_job' => $_POST['job'],
				'app_firstname' => $_POST['firstname'],
				'app_surname' => $_POST['surname'],
				'app_address' => $_POST['address'],
				'app_phonenumber' => $_POST['phonenumber'],
				'app_email' => $_POST['email'],
				'app_cover' => $_POST['cover']
		];

	$stmt ->execute ($criteria);
	header('Location: temp.php'); 
}

if (isset($_POST['submit'])){
	/* http://www.codingcage.com/2014/12/file-upload-and-view-with-php-and-mysql.html
	Here is the website the developer used to complete this feature of the website.
	On this website it shows how to upload files to a server and also how to download them
	from a HTML/PHP platform without the need to go file explorer on the server to find the file	
	*/
	$file = $_POST['firstname']."_".$_POST['surname']."-".$_FILES['upload_file']['name'];
    $file_loc = $_FILES['upload_file']['tmp_name'];
	 $file_size = $_FILES['upload_file']['size'];
	 $file_type = $_FILES['upload_file']['type'];
	 $folder="uploads/";
	 
	 move_uploaded_file($file_loc,$folder.$file);
	 //prepare statement	
	 $file_upload = $pdo->prepare('INSERT INTO uploads(file,type,size) VALUES(:file, :file_type, :file_size)
	');
	//prepare statement entry data
	 $criteria2 = [	
				'file' => $file,
				'file_type' => $file_type,
				'file_size' => $file_size
		];

	$file_upload ->execute ($criteria2);//executes the prepare statement
	 
}

require 'footer.php';//footer information
?>











