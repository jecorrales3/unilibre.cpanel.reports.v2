<?php
  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document allows the connection with MySQL         **
  ** @author       Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @created      The PHP document was create on 29/11/2019                 **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @modified   - The PHP document was created on 29/11/2019                **
  ** @who        - Johan Corrales | johan-corralesa@unilibre.edu.co          **
  ** @why        - Creation                                                  **
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  */

  /* define('DB_USER', "tasrvyzx_unilibre"); // db user
  define('DB_PASSWORD', "Unilibre2020*"); // db password (mention your db password here)
  define('DB_DATABASE', "tasrvyzx_unilibre_db"); // database name
  define('DB_SERVER', "localhost"); // db server
 */

  define('DB_USER', "root"); // db user
  define('DB_PASSWORD', ""); // db password (mention your db password here)
  define('DB_DATABASE', "unilibre_db"); // database name
  define('DB_SERVER', "localhost"); // db server

  $mysqli = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);

  // Check connection
  if(mysqli_connect_errno())
  {
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 ?>
