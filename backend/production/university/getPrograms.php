<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the programs list                 **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 11/01/2020                  **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 11/01/2020                 **
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

  //Evaluate connection with MySql
  if ($mysqli && isset($_SESSION['user']))
  {
    $mysqli->set_charset('utf8');
    //User information
    $user_faculty = $_SESSION['user']['id_facultad_usuario'];
    $user_type    = $_SESSION['user']['id_tipo_usuario'];

    if ($user_type == 1) {
      // Administrador
      $query = "SELECT prgm.id_programa_facultad,
                       prgm.nombre_programa_facultad,
                       prgm.titulo_programa_facultad,
                       prgm.fecha_registro_programa_facultad,
                       fctd.id_facultad,
                       fctd.nombre_facultad,
                       fctd.siglas_facultad
                FROM programa_facultad prgm
                INNER JOIN facultad fctd
                ON fctd.id_facultad = prgm.id_facultad_programa_facultad
                WHERE prgm.id_funcionalidad_programa_facultad = '1'
                ORDER BY prgm.nombre_programa_facultad ASC";
    } else {
      // Usuario
      $query = "SELECT prgm.id_programa_facultad,
                       prgm.nombre_programa_facultad,
                       prgm.titulo_programa_facultad,
                       prgm.fecha_registro_programa_facultad,
                       fctd.id_facultad,
                       fctd.nombre_facultad,
                       fctd.siglas_facultad
                FROM programa_facultad prgm
                INNER JOIN facultad fctd
                ON fctd.id_facultad = prgm.id_facultad_programa_facultad
                WHERE prgm.id_funcionalidad_programa_facultad = '1'
                AND prgm.id_facultad_programa_facultad = '$user_faculty'
                ORDER BY prgm.nombre_programa_facultad ASC";
    }

    $queryResult = $mysqli->query($query);

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
