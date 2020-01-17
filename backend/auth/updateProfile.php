<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a user profile                    **
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
  //Session start
  session_start();
  //User id
  $user_id = $_SESSION['user']['id_usuario'];
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['user_name'])    && isset($_POST['user_lastname'])     && isset($_POST['user_email']) &&
     isset($_POST['user_faculty']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $user_name     = ucfirst($_POST['user_name']);
  	$user_lastname = ucfirst($_POST['user_lastname']);
  	$user_email    = $_POST['user_email'];
  	$user_faculty  = $_POST['user_faculty'];

    /*
    echo "Name: " . $user_name;
    echo "Lastname: " . $user_lastname;
    echo "Email: " . $user_email;
    echo "Faculty: " . $user_faculty;
    */

    //Query to register new user
    $insertQuery  = "UPDATE usuario
                        SET nombre_usuario      = ?,
                            apellido_usuario    = ?,
                            correo_usuario      = ?,
                            id_facultad_usuario = ?
                      WHERE id_usuario          = ?";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("sssii", $user_name, $user_lastname, $user_email, $user_faculty, $user_id);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $updated_data = $stmt->affected_rows;
      $message = ($updated_data > 0) ? "Usuario actualizado." : "No se ha detectado cambios en la información." . $stmt->error;
      $response['message'] = $message;
    }
    else
    {
      $response['message'] = "Error (execute query): " . $stmt->error;
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
