<?php $this->load->view('header/header'); ?>
<?php $this->load->view('navbar/navbar'); ?>

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products Opening Stock</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Products Opening Stock</li>
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
              <div class="card-header" >
                <h3 class="card-title">Products Opening Stock List</h3>
                <a href="<?php echo site_url('newSProduct'); ?>" class="btn btn-primary" style="float: right;" ><i class="fa fa-plus"></i>&nbsp;Set Opening Stock</a>
              </div>

              <div class="card-body">
                <table id="example" class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                      <th style="width: 5%;">#SN.</th>
                      <th>Code</th>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Notes</th>
                      <th style="width: 10%;">Action</th> 
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($store as $value){
                    $i++;
                    
                    $pp = $this->db->select('
                                      store_pdetails.*,
                                      products.pCode,
                                      products.pName')
                                ->from('store_pdetails')
                                ->join('products','products.pid = store_pdetails.pid','left')
                                ->where('spid',$value['spid'])
                                ->get()
                                ->result();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td>
                        <?php foreach($pp as $p){ ?>
                        <?php echo $p->pCode; ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach($pp as $p){ ?>
                        <?php echo $p->pName; ?><br>
                        <?php } ?>
                      </td>
                      <td>
                        <?php foreach($pp as $p){ ?>
                        <?php echo $p->quantity; ?><br>
                        <?php } ?>
                      </td>
                      <td><?php echo $value['notes']; ?></td>
                      <td>
                        <a class="btn btn-success btn-xs" href="<?php echo site_url().'editSProduct/'.$value['spid']; ?>" ><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger btn-xs" href="<?php echo site_url('Product/delete_store_products').'/'.$value['spid']; ?>" onclick="return confirm('Are you sure you want to delete this Store Product ?');"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>   
                    <?php } ?> 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

<?php $this->load->view('footer/footer'); ?>