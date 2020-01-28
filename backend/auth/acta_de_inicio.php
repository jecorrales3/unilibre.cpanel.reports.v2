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
  $mpdf->SetTitle("ACTA DE INICIO");

  /*
  *****************************************************************************
  *****************************************************************************
                   DECLARAMOS LA CABECERA DEL DOCUMENTO PDF
  *****************************************************************************
  *****************************************************************************
  */
  // Define the Header/Footer before writing anything so they appear on the first page
  $mpdf->SetHTMLHeader('
  <table style="text-align: center; border: 1px solid #141414; font-family:arial;" width="100%">
  	<tr>
  		<td rowspan="3" width="30%">
        <img src="../class/PDF/images/unilibre_logo.png" style="height: 95px;">
      </td>
  		<td rowspan="3" width="50%" style="border-left: 1px solid #141414; border-right: 1px solid #141414; font-size:19px;">
        <b>
          ACTA DE INICIO DE PROYECTOS
          <br>
          DE INVESTIGACIÓN
        </b>
      </td>
  		<td width="30%" style="border-bottom: 1px solid #141414; font-size:13px;">
        <b>ST-INV-02-P-02-F04</b>
      </td>
  	</tr>
  	<tr>
  		<td width="30%" style="border-bottom: 1px solid #141414; font-size:13px;">
        <b>VERSIÓN 1</b>
      </td>
  	</tr>
  	<tr>
  		<td width="30%" style="font-size:13px;">
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

    <p class="col-md-12" style="text-align: justify;">
      <i>De conformidad con lo aprobado por el Consejo Seccional de Investigación, en la reunión de fecha _____________________, al proyecto de investigación Titulado “_______________________________________” y vinculado al grupo de Investigación ______________ por un monto de $_________________, presentado por el Investigador Principal _____________________________________ identificado con el documento de identidad Nº. ___________________, adscrito a la Facultad _____________________________, de la Seccional _____________; se compromete con los términos descritos a continuación:</i></p>

   <div>
     <ul>
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

     <style>
        .tables{
          border-collapse: collapse;
        }
        .border{
        border:1px solid black;
        }
     </style>

    <table class="tables" style="margin: auto;">

      <tr>
      <th class="border">Informes de Avance</th>
      <th class="border">Fecha de Entrega</th>
      </tr>

      <tr>
      <td class="border">I Informe de Avance</td>
      <td class="border"></td>
      </tr>

      <tr>
      <td class="border">II Informe de Avance</td>
      <td class="border"></td>
      </tr>

      <tr>
      <td class="border">III Informe de Avance</td>
      <td class="border"></td>
      </tr>

      <tr>
      <td class="border">Informe Final</td>
      <td class="border"></td>
      </tr>
    </table>

    <p class="">
       • Una vez proporcionados los resultados del proyecto de investigación a la Universidad Libre, esta decidirá sobre la conveniencia de solicitar la protección legal sobre los derechos patrimoniales a los que haya lugar.
       <br>
       • Cumplir con la reglamentación interna y la legislación vigente relacionada con propiedad intelectual y demás normas complementarias que regulen esta materia.
       <br>
       •  Cumplir con los resultados y compromisos relacionados.
       <br>
    </p>
    <br>
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

  $mpdf->Output("ACTA DE INICIO" . '.pdf', 'I');

 ?>
