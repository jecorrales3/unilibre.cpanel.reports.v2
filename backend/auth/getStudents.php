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

  //Evaluate connection with MySql
  if ($mysqli)
  {
    $mysqli->set_charset('utf8');
    $queryResult = $mysqli->query("SELECT edte.id_estudiante_reporte,
                                  	      edte.nombre_estudiante_reporte,
                                          edte.apellido_estudiante_reporte,
                                          edte.documento_estudiante_reporte,
                                          cdad.nombre_ciudad,
                                          COUNT(*) AS contador_reporte,
                                          fctd.nombre_facultad,
                                          fctd.siglas_facultad
                                     FROM estudiante_reporte edte
                                     LEFT JOIN ciudad cdad
                                     ON cdad.id_ciudad = edte.id_ciudad_estudiante_reporte
                                     INNER JOIN configuracion_reporte conf
                                     ON conf.id_configuracion_reporte = edte.id_configuracion_estudiante_reporte
                                     INNER JOIN facultad fctd
                                     ON fctd.id_facultad = conf.id_facultad_final_configuracion_reporte
                                     GROUP BY edte.documento_estudiante_reporte
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
