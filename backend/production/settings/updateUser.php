<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a user profile                    **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 10/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 10/01/2020                **
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
  include 'consult.php';
  //Session start
  session_start();
  //User id
  $user_id = $_SESSION['user']['id_usuario'];
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['user_id'])      && isset($_POST['user_name'])  && isset($_POST['user_lastname']) &&
     isset($_POST['user_faculty']) && isset($_POST['user_type'])  && isset($_POST['user_state'])    &&
     isset($_POST['user_email']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $user_id       = $_POST['user_id'];
    $user_name     = ucfirst($_POST['user_name']);
  	$user_lastname = ucfirst($_POST['user_lastname']);
  	$user_faculty  = $_POST['user_faculty'];
  	$user_type     = $_POST['user_type'];
  	$user_state    = $_POST['user_state'];
  	$user_email    = $_POST['user_email'];
  	$user_password = $_POST['user_password'];
  	$user_confirm_password  = $_POST['user_confirm_password'];

    /*
    echo "ID: " . $user_id;
    echo "Name: " . $user_name;
    echo "Lastname: " . $user_lastname;
    echo "Faculty: " . $user_faculty;
    echo "Type: " . $user_type;
    echo "State: " . $user_state;
    echo "Email: " . $user_email;
    echo "Password: " . $user_password;
    echo "Confirm: " . $user_confirm_password;
    */

    if (validateUser($user_id, $user_email))
    {
      $response["message"] = "El usuario (correo) ya se encuentra asignado a otro usuario del sistema; inténtalo de nuevo.";
    }
    else
    {
      if (!empty($user_password))
      {
        if ($user_confirm_password == $user_password)
        {
          //The user doesn't exist, so, proceed to register
          //Get a unique Salt
          $salt         = getSalt();

          //Generate a unique password Hash
          $passwordHash = password_hash(concatPasswordWithSalt($user_password, $salt),PASSWORD_DEFAULT);

          //Query to register new user
          $updateQuery  = "UPDATE usuario
                              SET nombre_usuario          = ?,
                                  apellido_usuario        = ?,
                                  correo_usuario          = ?,
                                  id_facultad_usuario     = ?,
                                  id_tipo_usuario         = ?,
                                  id_estado_usuario       = ?,
                                  contrasena_hash_usuario = ?,
                                  salt_usuario            = ?
                            WHERE id_usuario              = ?";
          //Prepared query
          $stmt = $mysqli->prepare($updateQuery);
          //Parameters
          $stmt->bind_param("sssiiissi", $user_name, $user_lastname, $user_email, $user_faculty, $user_type, $user_state, $passwordHash, $salt, $user_id);
          //Evaluate if the query was executed
          if($stmt->execute())
          {
            $updated_data = $stmt->affected_rows;
            $message = ($updated_data > 0) ? "Usuario actualizado." : "No se ha detectado cambios en la información | (COD001)" . $stmt->error;
            $response['message'] = $message;
          }
          else
          {
            $response['message'] = "Error (execute query): " . $stmt->error;
          }
        }
        else
        {
          $response["message"] = "La contraseñas no coinciden; inténtalo de nuevo.";
        }
      }
      else
      {
        //Query to register new user
        $updateQuery  = "UPDATE usuario
                            SET nombre_usuario      = ?,
                                apellido_usuario    = ?,
                                correo_usuario      = ?,
                                id_facultad_usuario = ?,
                                id_tipo_usuario     = ?,
                                id_estado_usuario   = ?
                          WHERE id_usuario          = ?";
        //Prepared query
        $stmt = $mysqli->prepare($updateQuery);
        //Parameters
        $stmt->bind_param("sssiiii", $user_name, $user_lastname, $user_email, $user_faculty, $user_type, $user_state, $user_id);
        //Evaluate if the query was executed
        if($stmt->execute())
        {
          $updated_data = $stmt->affected_rows;
          $message = ($updated_data > 0) ? "Usuario actualizado." : "No se ha detectado cambios en la información | (COD002)" . $stmt->error;
          $response['message'] = $message;
        }
        else
        {
          $response['message'] = "Error (execute query): " . $stmt->error;
        }
      }
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
