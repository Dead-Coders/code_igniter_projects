<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Customer</h1>
</div>
    
<div class="card shadow mb-4">
    <div class="card-body">
        <?php foreach($kostumer as $k){ ?>
        <form action="<?php echo base_url().'admin/kostumer_update' ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $k->kostumer_id; ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="nama" value="<?php echo $k->kostumer_nama; ?>"></div>
                <?php echo form_error('nama'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="alamat" rows="3"><?php echo $k->kostumer_alamat; ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Gender</label>
                <div class="col-sm-10 pt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jk" value="Male"<?php echo ($k->kostumer_jk=='Male') ? ' checked':''; ?>>
                        <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jk" value="Female"<?php echo ($k->kostumer_jk=='Male') ? '':' checked'; ?>>
                        <label class="form-check-label">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="jk" value="Others"<?php echo ($k->kostumer_jk=='Male') ? '':' checked'; ?>>
                        <label class="form-check-label">Others</label>
                    </div>
                </div>
                <?php echo form_error('status'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Phone Number</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="hp" value="<?php echo $k->kostumer_hp; ?>"></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">ID card number</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="ktp" value="<?php echo $k->kostumer_ktp; ?>"></div>
                <?php echo form_error('ktp'); ?>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-secondary">Save Changes</button>
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
</div>