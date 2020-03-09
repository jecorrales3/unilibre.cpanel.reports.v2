<?php
  // C6 -> Homologación Auxiliar (Inactivo)

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document register a report (C6)                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 27/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 27/01/2020                **
  ** @who        - Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @why        - Creation                                                  **

  ** @modified   - The PHP document was disabled on 21/02/2020               **
  ** @why        - University requirements                                   **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  */
  //Array for results
  $response = array();
  //Include files
  include '../db/db_connection.php';
  include 'certificate_query.php';
  //Session start
  session_start();
  //User id
  $user_id         = $_SESSION['user']['id_usuario'];
  $user_faculty_id = $_SESSION['user']['id_facultad_usuario'];
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  if(isset($_POST))
	{
    //Object UTF8
    $mysqli->set_charset('utf8');

    //Post variables (Settings)
    $program_id   = $_POST['report_settings_C6'][0]['programa_reporte'];
    $date_report  = $_POST['report_settings_C6'][0]['fecha_reporte'];
    $time_report  = $_POST['report_settings_C6'][0]['hora_reporte'];
    $title_report = $_POST['report_settings_C6'][0]['titulo_reporte'];

    //Get the final values
    $program_data      = getProgramData($program_id);
    $state_consecutive = validateConsecutiveC6($user_faculty_id);
    $consecutive_data  = getConsecutiveDataC6($user_faculty_id);

    //Consecutive array
    $consecutive_id      = $consecutive_data['consecutive_id'];
    $current_consecutive = $consecutive_data['current_consecutive'];

    //Program array
    $program_name      = $program_data['program_name'];

    //Counter
    $count = 0;
    //Status
    $response["status"]  = true;


    /*
    echo "Program: " . $program_report;
    echo "Adviser: " . $adviser_report;
    echo "Title: " . $title_report;
    */

    if ($state_consecutive == 1)
    {
      /*
      *****************************************************************************
      *****************************************************************************
      ***********************     QUERY FACULTY REPORT      ***********************
      *****************************************************************************
      *****************************************************************************
      */
      $query_faculty = $mysqli->query("SELECT fctd.id_facultad,
                                              fctd.nombre_facultad,
                                              fctd.siglas_facultad
                                         FROM usuario usro
                                       INNER JOIN facultad fctd
                                       ON fctd.id_facultad = usro.id_facultad_usuario
                                       WHERE usro.id_usuario = '$user_id'");

      $data_faculty = array();

      while ($row_faculty = $query_faculty->fetch_assoc())
      {
        $data_faculty[]   = $row_faculty;
        $faculty_name     = $row_faculty['nombre_facultad'];
        $faculty_acronym  = $row_faculty['siglas_facultad'];
      }

      /*
      *****************************************************************************
      *****************************************************************************
      ***********************     QUERY MEMBERS REPORT      ***********************
      *****************************************************************************
      *****************************************************************************
      */
      $query_members = $mysqli->query("SELECT itgt.id_integrante,
                                    	        itgt.nombre_integrante,
                                              itgt.apellido_integrante
                                       FROM integrante itgt
                                       INNER JOIN tipo_integrante tint
                                       ON tint.id_tipo_integrante = itgt.id_tipo_integrante
                                       WHERE itgt.id_funcionalidad_integrante = '1'
                                       AND itgt.id_facultad_integrante = '$user_faculty_id'
                                       AND itgt.id_tipo_integrante != '3'
                                       ORDER BY itgt.id_tipo_integrante ASC");

      $data_members = array();

      while ($row_member = $query_members->fetch_assoc())
      {
        $data_members[]  = $row_member;
        $count++;

        switch ($count)
        {
            case 1:
                $dean_name     = $row_member['nombre_integrante'];
                $dean_lastname = $row_member['apellido_integrante'];
                break;
            case 2:
                $director_name     = $row_member['nombre_integrante'];
                $director_lastname = $row_member['apellido_integrante'];
                break;
            default:
                $response["status"]  = false;
        }
      }

      if ($response["status"])
      {
        /*
        *****************************************************************************
        *****************************************************************************
        *********************     REGISTER FACULTY REPORT      **********************
        *****************************************************************************
        *****************************************************************************
        */
        //Query to register new faculty report
        $insertQueryFaculty  = "INSERT INTO `facultad_reporte`
                                            (`id_facultad_reporte`, `nombre_facultad_reporte`, `siglas_facultad_reporte`,
                                             `nombre_programa_facultad_reporte`, `nombre_decano_facultad_reporte`, `apellido_decano_facultad_reporte`,
                                             `nombre_director_facultad_reporte`, `apellido_director_facultad_reporte`)
                                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        //Prepared query
        $inserted_faculty = $mysqli->prepare($insertQueryFaculty);
        //Parameters
        $inserted_faculty->bind_param("sssssss", $faculty_name, $faculty_acronym, $program_name,
                                                 $dean_name,    $dean_lastname,   $director_name,
                                                 $director_lastname);
        //Evaluate if the query was executed
        if($inserted_faculty->execute())
        {
          //Getting the id on system
          $faculty_id = $mysqli->insert_id;
        }
        else
        {
          $response['message_error'] = "Error (execute query in facultad_reporte): " . $inserted_faculty->error;
        }


        if (isset($faculty_id))
        {
          /*
          *****************************************************************************
          *****************************************************************************
          *******************    REGISTER CONFIGURATION REPORT     ********************
          *****************************************************************************
          *****************************************************************************
          */
          //Query to register new faculty report
          $insertQueryConfiguration  = "INSERT INTO `configuracion_reporte`
                                                   (`id_configuracion_reporte`, `titulo_configuracion_reporte`, `fecha_generacion_configuracion_reporte`, `fecha_sustentacion_configuracion_reporte`, `hora_sustentacion_configuracion_reporte`,
                                                    `id_facultad_configuracion_reporte`, `id_resultado_configuracion_reporte`, `id_usuario_configuracion_reporte`,
                                                    `id_funcionalidad_configuracion_reporte`, `id_consecutivo_configuracion_reporte`, `id_facultad_final_configuracion_reporte`,
                                                    `id_tipo_reporte_configuracion_reporte`)
                                        VALUES (NULL, ?, CURDATE(), ?, ?, ?, '1', ?, '1', ?, ?, '2')";
          //Prepared query
          $inserted_configuration = $mysqli->prepare($insertQueryConfiguration);
          //Parameters
          $inserted_configuration->bind_param("sssiiii", $title_report, $date_report, $time_report, $faculty_id, $user_id, $consecutive_id, $user_faculty_id);
          //Evaluate if the query was executed
          if($inserted_configuration->execute())
          {
            //Getting the id on system
            $configuration_id = $mysqli->insert_id;
          }
          else
          {
            $response['message_error'] = "Error (execute query in facultad_reporte): " . $inserted_configuration->error;
          }

          if ($configuration_id)
          {
            /*
            *****************************************************************************
            *****************************************************************************
            *********************     REGISTER STUDENTS REPORT     **********************
            *****************************************************************************
            *****************************************************************************
            */
            //Get the students report
            foreach ($_POST['report_students_C6'] as $student)
            {
              $student_name     = $student['nombre_estudiante'];
              $student_lastname = $student['apellido_estudiante'];
              $student_document = $student['documento_estudiante'];

              //Query to register new faculty report
              $insertQueryStudents  = "INSERT INTO `estudiante_reporte`
                                                  (`id_estudiante_reporte`, `nombre_estudiante_reporte`, `apellido_estudiante_reporte`, `documento_estudiante_reporte`,
                                                   `id_configuracion_estudiante_reporte`)
                                       VALUES (NULL, ?, ?, ?, ?)";
              //Prepared query
              $inserted_student = $mysqli->prepare($insertQueryStudents);
              //Parameters
              $inserted_student->bind_param("sssi", $student_name, $student_lastname, $student_document, $configuration_id);
              //Evaluate if the query was executed
              if($inserted_student->execute())
              {
                $inserted_data_student = $inserted_student->affected_rows;

                if ($inserted_data_student > 0)
                {
                  $response["status"]  = true;
                }
                else
                {
                  $response["status"]  = false;
                }
              }
              else
              {
                $response['message_error'] = "Error (execute query in estudiante_reporte): " . $inserted_student->error;
              }
            }


            /*
            *****************************************************************************
            *****************************************************************************
            **********************     REGISTER MEMBERS REPORT     **********************
            *****************************************************************************
            *****************************************************************************
            */
            //Get the members report
            foreach ($_POST['report_members_C6'] as $member)
            {
              $member_name     = $member['nombre_integrante'];
              $member_lastname = $member['apellido_integrante'];
              $member_document = $member['cedula_integrante'];
              $member_type     = $member['id_tipo_integrante'];
              $member_position = $member['id_tipo_cargo_integrante'];

              //Query to register new faculty report
              $insertQueryMembers  = "INSERT INTO `integrante_reporte`
                                                 (`id_integrante_reporte`, `nombre_integrante_reporte`, `apellido_integrante_reporte`,
                                                  `cedula_integrante_reporte`, `id_tipo_integrante_reporte`, `id_tipo_cargo_integrante_reporte`,
                                                  `id_configuracion_integrante_reporte`)
                                       VALUES (NULL, ?, ?, ?, ?, ?, ?)";
              //Prepared query
              $inserted_member = $mysqli->prepare($insertQueryMembers);
              //Parameters
              $inserted_member->bind_param("sssiii", $member_name, $member_lastname, $member_document, $member_type, $member_position, $configuration_id);
              //Evaluate if the query was executed
              if($inserted_member->execute())
              {
                $inserted_data_member = $inserted_member->affected_rows;

                if ($inserted_data_member > 0)
                {
                  $response["status"]  = true;
                }
                else
                {
                  $response["status"]  = false;
                }
              }
              else
              {
                $response['message_error'] = "Error (execute query in integrante_reporte): " . $inserted_member->error;
              }
            }


            if ($response["status"])
            {
              //Query to update a consecutive
              $updateQuery  = "UPDATE configuracion_reporte conf
                               INNER JOIN consecutivo_reporte ctvo
                               ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
                               SET conf.codigo_configuracion_reporte = ? + 1,
                                   ctvo.consecutivo_actual_reporte   = ? + 1,
                                   ctvo.consecutivo_restante_reporte = ctvo.consecutivo_restante_reporte - 1
                               WHERE conf.id_configuracion_reporte   = ?";
              //Prepared query
              $stmt = $mysqli->prepare($updateQuery);
              //Parameters
              $stmt->bind_param("iii", $current_consecutive, $current_consecutive, $configuration_id);
              //Evaluate if the query was executed
              if($stmt->execute())
              {
                $updated_data = $stmt->affected_rows;
                $message = ($updated_data > 0) ? "Reporte generado." : "Error al generar el reporte" . $stmt->error;
                //Response
                $response['message']          = $message;
                $response['configuration_id'] = $configuration_id;
              }
              else
              {
                $response['message_error'] = "Error (execute query): " . $stmt->error;
              }
            }
            else
            {
              $response['message'] = "Algo ha fallado al tratar de registrar Estudiantes, Jurados o Asesores; inténtalo de nuevo.";
            }


          }
          else
          {
            $response["status"]  = false;
            $response["message"] = "Error al obtener el identificador (id_configuracion_reporte)";
          }
        }
        else
        {
          $response["status"]  = false;
          $response["message"] = "Verificar si los integrantes están correctamente registrados, Decano y Director de investigaciones (id_facultad_reporte)";
        }
      }
      else
      {
        $response["status"]  = false;
        $response["message"] = "Parámetros del Decano y el Director de investigaciones incorrectos; Verifica el número de integrantes para los roles mencionados.";
      }
    }
    else
    {
      $response["status"]  = false;
      $response["message"] = "El consecutivo no cumple con las condiciones necesarias para generar el reporte.";
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
