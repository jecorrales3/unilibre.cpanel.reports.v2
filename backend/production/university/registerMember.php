<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document register a member                        **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 13/12/2019                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 13/12/2019                **
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
  if(isset($_POST['member_name'])     && isset($_POST['member_lastname']) && isset($_POST['member_document']) &&
     isset($_POST['member_faculty'])  && isset($_POST['member_type']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');
    //Post variables
    $member_name     = ucfirst($_POST['member_name']);
  	$member_lastname = ucfirst($_POST['member_lastname']);
  	$member_email    = $_POST['member_email'];
  	$member_document = $_POST['member_document'];
  	$member_faculty  = $_POST['member_faculty'];
  	$member_type     = $_POST['member_type'];

    /*
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

    //Query to register new user
    $insertQuery  = "INSERT INTO `integrante`(`id_integrante`, `nombre_integrante`, `apellido_integrante`,
                                              `correo_integrante`, `cedula_integrante`, `fecha_registro_integrante`,
                                              `id_tipo_integrante`, `id_facultad_integrante`, `id_funcionalidad_integrante`)
                     VALUES (NULL, ?, ?, ?, ?, CURDATE(), ?, ?, '1')";
    //Prepared query
    $stmt = $mysqli->prepare($insertQuery);
    //Parameters
    $stmt->bind_param("ssssii", $member_name, $member_lastname, $member_email, $member_document, $member_type, $member_faculty);
    //Evaluate if the query was executed
    if($stmt->execute())
    {
      $inserted_data = $stmt->affected_rows;
      $message = ($inserted_data > 0) ? "Integrante registrado." : "Error (inserted data) :" . $stmt->error;
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
