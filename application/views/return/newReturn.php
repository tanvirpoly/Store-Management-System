<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Refund</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Refund</li>
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
                <h3 class="card-title">Refund Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url() ?>Returns/returns_by_sales_invoice">
                  <div class="row">
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Select Employee *</label>
                      <select class="form-control select2" name="employee" id="employee" required >
                        <option value="all">All</option>
                        <?php foreach($users as $value){ ?>
                        <option value="<?php echo $value['uid']; ?>"><?php echo $value['uName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-4 col-12">
                      <label>Requisition Number *</label>
                      <select class="form-control select2" name="returnid" id="returnid" required >
                        <option value="">Select Employee First</option>
                      </select>
                    </div>
                    <div class="form-group col-md-2 col-sm-2 col-12" style="text-align: left; margin-top: 30px;">
                      <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>&nbsp;&nbsp;Search</button>
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
    <script type="text/javascript">
      $(document).ready(function() {
        $('#employee').change(function() {
          var url = "<?php echo base_url(); ?>Returns/get_delivery_req_by_emp";
          var id = $('#employee').val() ;
             //alert(url); alert(id);
          $.ajax({
            method: "POST",
            url     : url,
            dataType: 'json',
            data    : {"id" : id},
            success:function(data){ 
                // alert(data);
              if(data == ''){
                  alert('Requisition has NO refundable products')
                  
              }else{
                  $('#returnid').removeAttr("disabled")
                  var HTML = "<option value=''>Select One</option>";
                  for (var key in data) 
                    {if (data.hasOwnProperty(key)) {
                      HTML +="<option value='"+data[key]["rInvoice"]+"'>" + data[key]["rInvoice"]+' ( '+ data[key]["reference"]+' )'+"</option>";
                    }}
                  $("#returnid").html(HTML);
              }
              },
            error:function(data){
              alert('error');
              }
            });
          });
        });
    </script>
