<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the methods for consult data      **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 9/01/2020                  **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 9/01/2020                 **
  ** @who        - Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @why        - Creation                                                  **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  */
  function checkUser($username)
  {
    //TokyoTyrantQuery
  	$query = "SELECT correo_usuario FROM usuario WHERE correo_usuario = ? AND id_funcionalidad_usuario = '1'";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("s", $username);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function userUpdateExists($user_id, $user_email)
  {
    //TokyoTyrantQuery
  	$query = "SELECT id_usuario
              FROM usuario usro
              WHERE correo_usuario = ?
              AND id_usuario       = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("si", $user_email, $user_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}

  		$stmt->close();
  	}

  	return false;
  }

  function validateUser($user_id, $user_email)
  {
    //TokyoTyrantQuery
  	$query = "SELECT id_usuario
              FROM usuario usro
              WHERE correo_usuario = ?
              AND id_usuario       != ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("si", $user_email, $user_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}

  		$stmt->close();
  	}

  	return false;
  }
?>
