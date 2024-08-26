<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Company Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Company Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Company Profile Information</h3>
              </div>

              <div class="card-body">
                <form action="<?php echo base_url('Home/save_company_profile'); ?>" method="post" enctype='multipart/form-data' >
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Company Name *</label>
                      <input type="text" class="form-control" name="com_name" placeholder="Company Name" value="<?php if($company){ ?><?php echo $company->compName; ?><?php } ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Company Address *</label>
                      <input type="text" class="form-control" name="com_address" placeholder="Company Address" value="<?php if($company){ ?><?php echo $company->compAddress; ?><?php } ?>" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Mobile Number *</label>
                      <input type="text" class="form-control" name="com_mobile" placeholder="Mobile Number" value="<?php if($company){ ?><?php echo $company->compMobile; ?><?php } ?>" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Email</label>
                      <input type="email" class="form-control" name="com_email" placeholder="exemple@sunshine.com" value="<?php if($company){ ?><?php echo $company->compEmail; ?><?php } ?>" >
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Company Logo</label>
                      <input type="file" name="userfile" >
                    </div>
                  </div>
                  <div class="form-group col-md-12 col-sm-12 col-12" style="margin-top: 20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
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