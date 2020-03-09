<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document shows a message result action            **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 21/01/2020                 **
  ** @required     db_connection.php for anothers PHP documents              **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 21/01/2020                **
  ** @who        - Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @why        - Creation                                                  **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  */

  function getMessageError()
  {
    $html_error = "
    <style>
      #notfound
      {
        position: relative;
        height: 100vh;
      }

      #notfound .notfound
      {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
      }

      .notfound
      {
        max-width: 920px;
        width: 100%;
        line-height: 1.4;
        text-align: center;
        padding-left: 15px;
        padding-right: 15px;
      }

      .notfound .notfound-404
      {
        position: absolute;
        height: 100px;
        top: 0;
        left: 50%;
        -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
                transform: translateX(-50%);
        z-index: -1;
      }

      .notfound .notfound-404 h1
      {
        font-family: 'Maven Pro', sans-serif;
        color: #ececec;
        font-weight: 900;
        font-size: 276px;
        margin: 0px;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
      }

      .notfound h2
      {
        font-family: 'Maven Pro', sans-serif;
        font-size: 46px;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0px;
      }

      .notfound p
      {
        font-family: 'Maven Pro', sans-serif;
        font-size: 16px;
        color: #000;
        font-weight: 400;
        text-transform: uppercase;
        margin-top: 15px;
      }
    </style>
    <div id='notfound'>
      <div class='notfound'>
        <div class='notfound-404'>
          <h1>404</h1>
        </div>
        <h2>
          Lo sentimos, ¡página no encontrada!
        </h2>
        <p>
          El reporte que está buscando pudo haber sido eliminado o su facultad no tiene acceso al reporte generado.
        </p>
      </div>
    </div>
    ";

    return $html_error;
  }



  function getMessageAccessError()
  {
    $html_error = "
    <style>
      #notfound
      {
        position: relative;
        height: 100vh;
      }

      #notfound .notfound
      {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
      }

      .notfound
      {
        max-width: 920px;
        width: 100%;
        line-height: 1.4;
        text-align: center;
        padding-left: 15px;
        padding-right: 15px;
      }

      .notfound .notfound-404
      {
        position: absolute;
        height: 100px;
        top: 0;
        left: 50%;
        -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
                transform: translateX(-50%);
        z-index: -1;
      }

      .notfound .notfound-404 h1
      {
        font-family: 'Maven Pro', sans-serif;
        color: #ececec;
        font-weight: 900;
        font-size: 276px;
        margin: 0px;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
      }

      .notfound h2
      {
        font-family: 'Maven Pro', sans-serif;
        font-size: 46px;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0px;
      }

      .notfound p
      {
        font-family: 'Maven Pro', sans-serif;
        font-size: 16px;
        color: #000;
        font-weight: 400;
        text-transform: uppercase;
        margin-top: 15px;
      }
    </style>
    <div id='notfound'>
      <div class='notfound'>
        <div class='notfound-404'>
          <h1>404</h1>
        </div>
        <h2>
          Lo sentimos, ¡página no encontrada!
        </h2>
        <p>
          No tiene acceso a este módulo del sistema, si es usuario del <b>SIGR</b> debe iniciar sesión para ver el contenido del reporte.
        </p>
      </div>
    </div>
    ";

    return $html_error;
  }

  function getMessageAccessReportC6()
  {
    $html_error = "
    <style>
      #notfound
      {
        position: relative;
        height: 100vh;
      }

      #notfound .notfound
      {
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
      }

      .notfound
      {
        max-width: 920px;
        width: 100%;
        line-height: 1.4;
        text-align: center;
        padding-left: 15px;
        padding-right: 15px;
      }

      .notfound .notfound-404
      {
        position: absolute;
        height: 100px;
        top: 0;
        left: 50%;
        -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
                transform: translateX(-50%);
        z-index: -1;
      }

      .notfound .notfound-404 h1
      {
        font-family: 'Maven Pro', sans-serif;
        color: #ececec;
        font-weight: 900;
        font-size: 276px;
        margin: 0px;
        position: absolute;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
      }

      .notfound h2
      {
        font-family: 'Maven Pro', sans-serif;
        font-size: 46px;
        color: #000;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0px;
      }

      .notfound p
      {
        font-family: 'Maven Pro', sans-serif;
        font-size: 16px;
        color: #000;
        font-weight: 400;
        text-transform: uppercase;
        margin-top: 15px;
      }
    </style>
    <div id='notfound'>
      <div class='notfound'>
        <div class='notfound-404'>
          <h1>404</h1>
        </div>
        <h2>
          Lo sentimos, ¡página no encontrada!
        </h2>
        <p>
          El tipo de reporte <strong>Homologación Auxiliar</strong> ha sido desactivado del sistema por requerimientos del administrador del sistema.
        </p>
      </div>
    </div>
    ";

    return $html_error;
  }


 ?>
