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
  $mpdf->SetTitle("PAZ Y SALVO AUXILIARES");

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
   <h4>
     <p class="" style="text-align: center;">
      <b>
       UNIVERSIDAD LIBRE SECCIONAL PEREIRA
      <br>
       FACULTAD DE CIENCIAS ECONÓMICAS Y CONTABLES
      <br>
       CENTRO DE INVESTIGACIONE
       <br>
       <br>
       MAESTRÍA EN ADMINISTRACIÓN DE EMPRESAS
       <br>
       PAZ Y SALVO
      </b>
     </p>
     </h4>
   </div>

    <p class="" style="text-align: justify;"><b>POR CONCEPTO DE:</b> Aprobación, homologación, socialización y entrega al Centro de Investigaciones como <b>Auxiliares de Investigación</b> del trabajo de investigación denominado: <b>“MARKETING TURÍSTICO EN EL PAISAJE CULTURAL CAFETERO: CASO DE ESTUDIO DEMANDA TURÍSTICA EN SALENTO, QUINDÍO”</b> y cuyos auxiliares son los estudiantes: <b>JHEIMY IBETH TABORDA LÓPEZ, LUISA FERNANDA MORALES YEPES y MAIRA ALEJANDRA RIOS BETANCURTH</b>, requisito parcial para optar al título de <b>ADMINISTRADOR DE EMPRESAS</b>.
    </p>


    <p class="">
      <b>
        NOMBRE DEL EGRESADO(A): LUZ MARÍA RESTREPO AGUIRRE
        <br>
      </b>
      <b>
        Cédula de Ciudadanía No. 1.087.493.056 de Belén de Umbría
        <br>
      </b>
      <b>
        DEL PROGRAMA DE ADMINISTRACIÓN DE EMPRESAS
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


  $mpdf->AddPageByArray(array(
    'setAutoTopMargin' => 'stretch',
    'autoMarginPadding' => 5,
    'setAutoBottomMargin' => 'stretch',
    'autoMarginPadding' => 7
  ));
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

  $mpdf->Output("PAZ Y SALVO DE MAESTRÍA" . '.pdf', 'I');

 ?>
