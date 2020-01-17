<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document alloes the faculties                     **
  ** @author       Juan Castaño | juand-castanof@unilibre.edu.co             **
  ** @created      The PHP document was create on 13/12/2019                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 13/12/2019                **
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
    $queryResult = $mysqli->query("SELECT fctd.id_facultad,
                                          fctd.nombre_facultad,
                                          fctd.siglas_facultad,
                                          fctd.fecha_registro_facultad,
                                          cdad.id_ciudad,
                                          cdad.nombre_ciudad,
                                          dpto.nombre_departamento,
                                          (SELECT COUNT(*)
                                           FROM integrante intg
                                           WHERE intg.id_facultad_integrante = fctd.id_facultad
                                          ) AS contador_integrantes
                                   FROM facultad fctd
                                   INNER JOIN ciudad cdad
                                   ON cdad.id_ciudad = fctd.id_ciudad_facultad
                                   INNER JOIN departamento dpto
                                   ON dpto.id_departamento = cdad.id_departamento_ciudad
                                   WHERE fctd.id_funcionalidad_facultad = '1'
                                   ORDER BY fctd.nombre_facultad DESC");
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
