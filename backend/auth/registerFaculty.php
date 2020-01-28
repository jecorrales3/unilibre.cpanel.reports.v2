<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a member                          **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 05/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 05/01/2020                **
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
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['faculty_name']) && isset($_POST['faculty_acronym']) && isset($_POST['faculty_city']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
  	$faculty_name    = $_POST['faculty_name'];
  	$faculty_acronym = $_POST['faculty_acronym'];
  	$faculty_city    = $_POST['faculty_city'];

    /*
    echo "Name: " . $faculty_name;
    echo "Acronym: " . $faculty_acronym;
    echo "City: " . $faculty_city;
    */

    //Query to register new faculty
    $insertQuery  = "INSERT INTO `facultad`(`id_facultad`, `nombre_facultad`, `siglas_facultad`,
                                            `fecha_registro_facultad`, `id_ciudad_facultad`, `id_funcionalidad_facultad`)
                     VALUES (NULL, ?, ?, CURDATE(), ?, '1')";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("ssi", $faculty_name, $faculty_acronym, $faculty_city);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $inserted_data = $stmt->affected_rows;
      $message = ($inserted_data > 0) ? "Facultad registrada." : "Error (inserted data) :" . $stmt->error;
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
