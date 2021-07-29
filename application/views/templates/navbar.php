<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url(); ?>home" class="nav-link">Home</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
    
      <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fas fa-user-tie nav-icon"></i>
              User
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              <i class="fas fa-user-tie nav-icon"></i>
             User Name
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>home" class="brand-link">
      <img src="<?php echo base_url()."assets/"; ?>emb.png" alt="Logo" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">OOS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Reports</li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-desktop"></i>
              <p>
                OPMS
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pto" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>PTO</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>dp" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>DP</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>sqi" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>SQI</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>coc" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>COC</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pcl" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>PCL</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>pmpin" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>PMPIN</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>ccor" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>CCOR</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>ccoi" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>CCOI</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>odsir" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>ODS-IR</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>odsic" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>ODS-IC</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>odsr" class="nav-link">
                  <i class="fas fa-list-ul nav-icon"></i>
                  <p>ODS-R</p>
                </a>
              </li>
              
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-list-alt"></i>
              <p>
                Monitoring
                <i class="fas fa-angle-right right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>casehandler_summary" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Casehandler Summary</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>