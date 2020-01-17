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
  $mpdf->SetTitle("PAZ Y SALVO");

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
      <br>
       PROGRAMA DE ECONOMÍA
      <br>
       PAZ Y SALVO
      </b></h4>
     </p>
   </div>

    <p class="" style="text-align: justify;"><b>POR CONCEPTO DE:</b> Aprobación, homologación, socialización y entrega al Centro de Investigaciones del trabajo denominado <b>“ODS AGENDA 2030: EDUCACIÓN, PILAR FUNDAMENTAL DE TRABAJO DECENTE Y EL CRECIMIENTO ECONÓMICO”</b> realizado bajo el marco del Seminario Internacional denominado Objetivos de Desarrollo Sostenible, desarrollado con la colaboración de la Universidad San Martín de Porres-Lima Perú, y cuya asesora principal es la docente:<b> LUZ ANDREA BEDOYA PARRA,</b> como requisito parcial para optar al título de <b>ECONOMISTA.</b>
    </p>


    <p class="">
      <b>
        NOMBRE DEL EGRESADO(A): ESTEFANIA MARÍN BETANCUR
        <br>
      </b>
      <b>
        Cédula de Ciudadanía No. 1.087.493.056 de Belén de Umbría
        <br>
      </b>
      <b>
        DEL PROGRAMA DE ECONOMÍA
      </b>
    </p>

    <p class="" style="text-align: justify;">Dado en Pereira, a los 5 días del mes de julio de 2019, con destino a la de Oficina de Registro y Control.
    </p>


    <p class="" style="text-align: justify; padding-top:80px;">
    <b>
    MARLEN ISABEL REDONDO RAMIREZ
    <br>
    Directora Centro Investigaciones
    <br>
    Facultad de Ciencias Económicas, Administrativas y Contables
    </b>
    <br>
     </p>
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

  $mpdf->Output("PAZ Y SALVO" . '.pdf', 'I');

 ?>
