<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update the password profile              **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 07/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 07/01/2020                **
  ** @who        - Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @why        - Creation                                                  **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  */
  //Array for results
  $response = array();
  //Include files
  include '../db/db_connection.php';
  include '../auth/authentication.php';
  //Session start
  session_start();
  //User id
  $user_id = $_SESSION['user']['id_usuario'];
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['old_password'])    && isset($_POST['new_password'])     && isset($_POST['confirm_password']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
  	$old_password     = $_POST['old_password'];
  	$new_password     = $_POST['new_password'];
  	$confirm_password = $_POST['confirm_password'];

    /*
    echo "Name: " . $user_name;
    echo "Lastname: " . $user_lastname;
    echo "Email: " . $user_email;
    echo "Faculty: " . $user_faculty;
    */

    if ($confirm_password == $new_password)
    {
      //Query
    	$query = "SELECT contrasena_hash_usuario,
                       salt_usuario
                  FROM usuario
                 WHERE id_usuario = ?";

    	if($stmt = $mysqli->prepare($query))
      {
    		$stmt->bind_param("i", $user_id);
    		$stmt->execute();
    		$stmt->bind_result($password_hash, $salt);

        if($stmt->fetch())
        {
    			//Validate the password
          if(password_verify(concatPasswordWithSalt($old_password, $salt), $password_hash))
          {
            //Cleaning consult
            $stmt->free_result(); // Does what it says.
            //Get a unique Salt
            $salt         = getSalt();

            //Generate a unique password Hash
            $passwordHash = password_hash(concatPasswordWithSalt($new_password, $salt),PASSWORD_DEFAULT);

            //Query to register new user
            $updateQuery  = "UPDATE usuario
                                SET contrasena_hash_usuario = ?,
                                    salt_usuario            = ?
                              WHERE id_usuario              = ?";
            //Prepared query
            $stmtu = $mysqli->prepare($updateQuery);
            //Parameters
            $stmtu->bind_param("ssi",  $passwordHash, $salt, $user_id);
            //Evaluate if the query was executed
            if($stmtu->execute())
            {
              $updated_data = $stmtu->affected_rows;
              $message = ($updated_data > 0) ? "Contraseña actualizada." : "Error (update data) :" . $stmtu->error;
              $response['message'] = $message;
            }
            else
            {
              $response['message'] = "Error (execute query): " . $stmtu->error;
            }
          }
      		else
          {
            $response["message"] = "La contraseña no se encuentra registrada; inténtalo de nuevo.";
      		}
    		}
    		else
        {
          $response["message"] = "Error al consultar los datos.";
    		}
    	}
    }
    else
    {
      $response["message"] = "La contraseñas no coinciden; inténtalo de nuevo.";
    }
  }
  else
  {
    $response["status"]  = false;
    $response["message"] = "Missing mandatory parameters";
  }

  //Display the JSON response
  echo json_encode($response);

 ?>
