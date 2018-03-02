<?php
 function logIn($username, $password, $ip) {
 	require_once('connect.php');
 	$username = mysqli_real_escape_string($link, $username);
 	$password = mysqli_real_escape_string($link, $password);


 	$loginstring = "SELECT * FROM tbl_user WHERE user_name = '{$username}'";
 	//echo $loginstring;
 	$user_set = mysqli_query($link, $loginstring);

 	if(mysqli_num_rows($user_set)){

 		$found_user = mysqli_fetch_array($user_set,MYSQLI_ASSOC);
 		$id = $found_user['user_id'];//now you have access to the users ID
    $passwrd = $found_user['user_pass'];
    $signedin = $found_user['user_signedin'];
    $timecreated = $found_user['user_timecreated'];

    if($found_user['user_pass'] === $password && ($found_user['user_attempts'] < 3)) {
      $_SESSION['user_id'] = $id;
      $_SESSION['user_name'] = $found_user['user_name'];
      $_SESSION['user_fname'] = $found_user['user_fname'];
      $_SESSION['user_signedin'] = $found_user['user_signedin'];


 		if(mysqli_query($link, $loginstring)){
 			//if they've successfully logged in then update their ip address in the db
 			$updatestring = "UPDATE tbl_user SET user_ip = '$ip' WHERE user_id = {$id}";
      $updateattempts = "UPDATE tbl_user SET user_attempts = 0 WHERE user_id = {$id}";
      $updatesignedin = "UPDATE tbl_user SET user_signedin = 1 WHERE user_id = {$id}";
 			$updatequery = mysqli_query($link, $updatestring);
      $updatequery2 = mysqli_query($link, $updateattempts);
      $updatequery3 = mysqli_query($link, $updatesignedin);

      if($signedin == false) {
        redirect_to('admin_edituser.php');
      }

 		}
 		redirect_to('admin_index.php');

  } else if ($found_user['user_attempts'] < 3 ) {
    $attempts = $found_user['user_attempts'] + 1;
    $attemptquery = "UPDATE tbl_user SET user_attempts = {$attempts} WHERE user_id = {$id}";
    $updateattempts = mysqli_query($link, $attemptquery);
    $message = "Failed Login Attempt - Remember, you only have three tries.";
    return $message;
  } else{
    return "You are locked out, sorry.";
  }

 	// } else {
 	// 	$message = "Username or password is incorrect";
 	// 	return $message;
 	}


 	mysqli_close($link);//always make sure to close it off especially on a login
 }



?>
