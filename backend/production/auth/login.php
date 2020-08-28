<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the sign in                       **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 29/11/2019                 **
  ** @required     db_connection.php for connect with MySql                  **
  **               authentication.php functions for authentication login     **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 29/11/2019                **
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
  include 'authentication.php';

  //Delay script execution
  sleep(1);
  //Session start
  session_start();
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['user_email']) && isset($_POST['user_password']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $username = $_POST['user_email'];
  	$password = $_POST['user_password'];

    //Query
  	$query = "SELECT id_usuario,
                     nombre_usuario,
                     apellido_usuario,
                     correo_usuario,
                     contrasena_hash_usuario,
                     salt_usuario,
                     id_tipo_usuario,
                     id_facultad_usuario
                FROM usuario
               WHERE correo_usuario = ?
                 AND id_funcionalidad_usuario = '1'
                 AND id_estado_usuario = '1'";

  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("s", $username);
  		$stmt->execute();
  		$stmt->bind_result($user_id, $user_name, $user_lastname, $user_email, $password_hash, $salt, $user_type, $user_faculty);

      if($stmt->fetch())
      {
  			//Validate the password
  			if(password_verify(concatPasswordWithSalt($password, $salt), $password_hash))
        {
          //Session array
          $data = array(
            'id_usuario'          => $user_id,
            'nombre_usuario'      => $user_name,
            'apellido_usuario'    => $user_lastname,
            'correo_usuario'      => $user_email,
            'id_tipo_usuario'     => $user_type,
            'id_facultad_usuario' => $user_faculty
          );

          //Session company object
          $_SESSION['user'] = $data;

          //Result of the action
  				$response["status"]   = true;
  				$response["message"]  = "Bienvenido al sistema.";
  				$response["usertype"] = $user_type;
  			}
  			else
        {
  				$response["status"]  = false;
  				$response["message"] = "Usuario o contraseña inválida.";
  			}
  		}
  		else
      {
  			$response["status"]  = false;
  			$response["message"] = "El usuario ha sido eliminado o suspendido.";
  		}

  		$stmt->close();
  	}
  }
  else
  {
  	$response["status"]  = false;
  	$response["message"] = "Algo ha salido mal; inténtalo de nuevo.";
  }

  //Display the JSON response
  echo json_encode($response);


 ?>
