<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document consult methods report                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 16/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 16/01/2020                **
  ** @who        - Johan Corrales | johan-corralesa@unilibre.edu.co          **
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
?>
