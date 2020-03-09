<?php

  /*
  *****************************************************************************
  *****************************     UNILIBRE      *****************************
  *****************************************************************************
  ** @description  The PHP document consult methods report                   **
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

  function getProgramData($program_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT prgm.nombre_programa_facultad,
                     prgm.titulo_programa_facultad
              FROM programa_facultad prgm
              INNER JOIN facultad fctd
              ON fctd.id_facultad = prgm.id_facultad_programa_facultad
              WHERE prgm.id_funcionalidad_programa_facultad = '1'
              AND prgm.id_programa_facultad = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("i", $program_id);
  		$stmt->execute();
      $stmt->bind_result($program_name, $program_title);
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
        //Session array
        $program_data = array(
          'program_name'  => $program_name,
          'program_title' => $program_title
        );

        return $program_data;
  		}
  		$stmt->close();
  	}

  	return false;
  }


  /*
  *****************************************************************************
  *****************************************************************************
  **********************       GET CONSECUTIVE DATA      **********************
  *****************************************************************************
  *****************************************************************************
  */


  function getConsecutiveDataC1($user_faculty_id)
  {
    //TokyoTyrantQuery
    $query = "SELECT ctvo.id_consecutivo_reporte,
                     ctvo.consecutivo_actual_reporte
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '1'
              AND ctvo.id_facultad_consecutivo_reporte = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
    if($stmt = $mysqli->prepare($query))
    {
      $stmt->bind_param("i", $user_faculty_id);
      $stmt->execute();
      $stmt->bind_result($consecutive_id, $current_consecutive);
      $stmt->store_result();
      $stmt->fetch();

      if($stmt->num_rows == 1)
      {
        $stmt->close();
        //Session array
        $consecutive_data = array(
          'consecutive_id'      => $consecutive_id,
          'current_consecutive' => $current_consecutive
        );
        return $consecutive_data;
      }
      $stmt->close();
    }

    return false;
  }

  function getConsecutiveDataC2($user_faculty_id)
  {
    //TokyoTyrantQuery
    $query = "SELECT ctvo.id_consecutivo_reporte,
                     ctvo.consecutivo_actual_reporte
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '2'
              AND ctvo.id_facultad_consecutivo_reporte = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
    if($stmt = $mysqli->prepare($query))
    {
      $stmt->bind_param("i", $user_faculty_id);
      $stmt->execute();
      $stmt->bind_result($consecutive_id, $current_consecutive);
      $stmt->store_result();
      $stmt->fetch();

      if($stmt->num_rows == 1)
      {
        $stmt->close();
        //Session array
        $consecutive_data = array(
          'consecutive_id'      => $consecutive_id,
          'current_consecutive' => $current_consecutive
        );
        return $consecutive_data;
      }
      $stmt->close();
    }

    return false;
  }

  function getConsecutiveDataC3($user_faculty_id)
  {
    //TokyoTyrantQuery
    $query = "SELECT ctvo.id_consecutivo_reporte,
                     ctvo.consecutivo_actual_reporte
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '3'
              AND ctvo.id_facultad_consecutivo_reporte = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
    if($stmt = $mysqli->prepare($query))
    {
      $stmt->bind_param("i", $user_faculty_id);
      $stmt->execute();
      $stmt->bind_result($consecutive_id, $current_consecutive);
      $stmt->store_result();
      $stmt->fetch();

      if($stmt->num_rows == 1)
      {
        $stmt->close();
        //Session array
        $consecutive_data = array(
          'consecutive_id'      => $consecutive_id,
          'current_consecutive' => $current_consecutive
        );
        return $consecutive_data;
      }
      $stmt->close();
    }

    return false;
  }

  function getConsecutiveDataC4($user_faculty_id)
  {
    //TokyoTyrantQuery
    $query = "SELECT ctvo.id_consecutivo_reporte,
                     ctvo.consecutivo_actual_reporte
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '4'
              AND ctvo.id_facultad_consecutivo_reporte = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
    if($stmt = $mysqli->prepare($query))
    {
      $stmt->bind_param("i", $user_faculty_id);
      $stmt->execute();
      $stmt->bind_result($consecutive_id, $current_consecutive);
      $stmt->store_result();
      $stmt->fetch();

      if($stmt->num_rows == 1)
      {
        $stmt->close();
        //Session array
        $consecutive_data = array(
          'consecutive_id'      => $consecutive_id,
          'current_consecutive' => $current_consecutive
        );
        return $consecutive_data;
      }
      $stmt->close();
    }

    return false;
  }

  /*
  *****************************************************************************
  *****************************************************************************
  *********************   VALIDATION CONSECUTIVE REPORT   *********************
  *****************************************************************************
  *****************************************************************************
  */
  function validateConsecutiveC1($user_faculty_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT YEAR(CURDATE()) AS year
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '1'
              AND ctvo.id_facultad_consecutivo_reporte = ?
              AND ctvo.consecutivo_actual_reporte
              BETWEEN ctvo.consecutivo_desde_reporte
              AND ctvo.consecutivo_hasta_reporte
              AND ctvo.consecutivo_actual_reporte < ctvo.consecutivo_hasta_reporte";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("i", $user_faculty_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateConsecutiveC2($user_faculty_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT YEAR(CURDATE()) AS year
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '2'
              AND ctvo.id_facultad_consecutivo_reporte = ?
              AND ctvo.consecutivo_actual_reporte
              BETWEEN ctvo.consecutivo_desde_reporte
              AND ctvo.consecutivo_hasta_reporte
              AND ctvo.consecutivo_actual_reporte < ctvo.consecutivo_hasta_reporte";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("i", $user_faculty_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateConsecutiveC3($user_faculty_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT YEAR(CURDATE()) AS year
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '3'
              AND ctvo.id_facultad_consecutivo_reporte = ?
              AND ctvo.consecutivo_actual_reporte
              BETWEEN ctvo.consecutivo_desde_reporte
              AND ctvo.consecutivo_hasta_reporte
              AND ctvo.consecutivo_actual_reporte < ctvo.consecutivo_hasta_reporte";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("i", $user_faculty_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateConsecutiveC4($user_faculty_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT YEAR(CURDATE()) AS year
                FROM consecutivo_reporte ctvo
              WHERE ctvo.year_consecutivo_reporte = (SELECT YEAR(CURDATE()))
              AND ctvo.id_estado_consecutivo_reporte   = '1'
              AND ctvo.id_tipo_consecutivo_reporte     = '4'
              AND ctvo.id_facultad_consecutivo_reporte = ?
              AND ctvo.consecutivo_actual_reporte
              BETWEEN ctvo.consecutivo_desde_reporte
              AND ctvo.consecutivo_hasta_reporte
              AND ctvo.consecutivo_actual_reporte < ctvo.consecutivo_hasta_reporte";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("i", $user_faculty_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }



  /*
  *****************************************************************************
  *****************************************************************************
  ***********************       VALIDATION REPORT       ***********************
  *****************************************************************************
  *****************************************************************************
  */

  function validateReportC1($user_faculty_id, $configuration_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT conf.id_configuracion_reporte,
	                   conf.id_facultad_final_configuracion_reporte
              FROM configuracion_reporte conf
              INNER JOIN consecutivo_reporte ctvo
              ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
              WHERE conf.id_facultad_final_configuracion_reporte = ?
              AND ctvo.id_tipo_consecutivo_reporte               = '1'
              AND conf.id_configuracion_reporte                  = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("ii", $user_faculty_id, $configuration_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateReportC2($user_faculty_id, $configuration_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT conf.id_configuracion_reporte,
	                   conf.id_facultad_final_configuracion_reporte
              FROM configuracion_reporte conf
              INNER JOIN consecutivo_reporte ctvo
              ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
              WHERE conf.id_facultad_final_configuracion_reporte = ?
              AND ctvo.id_tipo_consecutivo_reporte               = '2'
              AND conf.id_configuracion_reporte                  = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("ii", $user_faculty_id, $configuration_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateReportC3($user_faculty_id, $configuration_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT conf.id_configuracion_reporte,
	                   conf.id_facultad_final_configuracion_reporte
              FROM configuracion_reporte conf
              INNER JOIN consecutivo_reporte ctvo
              ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
              WHERE conf.id_facultad_final_configuracion_reporte = ?
              AND ctvo.id_tipo_consecutivo_reporte               = '3'
              AND conf.id_configuracion_reporte                  = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("ii", $user_faculty_id, $configuration_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateReportC4($user_faculty_id, $configuration_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT conf.id_configuracion_reporte,
	                   conf.id_facultad_final_configuracion_reporte
              FROM configuracion_reporte conf
              INNER JOIN consecutivo_reporte ctvo
              ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
              WHERE conf.id_facultad_final_configuracion_reporte = ?
              AND ctvo.id_tipo_consecutivo_reporte               = '4'
              AND conf.id_configuracion_reporte                  = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("ii", $user_faculty_id, $configuration_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateReportC5($user_faculty_id, $configuration_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT conf.id_configuracion_reporte,
	                   conf.id_facultad_final_configuracion_reporte
              FROM configuracion_reporte conf
              WHERE conf.id_facultad_final_configuracion_reporte = ?
              AND conf.id_configuracion_reporte                  = ?
              AND conf.id_tipo_reporte_configuracion_reporte
              BETWEEN 5 AND 8";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("ii", $user_faculty_id, $configuration_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }

  function validateReportC6($user_faculty_id, $configuration_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT conf.id_configuracion_reporte,
	                   conf.id_facultad_final_configuracion_reporte
              FROM configuracion_reporte conf
              INNER JOIN consecutivo_reporte ctvo
              ON ctvo.id_consecutivo_reporte = conf.id_consecutivo_configuracion_reporte
              WHERE conf.id_facultad_final_configuracion_reporte = ?
              AND ctvo.id_tipo_consecutivo_reporte               = '6'
              AND conf.id_configuracion_reporte                  = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("ii", $user_faculty_id, $configuration_id);
  		$stmt->execute();
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
  			return true;
  		}
  		$stmt->close();
  	}

  	return false;
  }
?>
