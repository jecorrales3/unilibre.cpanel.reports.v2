<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the profile data                  **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 13/12/2019                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 13/12/2019                **
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

  //Evaluate connection with MySql
  if ($mysqli)
  {
    $mysqli->set_charset('utf8');
    $queryResult = $mysqli->query("SELECT usro.id_usuario,
                                   	      usro.nombre_usuario,
                                          usro.apellido_usuario,
                                          usro.correo_usuario,
                                          fctd.id_facultad,
                                          fctd.nombre_facultad,
                                          tipo.id_tipo_usuario,
                                          tipo.nombre_tipo_usuario,
                                          euso.id_estado_usuario,
                                          euso.nombre_estado_usuario
                                     FROM usuario usro
                                   INNER JOIN facultad fctd
                                   ON fctd.id_facultad = usro.id_facultad_usuario
                                   INNER JOIN tipo_usuario tipo
                                   ON tipo.id_tipo_usuario = usro.id_tipo_usuario
                                   INNER JOIN estado_usuario euso
                                   ON euso.id_estado_usuario = usro.id_estado_usuario
                                   WHERE usro.id_usuario = '$user_id'");
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
