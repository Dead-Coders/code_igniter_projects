<?= $this->extend('layouts/blog_base') ?>
<?= $this->section('custom_css') ?>
<style>
    .post-img-holder{
        width:100%;
        max-height:10em;
    }
    .post-img{
        width:100%;
        height:100%;
        object-fit:cover;
        object-position:center center;
        transition:all .2s ease-in-out;
    }
    .post-item:hover .post-img{
        transform:scale(1.2);
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card rounded-0 shadow mb-3">
    <div class="card-body">
        <div class="container-fluid">
            <h4 class="fw-bolder">Welcome to <?= env('system_name') ?></h4>
        </div>
    </div>
</div>
<div class="list-group" id="post-list">
    <?php 
        foreach($posts as $row):
    ?>
    <a href="<?= base_url("Blog/view/".$row['id']) ?>" class="list-group-item list-group-item-action text-decoration-none text-reset post-item">
        <div class="d-flex w-100">
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="w-100 overflow-hidden" class="post-img-holder">
                    <img src="<?= $row['banner'] ?>" alt="<?= $row['title'] ?>" class="img-thumbnail p-0 border rounded-0 bg-dark post-img">
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="container-fluid">
                    <div class="h4 fw-bolder"><?= $row['title'] ?></div>
                    <hr>
                    <p class="truncate-5"><?= $row['short_description'] ?></p>
                </div>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php if(isset($posts) && count($posts) <= 0): ?>
    <center><small class="text-muted"><i>No post has been published yet.</i></small></center>
<?php endif; ?>
<div class="bg-light pt-4 px-3 my-3">
    <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
</div>
<?= $this->endSection() ?>