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

  /*
  *****************************************************************************
  *****************************************************************************
  **********************       GET CONSECUTIVE DATA      **********************
  *****************************************************************************
  *****************************************************************************
  */

  function getConsecutiveData($consecutive_id)
  {
    //TokyoTyrantQuery
  	$query = "SELECT ctvo.id_tipo_consecutivo_reporte,
	                   ctvo.id_facultad_consecutivo_reporte
                FROM consecutivo_reporte ctvo
                WHERE ctvo.id_consecutivo_reporte = ?";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
  	if($stmt = $mysqli->prepare($query))
    {
  		$stmt->bind_param("i", $consecutive_id);
  		$stmt->execute();
      $stmt->bind_result($consecutive_type, $consecutive_faculty);
  		$stmt->store_result();
  		$stmt->fetch();

  		if($stmt->num_rows == 1)
      {
  			$stmt->close();
        //Session array
        $consecutive_data = array(
          'consecutive_type'    => $consecutive_type,
          'consecutive_faculty' => $consecutive_faculty
        );

        return $consecutive_data;
  		}
  		$stmt->close();
  	}

  	return false;
  }


  function getConsecutiveState($consecutive_faculty, $consecutive_type)
  {
    //TokyoTyrantQuery
    $query = "SELECT ctvo.id_tipo_consecutivo_reporte
                FROM consecutivo_reporte ctvo
               WHERE ctvo.id_facultad_consecutivo_reporte = ?
               AND ctvo.id_tipo_consecutivo_reporte       = ?
               AND ctvo.id_estado_consecutivo_reporte     = '1'";
    //Global connection variable
    global $mysqli;

    //Prepare query (true)
    if($stmt = $mysqli->prepare($query))
    {
      $stmt->bind_param("ii", $consecutive_faculty, $consecutive_type);
      $stmt->execute();
      $stmt->bind_result($consecutive_result);
      $stmt->store_result();
      $stmt->fetch();

      if($stmt->num_rows == 1)
      {
        $stmt->close();

        return $consecutive_result;
      }
      $stmt->close();
    }

    return false;
  }
?>
