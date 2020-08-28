<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document upload a file (member signature)         **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 19/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 19/02/2020                **
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

  //Check for Mandatory parameters
  if(isset($_GET['member_id']) && isset($_FILES['file']))
  {
    //Object UTF8
    $mysqli->set_charset('utf8');

    //Get variables
    $member_id  = $_GET['member_id'];
    //File Information
    $file_name  = $_FILES['file']['name'];
    $file_type  = $_FILES['file']['type'];
    $file_size  = $_FILES['file']['size'];
    $file_temp  = $_FILES['file']['tmp_name'];
    //File route
    $file_route  = "static/images/signature/";
    //$file_route  = "img/unilibre/signatures/";
    $route       = $file_route . $file_name;
    $final_route = $file_route. "/";
    //Information about file
    $file_info  = pathinfo($route, PATHINFO_EXTENSION);
    $name       = "signature_member_" . $member_id;


    /*
    echo "ID: " . $member_id;
    echo "Name: " . $file_name;
    echo "Type: " . $file_type;
    echo "Size: " . $file_size;
    echo "Temp: " . $file_temp;
    */

    //Evaluate the route
    if(!is_dir($file_route))
    {
      mkdir($file_route, 0777, true);
    }

    if ($file_type == "image/png" || $file_type == "image/jpg" || $file_type == "image/jpeg" && $file_size <= 2000000)
    {
      if(move_uploaded_file($file_temp, $route))
      {
        //Rename file
        rename($route, $final_route . $name . "." . $file_info);
        //Final file
        $route = '/app/backend/production/file/' . $file_route . $name . "." . $file_info;
        $https = 'https://' . $_SERVER['HTTP_HOST'] . '/app/backend/production/file/' . $file_route . $name . "." . $file_info;

        //Query to update a member signature
        $insertQuery  = "UPDATE integrante
                            SET https_firma_integrante  = ?,
                                imagen_firma_integrante = ?,
                                fecha_firma_integrante  = CURDATE()
                          WHERE id_integrante           = ?";
        //Prepared query
        $stmt = $mysqli->prepare($insertQuery);
        //Parameters
        $stmt->bind_param("ssi", $https, $route, $member_id);
        //Evaluate if the query was executed
        if($stmt->execute())
        {
          $updated_data = $stmt->affected_rows;
          $message = ($updated_data > 0) ? "El servidor ha procesado la firma digital del integrante." : "No se ha detectado cambios en la información." . $stmt->error;
          $response['message'] = $message;
        }
        else
        {
          $response['message'] = "Error (execute query): " . $stmt->error;
        }
      }
      else
      {
        $response['message'] = "La imagen no se encuentra como registro temporal.";
      }
    }
    else
    {
      $response['message'] = "El archivo no cumple los parámetros necesarios.";
    }

  }
  else
  {
    $response["status"]  = false;
    $response["message"] = "Missing mandatory parameters";
  }

  //Display the JSON response
  echo json_encode($response);

 ?>
