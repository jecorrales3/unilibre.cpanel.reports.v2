<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document consult the member list of a faculty     **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 9/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 9/01/2020                **
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
  $faculty_id = $_GET['faculty_id'];

  //Evaluate connection with MySql
  if (isset($faculty_id))
  {
    $mysqli->set_charset('utf8');
    $queryResult = $mysqli->query("SELECT itgt.nombre_integrante,
                                          itgt.apellido_integrante,
                                          itgt.correo_integrante,
                                          itgt.cedula_integrante,
                                          itgt.fecha_registro_integrante,
                                          tint.id_tipo_integrante,
                                          tint.nombre_tipo_integrante
                                     FROM integrante itgt
                                   INNER JOIN tipo_integrante tint
                                   ON tint.id_tipo_integrante = itgt.id_tipo_integrante
                                   INNER JOIN facultad fctd
                                   ON fctd.id_facultad = itgt.id_facultad_integrante
                                   WHERE itgt.id_funcionalidad_integrante = '1'
                                   AND fctd.id_facultad = '$faculty_id'");
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
