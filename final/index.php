<?php

session_start();
if(!isset($_SESSION['currentUser'])){
        header('Location: login.php');
    }
?>
<html>
        <body align="center";>
		<head>Welcome to the best discussion Forum. Stay Sexy!</head>
		<div style="width:800px; margin:0 auto;" style="background-color: white;"> 
			<div align="center">
			<form action="login.php" method="post">
				<div class="form-group is-empty"><input type="text" name="login_username" class="form-control" placeholder="Username"></div>
				<div class="form-group is-empty"><input type="text" name="login_pass" class="form-control" placeholder="Password"></div>
				<input type="submit" value="Login">
			</form> 
			</div>
			<small>No account? <a href="register.php">Register</a></small>
		</div>
		</body>

        <?php 
		header("Location: index.html");
        if(	isset($_SESSION['errorAdminFolder']) && !empty($_SESSION['errorAdminFolder'])){
			
			echo '<font color="red">'.$_SESSION['errorAdminFolder'].'</font>';
			unset($_SESSION['errorAdminFolder']);

		}
		elseif (isset($_SESSION['errorModeratorFolder']) && !empty($_SESSION['errorModeratorFolder'])) {

			echo '<font color="red">'.$_SESSION['errorModeratorFolder'].'</font>';
			unset($_SESSION['errorModeratorFolder']);
		}

        ?>
</html>
