<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the consecutive list (years)      **
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
  //User information
  $user_id      = $_SESSION['user']['id_usuario'];
  $user_type    = $_SESSION['user']['id_tipo_usuario'];
  $user_faculty = $_SESSION['user']['id_facultad_usuario'];

  //Evaluate connection with MySql
  if ($mysqli)
  {
    $mysqli->set_charset('utf8');
    $queryResult = $mysqli->query("SELECT ctvo.year_consecutivo_reporte,
	                                        COUNT(*) AS contador_reporte
                                     FROM consecutivo_reporte ctvo
                                   GROUP BY ctvo.year_consecutivo_reporte
                                   ORDER BY ctvo.year_consecutivo_reporte DESC");
    $data = array();
    while ($row = $queryResult->fetch_assoc())
    {
      $data[] = $row;
    }

    //Display the JSON response
    echo json_encode($data);
  }
  else
  {
    //Response action
    $response['message'] = "We're sorry, but this request is not valid!";

    //Display the JSON response
    echo json_encode($response);
  }

 ?>
