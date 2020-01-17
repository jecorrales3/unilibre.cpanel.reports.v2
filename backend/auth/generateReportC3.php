<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document generate a report (C3)                   **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 16/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 16/01/2020                **
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
  //Array for results
  $response = array();
  //Include files
  include '../db/db_connection.php';
  include 'certificate_query.php';
  require_once __DIR__ . '../../class/PDF/vendor/autoload.php';
  //Session start
  session_start();
  //User id
  $user_id = $_SESSION['user']['id_usuario'];
  //Get the input request parameters
  $inputJSON = file_get_contents('php://input');
  //convert JSON into array
  $_POST = json_decode($inputJSON, TRUE);

  if(isset($_POST))
	{
    //Object UTF8
    $mysqli->set_charset('utf8');

    //Post variables (Settings)
    $program_id   = $_POST['report_settings'][0]['programa_reporte'];
    $adviser_id   = $_POST['report_settings'][0]['asesor_reporte'];
    $title_report = $_POST['report_settings'][0]['titulo_reporte'];

    /*
    echo "Program: " . $program_report;
    echo "Adviser: " . $adviser_report;
    echo "Title: " . $title_report;
    */

    //Get the students report
    foreach ($_POST['report_students'] as $student)
    {
    	echo "Student: " . $student['nombre_estudiante'] . " " . $student['apellido_estudiante'] . " | ";
    }

    //Get the juries report
    foreach ($_POST['report_juries'] as $jury)
    {
    	echo "Jury: " . $jury['nombre_integrante'] . " " . $jury['apellido_integrante'] . " | ";
    }

    $query_profile = $mysqli->query("SELECT fctd.id_facultad,
                                            fctd.nombre_facultad
                                       FROM usuario usro
                                     INNER JOIN facultad fctd
                                     ON fctd.id_facultad = usro.id_facultad_usuario
                                     WHERE usro.id_usuario = '$user_id'");

    $data_profile = array();

    while ($row_profile = $query_profile->fetch_assoc())
    {
      $data_profile[]   = $row_profile;
      $faculty_name     = $row_profile['nombre_facultad'];
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
      'setAutoTopMargin' => 'stretch',
      'autoMarginPadding' => 5,
      'setAutoBottomMargin' => 'stretch',
      'autoMarginPadding' => 7
    ]);

    //Indicamos el titulo de la pagina
    $mpdf->SetTitle("ACTA DE APROBACIÓN");

    /*
    *****************************************************************************
    *****************************************************************************
                     DECLARAMOS LA CABECERA DEL DOCUMENTO PDF
    *****************************************************************************
    *****************************************************************************
    */
    // Define the Header/Footer before writing anything so they appear on the first page
    $mpdf->SetHTMLHeader('
    <div class="">
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
    </style>

    <div style="font-family: Times New Roman; font-size: 13px; padding-top:-50px;">
      <div style="text-align: center;">
        <p style="text-align: center;">
        <h4>
          <b>FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES CENTRO DE INVESTIGACIONES
            <p class="">
               ACTA DE APROBACIÓN DE PROYECTO No. 01 de 2019
               <br>
               ESPECIALIZACIÓN EN ALTA GERENCIA
               <br>
               (15 de enero de 2019)
             </p>
           </b>
         </h4>
      </div>
      <p class="col-md-12" style="text-align: justify;">
      En la ciudad de Pereira, el día <b>15 de enero de 2019</b>, en la Sala de Juntas de la oficina de la Dirección de Investigaciones de la
      Universidad Libre Seccional Pereira – Sede Belmonte, se reunieron los doctores; <b>MARLEN ISABEL REDONDO RAMIREZ</b>, Directora del Centro
      de Investigaciones de la Facultad de Ciencias Económicas, Administrativas y Contables, y el (la) doctor (a) <b>LEIDY JOHANNA HERNANDEZ RAMIREZ, como Asesor (a)</b>,
      del siguiente trabajo de investigación, con el fin de aprobar el proyecto de investigación:</p>
    </div>

    <div>
     <p>
       <b>
         <u>NOMBRE DEL TRABAJO:</u>
       </b>
     </p>
     <p>
       <b>
         ESTUDIO DE VIABILIDAD DE LA PUESTA EN FUNCIONAMIENTO DE UN OPERADOR
         TURÍSTICO EN LA CIUDAD DE PEREIRA BAJO LA MODALIDAD TODO INCLUIDO
       </b>
     </p>

     <p>
       <b>
         <u>NOMBRE DE LOS ESTUDIANTES:</u>
       </b>
     </p>

     <p style="line-height: 1em;">
       <b>
         JAISON MOSQUERA
       </b>
     </p>

     <p style="line-height: -4em;">
       <b>
         JAISON MOSQUERA
       </b>
     </p>

     <p style="line-height: -4em;">
       <b>
         JAISON MOSQUERA
       </b>
     </p>
    </div>
    <p style="text-align: justify;">
      Después de terminada la reunión se dio el resultado de: <u>APROBADO</u>
    </p>
    <p style="text-align: justify;">
      Para constancia se firma en Pereira a los 15 días del mes de enero de 2019.
    </p>
    <br>
    <br>

    <div>
      <table style="width:100%">
        <tr>
          <th class="text-center" style="width:50%">
            LUZ ANDREA BEDOYA PARRA
            <br>
            JURADO
          </th>
          <th class="text-center" style="width:50%">
            LUZ ANDREA BEDOYA PARRA
            <br>
            JURADO
          </th>
        </tr>
        <tr>
          <th class="text-center" colspan="2">
              LUZ ANDREA BEDOYA PARRA
              <br>
              JURADO
          </th>
        </tr>
        <tr>
          <th class="text-center" style="width:50%">
            LUZ ANDREA BEDOYA PARRA
            <br>
            Directora Centro de Investigaciones
          </th>
          <th class="text-center" style="width:50%">
            LUZ ANDREA BEDOYA PARRA
            <br>
            Decano Facultad de Ciencias Económicas, Administrativas y Contables
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
      <img src="../class/PDF/images/unilibre_footer.png" class="img-fluid" style="height: 80px; width: 1169px;" alt="Responsive image">
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

    $mpdf->Output("ACTA DE APROBACIÓN" . '.pdf', 'S');


	}
  else
  {
    $response["status"]  = false;
    $response["message"] = "Missing mandatory parameters";
  }

  //Display the JSON response
  //echo json_encode("Reporte generado.");


 ?>
