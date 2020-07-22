<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the list of report counters       **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 28/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 28/02/2020                **
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
  $faculty_id = $_SESSION['user']['id_facultad_usuario'];

  //Evaluate connection with MySql
  if ($mysqli)
  {
    $mysqli->set_charset('utf8');
    $queryResult = $mysqli->query("SELECT YEAR(conf.fecha_generacion_configuracion_reporte) AS year_report,
                                          tipo.id_tipo_reporte,
                                  	      tipo.nombre_tipo_reporte,
                                          fctd.nombre_facultad,
                                          fctd.siglas_facultad,
                                          COUNT(*) AS counter_report
                                  FROM configuracion_reporte conf
                                  INNER JOIN tipo_reporte tipo
                                  ON tipo.id_tipo_reporte = conf.id_tipo_reporte_configuracion_reporte
                                  INNER JOIN facultad fctd
                                  ON fctd.id_facultad = conf.id_facultad_final_configuracion_reporte
                                  WHERE conf.id_funcionalidad_configuracion_reporte = '1'
                                  AND conf.id_facultad_final_configuracion_reporte = '$faculty_id'
                                  GROUP BY tipo.id_tipo_reporte,
                                  	       year_report
                                  ORDER BY year_report DESC");
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
