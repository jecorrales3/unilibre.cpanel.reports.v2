<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C4)                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 28/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 28/01/2020                **
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
  require_once __DIR__ . '../../class/PDF/vendor/autoload.php';

  //Session start
  session_start();

  //Counters
  $counter_members = 0;
  $counter_members = 0;

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

      if (validateReportC3($user_faculty_id, $configuration_id))
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
                                                      rtdo.nombre_resultado_reporte
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
          $format_faculty_report_report = $row_configuration['nombre_resultado_reporte'];
          $consecutive_code_report      = $row_configuration['codigo_configuracion_reporte'];

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

        $data_students = array();

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
        $mpdf->SetTitle("ACTA DE INICIO - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report);

        /*
        *****************************************************************************
        *****************************************************************************
                         DECLARAMOS LA CABECERA DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        // Define the Header/Footer before writing anything so they appear on the first page
        $mpdf->SetHTMLHeader('
        <table class="text-center border" style="font-family:arial;" width="100%">
        	<tr>
        		<td rowspan="3" width="30%">
              <img src="../class/PDF/images/unilibre_logo.png" style="height: 95px;">
            </td>
        		<td rowspan="3" width="50%" class="bl br text-f19">
              <b>
                ACTA DE INICIO DE PROYECTOS
                <br>
                DE INVESTIGACIÓN
              </b>
            </td>
        		<td width="30%" class="bb text-f13">
              <b>ST-INV-02-P-02-F04</b>
            </td>
        	</tr>
        	<tr>
        		<td width="30%" class="bb text-f13">
              <b>VERSIÓN 1</b>
            </td>
        	</tr>
        	<tr>
        		<td width="30%" class="text-f13">
              <b>16/01/2018</b>
            </td>
        	</tr>
        </table>');

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
          th, td {
             padding: 5px;
          }
          .text-center
          {
            text-align: center;
          }
          .text-justify
          {
            text-align: justify;
          }

          .text-f19
          {
            font-size:19px;
          }

          .text-f13
          {
            font-size:13px;
          }

          .border
          {
            border: 1px solid #141414;
          }
          .bl
          {
            border-left: 1px solid #141414;
          }
          .bt
          {
            border-top: 1px solid #141414;
          }
          .br
          {
            border-right: 1px solid #141414;
          }
          .bb
          {
            border-bottom: 1px solid #141414;
          }

          .bg-header
          {
            background-color: rgb(217, 217, 217);
          }
        </style>

        <div style="font-family: Times New Roman; font-size: 13px; padding-top:10px;">
          <p class="text-justify">
            <i>
              De conformidad con lo aprobado por el Consejo Seccional de Investigación, en la reunión de fecha _____________________,
              al proyecto de investigación Titulado “_______________________________________” y vinculado al grupo de Investigación ______________
              por un monto de $_________________, presentado por el Investigador Principal _____________________________________ identificado con
              el documento de identidad Nº. ___________________, adscrito a la Facultad _____________________________, de la Seccional _____________;
              se compromete con los términos descritos a continuación:
            </i>
          </p>
        </div>

        <ul class="text-justify">
         <li>
           Cumplir con los objetivos generales y específicos del proyecto
         </li>
         <li>
           Presentar al Centro de investigación  informes de avances Semestrales, información adicional  requerida por el centro de investigaciones de la facultad y un informe final al terminar la ejecución del proyecto, de acuerdo a los formatos establecidos, enfatizando sobre los productos académicos, los resultados y la incidencia del proyecto
         </li>
         <li>
           Cumplir con las condiciones de financiamiento aprobadas en la propuesta de investigación
         </li>
         <li>
           Fecha de finalización del proyecto: ____________________
         </li>
         <li>
           Fecha de informe (es) parcial (es)  y final del proyecto:
         </li>
        </ul>
        <br>
        <table class="text-center" align="center" width="55%">
          <tr>
            <th class="border bg-header" width="50%">Informes de Avance</th>
            <th class="border bg-header" width="50%">Fecha de Entrega</th>
          </tr>
          <tr>
            <td class="border">  I Informe de Avance</td>
            <td class="border"></td>
          </tr>
          <tr>
            <td class="border">  II Informe de Avance</td>
            <td class="border"></td>
          </tr>
          <tr>
            <td class="border"> III Informe de Avance</td>
            <td class="border"></td>
          </tr>
          <tr>
            <td class="border">Informe Final</td>
            <td class="border"></td>
          </tr>
        </table>
        <br>
        <ul class="text-justify">
         <li>
           Una vez proporcionados los resultados del proyecto de investigación a la Universidad Libre, esta decidirá sobre la conveniencia de solicitar la protección legal sobre los derechos patrimoniales a los que haya lugar.
         </li>
         <li>
           Cumplir con la reglamentación interna y la legislación vigente relacionada con propiedad intelectual y demás normas complementarias que regulen esta materia.
         </li>
         <li>
           Cumplir con los resultados y compromisos relacionados.
         </li>
        </ul>
        ';

        /*
        *****************************************************************************
        *****************************************************************************
                          ESCRIBIMOS EL CUERPO DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        $mpdf->WriteHTML($html);

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

        $mpdf->Output("ACTA DE INICIO - CONSECUTIVO " . $consecutive_code_report . " DE " . $year_report . ".pdf", "I");
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
