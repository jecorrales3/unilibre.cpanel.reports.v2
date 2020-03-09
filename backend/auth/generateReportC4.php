<?php
  // C4 -> Acta de Sustentación

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C4)                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 24/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 24/01/2020                **
  ** @who        - Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @why        - Creation                                                  **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  */
  //Include files
  include '../db/db_connection.php';
  include 'certificate_query.php';
  include 'message_error.php';
  //mPDF class
  require_once __DIR__ . '../../class/mPDF/vendor/autoload.php';

  //Session start
  session_start();

  //Counters
  $counter_juries   = 0;
  $counter_students = 0;
  $counter_members  = 0;

  //$_GET
  $configuration_id = $_GET['configuration_id'];

  //Conector text
  $conector_juries   = "el jurado";
  $conector_students = "el estudiante";

  if(isset($configuration_id))
	{
    if(isset($_SESSION['user']))
    {
      //User data
      $user_id         = $_SESSION['user']['id_usuario'];
      $user_faculty_id = $_SESSION['user']['id_facultad_usuario'];

      //Object UTF8
      //$mysqli->set_charset('utf8');

      if (validateReportC4($user_faculty_id, $configuration_id))
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
        $query_students_list = $mysqli->query("SELECT edte.nombre_estudiante_reporte,
  	                                                  edte.apellido_estudiante_reporte,
                                                      edte.nota_numero_estudiante_reporte,
                                                      edte.nota_letras_estudiante_reporte
                                                 FROM estudiante_reporte edte
                                               WHERE edte.id_configuracion_estudiante_reporte = '$configuration_id'
                                               ORDER BY edte.apellido_estudiante_reporte ASC
                                               LIMIT 3");

        $query_students = $mysqli->query("SELECT edte.nombre_estudiante_reporte,
  	                                             edte.apellido_estudiante_reporte
                                            FROM estudiante_reporte edte
                                           WHERE edte.id_configuracion_estudiante_reporte = '$configuration_id'
                                           ORDER BY edte.apellido_estudiante_reporte ASC
                                           LIMIT 3");

        $data_students = array();

        //Counting rows
        $number_students = mysqli_num_rows($query_students);

        if ($number_students > 1)
        {
          $conector_students = "los estudiantes";
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
        ************************     QUERY JURIES REPORT    ************************
        *****************************************************************************
        *****************************************************************************
        */
        $query_juries = $mysqli->query("SELECT igte.nombre_integrante_reporte,
  	                                            igte.apellido_integrante_reporte,
                                                tipo.id_tipo_cargo_reporte,
                                                tipo.nombre_tipo_cargo_reporte
                                           FROM integrante_reporte igte
                                         INNER JOIN tipo_cargo_reporte tipo
                                         ON tipo.id_tipo_cargo_reporte = igte.id_tipo_cargo_integrante_reporte
                                         WHERE igte.id_configuracion_integrante_reporte = '$configuration_id'
                                         AND tipo.id_tipo_cargo_reporte = '2'");

        $data_juries = array();

        //Counting rows
        $number_juries = mysqli_num_rows($query_juries);

        if ($number_juries > 1)
        {
          $conector_juries = "los jurados";
        }


        /*
        *****************************************************************************
        *****************************************************************************
        ************************     QUERY MEMBERS REPORT    ************************
        *****************************************************************************
        *****************************************************************************
        */
        $query_members = $mysqli->query("SELECT igte.nombre_integrante_reporte,
  	                                            igte.apellido_integrante_reporte,
                                                tipo.id_tipo_cargo_reporte,
                                                tipo.nombre_tipo_cargo_reporte
                                           FROM integrante_reporte igte
                                         INNER JOIN tipo_cargo_reporte tipo
                                         ON tipo.id_tipo_cargo_reporte = igte.id_tipo_cargo_integrante_reporte
                                         WHERE igte.id_configuracion_integrante_reporte = '$configuration_id'
                                         LIMIT 3");

        $data_members = array();

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
        $mpdf->SetTitle("ACTA DE SUSTENTACIÓN - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report);

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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
          table, th, td
          {
            border-collapse: collapse;
          }

          .th, .td
          {
             padding: 17px;
          }

          .text-center
          {
            text-align: center;
          }

          .text-left
          {
            text-align: left;
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
          <div class="text-center">
            <h4>
              <b>
                UNIVERSIDAD LIBRE SECCIONAL PEREIRA
                <br>
                ' . mb_strtoupper($faculty_name_report) .  ' CENTRO DE INVESTIGACIONES
                <p>
                   ACTA DE SUSTENTACIÓN DE PROYECTO No. ' . $consecutive_code_report . ' de ' . $consecutive_year_report . '
                   <br>
                   ' . mb_strtoupper($program_name_report) .  '
                   <br>
                   (' . $day_report . ' de ' . $month_report . ' de ' . $year_report . ')
                 </p>
               </b>
             </h4>
          </div>
          <p class="text-justify">
            Ante ' . $conector_juries . '
            ';

              while ($row_jury = $query_juries->fetch_assoc())
              {
                //Counter row
                $counter_juries++;
                //Array
                $data_juries[] = $row_jury;

                if (--$number_juries != 0)
                {
                  $html .=
                  '
                  <span>
                    <b> ' . mb_strtoupper($row_jury['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_jury['apellido_integrante_reporte']) . '</b>
                  </span>
                  ';
                }
                else
                {
                  $conector   = (count($data_juries) > 1) ? "y" : "";
                  $html .=
                  '
                  <span>
                     <b> ' . $conector . ' ' . mb_strtoupper($row_jury['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_jury['apellido_integrante_reporte']) . ';</b>
                  </span>
                  ';
                }

              }
              $counter_juries = 0;

            $html .='
            Asesor, <b>' . mb_strtoupper($adviser_name) . ' ' . mb_strtoupper($adviser_lastname) . ',</b>
            el Decano de la ' . $faculty_name_report . ', <b>' . mb_strtoupper($dean_name_report) . ' ' . mb_strtoupper($dean_lastname_report) . '</b>
            y el (la) Director(a) del Centro de Investigaciones de la  ' . $faculty_name_report . ' de la Universidad Libre Seccional Pereira
            <b>' . mb_strtoupper($director_name_report) . ' ' . mb_strtoupper($director_lastname_report) . '.</b>
          </p>
          <p class="text-justify">
            Se presentó la sustentación del trabajo de investigación <b>“' . mb_strtoupper($title_report) . '”</b> por ' . $conector_students . ',

            ';

              while ($row_student = $query_students->fetch_assoc())
              {
                //Counter row
                $counter_students++;
                //Array
                $data_students[] = $row_student;

                if (--$number_students != 0)
                {
                  $html .=
                  '
                  <span>
                    <b> ' . mb_strtoupper($row_student['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student['apellido_estudiante_reporte']) .'</b>
                  </span>
                  ';
                }
                else
                {
                  $conector   = (count($data_students) > 1) ? "y" : "";
                  $html .=
                  '
                  <span>
                     <b> ' . $conector . ' ' . mb_strtoupper($row_student['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student['apellido_estudiante_reporte']) . ';</b>
                  </span>
                  ';
                }

              }
              $counter_students = 0;

            $html .='obteniendo la siguiente calificación:
          </p>
        </div>

        <table style="width:100%">
          <tr>
             <th class="text-left" style="width:50%">
               <br>

             </th>
             <th style="width:20%">
               Números
               <br>
             </th>
             <th style="width:30%">
               Letras
               <br>
             </th>
          </tr>
          ';
            while ($row_student_list = $query_students_list->fetch_assoc())
            {
              //Array
              $data_students_list[] = $row_student_list;
              //Calculate note
              $job_qualification_average += $row_student_list['nota_numero_estudiante_reporte'];

              $html .=
               '
               <tr>
                  <th class="text-left" style="width:50%">
                    ' . mb_strtoupper($row_student_list['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student_list['apellido_estudiante_reporte']) . '
                  </th>
                  <th style="width:20%">
                    ' . $row_student_list['nota_numero_estudiante_reporte'] . '
                  </th>
                  <th style="width:30%">
                    ' . ucfirst($row_student_list['nota_letras_estudiante_reporte']) . '
                  </th>
               </tr>';
            }

            //Final job qualification
            $job_qualification = $job_qualification_average/count($data_students_list);

          $html .='

        </table>
        <br>
        <p class="text-justify">
          <b>
            Los evaluadores consideraron calificar la calidad del trabajo como:
          </b>
        </p>

        <table style="width:70%">
          <tr>
            ';
              switch (true)
              {
                case $job_qualification >= 3.5 && $job_qualification <= 4.4:
                  $approved = "X";
                  break;
                case $job_qualification >= 4.5 && $job_qualification <= 4.7:
                  $very_well = "X";
                  break;
                case $job_qualification >= 4.8 && $job_qualification <= 4.9:
                  $meritorious = "X";
                  break;
                case $job_qualification == 5:
                  $summa_cum_laude = "X";
                  break;
                default:
                  //Show the result
                  $note = "La nota no está entre los rangos permitidos.";
                  //Notes
                  $approved        = NULL;
                  $meritorious     = NULL;
                  $very_well       = NULL;
                  $summa_cum_laude = NULL;
                  break;
              }

            $html .='
            <th class="text-left" style="width:35%">
              Aprobado (' . $approved . ')
              <br>
              Meritorio (' . $meritorious . ')
            </th>
            <th class="text-left" style="width:35%">
              Muy bien (' . $very_well . ')
              <br>
              Summa cum laude (' . $summa_cum_laude . ')
            </th>
          </tr>
        </table>
        ';
          if(isset($note))
          {
            $html .='
              <p class="text-justify" style="color:red;">
                ' . $note . '
              </p>
            ';
          }
        $html .='

        <p class="text-justify">
          Para constancia se firma en Pereira a los ' . $day_report . ' días del mes de ' . $month_report . ' de ' . $year_report . '.
        </p>
        <br>
        <div>
          <table style="width:100%">
            <tr>
            ';

              while ($row_member = $query_members->fetch_assoc())
              {
                //Counter row
                $counter_members++;
                //Array
                $data_members[] = $row_member;

                if ($counter_members <= 2)
                {
                  $html .=
                  '
                  <th class="text-center th" style="width:50%">
                    ' . mb_strtoupper($row_member['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_member['apellido_integrante_reporte']) . '
                    <br>
                    <span style="font-size: 12px;font-weight: normal;">
                      ' . strtoupper($row_member['nombre_tipo_cargo_reporte']) . '
                    </span>
                  </th>
                  ';
                }
                else
                {
                  $html .=
                  '
                  <tr>
                    <th class="text-center th" colspan="2">
                      ' . mb_strtoupper($row_member['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_member['apellido_integrante_reporte']) . '
                      <br>
                      <span style="font-size: 12px;font-weight: normal;">
                        ' . strtoupper($row_member['nombre_tipo_cargo_reporte']) . '
                      </span>
                    </th>
                  </tr>
                  ';
                }
              }

              if (count($data_members) == 2)
              {
                $html .=
                '
                <tr>
                  <th class="text-center th" colspan="2">
                    <br><br>
                  </th>
                </tr>
                ';
              }

            $html .='
            </tr>
            <tr>
              <th class="text-center" style="width:50%">
                ' . mb_strtoupper($dean_name_report) . ' ' . mb_strtoupper($dean_lastname_report) . '
                <br>
                <span style="font-size: 12px;font-weight: normal;">
                  Decano ' . $faculty_name_report . '
                </span>
              </th>
              <th class="text-center" style="width:50%">
                ' . mb_strtoupper($director_name_report) . ' ' . mb_strtoupper($director_lastname_report) . '
                <br>
                <span style="font-size: 12px;font-weight: normal;">
                  Director(a) Centro de Investigaciones
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
          <img src="../class/PDF/images/unilibre_footer.png" class="img-fluid" style="height: 70px; width: 1169px;" alt="Responsive image">
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

        $mpdf->Output("ACTA DE SUSTENTACIÓN - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report . ".pdf", "I");
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
