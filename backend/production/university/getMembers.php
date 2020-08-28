<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document alloes the members                       **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 21/12/2019                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 21/12/2019                **
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

  //Evaluate connection with MySql
  if ($mysqli && isset($_SESSION['user']))
  {
    $mysqli->set_charset('utf8');
    //User information
    $user_id      = $_SESSION['user']['id_usuario'];
    $user_type    = $_SESSION['user']['id_tipo_usuario'];
    $user_faculty = $_SESSION['user']['id_facultad_usuario'];

    //Get the user query
    if ($user_type == 1)
    {
      $query = "SELECT itgt.id_integrante,
                       itgt.nombre_integrante,
                       itgt.apellido_integrante,
                       itgt.correo_integrante,
                       itgt.cedula_integrante,
                       itgt.fecha_registro_integrante,
                       tint.id_tipo_integrante,
                       tint.nombre_tipo_integrante,
                       fctd.id_facultad,
                       fctd.nombre_facultad
                FROM integrante itgt
                INNER JOIN tipo_integrante tint
                ON tint.id_tipo_integrante = itgt.id_tipo_integrante
                INNER JOIN facultad fctd
                ON fctd.id_facultad = itgt.id_facultad_integrante
                WHERE itgt.id_funcionalidad_integrante = '1'
                ORDER BY fctd.nombre_facultad ASC,
                        tint.id_tipo_integrante ASC,
                        itgt.apellido_integrante ASC,
                        itgt.nombre_integrante ASC";
    }
    else
    {
      $query = "SELECT itgt.id_integrante,
                       itgt.nombre_integrante,
                       itgt.apellido_integrante,
                       itgt.correo_integrante,
                       itgt.cedula_integrante,
                       itgt.fecha_registro_integrante,
                       tint.id_tipo_integrante,
                       tint.nombre_tipo_integrante,
                       fctd.id_facultad,
                       fctd.nombre_facultad
                FROM integrante itgt
                INNER JOIN tipo_integrante tint
                ON tint.id_tipo_integrante = itgt.id_tipo_integrante
                INNER JOIN facultad fctd
                ON fctd.id_facultad = itgt.id_facultad_integrante
                WHERE itgt.id_funcionalidad_integrante = '1'
                AND itgt.id_facultad_integrante        = '$user_faculty'
                ORDER BY fctd.nombre_facultad ASC,
                        tint.id_tipo_integrante ASC,
                        itgt.apellido_integrante ASC,
                        itgt.nombre_integrante ASC";
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
