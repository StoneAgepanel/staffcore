<?php

  session_start();

  require_once("../../staffcore/configs/config.php");
  require_once("../../staffcore/mysql.php");

  if(!isset($_SESSION['user_id'])){
    ?>
    <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>">
    <?php
    exit();
  }

  require_once("../../staffcore/functions.php");

  $sql = "SELECT * FROM ReportSystem_reportsdb WHERE STATUS = '0' ORDER BY id LIMIT 1";
  $result = mysqli_query($conn,$sql);

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      header("Location: ../reports/?case=".$row['id']);
    }
  } else {
    header("Location: ../reports/?info=There%20are%20no%20cases%20at%20the%20moment%21%20Please%20try%20again%20later%21");
  }

?>
