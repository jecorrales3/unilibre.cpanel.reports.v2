<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document delete a faculty                         **
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
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['faculty_id']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $faculty_id       = $_POST['faculty_id'];

    /*
    echo "ID: " . $faculty_id;
    */

    //Query to delete a faculty
    $insertQuery  = "UPDATE facultad
                        SET id_funcionalidad_facultad = '2'
                      WHERE id_facultad               = ?";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("i", $faculty_id);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $updated_data = $stmt->affected_rows;
      $message = ($updated_data > 0) ? "Facultad eliminada." : "No se ha detectado cambios en la información." . $stmt->error;
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
