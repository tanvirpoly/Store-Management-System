<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Requisition</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Requisition</li>
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
                <h3 class="card-title">Approve Requisition Information</h3>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-sm-6 col-12">
                    <b>Reference : <?php echo $prints['reference']; ?></b>
                  </div>
                  <div class="col-md-6 col-sm-6 col-12">
                    <b>Employee : <?php echo $prints['uName']; ?></b>
                  </div>
                </div><br>

                <form method="POST" action="<?php echo base_url() ?>Sale/save_approve_sales" >
                  <input type="hidden" name="said" value="<?php echo $said; ?>" required >

                  <div class="col-sm-12 col-md-12 col-12"  >
                    <table id="mtable" class="table table-bordered table-striped">
                      <thead class="btn-default">
                        <tr>
                          <th>Products</th>
                          <th>Stock</th>
                          <th>Req. Quantity</th>
                          <th>Quantity</th> 
                          <th>Unit</th> 
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php
                        $sl = 0;
                        foreach($salesp as $value){
                        $id = $value['pid'];
                        
                        $mp = $this->db->select('tquantity')
                                  ->from('stock')
                                  ->where('pid',$value['pid'])
                                  ->get()
                                  ->row();
                        if($mp)
                          {
                          $tdqnt = $mp->tquantity;
                          }
                        else
                          {
                          $tdqnt = 0;
                          }
                        ?>
                        <tr>
                          <td>
                            <?php echo $value['pName'].' ( '.$value['pCode'].' )'; ?>
                            <input type='hidden' name='product[]' value="<?php echo $value['pid']; ?>" required >
                          </td>
                          <td><?php echo $tdqnt; ?></td>
                          <td><?php echo $value['quantity']; ?></td>   
                          <td>
                            <input type='text' onkeyup='totalPrice(<?php echo $id ?>)' name='quantity[]' id='quantity_<?php echo $id ?>' value="<?php echo $value['quantity']; ?>" required >
                          </td>
                          <td><?php echo $value['unitName']; ?></td>   
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <div class="form-group col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; text-align: center;">
                    <button type="submit" class="btn btn-info"><i class="far fa-save"></i>&nbsp;&nbsp;Update</button>
                    <a href="<?php echo site_url('requisition') ?>" class="btn btn-danger" ><i class="fa fa-arrow-left" ></i>&nbsp;&nbsp;Back</a>
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
