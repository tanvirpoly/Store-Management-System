<?php $this->load->view('header/header'); ?>


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Register</h1>
                </div>
            </div>
        </div>
    </section>

    <form action="<?php echo base_url('Login/save_employeeOne'); ?>" method="post" enctype="multipart/form-data">
        <div class="col-md-12 col-sm-12 col-12">
            <div class="row">
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Employee Name *</label>
                    <input type="text" class="form-control" name="empName" placeholder="Employee Name" required>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Employee Department *</label>
                    <input type="text" class="form-control" name="empDpt" placeholder="Employee Department" required>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Contact Number *</label>
                    <input type="text" class="form-control" name="empMobile" placeholder="Mobile Number" onkeypress="return isNumberKey(event)" maxlength="11" minlength="11" required>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Address *</label>
                    <input type="text" class="form-control" name="empAddress" placeholder="Address" required>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Email ID</label>
                    <input type="email" class="form-control" name="empEmail" placeholder="example@gmail.com">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Employee Salary</label>
                    <input type="text" class="form-control" name="empSalary" placeholder="Salary">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Joining Date</label>
                    <input type="text" class="form-control datepicker" name="joinDate" placeholder="Date of Joining">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Image</label>
                    <input type="file" name="userfile">
                </div>
                <div class="form-group col-md-6 col-sm-6 col-12">
                    <label>Signature</label>
                    <input type="file" name="userfileOne">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="window.location.href = 'Login'">
                <i class="far fa-window-close"></i>&nbsp;&nbsp;Cancel
            </button>

        </div>
    </form>

<div class="footer-container">
    <?php $this->load->view('footer/footer'); ?>
</div>
<style>
.footer-container {
    display: none;
}
</style>

