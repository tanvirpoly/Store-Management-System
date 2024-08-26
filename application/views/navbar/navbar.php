<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #343A40;">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #fff;"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <div class="nav-link" id="google_translate_element"></div>
        </li>
        <?php
        $purchase = $this->db->select('status')
                ->from('purchase')
                ->where('status','On Process')
                ->get();

        $count = $purchase->num_rows();
        ?>
        <li class="nav-item">
          <div class="nav-link" >
            <a href="<?php echo base_url(); ?>workOrder"  class="n-icon">
              <i class="fa fa-bell" title="Stock Alert" style="color: #fff;"></i>
              <span class="badge badge-warning navbar-badge"><?php echo $count; ?></span>
            </a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" style="color: #fff;" ><?= $_SESSION['name'] ?>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="<?php echo base_url(); ?>comProfile" class="dropdown-item">
              Company Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?php echo base_url(); ?>aSetting" class="dropdown-item">
              Change Password
            </a>
            <a href="<?php echo base_url(); ?>Login/logout" class="dropdown-item">
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>

      <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="<?php echo base_url(); ?>Dashboard" class="brand-link">
        <?php $company = $this->pm->company_details(); ?>
        <img src="<?php echo base_url().'upload/company/'.$company->compLogo; ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $_SESSION['company'] ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <?php $this->load->view('sidebar/sidebar'); ?>
	  
      </div>
    </aside>