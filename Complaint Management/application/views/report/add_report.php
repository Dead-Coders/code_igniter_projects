<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-3">
        <div class="card-header">
            Report Form
        </div>

        <div class="card-body">
        	<form action="<?php echo site_url('report/addreport') ?>" method="post" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="title">Reporter Name*</label>
                    <input class="form-control" type="text" name="name" value="<?= $user['name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nik">Reporting ID*</label>
                    <input class="form-control"
                    type="text" name="nik" placeholder="Enter NIK" value="<?= set_value('nik'); ?>">
                    <?= form_error('nik', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rt">RT*</label>
                            <input class="form-control"
                            type="number" name="rt" placeholder="Enter RT" value="<?= set_value('rt'); ?>">
                            <?= form_error('rt', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rw">RW*</label>
                            <input class="form-control"
                            type="number" name="rw" placeholder="Enter RW" value="<?= set_value('rw'); ?>">
                            <?= form_error('rw', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="village">Village*</label>
                            <input class="form-control"
                            type="text" name="village" placeholder="Village" value="<?= set_value('village'); ?>">
                            <?= form_error('village', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">Report Title*</label>
                    <input class="form-control"
                    type="text" name="title" placeholder="Report Title" value="<?= set_value('title'); ?>">
                    <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="description">Report Description*</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Report Description" rows="3"></textarea>
                    <?= form_error('description', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="type">Type of Report</label>
                    <select class="form-control" id="type" name="type">
                        <option value="Corona Virus">Corona Virus</option>
                        <option value="Health">Health</option>
                        <option value="Food Aid">Food Aid</option>
                        <option value="Economy">Economy</option>
                        <option value="Education">Education</option>
                        <option value="Agriculture">Agriculture</option>
                        <option value="Drugs">Drugs</option>
                        <option value="Criminal Acts">Criminal Acts</option>
                        <option value="Sexual Harassment">Sexual Harassment</option>
                        <option value="Natural Disasters">Natural Disasters</option>
                    </select>
                </div>
                <div class="form-group">
                <label for="file">Attachment</label>
                    <input class="form-control-file"
                    type="file" name="file" />
                    <div class="invalid-feedback">
                        <?php echo form_error('file') ?>
                    </div>
                </div>
                <!-- button save -->
                <input class="btn btn-success" type="submit" name="btn" value="Report!" />
            </form>
        </div>

        <div class="card-footer small text-muted">
            * must be filled
        </div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->