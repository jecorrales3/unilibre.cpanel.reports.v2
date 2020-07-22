<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a consecutive                     **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 10/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 10/02/2020                **
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
  include 'consecutive_query.php';
  //Session start
  session_start();
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  //Check for Mandatory parameters
  if(isset($_POST['consecutive_id']) && isset($_POST['consecutive_state']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $consecutive_id       = $_POST['consecutive_id'];
  	$consecutive_state    = $_POST['consecutive_state'];

    //Consecutive array
    $consecutive_data    = getConsecutiveData($consecutive_id);
    $consecutive_type    = $consecutive_data['consecutive_type'];
    $consecutive_faculty = $consecutive_data['consecutive_faculty'];

    /*
    echo "ID: " . $consecutive_id;
    echo "State: " . $consecutive_state;
    */

    if (getConsecutiveState($consecutive_faculty, $consecutive_type))
    {
      if ($consecutive_state != 1)
      {
        //Query to update the faculty
        $insertQuery  = "UPDATE consecutivo_reporte
                            SET id_estado_consecutivo_reporte = ?
                          WHERE id_consecutivo_reporte        = ?";
        //Prepared query
        $stmt = $mysqli->prepare($insertQuery);
        //Parameters
        $stmt->bind_param("ii", $consecutive_state, $consecutive_id);
        //Evaluate if the query was executed
        if($stmt->execute())
        {
          $updated_data = $stmt->affected_rows;
          $message = ($updated_data > 0) ? "Consecutivo actualizado." : "No se ha detectado cambios en la información." . $stmt->error;
          $response['message'] = $message;
        }
        else
        {
          $response['message'] = "Error (execute query): " . $stmt->error;
        }
      }
      else
      {
        //No se puede actualizar el consecutivo (activo)
        $response["message"] = "No se puede actualizar el consecutivo; hay otro consecutivo activo actualmente.";
      }
    }
    else
    {
      //Query to update the faculty
      $insertQuery  = "UPDATE consecutivo_reporte
                          SET id_estado_consecutivo_reporte = ?
                        WHERE id_consecutivo_reporte        = ?";
      //Prepared query
      $stmt = $mysqli->prepare($insertQuery);
      //Parameters
      $stmt->bind_param("ii", $consecutive_state, $consecutive_id);
      //Evaluate if the query was executed
      if($stmt->execute())
      {
        $updated_data = $stmt->affected_rows;
        $message = ($updated_data > 0) ? "Consecutivo actualizado." : "No se ha detectado cambios en la información." . $stmt->error;
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
    $response["status"]  = false;
    $response["message"] = "Missing mandatory parameters";
  }

  //Display the JSON response
  echo json_encode($response);

 ?>
