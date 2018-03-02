<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

function createUser($fname, $username, $password, $email, $userlvl) {
	include('connect.php');

	$userString = "INSERT INTO tbl_user VALUES(NULL, '{$fname}', '{$username}','{$password}', '{$email}', NULL, '{$userlvl}', NULL, 0, 0, NOW())"; //NOW() gives me the time the user was created
	//echo $userString;
	$userQuery = mysqli_query($link, $userString);
	if($userQuery) {
		$createEmail = sendEmail($fname, $username, $password, $email);
		redirect_to("admin_index.php");
	} else {
		$message = "Sorry, there was a problem setting up that user. Please try again.";
		return $message;
	}

	mysqli_close($link);
}

function genPassword( $length = 10 ) {
	$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890,.?:;!@#$%^&*-_/";
	$password = substr( str_shuffle( $characters ), 0, $length );
	echo $password;
}

function sendEmail($fname, $username, $password, $email) {
	include('connect.php');
	$to = $email;
	$subj = "Movie Review App Login Information";
	$msg = "Hi there, ".$fname."\n\n A new account was made for you on the Movie Review App. Here are your credentials:\n\n Username: ".$username."\n\n Password: ".$password."\n\n Please login and change your password at: admin_index.php. Thanks for joining!";
	//echo $msg;
	mail($to, $subj, $msg);
	// $direct = $direct."?name={$name}";
	redirect_to("admin_index.php");

	mysqli_close($link);
}

function editUser($id, $fname, $username, $password, $email) {
	include('connect.php');

	$updatestring = "UPDATE tbl_user SET user_fname = '{$fname}', user_name = '{$username}', user_pass = '{$password}', user_email = '{$email}' WHERE user_id = {$id}";
	//echo $updatestring;
	$updatequery = mysqli_query($link, $updatestring);
	if($updatequery){
		$_SESSION['user_fname'] = $fname;
		redirect_to("admin_index.php");
	} else {
		$message = "There was a problem changing your information, please contact your web admin.";
		return $message;
	}

	mysqli_close($link);
}

function deleteUser($id) {
	//echo $id;
	include('connect.php');

	$delstring = "DELETE FROM tbl_user WHERE user_id={$id}";
	$delquery = mysqli_query($link, $delstring);
	if($delquery) {
		redirect_to("../admin_index.php");
	} else {
		$message = "Sorry, there was an error.";
		return $message;
	}

	mysqli_close($link);
}





 ?>
