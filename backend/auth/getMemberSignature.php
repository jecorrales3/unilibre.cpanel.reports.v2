<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document alloes the members (signature)           **
  ** @author       Juan Castaño | johan-corralesa@unilibre.edu.co            **
  ** @created      The PHP document was create on 19/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 19/02/2020                **
  ** @who        - Juan Castaño | johan-corralesa@unilibre.edu.co            **
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
    $queryResult = $mysqli->query("SELECT itgt.id_integrante,
                                  	      itgt.nombre_integrante,
                                          itgt.apellido_integrante,
                                          itgt.correo_integrante,
                                          itgt.cedula_integrante,
                                          itgt.fecha_registro_integrante,
                                          itgt.https_firma_integrante,
                                          itgt.imagen_firma_integrante,
                                          tint.id_tipo_integrante,
                                          tint.nombre_tipo_integrante,
                                          fctd.id_facultad,
                                          fctd.nombre_facultad,
                                          fctd.siglas_facultad
                                     FROM integrante itgt
                                   INNER JOIN tipo_integrante tint
                                   ON tint.id_tipo_integrante = itgt.id_tipo_integrante
                                   INNER JOIN facultad fctd
                                   ON fctd.id_facultad = itgt.id_facultad_integrante
                                   WHERE itgt.id_funcionalidad_integrante = '1'
                                   AND tint.id_tipo_integrante            = '2'
                                   ORDER BY fctd.nombre_facultad     ASC,
                                            tint.id_tipo_integrante  ASC,
                                            itgt.apellido_integrante ASC,
                                            itgt.nombre_integrante   ASC");
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
