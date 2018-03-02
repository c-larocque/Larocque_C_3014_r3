<?php
//mac error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once('phpscripts/config.php');
confirm_logged_in();

$id = $_SESSION['user_id'];
//echo $id;
$tbl = "tbl_user";
$col = "user_id";
$popForm = getSingle($tbl, $col, $id);
$found_user = mysqli_fetch_array($popForm, MYSQLI_ASSOC);
//echo $found_user['user_name']; doesn't work if it's just $found_user

if(isset($_POST['submit'])) {
	$fname = trim($_POST['fname']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$email = trim($_POST['email']);
	$result = editUser($id, $fname, $username, $password, $email);
	$message = $result;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,600%7CRoboto:300,400" rel="stylesheet">
<link rel="stylesheet" href="css/main.css">
	<title>Movie Review App - Edit User Account</title>
</head>
<body class="userBack">

	<header>
    <p class="navBut">Hi <?php echo $_SESSION['user_name']; ?></p> <!-- This shows the username when you log in -->
		<a href="admin_index.php" class="navBut">Dashboard</a>
		<a href="phpscripts/caller.php?caller_id=logout" class="navBut">Sign Out</a>
  </header>

	<h1>Welcome to the Movie Review App</h1>

	<?php if(!empty($message)) {echo $message;} ?>

	<form action="admin_edituser.php" method="post" class="form">
		<h2>Edit Your Account</h2>
		<label>First Name: </label>
		<input type="text" name="fname" value="<?php echo $found_user['user_fname']; ?>" ><br>

		<label>Username: </label>
		<input type="text" name="username" value="<?php echo $found_user['user_name']; ?>"><br>

		<label>Password: </label>
		<input type="text" name="password" value="<?php echo $found_user['user_pass']; ?>"><br>

		<label>Email: </label>
		<input type="text" name="email" value="<?php echo $found_user['user_email']; ?>"><br>

		<input type="submit" name="submit" value="Submit Changes" class="submitButton"><br>

	</form>




</body>
</html>
