<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a program                         **
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
  if(isset($_POST['program_id'])    && isset($_POST['program_name'])     && isset($_POST['program_faculty']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $program_id      = $_POST['program_id'];
  	$program_name    = $_POST['program_name'];
  	$program_faculty = $_POST['program_faculty'];

    /*
    echo "ID: " . $program_id;
    echo "Name: " . $program_name;
    echo "Faculty: " . $program_faculty;
    */

    //Query to update a program
    $insertQuery  = "UPDATE programa_facultad
                        SET nombre_programa_facultad      = ?,
                            id_facultad_programa_facultad = ?
                      WHERE id_programa_facultad          = ?";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("sii", $program_name, $program_faculty, $program_id);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $updated_data = $stmt->affected_rows;
      $message = ($updated_data > 0) ? "Programa actualizado." : "No se ha detectado cambios en la información." . $stmt->error;
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
