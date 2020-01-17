<?php

  //Inclusion del archivo respectivo para la conexion con la BD
  require_once __DIR__ . '/../vendor/autoload.php';

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
  <img src="C:/xampp/htdocs/class/PDF/test/cabezaUnilibre.png" class="img-fluid" style="height: 120px; width: 1170px;" alt="Responsive image">
  </div>');

  /*
  *****************************************************************************
  *****************************************************************************
                   DECLARAMOS EL CUERPO DEL DOCUMENTO PDF
  *****************************************************************************
  *****************************************************************************
  */
  $html = '

  <div class="" style="font-family: Times New Roman; font-size: 13px; padding-top:-50px;">
   <div class="" style="text-align: center;">
    <p class="" style="text-align: center;">
    <h4><b>FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES
    <br>
     CENTRO DE INVESTIGACIONES
     </p>
    <p class="">
     ACTA DE APROBACIÓN DE PROYECTO No. 01 de 2019 
     <br>
     ESPECIALIZACIÓN EN ALTA GERENCIA
     <br>
     (15 de enero de 2019)</b></h4>
     </p>
    </div>
    <p class="col-md-12" style="text-align: justify;">En la ciudad de Pereira, el día <b>15 de enero de 2019</b>, en la Sala de Juntas de la oficina de la Dirección de Investigaciones de la Universidad Libre Seccional Pereira – Sede Belmonte, se reunieron los doctores; <b>MARLEN ISABEL REDONDO RAMIREZ</b>, Directora del Centro de Investigaciones de la Facultad de Ciencias Económicas, Administrativas y Contables, y el (la) doctor (a) <b>LEIDY JOHANNA HERNANDEZ RAMIREZ, como Asesor (a)</b>, del siguiente trabajo de investigación, con el fin de aprobar el proyecto de investigación:</p>

   <div>
    <p class="">
      <b>
        <u>NOMBRE DEL TRABAJO:</u>
      </b>
    </p>

    <p class="">
      <b>
        ESTUDIO DE VIABILIDAD DE LA PUESTA EN FUNCIONAMIENTO DE UN OPERADOR
        TURÍSTICO EN LA CIUDAD DE PEREIRA BAJO LA MODALIDAD TODO INCLUIDO
      </b>
    </p>

    <p class="">
      <b>
        <u>NOMBRE DE LOS ESTUDIANTES:</u>
      </b>
    </p>

    <p class=""  style=" line-height: 1em;">
      <b>
        JAISON MOSQUERA
      </b>
    </p>

    <p class=""  style=" line-height: -4em;">
      <b>
        JAISON MOSQUERA
      </b>
    </p>

    <p class=""  style=" line-height: -4em;">
      <b>
        JAISON MOSQUERA
      </b>
    </p>
   </div>
    <p class="col-md-12" style="text-align: justify;">Después de terminada la reunión se dio el resultado de: <u>APROBADO</u></p>

    <p class="col-md-12" style="text-align: justify;">Para constancia se firma en Pereira a los 15 días del mes de enero de 2019.</p>
    <br>
    <br>

    <div class="">
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
     </div>
  </div>
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
  <div class="">
    <img src="C:/xampp/htdocs/class/PDF/test/footerUnilibre.png" class="img-fluid" style="height: 80px; width: 1169px;" alt="Responsive image">
    <pre class="" style="text-align:center; font-family: Times New Roman; font-size: 13px;">PEREIRA RISARALDA. 
      Sede Centro Calle 40. No. 7-30 PBX (6) 3401081 
      <br>
      Sede Belmonte: Avenida las Américas PBX (6) 3401043
    </pre>
  </div>
  ';
  $mpdf->SetHTMLFooter($html_footer);

  /*
  *****************************************************************************
  *****************************************************************************
             DECLARAMOS EL NOMBRE DEL ARCHIVO Y EXTENSION
  *****************************************************************************
  *****************************************************************************
  */

  $mpdf->Output("ACTA DE APROBACIÓN" . '.pdf', 'I');

 ?>
