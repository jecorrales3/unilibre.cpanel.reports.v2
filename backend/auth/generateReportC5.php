<?php
  // C5 -> Paz y Salvos (Asesorado)
  // C5 -> Paz y Salvos (Auxiliares de Investigación)
  // C5 -> Paz y Salvos (Seminario Internacional)
  // C5 -> Paz y Salvos (Semillero de Investigación)

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C5)                   **
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
  //Time
  setlocale(LC_ALL,"es_ES");
  date_default_timezone_set('America/Bogota');
  $date = strftime("%e de %B de %Y");;
  //Include files
  include '../db/db_connection.php';
  include 'certificate_query.php';
  include 'message_error.php';
  //mPDF class
  require_once __DIR__ . '../../class/mPDF/vendor/autoload.php';

  //Session start
  session_start();

  //Counters
  $counter_students = 0;

  //Conector text
  $conector_students = "y cuyo auxiliar es el estudiante";

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

      if (validateReportC5($user_faculty_id, $configuration_id))
      {
        /*
        *****************************************************************************
        *****************************************************************************
        ********************     QUERY CONFIGURATION REPORT     *********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_configuration = $mysqli->query("SELECT frpt.nombre_facultad_reporte,
                                                      frpt.nombre_programa_facultad_reporte,
                                                      frpt.titulo_programa_facultad_reporte,
                                                      DATE_FORMAT(conf.fecha_generacion_configuracion_reporte, '%d/%m/%Y') AS fecha_generacion_configuracion_reporte,
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
                                                      trte.id_tipo_reporte,
                                                      trte.nombre_tipo_reporte,
                                                      conf.id_funcionalidad_configuracion_reporte,
                                                      conf.marco_seminario_configuracion_reporte,
                                                      conf.universidad_seminario_configuracion_reporte
                                                 FROM configuracion_reporte conf
                                               INNER JOIN facultad_reporte frpt
                                               ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                               INNER JOIN resultado_reporte rtdo
                                               ON rtdo.id_resultado_reporte = conf.id_resultado_configuracion_reporte
                                               INNER JOIN tipo_reporte trte
                                               ON trte.id_tipo_reporte = conf.id_tipo_reporte_configuracion_reporte
                                               WHERE conf.id_configuracion_reporte = '$configuration_id'");

        $data_configuration = array();

        while ($row_configuration = $query_configuration->fetch_assoc())
        {
          $data_configuration[]         = $row_configuration;
          $faculty_name_report          = $row_configuration['nombre_facultad_reporte'];
          $program_name_report          = $row_configuration['nombre_programa_facultad_reporte'];
          $program_title_report         = $row_configuration['titulo_programa_facultad_reporte'];
          $date_report                  = $row_configuration['fecha_generacion_configuracion_reporte'];
          $day_report                   = $row_configuration['dia_reporte'];
          $month_report                 = $row_configuration['mes_letras_reporte'];
          $year_report                  = $row_configuration['year_reporte'];
          $title_report                 = $row_configuration['titulo_configuracion_reporte'];
          $type_report                  = $row_configuration['id_tipo_reporte'];
          $file_name_report             = $row_configuration['nombre_tipo_reporte'];
          $state_report                 = $row_configuration['id_funcionalidad_configuracion_reporte'];
          $seminar_name_report          = $row_configuration['marco_seminario_configuracion_reporte'];
          $university_report            = $row_configuration['universidad_seminario_configuracion_reporte'];
        }

        /*
        *****************************************************************************
        *****************************************************************************
        **********************     QUERY STUDENTS REPORT      ***********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_students = $mysqli->query("SELECT edte.nombre_estudiante_reporte,
  	                                             edte.apellido_estudiante_reporte,
                                                 edte.documento_estudiante_reporte
                                            FROM estudiante_reporte edte
                                           WHERE edte.id_configuracion_estudiante_reporte = '$configuration_id'
                                           ORDER BY edte.apellido_estudiante_reporte ASC
                                           LIMIT 3");

        $data_students      = array();

        /*
        *****************************************************************************
        *****************************************************************************
        **********************     QUERY STUDENTS REPORT      ***********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_students_list= $mysqli->query("SELECT edte.nombre_estudiante_reporte,
  	                                             edte.apellido_estudiante_reporte,
                                                 edte.documento_estudiante_reporte
                                            FROM estudiante_reporte edte
                                           WHERE edte.id_configuracion_estudiante_reporte = '$configuration_id'
                                           ORDER BY edte.apellido_estudiante_reporte ASC
                                           LIMIT 3");

        $data_students_list = array();
        //Counting rows
        $number_students = mysqli_num_rows($query_students_list);

        if ($number_students > 1)
        {
          $conector_students = "y cuyos auxiliares son los estudiantes";
        }

        while ($row_student_list = $query_students_list->fetch_assoc())
        {
          //Counter row
          $counter_students++;
          //Array
          $data_students_list[]  = $row_student_list;

          $student_name = mb_strtoupper($row_student_list['nombre_estudiante_reporte']) . " " . mb_strtoupper($row_student_list['apellido_estudiante_reporte']);

          //Query rows
          if (--$number_students != 0)
          {
            $conector       = (count($data_students_list) == 1) ? ", " : " ";
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
        **********************    QUERY MAIN MEMBERS REPORT   ***********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_main_members = $mysqli->query("SELECT frpt.nombre_director_facultad_reporte,
                                                     frpt.apellido_director_facultad_reporte,
                                                     frpt.https_firma_director_facultad_reporte
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
          $data_main_members[]       = $row_main_member;
          //Query rows
          $director_name_report      = $row_main_member['nombre_director_facultad_reporte'];
          $director_lastname_report  = $row_main_member['apellido_director_facultad_reporte'];
          $director_signature_report = $row_main_member['https_firma_director_facultad_reporte'];
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
                                          AND tipo.id_tipo_cargo_reporte = '1'
                                          LIMIT 1");

        $data_advisors = array();

        while ($row_adviser = $query_advisors->fetch_assoc())
        {
          //Array
          $data_advisors[]  = $row_adviser;
          //Query rows
          $adviser_name     = $row_adviser['nombre_integrante_reporte'];
          $adviser_lastname = $row_adviser['apellido_integrante_reporte'];
        }


        /*
        *****************************************************************************
        *****************************************************************************
                          FORMAT STRING FOR FACULTY NAME REPORT
        *****************************************************************************
        *****************************************************************************
        */
        $string = mb_convert_case($faculty_name_report . "áéíóú", MB_CASE_TITLE, "UTF-8");

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
          'setAutoTopMargin'  => 'stretch',
          'margin_left'       => 25,
          'margin_right'      => 25,
          'autoMarginPadding' => 7
        ]);

        //Indicamos el titulo de la pagina
        $mpdf->SetTitle(mb_strtoupper($file_name_report));

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
          <img src="../class/mPDF/vendor/images/unilibre_header.png" class="img-fluid" style="height: 120px; width: 1170px;" alt="Responsive image">
        </div>
        <div style="font-family: Times New Roman; font-size: 13px; padding-top:-10px;">
          <div class="text-center">
            <h4>
              <b>
                ' . mb_strtoupper($faculty_name_report) .  '
                <br>
                CENTRO DE INVESTIGACIONES
                <br>
                ' . mb_strtoupper($program_name_report) .  '
                <br>
                <br>
                <br>
                <p>
                   PAZ Y SALVO
                </p>
                <br>
                <br>
               </b>
             </h4>
          </div>
        </div>');


        while ($row_student = $query_students->fetch_assoc())
        {
          //Array
          $data_students[]         = $row_student;

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
          <div style="font-family: Times New Roman; font-size: 13px; padding-top:-50px;">
            ';
            switch ($type_report)
            {
              //Paz y Salvo (Asesorado)
              case 5:
                $margin_top = "50px";
                $html .='
                <p class="text-justify">
                  <b>POR CONCEPTO DE:</b> Aprobación de sustentación y entrega al Centro de Investigaciones del Trabajo de Investigación
                  titulado <b>“' . mb_strtoupper($title_report) . '”</b> como requisito parcial para optar al título de <b>' . mb_strtoupper($program_title_report) . '.</b>
                </p>';
                break;

                //Paz y Salvo (Auxiliar de investigación)
                case 6:
                $margin_top = "30px";
                $html .='
                <p class="text-justify">
                  <b>POR CONCEPTO DE:</b> Aprobación, homologación, socialización y entrega al Centro de Investigaciones como <b>Auxiliares de Investigación</b> del trabajo de
                  investigación denominado: <b>“' . mb_strtoupper($title_report) . '”</b> ' . $conector_students . ': <b>' . $students_list . ',</b> requisito parcial
                  para optar al título de <b>' . mb_strtoupper($program_title_report) . '.</b>
                </p>';
                break;

                //Paz y Salvo (Seminario Internacional)
                case 7:
                $margin_top = "10px";
                $html .='
                <p class="text-justify">
                  <b>POR CONCEPTO DE:</b> Aprobación, homologación, socialización y entrega al Centro de Investigaciones como <b>Auxiliares de Investigación</b> del trabajo de
                  investigación denominado: <b>“' . mb_strtoupper($title_report) . '”</b> realizado bajo el marco del Seminario Internacional denominado ' . $seminar_name_report . ',
                  desarrollado con la colaboración de la Universidad ' . $university_report . ', y cuyo asesor(a) principal es el(la) docente: <b>' . mb_strtoupper($adviser_name) . ' ' . mb_strtoupper($adviser_lastname) . '</b>, como requisito parcial
                  para optar al título de <b>' . mb_strtoupper($program_title_report) . '.</b>
                </p>';
                break;

                //Paz y Salvo (Semillero de Investigación)
                case 8:
                $margin_top = "50px";
                $html .='
                <p class="text-justify">
                  <b>POR CONCEPTO DE:</b> Aprobación, homologación, socialización y entrega al Centro de Investigaciones de productos investigativos derivados de la
                  OPCIÓN DE INVESTIGACIÓN: <b>“SEMILLERO DE INVESTIGACIÓN” (Artículo 45 del acuerdo 01 de febrero de 2019),</b> como requisito parcial para optar
                  al título de <b>' . mb_strtoupper($program_title_report) . '.</b>
                </p>';
                break;
            }

            $html .='
            <br>
            <b>NOMBRE DEL EGRESADO(A): ' . mb_strtoupper($row_student['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student['apellido_estudiante_reporte']) . '</b>
            <br>
            <p class="text-justify">
              Cédula de Ciudadanía No. ' . number_format($row_student['documento_estudiante_reporte'], 0, '.', '.') . '
            </p>
            <br>
            <b>DEL PROGRAMA DE ' . mb_strtoupper($program_name_report) . '</b>
            <br>
            <br>
            <p class="text-justify">
              Dado en Pereira, a los ' . $day_report . ' días del mes de ' . $month_report . ' de ' . $year_report . ', con destino a la Oficina de Registro y Control.
            </p>
            <div style="margin-top: ' . $margin_top . ';">
              <table style="width:100%">
                <tr>
                  <th class="text-center" style="width:20%"></th>
                  <th class="text-center" style="width:60%">
                    <!--<img src="' . $director_signature_report . '" height="200px" width="200px">-->
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/8c/Signature_of_BTS%27_Jungkook.png" height="200px" width="200px">
                    <br>
                    ' . mb_strtoupper($director_name_report) . ' ' . mb_strtoupper($director_lastname_report) . '
                    <br>
                    <span style="font-size: 12px;font-weight: normal;">
                      Director(a) Centro de Investigación de la ' . $faculty_name_report . '
                    </span>
                  </th>
                  <th class="text-center" style="width:20%"></th>
                </tr>
              </table>
            </div>
          </div>';

          $mpdf->AddPageByArray(array(
            'setAutoTopMargin'  => 'stretch',
            'margin_left'       => 25,
            'margin_right'      => 25,
            'autoMarginPadding' => 7
          ));

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
            <img src="../class/mPDF/vendor/images/unilibre_footer.png" class="img-fluid" style="height: 70px; width: 1169px;" alt="Responsive image">
            <pre style="text-align:center; font-family: Times New Roman; font-size: 13px;">PEREIRA RISARALDA.
              Sede Centro Calle 40. No. 7-30 PBX (6) 3401081
              <br>
              Sede Belmonte: Avenida las Américas PBX (6) 3401043
            </pre>
          </div>';

          $mpdf->SetHTMLFooter($html_footer);
        }

        /*
        *****************************************************************************
        *****************************************************************************
                   DECLARAMOS EL NOMBRE DEL ARCHIVO Y EXTENSION
        *****************************************************************************
        *****************************************************************************
        */

        $mpdf->Output(mb_strtoupper($file_name_report) . ".pdf", "I");
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
