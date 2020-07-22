<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the report list (last 5)          **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 02/03/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 02/03/2020                **
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
    $queryResult = $mysqli->query("SELECT conf.id_configuracion_reporte,
	                                        tipo.id_tipo_reporte,
	                                        tipo.nombre_tipo_reporte,
	                                        (SELECT COUNT(*) FROM estudiante_reporte edte WHERE edte.id_configuracion_estudiante_reporte = conf.id_configuracion_reporte) AS contador_estudiante,
	                                        (SELECT GROUP_CONCAT(CONCAT(edte.nombre_estudiante_reporte, ' ', edte.apellido_estudiante_reporte) SEPARATOR ', ') FROM estudiante_reporte edte WHERE edte.id_configuracion_estudiante_reporte = conf.id_configuracion_reporte) AS listado_estudiante,
                                          conf.fecha_generacion_configuracion_reporte,
                                          fcnd.id_funcionalidad,
	                                        fcnd.nombre_funcionalidad
                                     FROM configuracion_reporte conf
                                    INNER JOIN tipo_reporte tipo
                                    ON tipo.id_tipo_reporte = conf.id_tipo_reporte_configuracion_reporte
                                    INNER JOIN funcionalidad fcnd
                                    ON fcnd.id_funcionalidad = conf.id_funcionalidad_configuracion_reporte
                                    WHERE conf.id_facultad_final_configuracion_reporte = '$faculty_id'
                                    ORDER BY conf.id_configuracion_reporte DESC
                                    LIMIT 5");
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
