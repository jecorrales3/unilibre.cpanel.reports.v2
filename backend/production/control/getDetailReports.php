<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document consult the reports by year, month       **
  **               and program                                               **
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
  // Headers
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

  //Array for results
  $response = array();
  //Include files
  include '../db/db_connection.php';
  //Session start
  session_start();

  //$_GET Value
  $type_report  = $_GET['type_report'];
  $year_report  = $_GET['year_report'];
  $month_report = $_GET['month_report'];

  //Evaluate connection with MySql
  if (isset($type_report) && isset($year_report) && isset($month_report) && isset($_SESSION['user']))
  {
    $mysqli->set_charset('utf8');
    //User information
    $user_id      = $_SESSION['user']['id_usuario'];
    $user_type    = $_SESSION['user']['id_tipo_usuario'];
    $user_faculty = $_SESSION['user']['id_facultad_usuario'];

    //Get the user query
    if ($user_type == 1)
    {
      $queryResult = $mysqli->query("SELECT conf.id_configuracion_reporte,
                                    	      conf.titulo_configuracion_reporte,
                                            DATE_FORMAT(conf.fecha_generacion_configuracion_reporte,  '%d/%m/%Y') AS fecha_generacion_configuracion_reporte,
                                            DATE_FORMAT(conf.fecha_sustentacion_configuracion_reporte,'%d/%m/%Y') AS fecha_sustentacion_configuracion_reporte,
                                            TIME_FORMAT(conf.hora_sustentacion_configuracion_reporte, '%h:%i %p') hora_sustentacion_reporte,
                                            conf.codigo_configuracion_reporte,
                                            fctd.nombre_facultad,
                                            fctd.siglas_facultad,
                                            frpt.nombre_facultad_reporte,
                                            IF(frpt.nombre_programa_facultad_reporte IS NULL, 'N/A', frpt.nombre_programa_facultad_reporte) AS nombre_programa_facultad_reporte,
                                            rtdo.nombre_resultado_reporte,
                                            usro.nombre_usuario,
                                            usro.apellido_usuario,
                                            usro.correo_usuario,
                                            ctvo.year_consecutivo_reporte,
                                            trpt.id_tipo_reporte,
                                            trpt.nombre_tipo_reporte,
                                            fdad.id_funcionalidad,
                                            fdad.nombre_funcionalidad
                                       FROM configuracion_reporte conf
                                     INNER JOIN facultad_reporte frpt
                                     ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                     INNER JOIN resultado_reporte rtdo
                                     ON rtdo.id_resultado_reporte = conf.id_resultado_configuracion_reporte
                                     INNER JOIN usuario usro
                                     ON usro.id_usuario = conf.id_usuario_configuracion_reporte
                                     INNER JOIN funcionalidad fdad
                                     ON fdad.id_funcionalidad = conf.id_funcionalidad_configuracion_reporte
                                     LEFT JOIN consecutivo_reporte ctvo
                                     ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
                                     INNER JOIN facultad fctd
                                     ON fctd.id_facultad = conf.id_facultad_final_configuracion_reporte
                                     INNER JOIN tipo_reporte trpt
                                     ON trpt.id_tipo_reporte = conf.id_tipo_reporte_configuracion_reporte
                                     WHERE YEAR(conf.fecha_generacion_configuracion_reporte) = '$year_report'
                                     AND MONTH(conf.fecha_generacion_configuracion_reporte)  = '$month_report'
                                     AND trpt.id_tipo_reporte                                = '$type_report'
                                     ORDER BY fdad.id_funcionalidad ASC,
  		                                        conf.id_configuracion_reporte DESC");
    }
    else
    {
      $queryResult = $mysqli->query("SELECT conf.id_configuracion_reporte,
                                  	      conf.titulo_configuracion_reporte,
                                          DATE_FORMAT(conf.fecha_generacion_configuracion_reporte, '%d/%m/%Y') AS fecha_generacion_configuracion_reporte,
                                          DATE_FORMAT(conf.fecha_sustentacion_configuracion_reporte, '%d/%m/%Y') AS fecha_sustentacion_configuracion_reporte,
                                          TIME_FORMAT(conf.hora_sustentacion_configuracion_reporte, '%h:%i %p') hora_sustentacion_reporte,
                                          conf.codigo_configuracion_reporte,
                                          fctd.nombre_facultad,
                                          fctd.siglas_facultad,
                                          frpt.nombre_facultad_reporte,
                                          IF(frpt.nombre_programa_facultad_reporte IS NULL, 'N/A', frpt.nombre_programa_facultad_reporte) AS nombre_programa_facultad_reporte,
                                          rtdo.nombre_resultado_reporte,
                                          usro.nombre_usuario,
                                          usro.apellido_usuario,
                                          usro.correo_usuario,
                                          ctvo.year_consecutivo_reporte,
                                          trpt.id_tipo_reporte,
                                          trpt.nombre_tipo_reporte,
                                          fdad.id_funcionalidad,
                                          fdad.nombre_funcionalidad
                                     FROM configuracion_reporte conf
                                   INNER JOIN facultad_reporte frpt
                                   ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                   INNER JOIN resultado_reporte rtdo
                                   ON rtdo.id_resultado_reporte = conf.id_resultado_configuracion_reporte
                                   INNER JOIN usuario usro
                                   ON usro.id_usuario = conf.id_usuario_configuracion_reporte
                                   INNER JOIN funcionalidad fdad
                                   ON fdad.id_funcionalidad = conf.id_funcionalidad_configuracion_reporte
                                   LEFT JOIN consecutivo_reporte ctvo
                                   ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
                                   INNER JOIN facultad fctd
                                   ON fctd.id_facultad = conf.id_facultad_final_configuracion_reporte
                                   INNER JOIN tipo_reporte trpt
                                   ON trpt.id_tipo_reporte = conf.id_tipo_reporte_configuracion_reporte
                                   WHERE YEAR(conf.fecha_generacion_configuracion_reporte) = '$year_report'
                                   AND MONTH(conf.fecha_generacion_configuracion_reporte)  = '$month_report'
                                   AND trpt.id_tipo_reporte                                = '$type_report'
                                   AND conf.id_facultad_final_configuracion_reporte        = '$user_faculty'
                                   ORDER BY fdad.id_funcionalidad ASC,
		                                        conf.id_configuracion_reporte DESC");

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
