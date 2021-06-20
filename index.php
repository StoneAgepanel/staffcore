<?php
  session_start();

  require_once("staffcore/configs/config.php");
  require_once("staffcore/functions.php");
  require("staffcore/mysql.php");

  if(!isset($_SESSION['user_id'])){
    ?>
    <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>dashboard/login">
    <?php
    exit();
  }
  if(!hasUUID($_SESSION['user_id'])){
    ?>
    <meta http-equiv="refresh" content="0,URL=<?php echo BASE_URL; ?>/staffcore/waiting-for-server-response">
    <?php
    exit();
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="author" content="Laco Development">
    <meta name="application-name" content="StaffCore - Dashboard">
    <meta name="keywords" content="StaffCore,Dashboard,Management,StaffCore Dashboard">
    <meta name="description" content="StaffCore's WebInterface comes with many features to always have an overview!">

    <meta property="og:site_name" content="StaffCore - Dashboard">
    <meta property="og:image" content="<?php echo BASE_URL; ?>staffcore/img/logo.png">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo BASE_URL; ?>">
    <meta property="og:title" content="StaffCore - Dashboard">
    <meta property="og:description" content="StaffCore's WebInterface comes with many features to always have an overview!">

    <!-- Preloader -->
    <style>
    .pace {
      z-index: 2000;
      pointer-events: none;
      user-select: none;
      position: fixed;
      margin: auto;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 400px;
      border: 0px;
      height: 1px;
      overflow: hidden;
      background:#1b1b1b;
      }

      .pace .pace-progress {
        z-index: 2000;
        box-sizing: border-box;
        transform: translate3d(0, 0, 0);
        max-width: 400px;
        position: fixed;
        z-index: 2000;
        display: block;
        position: absolute;
        top: 0;
        right: 100%;
        height: 100%;
        width: 100%;
        background: grey;
      }

      .pace.pace-inactive {
        display: none;
      }

      #preloader{
        z-index: 1039;
        width: 100vw;
        height: 100vh;
        background: #212529;
        overflow:hidden;
        position:fixed;
        transition-timing-function: cubic-bezier(0.19, 1, 0.22, 1);
      }
      .p {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="pace.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-bez@1.0.11/src/jquery.bez.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>

    <link rel="icon" href="<?php echo BASE_URL; ?>staffcore/img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>staffcore/img/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>staffcore/img/logo_symbol.png">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <title>StaffCore - Dashboard</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>adminlte/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>adminlte/plugins/toastr/toastr.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body class="hold-transition sidebar-mini pace-danger">
    <div id="preloader">
      <div class="p">Loading StaffCore-UI...</div>
    </div>
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

          <?php
            $sql = "SELECT * FROM staffcoreui_notifications WHERE USER_ID = '".$_SESSION['user_id']."' AND SEEN = '0'";
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result) > 0){
              ?>
              <!-- Notifications Dropdown Menu -->
              <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-danger navbar-badge"><?php echo mysqli_num_rows($result); ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-header"><?php echo mysqli_num_rows($result); ?> Notification(s)</span>
                  <div class="dropdown-divider"></div>
                  <?php
                    while($row = mysqli_fetch_assoc($result)){
                      ?>
                      <a href="<?php echo $row['NOTIFY_LINK']; ?>" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> <?php echo $row['NOTIFY_TEXT']; ?>
                      </a>
                      <?php
                      $sql = "UPDATE staffcoreui_notifications SET SEEN = '1' WHERE id = '".$row['id']."'";
                      mysqli_query($conn,$sql);
                    }
                  ?>
                  <div class="dropdown-divider"></div>
                  <a href="dashboard/notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
              </li>
              <?php
            } else {
              ?>
              <!-- Notifications Dropdown Menu -->
              <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <span class="dropdown-header">No New Notifications</span>
                  <div class="dropdown-divider"></div>
                  <a href="dashboard/notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
              </li>
              <?php
            }
          ?>
          <?php
            $uuid = getPlayerUUID($_SESSION['user_id']);

            $sql = "SELECT * FROM staffcoreui_accounts WHERE id = '".$_SESSION['user_id']."'";
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_assoc($result)){
                ?>
                <li class="nav-item dropdown user-menu">
                  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="https://visage.surgeplay.com/head/160/<?php echo $uuid; ?>" class="user-image img-circle" alt="User Image">
                    <span class="d-none d-md-inline"><?php echo $row['PLAYER_NAME']; ?></span>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                    <!-- User image -->
                    <li class="user-header bg-danger">
                      <img src="https://visage.surgeplay.com/head/160/<?php echo $uuid; ?>" class="user-image img-circle elevation-2" alt="User Image">

                      <p>
                        <?php echo $row['PLAYER_NAME']; ?> - <?php echo $row['USER_RANK']; ?>
                        <small>Registered since <?php echo $row['REGISTERED_SINCE']; ?></small>
                      </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                      <div class="row">
                        <div class="col-12 text-center">
                          <a href="https://www.lacodev.de"><b>StaffCore-UI</b> by LacoDev</a>
                        </div>
                      </div>
                      <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                      <a href="dashboard/profile" class="btn btn-default btn-flat">
                        <i class="fas fa-user"></i>
                        Profile
                      </a>
                      <a href="dashboard/logout" class="btn btn-default btn-flat float-right text-danger">
                        <ion-icon name="log-out-outline"></ion-icon>
                        Log out
                      </a>
                    </li>
                  </ul>
                </li>
                <?php
              }
            }
          ?>
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-danger elevation-4">
        <!-- Brand Logo -->
        <a href="<?php echo BASE_URL; ?>" class="brand-link navbar-danger">
          <img src="<?php echo BASE_URL; ?>staffcore/img/logo_symbol.png" alt="StaffCore Logo" class="brand-image img-circle"
               style="opacity: .8">
          <span class="brand-text font-weight-light">StaffCore v3.5.0</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <?php
                if(!isAllowed("SIDEBAR_STAFF",getRankValue(getPlayerRank($_SESSION['user_id'])))){
                  ?>
                  <li class="nav-header">
                    User-Section
                  </li>
                  <li class="nav-item">
                    <a href="dashboard/tickets/" class="nav-link">
                      <i class="nav-icon fas fa-history"></i>
                      <p>Your Tickets</p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon far fa-envelope"></i>
                      <p>
                        Your Appeals
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/appeals/current" class="nav-link">
                          <i class="fas fa-inbox"></i>
                          <p>Current Appeals</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/appeals/create" class="nav-link">
                          <i class="fas fa-plus-circle"></i>
                          <p>Create new Appeal</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="dashboard/banhistory/" class="nav-link">
                      <i class="nav-icon fas fa-history"></i>
                      <p>Your Ban-History</p>
                    </a>
                  </li>
                  <?php
                }
                if(isAllowed("SIDEBAR_STAFF",getRankValue(getPlayerRank($_SESSION['user_id'])))){
                  ?>
                  <li class="nav-header">
                    Staff-Section
                  </li>
                  <li class="nav-item">
                    <a href="dashboard/activities/" class="nav-link">
                      <i class="nav-icon fas fa-chart-line"></i>
                      <p>Activities</p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-ban"></i>
                      <p>
                        Bans
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/bans/active" class="nav-link">
                          <i class="fab fa-ethereum"></i>
                          <p>Active Bans</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/bans/create" class="nav-link">
                          <i class="fas fa-user-times"></i>
                          <p>Ban Player</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-microphone-slash"></i>
                      <p>
                        Mutes
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/mutes/active" class="nav-link">
                          <i class="fab fa-ethereum"></i>
                          <p>Active Mutes</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/mutes/create" class="nav-link">
                          <i class="fas fa-comment-slash"></i>
                          <p>Mute Player</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="dashboard/reports/" class="nav-link">
                      <i class="nav-icon fas fa-exclamation-circle"></i>
                      <p>Reports <span class="badge badge-success">New</span></p>
                    </a>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-envelope"></i>
                      <p>
                        Appeals
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/appeals/assigned" class="nav-link">
                          <i class="fas fa-reply"></i>
                          <p>Assigned to you</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/appeals/all" class="nav-link">
                          <i class="fas fa-archive"></i>
                          <p>All Appeals</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-comment-dots"></i>
                      <p>
                        Chatlogs
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-success">New</span>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/chatlogs" class="nav-link">
                          <i class="fas fa-reply"></i>
                          <p>Messages of Players</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/livechat" class="nav-link">
                          <i class="fab fa-rocketchat"></i>
                          <p>Livechat</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-ticket-alt"></i>
                      <p>
                        Ticket-System
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-success">New</span>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/tickets/all" class="nav-link">
                          <i class="fas fa-archive"></i>
                          <p>All Tickets</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/tickets/current" class="nav-link">
                          <i class="fas fa-reply"></i>
                          <p>Your Tickets</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <?php
                }
                if(isAllowed("SIDEBAR_SENIORSTAFF",getRankValue(getPlayerRank($_SESSION['user_id'])))){
                  ?>
                  <li class="nav-header">
                    SrStaff-Section
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-user-shield"></i>
                      <p>
                        Management
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/srstaff/tasks" class="nav-link">
                          <i class="fas fa-tasks"></i>
                          <p>Tasks</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/srstaff/team" class="nav-link">
                          <i class="fas fa-users"></i>
                          <p>Staff-Team</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <?php
                }
                if(isAdminAccount($_SESSION['user_id'])){
                  ?>
                  <li class="nav-header">
                    Admin-Section
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-user-shield"></i>
                      <p>
                        Management
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/admin/manage/tasks" class="nav-link">
                          <i class="fas fa-tasks"></i>
                          <p>Tasks</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/admin/manage/stats" class="nav-link">
                          <i class="fas fa-street-view"></i>
                          <p>Staff Statistics</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/admin/manage/ranks" class="nav-link">
                          <i class="fas fa-layer-group"></i>
                          <p>Ranks</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/admin/manage/accounts" class="nav-link">
                          <i class="fas fa-user-circle"></i>
                          <p>Accounts</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon far fa-keyboard"></i>
                      <p>
                        Reason-Manager
                        <i class="fas fa-angle-left right"></i>
                        <span class="badge badge-success">New</span>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/admin/manager/ban" class="nav-link">
                          <i class="fas fa-ban"></i>
                          <p>BanManager</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/admin/manager/mute" class="nav-link">
                          <i class="fas fa-microphone-slash"></i>
                          <p>MuteManager</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/admin/manager/report" class="nav-link">
                          <i class="fas fa-exclamation-circle"></i>
                          <p>ReportManager</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-wrench"></i>
                      <p>
                        Configurations
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="dashboard/admin/settings/general" class="nav-link">
                          <i class="fas fa-cogs"></i>
                          <p>General Settings</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="dashboard/admin/settings/email" class="nav-link">
                          <i class="fas fa-envelope"></i>
                          <p>Email Settings</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <?php
                }
              ?>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">StaffCore-UI</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Home</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">
            <div class="card card-widget widget-user">
              <?php
                $uuid = getPlayerUUID($_SESSION['user_id']);

                $sql = "SELECT * FROM ReportSystem_playerdb WHERE UUID = '".$uuid."'";
                $result = mysqli_query($conn,$sql);

                if(mysqli_num_rows($result) > 0){
                  while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="widget-user-header bg-danger">
                      <h3 class="widget-user-username">
                        <?php
                          if(isAdminAccount($_SESSION['user_id'])){
                            echo $row['PLAYERNAME']." <span class='text-info text-bold' title='Admin-Account'>*</span>";
                          } else {
                            echo $row['PLAYERNAME'];
                          }
                        ?>
                      </h3>
                      <h5 class="widget-user-desc"><?php echo getPlayerRank($_SESSION['user_id']); ?></h5>
                    </div>
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="https://visage.surgeplay.com/bust/<?php echo $uuid; ?>" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?php echo $row['BANS']; ?></h5>
                            <span class="description-text">BANS</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?php echo $row['MUTES']; ?></h5>
                            <span class="description-text">MUTES</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header"><?php echo $row['REPORTS']; ?></h5>
                            <span class="description-text">REPORTS</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3">
                          <div class="description-block">
                            <h5 class="description-header"><?php echo $row['WARNS']; ?></h5>
                            <span class="description-text">WARNS</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <?php
                  }
                }
              ?>
            </div>

            <?php
              if(isAllowed("RECEIVE_TASKS",getRankValue(getPlayerRank($_SESSION['user_id'])))){
                ?>
                <div class="content-header">
                  <div class="row mb-2">
                    <div class="col-sm-6">
                      <h1 class="m-0 text-dark">Your Tasks</h1>
                    </div>
                  </div>
                </div>

                <div class="d-flex flex-wrap w-100">
                  <div class="card card-outline card-danger w-100">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#-ID</th>
                            <th scope="col">Assigned by</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql = "SELECT * FROM staffcoreui_tasks WHERE RECIPIENT = '".$_SESSION['user_id']."' AND STATUS = '0' OR STATUS = '1' ORDER BY STATUS DESC";
                            $result = mysqli_query($conn,$sql);

                            if(mysqli_num_rows($result) > 0){
                              while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                  <th scope="row"><?php echo $row['TASK_ID']; ?></th>
                                  <td><?php echo $row['ASSIGNED_BY']; ?></td>
                                  <td>
                                    <?php
                                      if($row['STATUS'] == 0){
                                        ?>
                                        <span class="font-weight-bold">
                                          <i class="fas fa-caret-right text-info"></i>
                                          <span class="text-muted">Assigned</span>
                                        </span>
                                        <?php
                                      }
                                      if($row['STATUS'] == 1){
                                        ?>
                                        <span class="font-weight-bold">
                                          <i class="fas fa-caret-up text-warning"></i>
                                          <span class="text-muted">In Progress</span>
                                        </span>
                                        <?php
                                      }
                                      if($row['STATUS'] == 2){
                                        ?>
                                        <span class="font-weight-bold">
                                          <i class="fas fa-caret-up text-success"></i>
                                          <span class="text-muted">Finished</span>
                                        </span>
                                        <?php
                                      }
                                      if($row['STATUS'] == -1){
                                        ?>
                                        <span class="font-weight-bold">
                                          <i class="fas fa-caret-down text-danger"></i>
                                          <span class="text-muted">Canceled</span>
                                        </span>
                                        <?php
                                      }
                                    ?>
                                  </td>
                                  <td>
                                    <a href="dashboard/task/?id=<?php echo $row['TASK_ID']; ?>" class="btn btn-block btn-danger btn-sm">View</a>
                                  </td>
                                </tr>
                                <?php
                              }
                            } else {
                              ?>
                              <tr>
                                <th scope="row" colspan="4">
                                  <div class="alert alert-success" role="alert">
                                    All set! You dont have any tasks for now!
                                  </div>
                                </th>
                              </tr>
                              <?php
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php
              }
            ?>

            <div class="content-header">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Your Reports</h1>
                </div>
              </div>
            </div>

            <div class="d-flex flex-wrap w-100">
              <div class="card card-outline card-danger w-100">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#-ID</th>
                        <th scope="col">Reported</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT * FROM ReportSystem_reportsdb WHERE REPORTER_UUID = '".$uuid."' ORDER BY id DESC LIMIT 3";
                        $result = mysqli_query($conn,$sql);

                        if(mysqli_num_rows($result) > 0){
                          while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                              <th scope="row"><?php echo $row['id']; ?></th>
                              <td><?php echo getPlayername($row['REPORTED_UUID']); ?></td>
                              <td><?php echo $row['REASON']; ?></td>
                              <td>
                                <?php
                                  if($row['STATUS'] == 0){
                                    ?>
                                    <span class="font-weight-bold">
                                      <i class="fas fa-caret-right text-warning"></i>
                                      <span class="text-muted">Pending</span>
                                    </span>
                                    <?php
                                  }
                                  if($row['STATUS'] == 1){
                                    ?>
                                    <span class="font-weight-bold">
                                      <i class="fas fa-caret-up text-success"></i>
                                      <span class="text-muted">Claimed</span>
                                    </span>
                                    <?php
                                  }
                                  if($row['STATUS'] == -1){
                                    ?>
                                    <span class="font-weight-bold">
                                      <i class="fas fa-caret-down text-danger"></i>
                                      <span class="text-muted">Denied</span>
                                    </span>
                                    <?php
                                  }
                                  if($row['STATUS'] == 2){
                                    ?>
                                    <span class="font-weight-bold">
                                      <i class="fas fa-caret-up text-success"></i>
                                      <span class="text-muted">Finished</span>
                                    </span>
                                    <?php
                                  }
                                ?>
                              </td>
                            </tr>
                            <?php
                          }
                        } else {
                          ?>
                          <tr>
                            <th scope="row" colspan="4">
                              <div class="alert alert-danger" role="alert">
                                You never reported anyone
                              </div>
                            </th>
                          </tr>
                          <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->

      <!-- Main Footer -->
      <footer class="main-footer position-fixed fixed-bottom">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
          Designed with <strong><a class="text-danger" href="https://adminlte.io">AdminLTE.io</a> Copyright &copy; 2014-2019</strong>
        </div>
        <!-- Default to the left -->
        <strong>StaffCore-UI developed by <a class="text-danger" href="https://www.lacodev.de">LacoDev</a> &copy; 2021</strong>
      </footer>
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?php echo BASE_URL; ?>adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BASE_URL; ?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BASE_URL; ?>adminlte/dist/js/adminlte.min.js"></script>
    <script src="<?php echo BASE_URL; ?>adminlte/dist/js/demo.js"></script>
    <!-- Toastr -->
    <script src="<?php echo BASE_URL; ?>adminlte/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
    </script>

    <script>

        paceOptions = {
          ajax: true,
          document: true,
          eventLag: false
        };

        Pace.on('done', function() {
        $('.p').delay(125).animate({top: '30%', opacity: '0'}, 2000);


        $('#preloader').delay(250).fadeOut(1000);

        <?php
          if(isset($_GET['success'])){
            ?>
            toastr["success"]("Success", "<?php echo htmlspecialchars($_GET['success']); ?>")
            <?php
          }
          if(isset($_GET['error'])){
            ?>
            toastr["error"]("Error", "<?php echo htmlspecialchars($_GET['error']); ?>")
            <?php
          }
          if(isset($_GET['warning'])){
            ?>
            toastr["warning"]("Warning", "<?php echo htmlspecialchars($_GET['warning']); ?>")
            <?php
          }
          if(isset($_GET['info'])){
            ?>
            toastr["info"]("Info", "<?php echo htmlspecialchars($_GET['info']); ?>")
            <?php
          }
        ?>

        TweenMax.from(".title", 2, {
             delay: 1.8,
                  y: 10,
                  opacity: 0,
                  ease: Expo.easeInOut
            })
       });

      </script>
  </body>
</html>
