<?php

  /*
   *****************************************************************************
   *****************************************************************************

   ** @description  The PHP document create a PDF invoice                     **
   ** @author       Johan Corrales | jecorrales@rotumark.co                   **
   ** @created      The PHP document was create on 17/12/2018                 **
   ** @required     connection.php for anothers PHP documents                 **

   *****************************************************************************
   *****************************************************************************

   ** @modified   - The PHP document was modified on 17/12/2018               **
   ** @who        - Johan Corrales | jecorrales@rotumark.co                   **
   ** @why        - Creation                                                  **

   *****************************************************************************
   *****************************************************************************
  */

  //Inclusion del archivo respectivo para la conexion con la BD
  require_once __DIR__ . '/../Class/PDF/vendor/autoload.php';
  require_once __DIR__ . '/../Connection/connection.php';
  error_reporting(0);
  //Declaracion de variables
  $idFacturacion = $_GET['id_factura'];
  //Declaracion de inicio de sesion
  session_start();
  $idEmpresa     = $_SESSION['usuario']['id_empresa'];
  //$idUsuario     = $_SESSION['usuario']['id_usuario'];
  //Declaracion del array para codificar en formato JSON la variable mensaje
  $resultado  = array();
  //Declaramos valores a utilizar en los calculos de la factura
  $descuento    = 0;
  $subtotal     = 0;
  $impuesto5    = 0;
  $impuesto19   = 0;
  $totalB       = 0;
  $totalFactura = 0;
  $mysqli->set_charset('utf8');

  /*
  *****************************************************************************
  *****************************************************************************
            INCIO--  ALGORITMO QUE REALIZA EL CAMBIO DE NUMERO A LETRAS
  *****************************************************************************
  *****************************************************************************
  */

  function numletras($numero, $_moneda)
  {
    switch($_moneda)
    {
      case 1:
      $_nommoneda='COLONES';
      break;
      case 2:
      $_nommoneda='DÓLARES';
      break;
      case 3:
      $_nommoneda='EUROS';
      break;
    }

    $tempnum = explode('.',$numero);

    if ($tempnum[0] !== "")
    {
      $numf = milmillon($tempnum[0]);
      if ($numf == "UN")
      {
        $numf = substr($numf, 0, -1);
      }

      $TextEnd = $numf.' ';
      $TextEnd .= $_nommoneda.' CON ';
    }

    if (isset($tempnum[1])== "" || $tempnum[1] >= 100)
    {
      $tempnum[1] = "00" ;
    }
    else
    {
      $tempnum[1] = null;
    }
      $TextEnd .= $tempnum[1] ;
      $TextEnd .= "/100";
      return $TextEnd;
  }

  function unidad($numuero)
  {
    switch ($numuero)
    {
      case 9:
      {
        $numu = "NUEVE";
        break;
      }
      case 8:
      {
        $numu = "OCHO";
        break;
      }
      case 7:
      {
        $numu = "SIETE";
        break;
      }
      case 6:
      {
        $numu = "SEIS";
        break;
      }
      case 5:
      {
        $numu = "CINCO";
        break;
      }
      case 4:
      {
        $numu = "CUATRO";
        break;
      }
      case 3:
      {
        $numu = "TRES";
        break;
      }
      case 2:
      {
        $numu = "DOS";
        break;
      }
      case 1:
      {
        $numu = "UN";
        break;
      }
      case 0:
      {
        $numu = "";
        break;
      }
    }
    return $numu;
  }

  function decena($numdero)
  {

    if ($numdero >= 90 && $numdero <= 99)
    {
      $numd = "NOVENTA ";
      if ($numdero > 90)
      $numd = $numd."Y ".(unidad($numdero - 90));
    }
    else if ($numdero >= 80 && $numdero <= 89)
    {
      $numd = "OCHENTA ";
      if ($numdero > 80)
      {
        $numd = $numd."Y ".(unidad($numdero - 80));
      }
    }
    else if ($numdero >= 70 && $numdero <= 79)
    {
      $numd = "SETENTA ";
      if ($numdero > 70)
      {
        $numd = $numd."Y ".(unidad($numdero - 70));
      }
    }
    else if ($numdero >= 60 && $numdero <= 69)
    {
      $numd = "SESENTA ";
      if ($numdero > 60)
      {
        $numd = $numd."Y ".(unidad($numdero - 60));
      }
    }
    else if ($numdero >= 50 && $numdero <= 59)
    {
      $numd = "CINCUENTA ";
      if ($numdero > 50)
      {
        $numd = $numd."Y ".(unidad($numdero - 50));
      }
    }
    else if ($numdero >= 40 && $numdero <= 49)
    {
      $numd = "CUARENTA ";
      if ($numdero > 40)
      {
        $numd = $numd."Y ".(unidad($numdero - 40));
      }
    }
    else if ($numdero >= 30 && $numdero <= 39)
    {
      $numd = "TREINTA ";
      if ($numdero > 30)
      {
        $numd = $numd."Y ".(unidad($numdero - 30));
      }
    }
    else if ($numdero >= 20 && $numdero <= 29)
    {
      if ($numdero == 20)
      {
        $numd = "VEINTE ";
      }
      else
      {
        $numd = "VEINTI".(unidad($numdero - 20));
      }
    }
    else if ($numdero >= 10 && $numdero <= 19)
    {
      switch ($numdero)
      {
        case 10:
        {
          $numd = "DIEZ ";
          break;
        }
        case 11:
        {
          $numd = "ONCE ";
          break;
        }
        case 12:
        {
          $numd = "DOCE ";
          break;
        }
        case 13:
        {
          $numd = "TRECE ";
          break;
        }
        case 14:
        {
          $numd = "CATORCE ";
          break;
        }
        case 15:
        {
          $numd = "QUINCE ";
          break;
        }
        case 16:
        {
          $numd = "DIECISEIS ";
          break;
        }
        case 17:
        {
          $numd = "DIECISIETE ";
          break;
        }
        case 18:
        {
          $numd = "DIECIOCHO ";
          break;
        }
        case 19:
        {
          $numd = "DIECINUEVE ";
          break;
        }
      }
    }
    else
    $numd = unidad($numdero);
    return $numd;
  }

  function centena($numc)
  {
    if ($numc >= 100)
    {
      if ($numc >= 900 && $numc <= 999)
      {
        $numce = "NOVECIENTOS ";
        if ($numc > 900)
        {
          $numce = $numce.(decena($numc - 900));
        }
      }
      else if ($numc >= 800 && $numc <= 899)
      {
        $numce = "OCHOCIENTOS ";
        if ($numc > 800)
        {
          $numce = $numce.(decena($numc - 800));
        }
      }
      else if ($numc >= 700 && $numc <= 799)
      {
        $numce = "SETECIENTOS ";
        if ($numc > 700)
        {
          $numce = $numce.(decena($numc - 700));
        }
      }
      else if ($numc >= 600 && $numc <= 699)
      {
        $numce = "SEISCIENTOS ";
        if ($numc > 600)
        {
          $numce = $numce.(decena($numc - 600));
        }
      }
      else if ($numc >= 500 && $numc <= 599)
      {
        $numce = "QUINIENTOS ";
        if ($numc > 500)
        {
          $numce = $numce.(decena($numc - 500));
        }
      }
      else if ($numc >= 400 && $numc <= 499)
      {
        $numce = "CUATROCIENTOS ";
        if ($numc > 400)
        {
          $numce = $numce.(decena($numc - 400));
        }
      }
      else if ($numc >= 300 && $numc <= 399)
      {
        $numce = "TRESCIENTOS ";
        if ($numc > 300)
        {
          $numce = $numce.(decena($numc - 300));
        }
      }
      else if ($numc >= 200 && $numc <= 299)
      {
        $numce = "DOSCIENTOS ";
        if ($numc > 200)
        {
          $numce = $numce.(decena($numc - 200));
        }
      }
      else if ($numc >= 100 && $numc <= 199)
      {
        if ($numc == 100)
        {
          $numce = "CIEN ";
        }
        else
        {
          $numce = "CIENTO ".(decena($numc - 100));
        }
      }
    }
    else
    {
      $numce = decena($numc);
    }

    return $numce;
  }

  function miles($nummero)
  {
    if ($nummero >= 1000 && $nummero < 2000)
    {
      $numm = "MIL ".(centena($nummero%1000));
    }
    if ($nummero >= 2000 && $nummero <10000)
    {
      $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
    }
    if ($nummero < 1000)
    {
      $numm = centena($nummero);
    }
    return $numm;
  }

  function decmiles($numdmero)
  {
    if ($numdmero == 10000)
    {
      $numde = "DIEZ MIL";
    }
    if ($numdmero > 10000 && $numdmero <20000)
    {
      $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));
    }
    if ($numdmero >= 20000 && $numdmero <100000)
    {
      $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));
    }
    if ($numdmero < 10000)
    {
      $numde = miles($numdmero);
    }
    return $numde;
  }

  function cienmiles($numcmero)
  {
    if ($numcmero == 100000)
    {
      $num_letracm = "CIEN MIL";
    }
    if ($numcmero >= 100000 && $numcmero <1000000)
    {
      $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));
    }
    if ($numcmero < 100000)
    {
      $num_letracm = decmiles($numcmero);
    }
    return $num_letracm;
  }

  function millon($nummiero)
  {
    if ($nummiero >= 1000000 && $nummiero <2000000)
    {
      $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
    }
    if ($nummiero >= 2000000 && $nummiero <10000000)
    {
      $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
    }
    if ($nummiero < 1000000)
    {
      $num_letramm = cienmiles($nummiero);
    }
    return $num_letramm;
  }

  function decmillon($numerodm)
  {
    if ($numerodm == 10000000)
    {
      $num_letradmm = "DIEZ MILLONES";
    }
    if ($numerodm > 10000000 && $numerodm <20000000)
    {
      $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));
    }
    if ($numerodm >= 20000000 && $numerodm <100000000)
    {
      $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));
    }
    if ($numerodm < 10000000)
    {
      $num_letradmm = millon($numerodm);
    }
    return $num_letradmm;
  }

  function cienmillon($numcmeros)
  {
    if ($numcmeros == 100000000)
    {
      $num_letracms = "CIEN MILLONES";
    }
    if ($numcmeros >= 100000000 && $numcmeros <1000000000)
    {
      $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));
    }
    if ($numcmeros < 100000000)
    {
      $num_letracms = decmillon($numcmeros);
    }
    return $num_letracms;
  }

  function milmillon($nummierod)
  {
    if ($nummierod >= 1000000000 && $nummierod <2000000000)
    {
      $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
    }
    if ($nummierod >= 2000000000 && $nummierod <10000000000)
    {
      $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
    }
    if ($nummierod < 1000000000)
    {
        $num_letrammd = cienmillon($nummierod);
    }
    return $num_letrammd;
  }

  /*
  *****************************************************************************
  *****************************************************************************
            FINAL--  ALGORITMO QUE REALIZA EL CAMBIO DE NUMERO A LETRAS
  *****************************************************************************
  *****************************************************************************
  */
  if (is_numeric($idEmpresa) && is_numeric($idFacturacion))
  {
    if (isset($idEmpresa) && !empty($idEmpresa) && isset($idFacturacion) && !empty($idFacturacion))
    {
      /*
      *****************************************************************************
      *****************************************************************************
           PREPARAMOS CONSULTA PARA VERIFICAR SI LA FACTURA SOLICITADA EXISTE
      *****************************************************************************
      *****************************************************************************
      */

      /* Esta es la consulta SQL */
      $consulta_factura = $mysqli->prepare("SELECT id_factura
                                              FROM factura
                                             WHERE id_factura = ?
                                               AND id_empresa_factura = ?
                                               AND id_estado_factura != '2'
                                               AND id_usuario_punto_venta_factura IS NULL");

      /* Comprobamos si la consulta se preparó correctamente */
      if ($consulta_factura === false)
      {
         die('Error SQL: ' . $mysqli->error);
      }

      /*Asignamos al primer "?" el valor de "id_puntoEmpresa" */
      $consulta_factura->bind_param('ii', $idFacturacion, $idEmpresa);

      /* Comprobamos si la consulta se ejecutó correctamente */
      if ($consulta_factura->execute() === false)
      {
        die('Error SQL: ' . $consulta_factura->error);
      }

      /* Aquí obtenemos el registro (si lo hay) */
      if ($consulta_factura->fetch() !== true)
      {
          echo "It's not possible to access this invoice because doesn't exist!";
      }
      else
      {
        $consulta_factura->next_result(); // Dump the extra resultset.
        $consulta_factura->free_result(); // Does what it says.
        /*
        *****************************************************************************
        *****************************************************************************
                         CONSULTA DE DATOS DEL PERFIL DE LA EMPRESA
        *****************************************************************************
        *****************************************************************************
        */

        $consultaPerfilEmpresa = $mysqli->query("SELECT empr.id_empresa,
                                                  	empr.nombre_empresa,
                                                    empr.nombre_comercial_empresa,
                                                    empr.nit_empresa,
                                                    empr.correo_empresa,
                                                    empr.contrasena_empresa,
                                                    empr.telefono_empresa,
                                                    empr.celular_empresa,
                                                    empr.direccion_empresa,
                                                    empr.ruta_imagen_empresa,
                                                    empr.imagen_empresa,
                                                    empr.puntaje_empresa,
                                                    empr.token_empresa,
                                                    cdad.nombre_ciudad,
                                                    dpto.nombre_departamento,
                                                    empr.id_licencia_empresa,
                                                    lcna.nombre_licencia,
                                                    lcna.costo_licencia,
                                                    lcna.tipo_licencia,
                                                    TIME_FORMAT(empr.fecha_inscripcion_licencia, '%d-%m-%Y') as fecha_inscripcion_licencia,
                                                    empr.fecha_desde_licencia,
                                                    TIME_FORMAT(empr.fecha_hasta_licencia, '%d-%m-%Y') as fecha_hasta_licencia,
                                                    elcn.nombre_estado_licencia,
                                                    ngco.nombre_modelo_negocio,
                                                    treg.id_tipo_regimen,
                                                    treg.nombre_tipo_regimen,
                                                    treg.responsabilidad_tipo_regimen

                                               FROM empresa empr
                                               INNER JOIN ciudad cdad
                                               ON cdad.id_ciudad = empr.id_ciudad_empresa
                                               INNER JOIN departamento dpto
                                               ON dpto.id_departamento = cdad.id_departamento_ciudad
                                               INNER JOIN licencia lcna
                                               ON lcna.id_licencia = empr.id_licencia_empresa
                                               INNER JOIN estado_licencia elcn
                                               ON elcn.id_estado_licencia = empr.id_estado_licencia_empresa
                                               INNER JOIN modelo_negocio ngco
                                               ON ngco.id_modelo_negocio = empr.id_modelo_negocio_empresa
                                               INNER JOIN tipo_regimen treg
                                               ON treg.id_tipo_regimen = empr.id_tipo_regimen_empresa
                                               WHERE empr.id_empresa = '$idEmpresa'");

        $data_perfil = array();

        while ($row = $consultaPerfilEmpresa->fetch_assoc())
        {
          $data_perfil[] = $row;
          $nombreEmpresa          = $row['nombre_comercial_empresa'];
          $rutaImagenEmpresa      = $row['ruta_imagen_empresa'];
          $imagenEmpresa          = $row['imagen_empresa'];
          $nitEmpresa             = $row['nit_empresa'];
          $direccionEmpresa       = $row['direccion_empresa'];
          $ciudadEmpresa          = $row['nombre_ciudad'];
          $departamentoEmpresa    = $row['nombre_departamento'];
          $telefonoEmpresa        = $row['telefono_empresa'];
          $celularEmpresa         = $row['celular_empresa'];
          $correoEmpresa          = $row['correo_empresa'];
          $regimenEmpresa         = $row['nombre_tipo_regimen'];
          $responsabilidadEmpresa = $row['responsabilidad_tipo_regimen'];
        }

        /*
        *****************************************************************************
        *****************************************************************************
                           CONSULTA DE DATOS DE LA FACTURA
        *****************************************************************************
        *****************************************************************************
        */

        $consultarDatosFactura = $mysqli->query("SELECT fact.id_factura,
                                                	     fact.numero_factura,
                                                       fact.fecha_factura,
                                                       fact.fecha_vencimiento_factura,
                                                       DATEDIFF(fact.fecha_vencimiento_factura, CURDATE()) AS fecha_diferencia,
                                                       cpiv.nombre_cliente,
                                                       cpiv.identificacion_cliente,
                                                       cpiv.correo_cliente,
                                                       cpiv.telefono_cliente,
                                                       cpiv.direccion_cliente,
                                                       cdad.nombre_ciudad,
                                                       dpto.nombre_departamento,
                                                	     efac.nombre_estado_factura,
                                                       tpag.nombre_tipo_pago,
                                                       conf.prefijo_configuracion_factura,
                                                       conf.id_configuracion_factura,
                                                       conf.nombre_configuracion_factura,
                                                       conf.prefijo_configuracion_factura,
                                                       conf.vigencia_desde_factura,
                                                       conf.vigencia_hasta_factura,
                                                       conf.consecutivo_desde_factura,
                                                       conf.consecutivo_hasta_factura,
                                                       conf.vigencia_desde_factura,
                                                       conf.resolucion_configuracion_factura

                                                FROM factura fact
                                                INNER JOIN cliente_factura_pivote cpiv
                                                ON cpiv.id_cliente_factura_pivote = fact.id_cliente_factura_pivote
                                                INNER JOIN ciudad cdad
                                                ON cdad.id_ciudad = cpiv.id_ciudad_cliente
                                                INNER JOIN departamento dpto
                                                ON dpto.id_departamento = cdad.id_departamento_ciudad
                                                INNER JOIN tipo_impresion impr
                                                ON impr.id_tipo_impresion = fact.id_tipo_impresion_factura
                                                INNER JOIN empresa empr
                                                ON empr.id_empresa = fact.id_empresa_factura
                                                INNER JOIN estado_factura efac
                                                ON efac.id_estado_factura = fact.id_estado_factura
                                                INNER JOIN tipo_pago tpag
                                                ON tpag.id_tipo_pago = fact.id_modo_pago_factura
                                                INNER JOIN configuracion_factura conf
                                                ON conf.id_configuracion_factura = fact.id_configuracion_factura
                                                WHERE fact.id_factura = '$idFacturacion'");

        $data_factura = array();

        while ($row = $consultarDatosFactura->fetch_assoc())
        {
          $data_factura[] = $row;
          $resolucionFactura            = $row['resolucion_configuracion_factura'];
          $fechaExpedicionFactura       = $row['vigencia_desde_factura'];
          $fechaVencimientoFactura      = $row['fecha_vencimiento_factura'];
          $consecutivoDesde             = $row['consecutivo_desde_factura'];
          $consecutivoHasta             = $row['consecutivo_hasta_factura'];
          $estadoFactura                = $row['nombre_tipo_pago'];
          $prefijoFactura               = $row['prefijo_configuracion_factura'];
          $numeroFactura                = $row['numero_factura'];
          $fechaFactura                 = $row['fecha_factura'];
          $vencimientoFactura           = $row['fecha_vencimiento_factura'];
          $nombreClienteFactura         = $row['nombre_cliente'];
          $identificacionClienteFactura = $row['identificacion_cliente'];
          $telefonoClienteFactura       = $row['telefono_cliente'];
          $direccionClienteFactura      = $row['direccion_cliente'];
          $ciudadClienteFactura         = $row['nombre_ciudad'];
          $departamentoClienteFactura   = $row['nombre_departamento'];
        }

        /*
        *****************************************************************************
        *****************************************************************************
                           CONSULTA DE DATOS DE LOS PUNTOS DE VENTA
        *****************************************************************************
        *****************************************************************************
        */

        $consultarPuntosVenta  = $mysqli->query("SELECT pven.id_punto_venta,
                                               	        pven.nombre_punto_venta,
                                                        pven.codigo_punto_venta,
                                                        pven.direccion_punto_venta,
                                                        pven.barrio_punto_venta,
                                                        pven.local_punto_venta,
                                                        pven.telefono_punto_venta,
                                                        pven.celular_punto_venta,
                                                        pven.id_bodega_punto_venta,
                                                        bdga.nombre_bodega,
                                                        bdga.numero_bodega,
                                                        bdga.codigo_bodega
                                                  FROM punto_venta pven
                                                  INNER JOIN bodega bdga
                                                  ON bdga.id_bodega = pven.id_bodega_punto_venta
                                                  WHERE bdga.id_empresa_bodega = '$idEmpresa'");

        $data_punto_venta = array();

        /*
        *****************************************************************************
        *****************************************************************************
                      CONSULTA DE DATOS DE LOS DETALLES DE FACTURACION
        *****************************************************************************
        *****************************************************************************
        */
        $consultaDetalleFactura = $mysqli->query("SELECT dfac.id_detalle_factura,
                                                         dfac.cantidad_detalle_factura,
                                                         dfac.fecha_detalle_factura,
                                                         dfac.costo_venta_detalle_factura,
                                                         dfac.descuento_detalle_factura,
                                                         dfac.id_producto_detalle_factura,
                                                         dfac.id_nota_credito_detalle_factura,
                                                         dfac.devolucion_detalle_factura,
                                                         dfac.id_factura_detalle_facutra,
                                                         ppiv.nombre_producto,
                                                         ppiv.codigo_producto,
                                                         ppiv.costo_venta_producto,
                                                         ppiv.id_impuesto_producto,
                                                         ipto.nombre_impuesto,
                                                         ipto.valor_impuesto,
                                                         ipto.calculo_impuesto,
                                                         ncrd.fecha_nota_credito,
                                                         fact.numero_factura,
                                                         fact.fecha_factura,
                                                         fact.fecha_vencimiento_factura
                                                    FROM detalle_factura dfac
                                                    INNER JOIN factura fact
                                                    ON fact.id_factura = dfac.id_factura_detalle_facutra
                                                    INNER JOIN producto_factura_pivote ppiv
                                                    ON ppiv.id_producto_factura_pivote = dfac.id_producto_detalle_factura_pivote
                                                    INNER JOIN impuesto ipto
                                                    ON ipto.id_impuesto = ppiv.id_impuesto_producto
                                                    LEFT JOIN nota_credito ncrd
                                                    ON ncrd.id_nota_credito = dfac.id_nota_credito_detalle_factura
                                                    WHERE dfac.id_factura_detalle_facutra = '$idFacturacion'");

        $data_detalle = array();
        $fila = 1;

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
        $mpdf->SetTitle($prefijoFactura . $numeroFactura);

        /*
        *****************************************************************************
        *****************************************************************************
                         DECLARAMOS LA CABECERA DEL DOCUMENTO PDF
        *****************************************************************************
        *****************************************************************************
        */
        // Define the Header/Footer before writing anything so they appear on the first page
        $mpdf->SetHTMLHeader('
        <div class="contenedor-vacio" style="float: center; width: 10%; background-color: #ff23;">
        </div>
        <div class="contenedor-logo" style="float: left; width: 20%; text-align: center; padding-top:30px; font-family: Arial; font-size: 11px; line-height: 1.2; color: #444;">
          <img class="logo-empresa" style="max-width: 100%; height: auto;" src="../../src/assets/' . $rutaImagenEmpresa . $imagenEmpresa . '" alt="">
          <strong>NIT: ' . $nitEmpresa . '</strong>
        </div>
        <div class="contenedor-empresa" style="float: right; width: 70%; text-align: center;">
          <br>
          <div style="width: 500px; text-align: center; font-family: Arial; font-size: 11px; line-height: 1.2; color: #444;">
            <strong> ' . strtoupper($nombreEmpresa) .  '</strong>
            <br>
            <strong>' . strtoupper($direccionEmpresa) . ' - '. strtoupper($ciudadEmpresa) . ', ' . strtoupper($departamentoEmpresa) .'</strong>
            <br>
            <strong>Teléfono: ' . strtoupper($telefonoEmpresa) .' - Celular: ' . strtoupper($celularEmpresa) . '</strong>
            <br>
            <strong>Email: ' . $correoEmpresa . ' </strong>
            <br><br>
            <strong> ' . mb_strtoupper($responsabilidadEmpresa) . ' - ' . mb_strtoupper($regimenEmpresa) . '</strong>
            <br>
            #' . $resolucionFactura . ' Fecha Exp ' . $fechaExpedicionFactura . ' Desde: ' . $consecutivoDesde . ' Hasta: ' . $consecutivoHasta . '
          </div>
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
        .text-left
          {
            text-align:left;
          }

          .text-right
          {
            text-align:right;
          }

          .text-center
          {
            text-align:center;
          }
          .table-factura
          {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
            border: 1px solid #dee2e6;
            padding: .3rem;

            text-align: center;
            font-size: 12px;
            font-family: Arial;
            line-height: 1.2;
            color: #444;
          }

          .table-item
          {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            padding: .3rem;
            border: 1px solid #dee2e6;

            text-align: center;
            font-size: 11px;
            font-family: Arial;
            line-height: 1.5;
            color: #444;
          }

          .table-item-prueba
          {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            width: 100%;
            table-layout: fixed;
            max-width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            padding: .3rem;
            border: 1px solid #dee2e6;

            text-align: center;
            font-size: 11px;
            font-family: Arial;
            line-height: 1.5;
            color: #444;
          }

          .thead-primary
          {
            background-color: #007bff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            font-size: 12px;
            font-family: Arial;
            line-height: 1.2;
          }

          .table-striped tr:nth-child(even)
          {
            background-color: #f2f2f2
          }

          .tr-calculos
          {
            padding: 0.1rem;
          }

          .td-calculos
          {
            border-right: 1px solid #dee2e6;
            border-left: 1px solid #dee2e6;
          }

          .td-legal
          {
            background-color: rgb(242, 242, 242) !important;
            border: 1px solid #D2D2D2;
          }
        </style>
        <table class="table-factura">
          <tbody>
            <tr>
              <td class="text-center" colspan="5" style="border: 1px solid #dee2e6;">
                <strong>FACTURA DE VENTA - ' . mb_strtoupper($estadoFactura) . '</strong>
              </td>
              <td class="text-center" colspan="2">
                <strong>N°. ' . mb_strtoupper($prefijoFactura) . $numeroFactura . '</strong>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table-factura">
          <tbody>
            <tr>
              <td class="text-left" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>CLIENTE</strong>
              </td>
              <td class="text-left" colspan="2" style="border: 1px solid #dee2e6;">
                ' . mb_strtoupper($nombreClienteFactura) . '
              </td>
              <td class="text-center" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>NIT</strong>
              </td>
              <td class="text-center" colspan="3" style="border: 1px solid #dee2e6;">
                ' . $identificacionClienteFactura . '
              </td>
              <td class="text-center" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>TELÉFONO</strong>
              </td>
              <td class="text-center" colspan="3" style="border: 1px solid #dee2e6;">
                ' . $telefonoClienteFactura . '
              </td>
            </tr>
            <tr>
              <td class="text-left" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>RAZÓN CCIAL</strong>
              </td>
              <td class="text-left" colspan="2">
                ' . mb_strtoupper($nombreClienteFactura) . '
              </td>
              <td class="text-center" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>FECHA</strong>
              </td>
              <td class="text-center" colspan="3" style="border: 1px solid #dee2e6;">
                ' . $fechaFactura . '
              </td>
              <td class="text-center" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>VENCE</strong>
              </td>
              <td class="text-center" colspan="3" style="border: 1px solid #dee2e6;">
                ' . $fechaVencimientoFactura . '
              </td>
            </tr>
            <tr>
              <td class="text-left" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>DIRECCIÓN</strong>
              </td>
              <td class="text-left" colspan="6" style="border: 1px solid #dee2e6;">
                ' . mb_strtoupper($direccionClienteFactura) . '
              </td>
              <td class="text-center" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>CIUDAD</strong>
              </td>
              <td class="text-center" colspan="3" style="border: 1px solid #dee2e6;">
                ' . mb_strtoupper($ciudadClienteFactura) . ', ' . mb_strtoupper($departamentoClienteFactura) . '
              </td>
            </tr>
            <tr>
              <td class="text-left" colspan="1" style="border: 1px solid #dee2e6;">
                <strong>Nota:</strong>
              </td>
              <td class="text-center" colspan="10" style="border: 1px solid #dee2e6;">

              </td>
            </tr>
          </tbody>
        </table>

        <table class="table-item table-striped" style="overflow: visible|hidden|wrap">
          <tr class="thead-primary">
            <th scope="col" style="color: #ffffff">#</th>
            <th class="text-left" scope="col" style="color: #ffffff">Código</th>
            <th class="text-left" scope="col" style="color: #ffffff">Producto</th>
            <th scope="col" class="text-center" style="color: #ffffff">Cantidad</th>
            <th scope="col" class="text-center" style="color: #ffffff">Descuento (%)</th>
            <th scope="col" class="text-center" style="color: #ffffff">IVA (%)</th>
            <th scope="col" class="text-right"  style="color: #ffffff">Total</th>
          </tr>
          <tbody>';
          while($row = $consultaDetalleFactura->fetch_assoc())
          {
            //Calculo de valores en tabla de items
            $impuesto   = ($row['calculo_impuesto'] == 0) ? 1 : $row['calculo_impuesto'];
            $total      = ((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - (($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura'])/100)) * $impuesto);
            //Calculo del descuento en factura
            $descuento += (($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura'])/100);
            //Calculo del subtotal de la factura
            $subtotal  += (($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - (($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura'])/100));
            //Calculo del impuesto, tanto del 5% como del 19%
            ($row['valor_impuesto'] == 5) ?
              $impuesto5 +=
              (
                ((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura']) / 100)) * $row['calculo_impuesto']
              )
              -
              (
                ((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura']) / 100))
              ):
              (
                ((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura']) / 100)) * $row['calculo_impuesto']
              )
              -
              (
                ((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura']) / 100))
              );

            ($row['valor_impuesto'] == 19) ?
              $impuesto19 +=
              (
                (((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura']) / 100)) * $row['calculo_impuesto'])
              )
              -
              (
                ((($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura']) - ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['descuento_detalle_factura']) / 100))
              ): $impuesto19 = 0;
            //Calculo del TOTAL de la factura
            ($row['valor_impuesto'] != 0) ?
            $totalA = (
              ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['calculo_impuesto'])
              -
              (($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['calculo_impuesto'] * $row['descuento_detalle_factura']) / 100))
            : $totalA = 0;

            ($row['valor_impuesto'] == 0) ?
            $totalB = (
              ($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'])
              -
              (($row['costo_venta_detalle_factura'] * $row['cantidad_detalle_factura'] * $row['calculo_impuesto'] * $row['descuento_detalle_factura']) / 100))
              : $totalB = 0;
            //Sumamos los dos valores obtenidos para calcular el valor total de la factura
            $totalFactura +=  $totalA + $totalB;
            $html .=
            '
            <tr  tyle="height:500px;">
                <th scope="row">'
                 .  $fila++ .
                '</th>
                <td class="text-left">'   . mb_strtoupper($row['codigo_producto']) . '</td>
                <td class="text-left">'   . mb_strtoupper($row['nombre_producto']) . '</td>
                <td class="text-center">' . $row['cantidad_detalle_factura'] . '</td>
                <td class="text-center">' . $row['descuento_detalle_factura'] . '</td>
                <td class="text-center">' . $row['valor_impuesto'] . '%</td>
                <td class="text-right">$' . number_format($total) . '</td>
            </tr>';
          }
            $num_letrammd = milmillon(round($totalFactura));
            $html .='
          </tbody>
        </table>
        <br><br>
        <table width="100%" class="table-item-prueba">
          <tbody>
            <tr class="td-legal">
              <td class="text-center" colspan="7">
                Esta factura se asimila en todos sus efectos legales a una letra de cambio según el Artículo 774 C.C.
              </td>
            </tr>
            <tr>
              <td class="text-left td-calculos" colspan="5" style="border-bottom: 1px solid #dee2e6;">
                Observaciones:
              </td>
              <td class="text-left td-calculos" colspan="1">
                Descuento:
              </td>
              <!--Calculos de facturacion-->
              <td class="text-right">
                - $  ' . number_format($descuento) . '
              </td>
            </tr>

            <tr>
              <td class="text-left" colspan="5">

              </td>
              <td class="text-left td-calculos" colspan="1">
                Subtotal (SIN IVA):
              </td>
              <!--Calculos de facturacion-->
              <td class="text-right td-calculos">
                $' . number_format($subtotal) . '
              </td>
            </tr>

            <tr>
              <td class="text-left td-calculos" colspan="5">

              </td>
              <td class="text-left td-calculos" colspan="1">
                Impuesto (5%):
              </td>
              <!--Calculos de facturacion-->
              <td class="text-right td-calculost">
                $' . number_format($impuesto5) . '
              </td>
            </tr>
            <tr>
              <td class="text-left td-calculos" colspan="5">

              </td>
              <td class="text-left td-calculos" colspan="1">
                Impuesto (19%):
              </td>
              <!--Calculos de facturacion-->
              <td class="text-right td-calculos">
                $' . number_format($impuesto19) . '
              </td>
            </tr>
            <tr>
              <td class="text-left td-calculos" colspan="5" style="border-top: 1px solid #dee2e6;">
                ' . $num_letrammd . '
              </td>
              <td class="text-left td-calculos" colspan="1" style="border-top: 1px solid #dee2e6;">
                NETO A PAGAR:
              </td>
              <!--Calculos de facturacion-->
              <td class="text-right td-calculos" style="border-top: 1px solid #dee2e6;">
                <strong>$' . number_format($totalFactura) . '</strong>
              </td>
            </tr>
          </tbody>
        </table>';

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
        <table class="table-item-prueba" style="overflow: auto | hidden | visible | wrap">
          <tbody>
            <tr>
              <td class="text-left tr-calculos" colspan="3" style="border: 1px solid #dee2e6;">
                <p>Despacha:</p>
                &nbsp;
              </td>
              <td class="text-left tr-calculos" colspan="3" style="border: 1px solid #dee2e6;">
                <p>Autoriza:</p>
                &nbsp;
              </td>
              <td class="text-left tr-calculos" colspan="3" style="border: 1px solid #dee2e6;">
                <p>Recibido:</p>
                &nbsp;
              </td>
            </tr>
            <tr>
              <td class="text-left tr-calculos" colspan="3" style="border: 1px solid #dee2e6; height="20px;"">
                <p>CC:</p>
                &nbsp;
              </td>
              <td class="text-left tr-calculos" colspan="3" style="border: 1px solid #dee2e6;">
                <p>CC:</p>
                &nbsp;
              </td>
              <td class="text-left tr-calculos" colspan="3" style="border: 1px solid #dee2e6;">
                <p>CC:</p>
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>
        <br>
        <table width="100%" style="font-size: 12px; font-family: Arial; color: #444;">
            <tr>
              <td class="text-left" colspan="9">
              ';
                while($row = $consultarPuntosVenta->fetch_assoc())
                {
                  $html_footer .=
                  ' '. ucwords($row['nombre_punto_venta']) .', ' . ucwords($row['direccion_punto_venta']) .  ' ' . ucwords($row['barrio_punto_venta']) .  ' - ';
                }
                $html_footer .='
              </td>
            </tr>
            <tr>
              <td colspan="9">
                <hr>
              </td>
            </tr>
            <tr>
                <td width="60%" align="left">
                  Software RTM (01 8000 999 999 - 311 345 3321) - ventas@rtm.com - www.rtm.com
                </td>
                <td width="40%" align="right">Página {PAGENO} de {nbpg}</td>
            </tr>
        </table>';
        $mpdf->SetHTMLFooter($html_footer);

        /*
        *****************************************************************************
        *****************************************************************************
                   DECLARAMOS EL NOMBRE DEL ARCHIVO Y EXTENSION
        *****************************************************************************
        *****************************************************************************
        */

        $mpdf->Output($prefijoFactura . $numeroFactura . '.pdf', 'I');
      }
    }
    else
    {
      echo "It's not possible to access this invoice!";
    }
  }
  else
  {
    echo "It's not possible to access this invoice, incorrect value!";
  }

 ?>
