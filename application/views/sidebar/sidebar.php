    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview menu-open">
          <a href="<?php echo base_url(); ?>Dashboard" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i><p> Dashboard</p>
          </a>
        </li>
        <?php if($_SESSION['products'] == 1){ ?>
		<li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fab fa-product-hunt"></i>
            <p> Products <i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <?php if($_SESSION['product_list'] == 1){ ?>
            <li class="nav-item">
               <a href="<?php echo base_url(); ?>Product" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Products</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>storeProduct" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Opening Stock</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>productAdjust" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Physical Count</p>
              </a>
            </li>
            <?php } if($_SESSION['stock_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>stockReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock Report</p>
              </a>
            </li>
            <?php } ?>
			<li class="nav-item">
              <a href="<?php echo base_url(); ?>usedPReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Used Product Report</p>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item">
              <a href="<?php echo base_url(); ?>Customer" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Customers</p>
              </a>
            </li>
        <?php } if($_SESSION['orders'] == 1){ ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i><p> Work Order
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if($_SESSION['order_list'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>workOrder" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Work Orders List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Purchase" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Purchase</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>sale" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Sale</p>
              </a>
            </li>
            <?php } if($_SESSION['new_order'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>newWOrder" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>New Work Order</p>
              </a>
            </li>
            <?php } if($_SESSION['order_receive'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>orderReceive" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Order Receive</p>
              </a>
            </li>
            <?php } if($_SESSION['order_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>orderReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Order Reports</p>
              </a>
            </li>
            
            <?php } if($_SESSION['receive_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>receiveReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Receive Reports</p>
              </a>
            </li>
            <?php } ?>
            
          </ul>
        </li>
        <?php } if($_SESSION['requisitions'] == 1){ ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-retweet"></i><p> Requisitions
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if($_SESSION['requisition_list'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>requisition" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Requisitions List</p>
              </a>
            </li>
            <?php } if($_SESSION['delivery_list'] == 1){ ?>
            <li class="nav-item">
             <a href="<?php echo base_url(); ?>delivery" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Delivery Requisitions</p>
              </a>
            </li>
            <?php } if($_SESSION['refund_list'] == 1){ ?>
            <li class="nav-item">
             <a href="<?php echo base_url(); ?>refund" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Refund Requisitions</p>
              </a>
            </li>
            <?php } if($_SESSION['requisition_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>reqReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Requisitions Reports</p>
              </a>
            </li>
            <?php } if($_SESSION['delivery_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>devReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Delivery Reports</p>
              </a>
            </li>
            <?php } ?>
          </ul>
        </li>
        <?php } if($_SESSION['users'] == 1){ ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>uSetting" class="nav-link">
           <i class="nav-icon fas fa-users"></i><p> Users</p>
          </a>
        </li>
        <?php } if($_SESSION['setting'] == 1){ ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Setting" class="nav-link">
            <i class="nav-icon fas fa-cog"></i><p> Settings</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-file"></i><p> Reports
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if($_SESSION['order_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>orderReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Order Report</p>
              </a>
            </li>
            <?php } if($_SESSION['receive_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>receiveReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Order Receive Report</p>
              </a>
            </li>
            <?php } if($_SESSION['requisition_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>reqReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Requisitions Reports</p>
              </a>
            </li>
            <?php } if($_SESSION['delivery_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>devReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Delivery Reports</p>
              </a>
            </li>
            <?php } if($_SESSION['stock_report'] == 1){ ?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>stockReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock Report</p>
              </a>
            </li>
			<li class="nav-item">
              <a href="<?php echo base_url(); ?>usedPReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Used Product Report</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>supReport" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Supplier ledgers</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>custLedger" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Customer Ledger</p>
              </a>
            </li>
        <?php } ?>
          </ul>
        </li>
        <?php } if($_SESSION['access_setup'] == 1){ ?>
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>userAccess" class="nav-link">
            <i class="nav-icon fas fa-cog"></i><p> Access Setup</p>
          </a>
        </li>
        <?php } ?>
		<li class="nav-item">
          <a href="<?php echo base_url(); ?>Login/logout" class="nav-link">
            <i class="nav-icon far fa-arrow-alt-circle-left"></i><p> Logout</p>
          </a>
        </li>
      </ul>
    </nav>