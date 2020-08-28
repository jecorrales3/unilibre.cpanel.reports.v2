<?php
  // C5 -> Paz y Salvos (Asesorado)
  // C5 -> Paz y Salvos (Auxiliares de Investigación)
  // C5 -> Paz y Salvos (Seminario Internacional)
  // C5 -> Paz y Salvos (Semillero de Investigación)

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document register a report (C5)                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 01/02/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 01/02/2020                **
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
    $program_id           = $_POST['report_settings_c5'][0]['programa_reporte'];
    $type_report          = $_POST['report_settings_c5'][0]['tipo_reporte'];
    $seminar_name_report  = $_POST['report_settings_c5'][0]['seminario_reporte'];
    $university_report    = $_POST['report_settings_c5'][0]['colaboracion_reporte'];
    //Validation title
    if ($type_report == 8)
    {
      $title_report = "Reporte sin título (N/A)";
    }
    else
    {
      $title_report = $_POST['report_settings_c5'][0]['titulo_reporte'];
    }

    //Get the final values
    $program_data         = getProgramData($program_id);

    //Program array
    $program_name         = $program_data['program_name'];
    $program_title        = $program_data['program_title'];

    //Counter
    $count = 0;
    //Status
    $response["status"] = true;

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
                                            itgt.apellido_integrante,
                                            itgt.https_firma_integrante
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
              $director_name      = $row_member['nombre_integrante'];
              $director_lastname  = $row_member['apellido_integrante'];
              $director_signature = $row_member['https_firma_integrante'];
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
                                          `nombre_programa_facultad_reporte`, `titulo_programa_facultad_reporte`, `nombre_decano_facultad_reporte`,
                                          `apellido_decano_facultad_reporte`, `nombre_director_facultad_reporte`, `apellido_director_facultad_reporte`,
                                          `https_firma_director_facultad_reporte`)
                              VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      //Prepared query
      $inserted_faculty = $mysqli->prepare($insertQueryFaculty);
      //Parameters
      $inserted_faculty->bind_param("sssssssss", $faculty_name,  $faculty_acronym, $program_name,
                                                 $program_title, $dean_name,       $dean_lastname,
                                                 $director_name, $director_lastname, $director_signature);
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
                                                 (`id_configuracion_reporte`, `titulo_configuracion_reporte`, `fecha_generacion_configuracion_reporte`,
                                                  `marco_seminario_configuracion_reporte`, `universidad_seminario_configuracion_reporte`,
                                                  `id_facultad_configuracion_reporte`, `id_resultado_configuracion_reporte`, `id_usuario_configuracion_reporte`,
                                                  `id_funcionalidad_configuracion_reporte`, `id_facultad_final_configuracion_reporte`, `id_tipo_reporte_configuracion_reporte`)
                                      VALUES (NULL, ?, CURDATE(), ?, ?, ?, '1', ?, '1', ?, ?)";
        //Prepared query
        $inserted_configuration = $mysqli->prepare($insertQueryConfiguration);
        //Parameters
        $inserted_configuration->bind_param("sssiiii", $title_report, $seminar_name_report, $university_report, $faculty_id, $user_id, $user_faculty_id, $type_report);
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
          foreach ($_POST['report_students_c5'] as $student)
          {
            $student_name     = $student['nombre_estudiante'];
            $student_lastname = $student['apellido_estudiante'];
            $student_document = $student['documento_estudiante'];

            //Query to register new faculty report
            $insertQueryStudents  = "INSERT INTO `estudiante_reporte`
                                                (`id_estudiante_reporte`, `nombre_estudiante_reporte`, `apellido_estudiante_reporte`,
                                                 `documento_estudiante_reporte`, `id_configuracion_estudiante_reporte`)
                                     VALUES (NULL, ?, ?, ?, ?)";
            //Prepared query
            $inserted_student = $mysqli->prepare($insertQueryStudents);
            //Parameters
            $inserted_student->bind_param("sssi", $student_name, $student_lastname, $student_document,
                                                  $configuration_id);
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
          if (isset($_POST['report_members_c5']))
          {
            //Get the members report
            foreach ($_POST['report_members_c5'] as $member)
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
          }


          if ($response["status"])
          {
            $message = "Reporte generado.";
            //Response
            $response['message']          = $message;
            $response['configuration_id'] = $configuration_id;
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
    $response["message"] = "Missing mandatory parameters";
  }

  //Display the JSON response
  echo json_encode($response);


 ?>
