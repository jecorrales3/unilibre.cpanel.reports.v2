<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a report state                    **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 13/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 13/02/2020                **
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
  if(isset($_POST['configuration_id']) && isset($_POST['report_state']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $configuration_report_id      = $_POST['configuration_id'];
  	$configuration_report_state   = $_POST['report_state'];

    /*
    echo "ID: " . $configuration_report_id;
    echo "State: " . $configuration_report_state;
    */

    //Query to update a program
    $insertQuery  = "UPDATE configuracion_reporte
                        SET id_funcionalidad_configuracion_reporte = ?
                      WHERE id_configuracion_reporte               = ?";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("ii", $configuration_report_state, $configuration_report_id);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $updated_data = $stmt->affected_rows;
      $message = ($updated_data > 0) ? "Reporte actualizado." : "No se ha detectado cambios en la información." . $stmt->error;
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
