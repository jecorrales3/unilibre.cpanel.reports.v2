<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document register a user                          **
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
  //Array for results
  $response = array();
  //Include files
  include '../db/db_connection.php';
  include 'authentication.php';
  include 'consult.php';
  //Session start
  session_start();
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['user_name'])  && isset($_POST['user_lastname']) && isset($_POST['user_faculty'])  &&
     isset($_POST['user_type'])  && isset($_POST['user_email'])    && isset($_POST['user_password']) &&
     isset($_POST['user_confirm_password']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $user_name             = ucfirst($_POST['user_name']);
  	$user_lastname         = ucfirst($_POST['user_lastname']);
  	$user_faculty          = $_POST['user_faculty'];
  	$user_type             = $_POST['user_type'];
  	$user_email            = $_POST['user_email'];
  	$user_password         = $_POST['user_password'];
  	$user_confirm_password = $_POST['user_confirm_password'];

    /*
    echo "Name: " . $user_name;
    echo "Lastname: " . $user_lastname;
    echo "Faculty: " . $user_faculty;
    echo "Type: " . $user_type;
    echo "Email: " . $user_email;
    echo "Pass: " . $user_password;
    echo "Confirm: " . $user_confirm_password;
    */

    if ($user_confirm_password == $user_password)
    {
      //Evaluate if user exists in db
      if (checkUser($user_email))
      {
        $response["message"] = "El usuario ingresado ya se encuentra registrado.";
      }
      else
      {
        //The user doesn't exist, so, proceed to register
        //Get a unique Salt
    		$salt         = getSalt();

    		//Generate a unique password Hash
    		$passwordHash = password_hash(concatPasswordWithSalt($user_password, $salt),PASSWORD_DEFAULT);

        //Query to register new user
        $insertQuery  = "INSERT INTO `usuario`(`id_usuario`, `nombre_usuario`, `apellido_usuario`,
                                               `correo_usuario`, `contrasena_hash_usuario`, `salt_usuario`,
                                               `fecha_registro_usuario`, `id_facultad_usuario`, `id_tipo_usuario`,
                                               `id_estado_usuario`, `id_funcionalidad_usuario`)
                         VALUES (NULL, ?, ?, ?, ?, ?, CURDATE(), ?, ?, '1', '1')";
        //Prepared query
        $stmt = $mysqli->prepare($insertQuery);
        //Parameters
        $stmt->bind_param("sssssii", $user_name, $user_lastname, $user_email, $passwordHash, $salt, $user_faculty, $user_type);
        //Evaluate if the query was executed
        if($stmt->execute())
        {
          $inserted_data = $stmt->affected_rows;
          $message = ($inserted_data > 0) ? "Usuario registrado." : "Error (inserted data) :" . $stmt->error;
          $response['message'] = $message;
        }
        else
        {
          $response['message'] = "Error (execute query): " . $stmt->error;
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
