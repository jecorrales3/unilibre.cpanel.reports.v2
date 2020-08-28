<?php
  // C6 -> Homologación Auxiliar (Inactivo)

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C6)                   **
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
  //Include files
  include '../db/db_connection.php';
  include '../control/certificate_query.php';
  include '../error/message_error.php';
  //mPDF class
  require_once __DIR__ . '../../class/mPDF/vendor/autoload.php';

  //Session start
  session_start();

  //Counters
  $counter_researchers = 0;
  $counter_pair        = 0;
  $counter_students    = 0;
  $counter_members     = 0;

  //$_GET
  $configuration_id = $_GET['configuration_id'];

  //Conector text
  $conector_researchers = "del investigador principal Doctor";
  $conector_students    = "participa como Auxiliar de investigación el estudiante del programa de";

  if(isset($configuration_id))
	{
    if(isset($_SESSION['user']))
    {
      //User data
      $user_id         = $_SESSION['user']['id_usuario'];
      $user_faculty_id = $_SESSION['user']['id_facultad_usuario'];

      //Object UTF8
      $mysqli->set_charset('utf8');

      if (validateReportC6($user_faculty_id, $configuration_id))
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
                                                      DAY(conf.fecha_sustentacion_configuracion_reporte) AS dia_sustentacion_reporte,
                                                      CASE MONTH(conf.fecha_sustentacion_configuracion_reporte)
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
                                                      END mes_sustentacion_letras_reporte,
                                                      YEAR(conf.fecha_sustentacion_configuracion_reporte) AS year_sustentacion_reporte,
                                                      TIME_FORMAT(conf.hora_sustentacion_configuracion_reporte, '%h:%i %p') hora_sustentacion_reporte,
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
          $support_day_report           = $row_configuration['dia_sustentacion_reporte'];
          $support_month_report         = $row_configuration['mes_sustentacion_letras_reporte'];
          $support_year_report          = $row_configuration['year_sustentacion_reporte'];
          $support_time_report          = $row_configuration['hora_sustentacion_reporte'];
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
          $conector_students = "participan como Auxiliares de investigación los estudiantes del programa de";
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
        **********************     QUERY RESEARCHERS REPORT    **********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_researchers = $mysqli->query("SELECT igte.nombre_integrante_reporte,
      	                                            igte.apellido_integrante_reporte,
                                                    tipo.id_tipo_cargo_reporte,
                                                    tipo.nombre_tipo_cargo_reporte
                                               FROM integrante_reporte igte
                                             INNER JOIN tipo_cargo_reporte tipo
                                             ON tipo.id_tipo_cargo_reporte = igte.id_tipo_cargo_integrante_reporte
                                             WHERE igte.id_configuracion_integrante_reporte = '$configuration_id'
                                             AND tipo.id_tipo_cargo_reporte = '3'");

        $data_researchers = array();

        //Counting rows
        $number_researchers = mysqli_num_rows($query_researchers);

        if ($number_researchers > 1)
        {
          $conector_researchers = "de los investigadores principales Doctores";
        }


        /*
        *****************************************************************************
        *****************************************************************************
        ************************     QUERY JURIES REPORT    ************************
        *****************************************************************************
        *****************************************************************************
        */
        $query_evaluation_pair = $mysqli->query("SELECT igte.nombre_integrante_reporte,
  	                                                    igte.apellido_integrante_reporte,
                                                        tipo.id_tipo_cargo_reporte,
                                                        tipo.nombre_tipo_cargo_reporte
                                                   FROM integrante_reporte igte
                                                 INNER JOIN tipo_cargo_reporte tipo
                                                 ON tipo.id_tipo_cargo_reporte = igte.id_tipo_cargo_integrante_reporte
                                                 WHERE igte.id_configuracion_integrante_reporte = '$configuration_id'
                                                 AND tipo.id_tipo_cargo_reporte = '4'");

        $data_evaluation_pair = array();

        //Counting rows
        $number_evaluation_pair = mysqli_num_rows($query_evaluation_pair);


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
        $mpdf->SetTitle("HOMOLOGACIÓN AUXILIAR - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report);

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
          table, th, td
          {
            border-collapse: collapse;
          }

          .th, .td
          {
             padding: 20px;
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
          }
        </style>

        <div style="font-family: Times New Roman; font-size: 12px; padding-top:-60px;">
          <div class="text-center">
            <h4>
              <b>
                <p>
                   ' . mb_strtoupper($faculty_name_report) .  '
                   <br>
                   PROGRAMA DE ' . mb_strtoupper($program_name_report) .  '
                   <br>
                   HOMOLOGACIÓN AUXILIAR DE INVESTIGACIÓN
                   <br>
                   RESOLUCIÓN ' . $consecutive_code_report . '
                   <br>
                   (' . $day_report . ' de ' . $month_report . ' de ' . $year_report . ')
                 </p>
               </b>
             </h4>
          </div>
          <p class="text-justify" style="padding-top:-20px;">
            <i>
              Con base en lo establecido en el Acuerdo No. 06 del 25 de octubre de 2006, Reglamento de investigaciones en su artículo 29 numeral 5,
              en donde señala homologar el trabajo de grado, previo el cumplimiento de las tareas e informes asignados como auxiliares por el término
              de un año, artículo 41 el trabajo realizado por los auxiliares de investigación debe ser debidamente sustentado y aprobado ante el director
              del Centro de Investigaciones y el investigador principal, previo concepto emitido por los pares designados y podrá aceptarse como requisito
              de trabajo de grado.
            </i>
          </p>
          <p class="text-justify">
            Resuelve que, al Centro de Investigaciones de la ' . $faculty_name_report . ', se presentó por parte ' . $conector_researchers . '
            ';

              while ($row_investigator = $query_researchers->fetch_assoc())
              {
                //Counter row
                $counter_researchers++;
                //Array
                $data_researchers[] = $row_investigator;

                if (--$number_researchers != 0)
                {
                  $html .=
                  '
                  <span>
                    <b> ' . mb_strtoupper($row_investigator['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_investigator['apellido_integrante_reporte']) . '</b>
                  </span>
                  ';
                }
                else
                {
                  $conector   = (count($data_researchers) > 1) ? "y" : "";
                  $html .=
                  '
                  <span>
                     <b> ' . $conector . ' ' . mb_strtoupper($row_investigator['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_investigator['apellido_integrante_reporte']) . ',</b>
                  </span>
                  ';
                }

              }
              $counter_researchers = 0;

              $html .='
              el trabajo titulado: <b>“' . mb_strtoupper($title_report) . '”</b> en el cual ' . $conector_students . '
              <b>' . mb_strtoupper($program_name_report) .  ': </b>

              ';

                while ($row_student = $query_students->fetch_assoc())
                {
                  //Counter row
                  $counter_students++;
                  //Array
                  $data_students[] = $row_student;

                  $conector_comma   = (count($data_students) > 2) ? "" : ",";
                  if (--$number_students != 0)
                  {
                    $html .=
                    '
                    <span>
                      <b> ' . mb_strtoupper($row_student['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student['apellido_estudiante_reporte']) . $conector_comma . '</b>
                    </span>
                    ';
                  }
                  else
                  {
                    $conector   = (count($data_students) > 1) ? "y" : "";
                    $html .=
                    '
                    <span>
                       <b> ' . $conector . ' ' . mb_strtoupper($row_student['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student['apellido_estudiante_reporte']) . '.</b>
                    </span>
                    ';
                  }

                }
                $counter_students = 0;

              $html .='
          </p>
          <p class="text-justify">
            El trabajo fue sometido a evaluación del par
            ';

              while ($row_evaluation_pair = $query_evaluation_pair->fetch_assoc())
              {
                //Counter row
                $counter_pair++;
                //Array
                $data_evaluation_pair[] = $row_evaluation_pair;

                if (--$number_evaluation_pair != 0)
                {
                  $html .=
                  '
                  <span>
                    <b> ' . mb_strtoupper($row_evaluation_pair['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_evaluation_pair['apellido_integrante_reporte']) . '</b>
                  </span>
                  ';
                }
                else
                {
                  $conector   = (count($data_evaluation_pair) > 1) ? "y" : "";
                  $html .=
                  '
                  <span>
                     <b> ' . $conector . ' ' . mb_strtoupper($row_evaluation_pair['nombre_integrante_reporte']) . ' ' . mb_strtoupper($row_evaluation_pair['apellido_integrante_reporte']) . ',</b>
                  </span>
                  ';
                }

              }
              $counter_pair = 0;

              $conector_evaluation_pair = (count($data_evaluation_pair) > 1) ? "quienes emitieron el respectivo concepto <b>Favorable.</b>" : "quien emitió el respectivo concepto <b>Favorable.</b>";
              $html .=
              '
                ' . $conector_evaluation_pair . '
              ';

              $html .='
          </p>
          <p class="text-justify">
            El Centro de Investigaciones programó Socialización del trabajo de investigación para el día <b>' . $support_day_report . ' de ' . $support_month_report . ' de ' . $support_year_report . '</b>
            a las <b>' . $support_time_report .  ',</b> en presencia de los investigadores principales y de (la) Director(a) del Centro de Investigaciones de la ' . $faculty_name_report . '.
          </p>
        </div>

        <table style="width:100%">
          <tr>
             <th class="text-left" style="width:60%">
               <br>

             </th>
             <th class="text-left" style="width:40%">
               <i>CONCEPTO</i>
               <br>
             </th>
          </tr>
          ';
            while ($row_student_list = $query_students_list->fetch_assoc())
            {
              //Array
              $data_students_list[] = $row_student_list;

              $html .=
               '
               <tr>
                  <th class="text-left" style="width:60%">
                    <b>' . mb_strtoupper($row_student_list['nombre_estudiante_reporte']) . ' ' . mb_strtoupper($row_student_list['apellido_estudiante_reporte']) . '</b>
                  </th>
                  <th class="text-left" style="width:40%">
                    <i>APROBADO</i>
                  </th>
               </tr>';
            }

          $html .='

        </table>

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
                      <i>' . ucwords($row_member['nombre_tipo_cargo_reporte']) . '</i>
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
                        <i>' . ucwords($row_member['nombre_tipo_cargo_reporte']) . '</i>
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
                  <i>Decano ' . $faculty_name_report . '</i>
                </span>
              </th>
              <th class="text-center" style="width:50%">
                ' . mb_strtoupper($director_name_report) . ' ' . mb_strtoupper($director_lastname_report) . '
                <br>
                <span style="font-size: 12px;font-weight: normal;">
                  <i>Director(a) Centro de Investigaciones</i>
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

        //$mpdf->Output("HOMOLOGACIÓN AUXILIAR - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report . ".pdf", "I");
        echo getMessageError();
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
