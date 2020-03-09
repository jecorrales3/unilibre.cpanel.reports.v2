<?php
  // C1 -> Acta de Inicio

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C1)                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 31/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 31/01/2020                **
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

      if (validateReportC1($user_faculty_id, $configuration_id))
      {
        /*
        *****************************************************************************
        *****************************************************************************
        ********************     QUERY CONFIGURATION REPORT     *********************
        *****************************************************************************
        *****************************************************************************
        */
        $query_configuration = $mysqli->query("SELECT frpt.nombre_facultad_reporte,
                                                      frpt.siglas_facultad_reporte,
                                      	              conf.codigo_configuracion_reporte,
                                                      conf.codigo_convocatoria_configuracion_reporte,
                                                      ctvo.year_consecutivo_reporte,
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
                                                      DATE_FORMAT(conf.fecha_sustentacion_configuracion_reporte, '%d/%m/%Y') AS fecha_sustentacion_configuracion_reporte,
                                                      DATE_FORMAT(conf.fecha_iniciacion_configuracion_reporte, '%d/%m/%Y') AS fecha_iniciacion_configuracion_reporte,
                                                      DATE_FORMAT(conf.fecha_finalizacion_configuracion_reporte, '%d/%m/%Y') AS fecha_finalizacion_configuracion_reporte,
                                                      conf.presupuesto_configuracion_reporte,
                                                      conf.nombre_grupo_investigacion_configuracion_reporte,
                                                      conf.id_funcionalidad_configuracion_reporte,
                                                      tcvt.id_tipo_convocatoria_reporte,
                                                      tcvt.nombre_tipo_convocatoria_reporte
                                                 FROM configuracion_reporte conf
                                               INNER JOIN facultad_reporte frpt
                                               ON frpt.id_facultad_reporte = conf.id_facultad_configuracion_reporte
                                               INNER JOIN consecutivo_reporte ctvo
                                               ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
                                               INNER JOIN resultado_reporte rtdo
                                               ON rtdo.id_resultado_reporte = conf.id_resultado_configuracion_reporte
                                               INNER JOIN tipo_convocatoria_reporte tcvt
                                               ON tcvt.id_tipo_convocatoria_reporte = conf.id_tipo_convocatoria_configuracion_reporte
                                               WHERE conf.id_configuracion_reporte = '$configuration_id'");

        $data_configuration = array();

        while ($row_configuration = $query_configuration->fetch_assoc())
        {
          $data_configuration[]         = $row_configuration;
          $acronym_faculty_report       = $row_configuration['siglas_facultad_reporte'];
          $faculty_name_report          = $row_configuration['nombre_facultad_reporte'];
          $consecutive_code_report      = $row_configuration['codigo_configuracion_reporte'];
          $convocatory_code_report      = $row_configuration['codigo_convocatoria_configuracion_reporte'];
          $consecutive_year_report      = $row_configuration['year_consecutivo_reporte'];
          $date_report                  = $row_configuration['fecha_generacion_configuracion_reporte'];
          $day_report                   = $row_configuration['dia_reporte'];
          $month_report                 = $row_configuration['mes_letras_reporte'];
          $year_report                  = $row_configuration['year_reporte'];
          $title_report                 = $row_configuration['titulo_configuracion_reporte'];

          $date_support_report          = $row_configuration['fecha_sustentacion_configuracion_reporte'];
          $initial_date_report          = $row_configuration['fecha_iniciacion_configuracion_reporte'];
          $final_date_report            = $row_configuration['fecha_finalizacion_configuracion_reporte'];
          $budget_report                = $row_configuration['presupuesto_configuracion_reporte'];
          $investigation_group_report   = $row_configuration['nombre_grupo_investigacion_configuracion_reporte'];
          $state_report                 = $row_configuration['id_funcionalidad_configuracion_reporte'];
          $convocatory_type_id_report   = $row_configuration['id_tipo_convocatoria_reporte'];
          $convocatory_type_report      = $row_configuration['nombre_tipo_convocatoria_reporte'];


          //Format value
          $consecutive_code_report = ($consecutive_code_report <= 9) ? '0' . $consecutive_code_report: $consecutive_code_report;

          $convocatory_code_report = ($convocatory_type_id_report == 1) ? " No. " . $convocatory_code_report : " CÓD. " . $convocatory_code_report;
        }


        /*
        *****************************************************************************
        *****************************************************************************
        ************************     QUERY JURIES REPORT     ************************
        *****************************************************************************
        *****************************************************************************
        */
        $query_investigator = $mysqli->query("SELECT igte.nombre_integrante_reporte,
  	                                                 igte.apellido_integrante_reporte,
                                                     igte.cedula_integrante_reporte
                                            FROM integrante_reporte igte
                                          INNER JOIN tipo_cargo_reporte tipo
                                          ON tipo.id_tipo_cargo_reporte = igte.id_tipo_cargo_integrante_reporte
                                          WHERE igte.id_configuracion_integrante_reporte = '$configuration_id'
                                          AND tipo.id_tipo_cargo_reporte = '3'
                                          LIMIT 1");

        $data_investigator = array();

        while ($row_investigator = $query_investigator->fetch_assoc())
        {
          //Array
          $data_investigator[]  = $row_investigator;
          //Query rows
          $investigator_name     = $row_investigator['nombre_integrante_reporte'];
          $investigator_lastname = $row_investigator['apellido_integrante_reporte'];
          $investigator_document = $row_investigator['cedula_integrante_reporte'];
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
              <b>' . $date_report . '</b>
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

          .text-f13
          {
            font-size:13px;
          }

          .text-f14
          {
            font-size:14px;
          }

          .text-f19
          {
            font-size:19px;
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
        <div class="text-center">
          <p class="text-center">
            <h4>
              <b>
                 ACTA No. ' . $consecutive_code_report . ' ' . mb_strtoupper($acronym_faculty_report) .  '
                 <br>
                 ' . mb_strtoupper($convocatory_type_report) .  $convocatory_code_report . '
               </b>
             </h4>
          </p>
        </div>
        <div class="text-f14" style="font-family: Times New Roman; padding-top:-15px;">
          <p class="text-justify">
            <i>
              De conformidad con lo aprobado por el Consejo Seccional de Investigación, en la reunión de fecha <b>' . $date_support_report . '</b>,
              al proyecto de investigación Titulado <b>“' . mb_strtoupper($title_report) . '”</b> y vinculado al grupo de Investigación <b>' . mb_strtoupper($investigation_group_report) . '</b>
              por un monto de <b>$' . number_format($budget_report) . '</b>, presentado por el (la) Investigador(a) Principal <b>' . mb_strtoupper($investigator_name) . ' ' . mb_strtoupper($investigator_lastname) . '</b> identificado(a) con
              el documento de identidad Nº. <b>' . number_format($investigator_document, 0, '.', '.') . '</b>, adscrito a la ' . $faculty_name_report . ', de la Seccional Pereira;
              se compromete con los términos descritos a continuación:
            </i>
          </p>
        </div>

        <div class="text-f14">
          <ul class="text-justify">
           <li>
             Cumplir con los objetivos generales y específicos del proyecto
           </li>
           <li>
             Presentar al <i>Centro de investigación</i>  informes de avances Semestrales, información adicional  requerida por el centro de investigaciones de la facultad y un informe final al terminar la ejecución del proyecto, de acuerdo a los formatos establecidos, enfatizando sobre los productos académicos, los resultados y la incidencia del proyecto
           </li>
           <li>
             Cumplir con las condiciones de financiamiento aprobadas en la propuesta de investigación
           </li>
           <li>
             Fecha de iniciación del proyecto:   <b>' . $initial_date_report . '</b>
           </li>
           <li>
             Fecha de finalización del proyecto:
             <b>
             ';

             if ($final_date_report == "00/00/0000" || !isset($final_date_report))
             {
               $html .= '
                 _______________________
               ';
             }
             else
             {
               $html .= '
                 ' . $final_date_report . '
               ';
             }
             $html .='
             </b>
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
          <br>
          <table style="width:100%">
            <tr>
              <th class="text-center" style="width:50%">
                ______________________________________
                <br>
                Investigador Principal
              </th>
              <th class="text-center" style="width:50%">
                ______________________________________
                <br>
                Dir. Centro de Investigación Facultad
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
