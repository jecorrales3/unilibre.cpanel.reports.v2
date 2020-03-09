<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a consecutive                     **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 07/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 07/02/2020                **
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
  if(isset($_POST['consecutive_current']) && isset($_POST['consecutive_faculty']) && isset($_POST['consecutive_type']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
  	$consecutive_current = $_POST['consecutive_current'];
  	$consecutive_faculty = $_POST['consecutive_faculty'];
  	$consecutive_type    = $_POST['consecutive_type'];
    $consecutive_state   = 0;
    $consecutive_result  = 1000 - $consecutive_current;
    //Format date values
    $consecutive_year       = date("Y");
    $year_start             = strtotime('first day of January', time());
    $year_end               = strtotime('last day of December', time());
    $consecutive_year_start = date('Y-m-d', $year_start);
    $consecutive_year_end   = date('Y-m-d', $year_end);

    /*
    echo "Current: " . $consecutive_current;
    echo "Faculty: " . $consecutive_faculty;
    echo "Type: " . $consecutive_type;
    */

    if (getConsecutiveState($consecutive_faculty, $consecutive_type))
    {
      $consecutive_state = '3';
    }
    else
    {
      $consecutive_state = '1';
    }


    if ($consecutive_state != 0)
    {
      //Query to register new faculty
      $insertQuery  = "INSERT INTO `consecutivo_reporte`
                                  (`id_consecutivo_reporte`,      `vigencia_desde_consecutivo_reporte`, `vigencia_hasta_consecutivo_reporte`,
                                   `year_consecutivo_reporte`,    `consecutivo_desde_reporte`,          `consecutivo_actual_reporte`,
                                   `consecutivo_hasta_reporte`,   `consecutivo_restante_reporte`,       `id_estado_consecutivo_reporte`,
                                   `id_tipo_consecutivo_reporte`, `id_facultad_consecutivo_reporte`)
                       VALUES (NULL, ?, ?, ?, '0', ?, '1000', ?, ?, ?, ?)";
      //Prepared query
      $stmt = $mysqli->prepare($insertQuery);
      //Parameters
      $stmt->bind_param("sssssiii", $consecutive_year_start, $consecutive_year_end, $consecutive_year, $consecutive_current, $consecutive_result, $consecutive_state, $consecutive_type, $consecutive_faculty);
      //Evaluate if the query was executed
      if($stmt->execute())
      {
        $inserted_data = $stmt->affected_rows;
        $message = ($inserted_data > 0) ? "Consecutivo registrado." : "Error (inserted data) :" . $stmt->error;
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
