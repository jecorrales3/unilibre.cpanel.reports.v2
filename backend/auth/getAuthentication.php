<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the functions authentication      **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 29/11/2019                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 29/11/2019                **
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

  if (isset($_SESSION['user']))
  {
    //Consult session result
    $response['status']   = true;
    $response['message']  = "The session is still active.";
    $response['username'] = $_SESSION['user']['nombre_usuario'] . " " . $_SESSION['user']['apellido_usuario'];
    $response['type']     = $_SESSION['user']['id_tipo_usuario'];
  }
  else
  {
    //Authentication result
    $response["status"]  = false;
    $response["message"] = "Invalid session.";
  }

  //Display the JSON response
  echo json_encode($response);

?>
