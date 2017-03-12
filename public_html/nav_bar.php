<div class="nav1">
  <ul>
	<li><a href="index.php">Home</a></li>
	<li><a href="">Categories</a>
	  <ul>
		<li><a href="display_c.php">Display Categories</a></li>
			<?php 
			if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
					echo '<li><a href="add_cat.php">Add Category</a></li>';
			}
		?>         
	  </ul>
	</li>
	
	<li><a href="">Jobs</a>
	  <ul>
		<li><a href="display.php">Display Jobs</a></li>
		<li><a href="apply.php">Apply For A Job</a></li>
			<?php 
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
						echo '<li><a href="add_job.php">Add Job</a></li>';
						
							
				}
			?>
	  </ul>
	</li>
		<?php 
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		echo '<li><a href="">Admin Area</a>
	  <ul>
		<li><a href="signup.php">Create Admin</a></li>';
		echo '<li><a href="view_app.php">View Applications</a></li>';
		echo '<li><a href="add_cat.php">Add Category</a></li>';
		echo '<li><a href="add_job.php">Add Job</a></li>';
		echo '<li><a href="view_log.php">View Log</a></li>';
		echo '<li><a href="view_files.php">View CV Files</a></li>';
		
		echo '</ul>';
				}
				
			?>
	  
	</li>
	<li><?php 
			if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
				echo'<li><form action="logout.php" method="POST" >
				<input type="submit" name="submit" value="Logout" style="width: 130px; height: 40px; ">
					</form></li>';
				} else {
					echo '<li><a href="login.php">Login</a></li>';
				};
		?> 
	</li>
		
	
	
		
  </ul>
</div>