<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Voucher</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Voucher</li>
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
                <h3 class="card-title">Voucher Information</h3>
              </div>

              <div class="card-body">
                <form method="POST" action="<?php echo site_url("Voucher/save_voucher") ?>">
                  <div class="col-md-12 col-sm-12 col-12">
                    <div class="row">
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Voucher Date *</label>
                        <input type="text" name="date" class="form-control datepicker" value="<?php echo date('m/d/Y') ?>" required >
                      </div>
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <label>Voucher Type *</label>
                        <select class="form-control" name="vaucher" id="vType" required >
                          <option value="">Select One</option>
                          <option value="Credit Voucher">Credit Voucher</option>
                          <option value="Debit Voucher">Debit Voucher</option>
                        </select>
                      </div>
                      
                      <div class="form-group col-md-4 col-sm-4 col-12">
                        <div class="d-none" id="customer">
                          <div class="col-md-12 col-sm-12 col-12">
                            <label>Select Customer *</label>
                            <select class="form-control" name="customer" id="custid" required="" >
                              <option value="">Select One</option>
                              <?php foreach($customer as $value){ ?>
                              <option value="<?php echo $value['custid']; ?>"><?php echo $value['custName'].' ( '.$value['custCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="d-none" id="supplier">
                          <div class="col-md-12 col-sm-12 col-12">
                            <label>Select Supplier *</label>
                            <select class="form-control" name="supplier" id="supid" required="" >
                              <option value="">Select One</option>
                              <?php foreach($supplier as $value){ ?>
                              <option value="<?php echo $value['supid']; ?>"><?php echo $value['supName'].' ( '.$value['supCode'].' )'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-12">
                        <div class="row" style="background-color:#298894; color: black;" align="center">
                          <div class="form-group col-md-6 col-sm-6 col-6">
                            <label>Particulars</label>
                            <input type="text" class="form-control" name="particular[]" placeholder="Particulars" required >
                          </div>
                          <div class="form-group col-md-4 col-sm-4 col-4">
                            <label>Amount</label>
                            <input type="text" class="form-control" name="amount[]" placeholder="Amount" required >
                          </div>
                          <div class="form-group col-md-2 col-sm-2 col-2">
                            <label>Add</label>
                            <button type="button" class="form-control btn btn-danger" id="addmore">Add More</button>
                          </div>
                        </div>

                        <div class="row">   
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <ol id="list" style="list-style-type: none;"></ol>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-12">
                        <div class="row">
                          <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Account Type *</label>
                            <select class="form-control" name="accountType" id="accountType" required >
                              <option value="">Select One</option>
                              <option value="Cash">Cash</option>
                              <option value="Bank">Bank</option>
                              <option value="Mobile">Mobile</option>
                            </select>
                          </div>
                          <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Account No *</label>
                            <select class="form-control" name="accountNo" id="accountNo" required >
                              <option value="">Select One</option>
                            </select>
                          </div>
                          <div class="form-group col-md-4 col-sm-4 col-12">
                            <label>Notes</label>
                            <input type="text" class="form-control" name="notes" placeholder="If have any notes" >
                          </div>
                        </div>
                      </div>

                      <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                        <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Submit</button>
                        <a href="<?php echo site_url('Voucher') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
                      </div>
                    </div>
                  </div>
                </form>

                <div class="d-none col-md-12 col-sm-12 col-xs-12">
                  <div id="product">
                    <ol class="ct">
                      <div class="row" style="background-color:#c5c745; border-radius: 4px; border:1px solid #fff; color: black; margin-left: -90px;" >
                        <div class="form-group col-md-6 col-sm-6 col-6">
                          <label>Particulars</label>
                          <input type="text" class="form-control" name="particular[]" placeholder="Particulars" >
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-4">
                          <label>Amount</label>
                          <input type="text" class="form-control" name="amount[]" placeholder="Amount" >
                        </div>
                        <div class="form-group col-md-2 col-sm-2 col-2">
                          <input type="button" class="btn btn-danger" value="Remove" onClick="$(this).parent().parent().remove();" style="margin-top: 30px;" >
                        </div>
                      </div>
                    </ol>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>
    
    <script type="text/javascript">
      $(document).ready(function(){
        $("#addmore").click(function(){
          $("#list").append($("#product").html());
          $("ol ol.ct input").removeAttr("id");
          });

        $("#remove_more").click(function(){
          $('ol.ct').has('input:checkbox:checked').remove();
          });
        });
    </script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#vType').change(function(){
          var vType = $("#vType").val();
            //alert(vType);
          if(vType == 'Credit Voucher')
            {
            $('#customer').removeAttr('class','d-none');
            $('#supplier').attr('class','d-none');

            $('#custid').attr('required','required');
            $('#supid').removeAttr('required','required');
            }
          else if(vType == 'Debit Voucher')
            {
            $('#customer').attr('class','d-none');
            $('#supplier').removeAttr('class','d-none');

            $('#custid').removeAttr('required','required');
            $('#supid').attr('required','required');
            }
          else
            {
            $('#customer').attr('class','d-none');
            $('#supplier').attr('class','d-none');

            $('#custid').removeAttr('required','required');
            $('#supid').removeAttr('required','required');
            }
          });
        });
    </script>

    <script type="text/javascript">
      $('#accountType').on('change',function(){
        var value = $(this).val();
        $('#accountNo').empty();
        getAccountNo(value, '#accountNo');
        });
        
        function getAccountNo(value,place){
          $(place).empty();
          if(value != ''){
            $.ajax({
              url: '<?php echo site_url()?>Voucher/getAccountNo',
              async: false,
              dataType: "json",
              data: 'id=' + value,
              type: "POST",
              success: function (data){
                $(place).append(data);
                $(place).trigger("chosen:updated");
                }
              });
            }
          else
            {
            customAlert('Please Select Account Type', "error", true);
            }
          }
    </script>