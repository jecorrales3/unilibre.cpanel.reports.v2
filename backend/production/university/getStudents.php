<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document alloes the students                      **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 03/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 03/02/2020                **
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
      $queryResult = $mysqli->query("SELECT edte.id_estudiante_reporte,
                                    	      edte.nombre_estudiante_reporte,
                                            edte.apellido_estudiante_reporte,
                                            edte.documento_estudiante_reporte,
                                            COUNT(*) AS contador_reporte,
                                            fctd.nombre_facultad,
                                            fctd.siglas_facultad
                                       FROM estudiante_reporte edte
                                       INNER JOIN configuracion_reporte conf
                                       ON conf.id_configuracion_reporte = edte.id_configuracion_estudiante_reporte
                                       INNER JOIN facultad fctd
                                       ON fctd.id_facultad = conf.id_facultad_final_configuracion_reporte
                                       GROUP BY edte.documento_estudiante_reporte
                                       ORDER BY edte.apellido_estudiante_reporte,
                                                edte.nombre_estudiante_reporte");
    }
    else
    {
      $queryResult = $mysqli->query("SELECT edte.id_estudiante_reporte,
                                    	      edte.nombre_estudiante_reporte,
                                            edte.apellido_estudiante_reporte,
                                            edte.documento_estudiante_reporte,
                                            COUNT(*) AS contador_reporte,
                                            fctd.nombre_facultad,
                                            fctd.siglas_facultad
                                       FROM estudiante_reporte edte
                                       INNER JOIN configuracion_reporte conf
                                       ON conf.id_configuracion_reporte = edte.id_configuracion_estudiante_reporte
                                       INNER JOIN facultad fctd
                                       ON fctd.id_facultad = conf.id_facultad_final_configuracion_reporte
                                       WHERE conf.id_facultad_final_configuracion_reporte = '$user_faculty'
                                       GROUP BY edte.documento_estudiante_reporte
                                       ORDER BY edte.apellido_estudiante_reporte,
                                                edte.nombre_estudiante_reporte");
    }

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
