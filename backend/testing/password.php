<?php
 //Include files
 include '../db/db_connection.php';
 include '../auth/authentication.php';
 $id_user  = '1';
 $password = $_GET['password'];
 /*
 $options = [
   'salt' => custom_function_for_salt(), //write your own code to generate a suitable salt
   'cost' => 12 // the default cost is 10
 ];*/
 if (isset($password))
 {
   //Get a unique Salt
		$salt         = getSalt();

		//Generate a unique password Hash
		$passwordHash = password_hash(concatPasswordWithSalt($password, $salt),PASSWORD_DEFAULT);

		//Query to register new user
		$insertQuery  = "UPDATE usuario SET contrasena_hash_usuario = ?,salt_usuario = ? WHERE id_usuario = ?";
		if($stmt = $mysqli->prepare($insertQuery))
    {
			$stmt->bind_param("ssi", $passwordHash, $salt, $id_user);
			$stmt->execute();
		  echo "User created";
			$stmt->close();
		}
 }
 else
 {
   echo "Its not possible access to that value.";
 }

 ?>
