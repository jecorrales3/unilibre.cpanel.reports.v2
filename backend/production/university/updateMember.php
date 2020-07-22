<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document update a member                          **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 03/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 03/01/2020                **
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
  if(isset($_POST['member_id'])       && isset($_POST['member_name'])     && isset($_POST['member_lastname']) &&
     isset($_POST['member_document']) && isset($_POST['member_faculty'])  && isset($_POST['member_type']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $member_id       = $_POST['member_id'];
    $member_name     = ucfirst($_POST['member_name']);
  	$member_lastname = ucfirst($_POST['member_lastname']);
  	$member_email    = $_POST['member_email'];
  	$member_document = $_POST['member_document'];
  	$member_faculty  = $_POST['member_faculty'];
  	$member_type     = $_POST['member_type'];

    /*
    echo "ID: " . $member_id;
    echo "Name: " . $member_name;
    echo "Lastname: " . $member_lastname;
    echo "Email: " . $member_email;
    echo "Document: " . $member_document;
    echo "Faculty: " . $member_faculty;
    echo "Member: " . $member_type;
    */
    if (empty($member_email))
    {
      $member_email = NULL;
    }

    //Query to update the member
    $insertQuery  = "UPDATE integrante
                        SET nombre_integrante      = ?,
                            apellido_integrante    = ?,
                            correo_integrante      = ?,
                            cedula_integrante      = ?,
                            id_tipo_integrante     = ?,
                            id_facultad_integrante = ?
                      WHERE id_integrante          = ?";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("ssssiii", $member_name, $member_lastname, $member_email, $member_document, $member_type, $member_faculty, $member_id);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $updated_data = $stmt->affected_rows;
      $message = ($updated_data > 0) ? "Integrante actualizado." : "No se ha detectado cambios en la información." . $stmt->error;
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
