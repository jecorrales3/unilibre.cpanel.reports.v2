<?php
  // C2 -> Nombramiento de Asesor

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C2)                   **
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
  //Include files
  include '../db/db_connection.php';
  include '../control/certificate_query.php';
  include '../error/message_error.php';
  //mPDF class
  require_once __DIR__ . '../class/mPDF/vendor/autoload.php';

  //Session start
  session_start();

  //Counters
  $counter_members = 0;

  //Conectors
  $conector_students_1 = "el estudiante";
  $conector_students_2 = "ha";
  $conector_advisors_1 = "al doctor(a)";
  //$_GET
  $configuration_id = $_GET['configuration_id'];

  if(isset($configuration_id))
	{
    if(isset($_SESSION['user']))
    {
      //User data
      $user_id         = $_SESSION['user']['id_usuario'];
      $user_faculty_id = $_SESSION['user']['id_facultad_usuario'];


      //Object UTF8
      $mysqli->set_charset('utf8');

      if (validateReportC2($user_faculty_id, $configuration_id))
      {
        /*
        *****************************************************************************
        *****************************************************************************
        ********************     QUERY CONFIGURATION REPORT     *********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_configuration = $mysqli->query("SELECT frpt.nombre_facultad_reporte,
                                      	              conf.codigo_configuracion_reporte,
                                                      ctvo.year_consecutivo_reporte,
                                                      frpt.nombre_programa_facultad_reporte,
                                                      conf.fecha_generacion_configuracion_reporte,
                                                      DAY(conf.fecha_generacion_configuracion_reporte) AS dia_reporte,
                                                      CASE MONTH(conf.fecha_generacion_configuracion_reporte)
                                                           WHEN 1  THEN 'Enero'
                                                           WHEN 2  THEN 'Febrero'
                                                           WHEN 3  THEN 'Marzo'
                                                           WHEN 4  THEN 'Abril'
                                                           WHEN 5  THEN 'Mayo'
                                                           WHEN 6  THEN 'Junio'
                                                           WHEN 7  THEN 'Julio'
                                                           WHEN 8  THEN 'Agosto'
                                                           WHEN 9  THEN 'Septiembre'
                                                           WHEN 10 THEN 'Octubre'
                                                           WHEN 11 THEN 'Noviembre'
                                                           WHEN 12 THEN 'Diciembre'
                                                      END mes_letras_reporte,
                                                      YEAR(conf.fecha_generacion_configuracion_reporte) AS year_reporte,
                                      	              conf.titulo_configuracion_reporte,
                                                      rtdo.nombre_resultado_reporte,
                                                      conf.id_funcionalidad_configuracion_reporte
                                                 FROM configuracion_reporte conf
                                               INNER JOIN facultad_reporte frpt
                                               ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                               INNER JOIN consecutivo_reporte ctvo
                                               ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
                                               INNER JOIN resultado_reporte rtdo
                                               ON rtdo.id_resultado_reporte = conf.id_resultado_configuracion_reporte
                                               WHERE conf.id_configuracion_reporte = '$configuration_id'");

        $data_configuration = array();

        while ($row_configuration = $query_configuration->fetch_assoc())
        {
          $data_configuration[]         = $row_configuration;
          $faculty_name_report          = $row_configuration['nombre_facultad_reporte'];
          $consecutive_year_report      = $row_configuration['year_consecutivo_reporte'];
          $program_name_report          = $row_configuration['nombre_programa_facultad_reporte'];
          $date_report                  = $row_configuration['fecha_generacion_configuracion_reporte'];
          $day_report                   = $row_configuration['dia_reporte'];
          $month_report                 = $row_configuration['mes_letras_reporte'];
          $year_report                  = $row_configuration['year_reporte'];
          $title_report                 = $row_configuration['titulo_configuracion_reporte'];
          $result_report                = $row_configuration['nombre_resultado_reporte'];
          $consecutive_code_report      = $row_configuration['codigo_configuracion_reporte'];
          $state_report                 = $row_configuration['id_funcionalidad_configuracion_reporte'];

          //Format value
          if ($consecutive_code_report <= 9)
          {
            $consecutive_code_report = '0' . $consecutive_code_report;
          }
        }

        /*
        *****************************************************************************
        *****************************************************************************
        **********************     QUERY STUDENTS REPORT      ***********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_students = $mysqli->query("SELECT edte.nombre_estudiante_reporte,
  	                                             edte.apellido_estudiante_reporte
                                            FROM estudiante_reporte edte
                                           WHERE edte.id_configuracion_estudiante_reporte = '$configuration_id'
                                           ORDER BY edte.apellido_estudiante_reporte ASC
                                           LIMIT 3");

        $data_students_list = array();
        //Counting rows
        $number_students = mysqli_num_rows($query_students);

        if ($number_students > 1)
        {
          $conector_students_1 = "los estudiantes";
          $conector_students_2 = "han";
        }

        while ($row_student_list = $query_students->fetch_assoc())
        {
          //Counter row
          $counter_students++;
          //Array
          $data_students_list[]  = $row_student_list;

          $student_name = mb_strtoupper($row_student_list['nombre_estudiante_reporte']) . " " . mb_strtoupper($row_student_list['apellido_estudiante_reporte']);

          //Query rows
          if (--$number_students != 0)
          {
            $conector       = (count($data_students_list) == 1) ? " " : ", ";
            $students_list .= $student_name . $conector;
          }
          else
          {
            $conector       = (count($data_students_list) > 1) ? "y" : "";
            $students_list .= $conector . ' ' . $student_name;
          }
        }

        /*
        *****************************************************************************
        *****************************************************************************
        ************************     QUERY JURIES REPORT     ************************
        *****************************************************************************
        *****************************************************************************
        */
        $query_advisors = $mysqli->query("SELECT igte.nombre_integrante_reporte,
  	                                             igte.apellido_integrante_reporte
                                            FROM integrante_reporte igte
                                          INNER JOIN tipo_cargo_reporte tipo
                                          ON tipo.id_tipo_cargo_reporte = igte.id_tipo_cargo_integrante_reporte
                                          WHERE igte.id_configuracion_integrante_reporte = '$configuration_id'
                                          AND tipo.id_tipo_cargo_reporte = '1'");

        $data_advisors_list = array();
        //Counting rows
        $number_advisors = mysqli_num_rows($query_advisors);

        if ($number_advisors > 1)
        {
          $conector_advisors_1 = "los doctores";
        }

        while ($row_advisors_list = $query_advisors->fetch_assoc())
        {
          //Array
          $data_advisors_list[]  = $row_advisors_list;

          $adviser_name = mb_strtoupper($row_advisors_list['nombre_integrante_reporte']) . " " . mb_strtoupper($row_advisors_list['apellido_integrante_reporte']);

          //Query rows
          if (--$number_advisors != 0)
          {
            $conector       = (count($data_advisors_list) == 1) ? ", " : " ";
            $advisors_list .= $adviser_name . $conector;
          }
          else
          {
            $conector       = (count($data_advisors_list) > 1) ? "y" : "";
            $advisors_list .= $conector . ' ' . $adviser_name;
          }
        }

        /*
        *****************************************************************************
        *****************************************************************************
        **********************    QUERY MAIN MEMBERS REPORT   ***********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_main_members = $mysqli->query("SELECT frpt.nombre_decano_facultad_reporte,
  	                                            frpt.apellido_decano_facultad_reporte,
                                                frpt.nombre_director_facultad_reporte,
                                                frpt.apellido_director_facultad_reporte
                                           FROM configuracion_reporte conf
                                         INNER JOIN facultad_reporte frpt
                                         ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                         WHERE conf.id_facultad_final_configuracion_reporte = '$user_faculty_id'
                                         AND conf.id_configuracion_reporte = '$configuration_id'
                                         LIMIT 2");

        $data_main_members = array();

        while ($row_main_member = $query_main_members->fetch_assoc())
        {
          //Array
          $data_main_members[]      = $row_main_member;
          //Query rows
          $dean_name_report         = $row_main_member['nombre_decano_facultad_reporte'];
          $dean_lastname_report     = $row_main_member['apellido_decano_facultad_reporte'];
          $director_name_report     = $row_main_member['nombre_director_facultad_reporte'];
          $director_lastname_report = $row_main_member['apellido_director_facultad_reporte'];
        }


        /*
        *****************************************************************************
        *****************************************************************************
                          FORMAT STRING FOR FACULTY NAME REPORT
        *****************************************************************************
        *****************************************************************************
        */
        $string = mb_convert_case($faculty_name_report, MB_CASE_TITLE, "UTF-8");

        $words = explode(" ", $string);
        $format_faculty_report = "";
        foreach ($words as $w)
        {
  	       if(strlen($w) >2)
           {
  		         $format_faculty_report.= ucwords(strtolower($w)).' ';
  	       }
           else
           {
  		         $format_faculty_report.= strtolower($w).' ';
  	       }
        }


        /*
        *****************************************************************************
        *****************************************************************************
                    PREPARAMOS LOS MARGENES Y TIPO DE PAGINA DEL PDF
        *****************************************************************************
        *****************************************************************************
        */
        $mpdf = new \Mpdf\Mpdf(
        [
          'setAutoTopMargin'    => 'stretch',
          'autoMarginPadding'   => 5,
          'setAutoBottomMargin' => 'stretch',
          'autoMarginPadding'   => 7
        ]);

        //Indicamos el titulo de la pagina
        $mpdf->SetTitle("NOMBRAMIENTO DE ASESOR - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report);

        /*
        *****************************************************************************
        *****************************************************************************
                         DECLARAMOS LA CABECERA DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        // Define the Header/Footer before writing anything so they appear on the first page
        $mpdf->SetHTMLHeader('
        <div>
          <img src="../class/PDF/images/unilibre_header.png" class="img-fluid" style="height: 120px; width: 1170px;" alt="Responsive image">
        </div>');

        /*
        *****************************************************************************
        *****************************************************************************
                         DECLARAMOS EL CUERPO DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        $html = '
        <style>
          table, th, td {
            border-collapse: collapse;
          }
          th, td {
             padding: 17px;
          }
          .text-center
          {
            text-align: center;
          }
          .text-justify
          {
            text-align: justify;
          }';

          if ($state_report == 3)
          {
            $html .= '
              body
              {
                background-image: url(anulado.png);
                background-image-resize:6;
              }
            ';
          }
          $html .='
        </style>

        <div style="font-family: Times New Roman; font-size: 13px; padding-top:-70px;">
          <div class="text-center">
            <p class="text-center">
            <h4>
              <b>' . mb_strtoupper($faculty_name_report) .  '
                <br>
                ' . mb_strtoupper($program_name_report) .  '
                <br>
                RESOLUCIÓN NÚMERO ' . $consecutive_code_report . ' de ' . $consecutive_year_report . '
                <br>
                ' . $day_report . ' de ' . $month_report . ' de ' . $year_report . '
                <br>
                <br>
                POR MEDIO DE LA CUAL SE DESIGNA ASESOR PARA LA REALIZACIÓN DE UN
                <br>
                TRABAJO DE INVESTIGACIÓN
               </b>
             </h4>
          </div>
          <p class="text-justify">
            El(la) Director(a) de Investigaciones de la facultad de ' . $faculty_name_report . ' de la Universidad Libre Seccional Pereira, en uso de las facultades reglamentarias y,
          </p>
          <p class="text-center">
            <b>CONSIDERANDO:</b>
          </p>
          <p>
            <ol class="text-justify">
              <li>
                Que ' . $conector_students_1 . ' del programa de <b>' . mb_strtoupper($program_name_report) .  ': ' . mb_strtoupper($students_list) . ',</b> ' . $conector_students_2 . ' presentado al Centro de Investigaciones
                la propuesta para elaborar el trabajo titulado <b>“' . mb_strtoupper($title_report) . '”</b>.
              </li>
              <li>
                Que el (los) estudiante(s) ha(n) cumplido con los requisitos acordados para designársele asesor,
              </li>
              <li>
                Que el (la) doctor(a) <b>' . mb_strtoupper($advisors_list) . '</b> llena los requisitos de perfil para desempeñarse como asesor,
              </li>
            </ol>
          </p>
          <p class="text-center">
            <b>RESUELVE:</b>
          </p>
          <p class="text-justify">
            <b>ARTICULO PRIMERO:</b> Desígnese como asesor para la ejecución del trabajo titulado <b>“' . mb_strtoupper($title_report) . '”</b> ' . $conector_advisors_1 . ' <b>' . mb_strtoupper($advisors_list) . '.</b>
            <br>
            <br>
            <b>ARTICULO SEGUNDO:</b> Comuníquese esta resolución al asesor y al interesado.
            <br>
            <br>
            <b>ARTICULO TERCERO:</b> La presente resolución rige a partir de la fecha de su expedición.
          </p>
          <p class="text-center">
            <b>COMUNÍQUESE Y CÚMPLASE:</b>
          </p>
          <p class="text-justify">
            Dada en Pereira, a los ' . $day_report . ' días del mes de ' . $month_report . ' de ' . $year_report . '.
          </p>

        </div>
        <div>
          <table style="width:100%">
            <tr>
              <th class="text-center" colspan="2">
                <!--<img src="' . $director_signature_report . '" height="100px" width="100px">-->
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/8c/Signature_of_BTS%27_Jungkook.png" height="150px" width="150px">
                <br>
                ' . mb_strtoupper($director_name_report) . ' ' . mb_strtoupper($director_lastname_report) . '
                <br>
                <span style="font-size: 12px;font-weight: normal;">
                  Director(a) Centro de Investigaciones
                </span>
                <br>
                <span style="font-size: 12px;font-weight: normal;">
                  ' . $faculty_name_report . '
                </span>
              </th>
            </tr>
          </table>
        </div>';

        /*
        *****************************************************************************
        *****************************************************************************
                          ESCRIBIMOS EL CUERPO DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
        $mpdf->WriteHTML($PDFContent);

        /*
        *****************************************************************************
        *****************************************************************************
                         DECLARAMOS EL PIE DE PAGINA DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        $html_footer = '
        <div>
          <pre style="text-align:center; font-family: Times New Roman; font-size: 13px;">PEREIRA RISARALDA.
            Sede Centro Calle 40. No. 7-30 PBX (6) 3401081
            <br>
            Sede Belmonte: Avenida las Américas PBX (6) 3401043
          </pre>
        </div>';

        $mpdf->SetHTMLFooter($html_footer);

        /*
        *****************************************************************************
        *****************************************************************************
                   DECLARAMOS EL NOMBRE DEL ARCHIVO Y EXTENSION
        *****************************************************************************
        *****************************************************************************
        */

        $mpdf->Output("NOMBRAMIENTO DE ASESOR - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report . ".pdf", "I");
      }
      else
      {
        echo getMessageError();
      }
    }
    else
    {
      echo getMessageAccessError();
    }
	}
  else
  {
    $response["status"]  = false;
    $response["message"] = "Missing mandatory parameters";
  }
 ?>
