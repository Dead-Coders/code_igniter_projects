<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">New Transaction</h1>
</div>
    
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="<?php echo base_url().'admin/transaksi_add_act' ?>" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Customer</label>
                <div class="col-sm-10">
                    <select name="kostumer" class="form-control">
                        <option value="" disabled selected>Choose Customer</option>
                        <?php foreach($kostumer as $k){ ?>
                        <option value="<?php echo $k->kostumer_id ?>"><?php echo $k->kostumer_nama ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php echo form_error('kostumer'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Car</label>
                <div class="col-sm-10">
                    <select name="mobil" class="form-control">
                        <option value="" disabled selected>Choose a Car</option>
                        <?php foreach($mobil as $m){ ?>
                        <option value="<?php echo $m->mobil_id ?>"><?php echo $m->mobil_merk ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php echo form_error('mobil'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Borrow Date</label>
                <div class="col-sm-10"><input type="date" class="form-control" name="tgl_pinjam"></div>
                <?php echo form_error('tgl_pinjam'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Return Date</label>
                <div class="col-sm-10"><input type="date" class="form-control" name="tgl_kembali"></div>
                <?php echo form_error('tgl_kembali'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total Price</label>
                <div class="col-sm-10"><input type="number" class="form-control" name="harga" placeholder="3000"></div>
                <?php echo form_error('harga'); ?>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Fine Per-Day</label>
                <div class="col-sm-10"><input type="number" class="form-control" name="denda" placeholder="500"></div>
                <?php echo form_error('denda'); ?>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>