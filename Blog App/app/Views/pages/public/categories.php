<?= $this->extend('layouts/blog_base') ?>
<?= $this->section('content') ?>
<div class="card rounded-0 shadow mb-3">
    <div class="card-body">
        <div class="container-fluid">
            <h4 class="fw-bolder">Category List</h4>
        </div>
    </div>
</div>
<div class="list-group" id="post-list">
    <?php 
        foreach($categories as $row):
    ?>
    <a href="<?= base_url("Blog/category/".$row['id']) ?>" class="list-group-item list-group-item-action text-decoration-none text-reset post-item">
        <div class="container-fluid">
            <div class="h4 fw-bolder"><?= $row['name'] ?></div>
            <hr>
            <p class="text-truncate"><?= $row['description'] ?></p>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php if(isset($categories) && count($categories) <= 0): ?>
    <center><small class="text-muted"><i>No post has been published yet.</i></small></center>
<?php endif; ?>
<div class="bg-light pt-4 px-3 my-3">
    <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
</div>
<?= $this->endSection() ?>