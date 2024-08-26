<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Delivery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Delivery</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    <?php
    $exception = $this->session->userdata('exception');
    if(isset($exception))
    {
    echo $exception;
    $this->session->unset_userdata('exception');
    } ?>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery Information</h3>
              </div>
                        <!--<?php var_dump($memo);?>-->

              <div class="card-body">
                <form method="POST" action="<?php echo base_url('searchDelivery'); ?>">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Requisition Number *</label>
                      <select class="form-control" name="mNumber" required >
                        <option value="">Select One</option>
                        <?php foreach($memo as $value){ ?>
                        <option value="<?php echo $value->invoice; ?>"><?php echo $value->invoice.' ('.$value->reference.')'; ?></option>
                        <?php } ?>
                      </select>
                      <!--<input type="text" class="form-control" name="mNumber" placeholder="Requisition Number" list="pdlist" autofocus required >-->
                      <!--<datalist id="pdlist" >-->
                      <!--  <?php foreach($memo as $value){ ?>-->
                      <!--  <option value="<?php echo $value->invoice; ?>"><?php echo $value->invoice; ?></option>-->
                      <!--  <?php } ?>-->
                      <!--</datalist>-->
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12" style="text-align: left;">
                      <button type="submit" name="search" class="btn btn-info" style="margin-top: 30px;"><i class="fa fa-search-plus" ></i>&nbsp;Search</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>