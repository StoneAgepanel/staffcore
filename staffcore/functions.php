<?php

  function getFormatedBanTime($end)
  {
    if($end != -1){
      $millis = $end;

      $sekunden = 0;
      $minuten = 0;
      $stunden = 0;
      $tage = 0;

      while($millis >= 1000) {
        $millis -= 1000;
        $sekunden += 1;
      }
      while($sekunden >= 60) {
        $sekunden -= 60;
        $minuten += 1;
      }
      while($minuten >= 60) {
        $minuten -= 60;
        $stunden += 1;
      }
      while($stunden >= 24) {
        $stunden -= 24;
        $tage += 1;
      }

      if($tage != 0) {
        if($stunden != 0) {
          if($minuten != 0) {
            if($sekunden != 0) {
              return $tage." Day(s) ".$stunden." Hour(s) ".$minuten." Minute(s)";
            } else {
              return $tage." Day(s) ".$stunden." Hour(s) ".$minuten." Minute(s)";
            }
          } else {
            return $tage." Day(s) ".$stunden." Hour(s) ";
          }
        } else {
          if($minuten != 0){
            return $tage." Day(s) ".$stunden." Hour(s) ".$minuten." Minute(s)";
          } else {
            return $tage." Day(s)";
          }
        }
      } else {
        if($stunden != 0) {
					if($minuten != 0) {
						if($sekunden != 0) {
              return $stunden." Hour(s) ".$minuten." Minute(s) ".$sekunden." Second(s)";
            } else {
              return $stunden." Hour(s) ".$minuten." Minute(s)";
            }
          } else {
            return $stunden." Hour(s)";
          }
        } else {
          if($minuten != 0) {
						if($sekunden != 0) {
              return $minuten." Minute(s) ".$sekunden." Second(s)";
            } else {
              return $minuten." Minute(s)";
            }
          } else {
            return "ERROR";
          }
        }
      }
    } else {
      return "Permanently";
    }
  }

  function existsBanReason($name)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_reasonsdb WHERE TYPE = 'BAN' AND NAME = '".$name."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function existsMuteReason($name)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_reasonsdb WHERE TYPE = 'MUTE' AND NAME = '".$name."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function existsReportReason($name)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_reasonsdb WHERE TYPE = 'REPORT' AND NAME = '".$name."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function getFormatedReportTime($case)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_reportsdb WHERE id = '".$case."'";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_assoc($result)){
      return $row['reg_date'];
    }
  }

  function getFormatedTicketTime($id)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_ticketdb WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_assoc($result)){
      return $row['reg_date'];
    }
  }

  function countTicketMessages($ticketid)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_ticketdb_messages WHERE TICKET_ID = '".$ticketid."'";
    $result = mysqli_query($conn,$sql);

    return mysqli_num_rows($result);
  }

  function countMessages($uuid)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_messages WHERE SENDER_UUID = '".$uuid."'";
    $result = mysqli_query($conn,$sql);

    return mysqli_num_rows($result);
  }

  function getTotalCases()
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_reportsdb WHERE STATUS = '0'";
    $result = mysqli_query($conn,$sql);

    return mysqli_num_rows($result);
  }

  function existsSetting($type)
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_settings WHERE TYPE = '".$type."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function getSetting($type)
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_settings WHERE TYPE = '".$type."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['VALUE'];
      }
    }
  }

  function hasUUID($id)
  {
    require("mysql.php");

    $sql = "SELECT UUID FROM staffcoreui_accounts WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        if($row['UUID'] != null){
          return true;
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }

  function getSeniorTaskID()
  {
    $taskid = "s-Task-";
    $suffix = getSeniorTaskIDSuffix();
    return $taskid.$suffix;
  }

  function getSeniorTaskIDSuffix()
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_tasks WHERE TASK_ID LIKE '%s-Task-%'";
    $result = mysqli_query($conn,$sql);

    $rows = mysqli_num_rows($result);

    if($rows < 10){
      return "0".$rows;
    } else {
      return "".$rows;
    }
  }

  function getAdminTaskID()
  {
    $taskid = "A-Task-";
    $suffix = getAdminTaskIDSuffix();
    return $taskid.$suffix;
  }

  function getAdminTaskIDSuffix()
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_tasks WHERE TASK_ID LIKE '%A-Task-%'";
    $result = mysqli_query($conn,$sql);

    $rows = mysqli_num_rows($result);

    if($rows < 10){
      return "0".$rows;
    } else {
      return "".$rows;
    }
  }

  function existsAnyAccount()
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_accounts";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function existsEmail($email)
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_accounts WHERE EMAIL = '".$email."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }
  function existsAppeal($banid,$uuid,$type)
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_appeals WHERE BAN_ID = '".$banid."' AND UUID = '".$uuid."' AND TYPE = '".$type."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function getEmail($id)
  {
    require("mysql.php");

    $sql = "SELECT EMAIL FROM staffcoreui_accounts WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['EMAIL'];
      }
    } else {
      return "UNKNOWN";
    }
  }

  function getPasswordhash($email)
  {
    require("mysql.php");

    $sql = "SELECT PASSWORD FROM staffcoreui_accounts WHERE EMAIL = '".$email."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['PASSWORD'];
      }
    } else {
      return "UNKNOWN";
    }
  }

  function getUserID($email)
  {
    require("mysql.php");

    $sql = "SELECT id FROM staffcoreui_accounts WHERE EMAIL = '".$email."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['id'];
      }
    } else {
      return -1;
    }
  }

  function existsPlayerData($username)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_playerdb WHERE PLAYERNAME = '".$username."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function getStandardRankValue()
  {
    require("mysql.php");

    $sql = "SELECT RANK_NAME FROM staffcoreui_ranks WHERE IS_STANDARD = '1'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['RANK_NAME'];
      }
    } else {
      return "MEMBER";
    }
  }

  function getRankNameById($id)
  {
    require("mysql.php");

    $sql = "SELECT RANK_NAME FROM staffcoreui_ranks WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['RANK_NAME'];
      }
    } else {
      return getStandardRankValue();
    }
  }

  function getRankNameByValue($value)
  {
    require("mysql.php");

    $sql = "SELECT RANK_NAME FROM staffcoreui_ranks WHERE RANK_VALUE = '".$value."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['RANK_NAME'];
      }
    } else {
      return getStandardRankValue();
    }
  }

  function getPlayerRank($id)
  {
    if(!isAdminAccount($id)){
      require("mysql.php");

      $sql = "SELECT USER_RANK FROM staffcoreui_accounts WHERE id = '".$id."'";
      $result = mysqli_query($conn,$sql);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          return $row['USER_RANK'];
        }
      } else {
        return getStandardRankValue();
      }
    } else {
      return getRankNameById(2);
    }
  }

  function getUserIDByUUID($uuid)
  {
    require("mysql.php");

    $sql = "SELECT id FROM staffcoreui_accounts WHERE UUID = '".$uuid."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['id'];
      }
    } else {
      return 0;
    }
  }

  function getPlayerUUID($id)
  {
    require("mysql.php");

    $sql = "SELECT UUID FROM staffcoreui_accounts WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['UUID'];
      }
    } else {
      return "UNKNOWN";
    }
  }

  function getPlayername($uuid)
  {
    if($uuid != CHATCONTROLLER){
      require("mysql.php");

      $sql = "SELECT PLAYERNAME FROM ReportSystem_playerdb WHERE UUID = '".$uuid."'";
      $result = mysqli_query($conn,$sql);

      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          return $row['PLAYERNAME'];
        }
      } else {
        return "UNKNOWN";
      }
    } else {
      return $uuid;
    }
  }

  function getUsernameByID($id)
  {
    require("mysql.php");

    $sql = "SELECT PLAYER_NAME FROM staffcoreui_accounts WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['PLAYER_NAME'];
      }
    } else {
      return "UNKNOWN";
    }
  }

  function getUsername($uuid)
  {
    require("mysql.php");

    $sql = "SELECT PLAYER_NAME FROM staffcoreui_accounts WHERE UUID = '".$uuid."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['PLAYER_NAME'];
      }
    } else {
      return "UNKNOWN";
    }
  }

  function getAppealIdByUUID($uuid)
  {
    require("mysql.php");

    $sql = "SELECT * FROM staffcoreui_appeals WHERE UUID = '".$uuid."' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['id'];
      }
    } else {
      return "UNKNOWN";
    }
  }

  function getUUID($username)
  {
    require("mysql.php");

    $sql = "SELECT UUID FROM ReportSystem_playerdb WHERE PLAYERNAME = '".$username."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['UUID'];
      }
    } else {
      return "UNKNOWN";
    }
  }
  function getRankValue($rankname)
  {
    require("mysql.php");

    $sql = "SELECT RANK_VALUE FROM staffcoreui_ranks WHERE RANK_NAME = '".$rankname."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['RANK_VALUE'];
      }
    } else {
      return 1;
    }
  }

  function countBans($uuid)
  {
    require("mysql.php");

    $sql = "SELECT * FROM ReportSystem_banhistory WHERE TEAM_UUID = '".$uuid."'";
    $result = mysqli_query($conn,$sql);

    return mysqli_num_rows($result);
  }

  function getPermissionValue($permission)
  {
    require("mysql.php");

    $sql = "SELECT MIN_RANK_VALUE FROM staffcoreui_ranks_permissions WHERE PERMISSION = '".$permission."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        return $row['MIN_RANK_VALUE'];
      }
    } else {
      return getRankValue(getRankNameById(2));
    }
  }

  function resetRankForGroup($rankname)
  {
    require("mysql.php");

    $standard = getStandardRankValue();

    $sql = "UPDATE staffcoreui_accounts SET USER_RANK = '".$standard."' WHERE USER_RANK = '".$rankname."'";
    if(mysqli_query($conn,$sql)){
      return true;
    } else {
      return false;
    }
  }

  function isAllowed($permission,$rankvalue)
  {
    if(getPermissionValue($permission) <= $rankvalue){
      return true;
    } else {
      return false;
    }
  }

  function isAdminAccount($id)
  {
    require("mysql.php");

    $sql = "SELECT ADMIN_ACCOUNT FROM staffcoreui_accounts WHERE id = '".$id."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        if($row['ADMIN_ACCOUNT'] == 1){
          return true;
        } else {
          return false;
        }
      }
    } else {
      return false;
    }
  }

  function isBanned($uuid)
  {
    require("mysql.php");

    $sql = "SELECT BANNED_UUID FROM ReportSystem_bansdb WHERE BANNED_UUID = '".$uuid."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

  function isMuted($uuid)
  {
    require("mysql.php");

    $sql = "SELECT MUTED_UUID FROM ReportSystem_mutesdb WHERE MUTED_UUID = '".$uuid."'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
      return true;
    } else {
      return false;
    }
  }

?>
