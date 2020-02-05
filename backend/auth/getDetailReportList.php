<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document consult the report list of a student     **
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

  //$_GET Value
  $student_document = $_GET['student_document'];

  //Evaluate connection with MySql
  if (isset($student_document))
  {
    $mysqli->set_charset('utf8');
    $queryResult = $mysqli->query("SELECT edte.documento_estudiante_reporte,
                                  	      conf.id_configuracion_reporte,
                                          DATE_FORMAT(conf.fecha_generacion_configuracion_reporte, '%d/%m/%Y') AS fecha_generacion_configuracion_reporte,
                                          conf.codigo_configuracion_reporte,
                                          conf.titulo_configuracion_reporte,
                                          frpt.nombre_facultad_reporte,
                                          frpt.nombre_programa_facultad_reporte,
                                          trpe.id_tipo_reporte,
                                          trpe.nombre_tipo_reporte,
                                          ctvo.year_consecutivo_reporte
                                     FROM estudiante_reporte edte
                                   LEFT JOIN ciudad cdad
                                   ON cdad.id_ciudad = edte.id_ciudad_estudiante_reporte
                                   INNER JOIN configuracion_reporte conf
                                   ON conf.id_configuracion_reporte = edte.id_configuracion_estudiante_reporte
                                   INNER JOIN facultad_reporte frpt
                                   ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                   INNER JOIN tipo_reporte trpe
                                   ON trpe.id_tipo_reporte = conf.id_tipo_reporte_configuracion_reporte
                                   LEFT JOIN consecutivo_reporte ctvo
                                   ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
                                   WHERE edte.documento_estudiante_reporte = '$student_document'
                                   ORDER BY edte.apellido_estudiante_reporte,
                                            edte.nombre_estudiante_reporte");
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
