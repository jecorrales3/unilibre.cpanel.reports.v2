<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the consecutive list              **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 06/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 06/02/2020                **
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
    $queryResult = $mysqli->query("SELECT ctvo.id_consecutivo_reporte,
	                                        ctvo.vigencia_desde_consecutivo_reporte,
                                          ctvo.vigencia_hasta_consecutivo_reporte,
                                          ctvo.year_consecutivo_reporte,
                                          ctvo.consecutivo_desde_reporte,
                                          ctvo.consecutivo_actual_reporte,
                                          ctvo.consecutivo_hasta_reporte,
                                          ctvo.consecutivo_restante_reporte,
                                          etdo.id_estado_consecutivo_reporte,
                                          etdo.nombre_estado_consecutivo_reporte,
                                          tipo.id_tipo_consecutivo_reporte,
                                          tipo.nombre_tipo_consecutivo_reporte,
                                          fctd.id_facultad,
                                          fctd.nombre_facultad,
                                          fctd.siglas_facultad
                                     FROM consecutivo_reporte ctvo
                                    INNER JOIN estado_consecutivo_reporte etdo
                                    ON etdo.id_estado_consecutivo_reporte = ctvo.id_estado_consecutivo_reporte
                                    INNER JOIN tipo_consecutivo_reporte tipo
                                    ON tipo.id_tipo_consecutivo_reporte = ctvo.id_tipo_consecutivo_reporte
                                    INNER JOIN facultad fctd
                                    ON fctd.id_facultad = ctvo.id_facultad_consecutivo_reporte
                                    ORDER BY etdo.id_estado_consecutivo_reporte ASC,
                                             ctvo.year_consecutivo_reporte DESC");
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
