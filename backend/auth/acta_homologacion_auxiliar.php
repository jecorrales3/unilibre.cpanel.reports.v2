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
    <h4><b>
     FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES
      PROGRAMA DE ADMINISTRACIÓN DE EMPRESAS
      <br>
      HOMOLOGACIÓN AUXILIAR DE INVESTIGACIÓN
     <br>
     Resolución 01
     <br>
     5 de marzo de 2019
     </b></h4>
     </p>
    </div>

    <p class="col-md-12" style="text-align: justify;"><i>Con base en lo establecido en el Acuerdo No. 06 del 25 de octubre de 2006, Reglamento de investigaciones en su artículo 29 numeral 5, en donde señala homologar el trabajo de grado, previo el cumplimiento de las tareas e informes asignados como auxiliares por el término de un año, artículo 41 el trabajo realizado por los auxiliares de investigación debe ser debidamente sustentado y aprobado ante el director del Centro de Investigaciones y el investigador principal, previo concepto emitido por los pares designados y podrá aceptarse como requisito de trabajo de grado.</i>
      <br>
      Resuelve que, al Centro de Investigaciones de la Facultad de Ciencias Económicas, Administrativas y Contables, se presentó por parte del (los) investigador(es) principal(es) Doctor(es) <b>ORLANDO RODRÍGUEZ GARCÍA y ANA MARIA BARRERA RODRIGUEZ</b>, el trabajo titulado: <b>“MARKETING TURÍSTICO EN EL PAISAJE CULTURAL CAFETERO: CASO DE ESTUDIO DEMANDA TURÍSTICA EN SALENTO, QUINDÍO”</b> en el cual participa(n) como Auxiliar(es) de investigación los estudiante(s) del programa de <b>ADMINISTRACIÓN DE EMPRESAS: JHEIMY IBETH TABORDA LÓPEZ, LUISA FERNANDA MORALES YEPES y MAIRA ALEJANDRA RIOS BETANCURTH.</b>
      <br>
      El trabajo fue sometido a evaluación del par LINDY NETH PEREA MOSQUERA, quien(es) emitieron el respectivo concepto Favorable.
      <br>
      El Centro de Investigaciones programó Socialización del trabajo de investigación para el día 28 de febrero 2019 a las 10:00 am., en presencia de los investigadores principales y del Directora del Centro de Investigaciones de la Facultad de Ciencias Económicas, Administrativas y Contables.
    </p>

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
