<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document register a program                       **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 11/01/2019                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 11/01/2019                **
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
  //Session start
  session_start();
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['program_name']) && isset($_POST['program_faculty']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $program_name     = ucfirst($_POST['program_name']);
  	$program_faculty  = $_POST['program_faculty'];
    
    /*
    echo "Name: " . $program_name;
    echo "Faculty: " . $program_faculty;
    */

    //Query to register new user
    $insertQuery  = "INSERT INTO `programa_facultad`(`id_programa_facultad`, `nombre_programa_facultad`, `fecha_registro_programa_facultad`,
                                                     `id_facultad_programa_facultad`, `id_funcionalidad_programa_facultad`)
                     VALUES (NULL, ?, CURDATE(), ?, '1')";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("si", $program_name, $program_faculty);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $inserted_data = $stmt->affected_rows;
      $message = ($inserted_data > 0) ? "Programa registrado." : "Error (inserted data) :" . $stmt->error;
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
