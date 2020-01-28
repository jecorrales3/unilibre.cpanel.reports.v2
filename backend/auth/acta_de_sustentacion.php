<?php

  //Inclusion del archivo respectivo para la conexion con la BD
  require_once __DIR__ . '../../class/PDF/vendor/autoload.php';

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
  $mpdf->SetTitle("ACTA DE SUSTENTACIÓN");

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
    <p class="col-md-12" style="text-align: justify;">
    Ante el(los) jurado(s) <b>LEIDY JOHANNA HERNANDEZ RAMÍREZ</b>, Asesor<b> ORLANDO RODRÍGUEZ GARCÍA y MARLEN ISABEL REDONDO RAMÍREZ</b>, Directora del Centro de Investigaciones de la Facultad de Ciencias Económicas, Administrativas y Contables, doctora <b>MARLEN ISABEL REDONDO RAMIREZ</b>, Decano Facultad de Ciencias Económicas, Administrativas y Contables <b>LUIS HERNANDO LÓPEZ PEÑARETE</b>, se presentó la sustentación del trabajo de investigación <b>“INFLUENCIA DE LAS INSTITUCIONES FORMALES DE LAS EPS EN LA RENTABILIDAD DE LAS IPS”</b> Presentado por la estudiante <b>LUZ MARÍA RESTREPO AGUIRRE</b>, obteniendo la siguiente calificación:
      </p>

 <style>
      table, th, td {
      border-collapse: collapse;
       }
       th, td {
         padding: 25px;
        }
      .text-center
      {
      text-align: center;
      }
 </style>


<div>

 <table style="width:100%">

  <tr>
    <th style="width:50%">
      <br>
      LUZ MARÍA RESTREPO AGUIRRE
    </th>
    <th style="width:20%">
      Números
      <br>
      4.5
    </th>
    <th style="width:30%">
      Letras
      <br>
      cuatro coma cinco
    </th>
  </tr>
</table>

    <p class="col-md-12" style="text-align: justify;"><b>Los evaluadores consideraron calificar la calidad del trabajo como:</b></p>

  <table style="width:70%">

  <tr>
    <th style="width:35%">
    Aprobado ( )
    <br>
    Meritorio ( )
    </th>
    <th style="width:35%">
     Muy bien ( x )
     <br>
     Summa cum laude ( )
    </th>
  </tr>
</table>
   </div>

    <p class="col-md-12" style="text-align: justify;">Para constancia se firma en Pereira a los 13 días del mes de agosto de 2019.</p>
    <br>
    <br>

    <div class="">

<table style="width:100%">
  <tr>
    <th class="text-center" style="width:50%">
       ORLANDO RODRÍGUEZ GARCÍA
        <br>
        ASESOR
    </th>
    <th class="text-center" style="width:50%">
      MARLEN ISABEL REDONDO RAMÍREZ
        <br>
        ASESOR
    </th>
  </tr>
  <tr>
    <th class="text-center" style="width:50%">
      LEIDY JOHANNA HERNANDEZ RAMÍREZ
        <br>
        JURADO
    </th>
    <th class="text-center" style="width:50%;">
      LUIS HERNANDO LÓPEZ PEÑARETE
        <br>
        Decano
        <br>
        Facultad de Ciencias Económicas, Administrativas y Contables
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

  $mpdf->Output("ACTA DE SUSTENTACIÓN" . '.pdf', 'I');

 ?>
