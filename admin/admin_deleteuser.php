<?php
//mac error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('phpscripts/config.php');
confirm_logged_in();

$tbl = "tbl_user";
$users = getAll($tbl);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,600%7CRoboto:300,400" rel="stylesheet">
	<link rel="stylesheet" href="css/main.css">
	<title>Movie Review App - Delete User</title>
</head>
<body class="userBack">

	<header>
    <p class="navBut">Hi <?php echo $_SESSION['user_name']; ?></p> <!-- This shows the username when you log in -->
		<a href="admin_index.php" class="navBut">Dashboard</a>
		<a href="phpscripts/caller.php?caller_id=logout" class="navBut">Sign Out</a>
  </header>

	<h1>Welcome to the Movie Review App</h1>

	<div id="deleteCon">
		<?php
			while($row = mysqli_fetch_array($users)) {
				echo "<div class=\"deleteUser\"><p>{$row['user_fname']}</p><a href=\"phpscripts/caller.php?caller_id=delete&id={$row['user_id']}\">Delete User</a><br></div>";
			}
		 ?>
 	</div>

</body>
</html>
