<?= $this->extend('layouts/blog_base') ?>
<?= $this->section('custom_css') ?>
<meta name="description" content="<?= $post['short_description'] ?>">
<meta name="keywords" content="<?= $post['tags'] ?>">
<meta name="author" content="<?= $post['author_full'] ?>">
<meta property="og:title" content="<?= $post['title'] ?>" />
<meta property="og:description" content="<?= $post['short_description'] ?>" />
<meta property="og:image" content="<?= $post['banner'] ?>" />
<meta property="og:url" content="<?= base_url("Blog/view/".$post['id']) ?>" />
<style>
   #post-img{
        width:100%;
        height:30em;
        object-fit:fill;
        object-position:center center;
    }
    
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card rounded-0 shadow">
    <div class="card-header">
        <div class="text-end">
            <a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="btn btn-sm rounded-0 btn-light border"><i class="fa fa-angle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <center>
                <img src="<?= $post['banner'] ?>" alt="" class="img-thumbnail p-0" id="post-img">
            </center>
            <h3 class="fw-bolder mt-3"><?= $post['title'] ?></h3>
            <hr>
            <div class="d-flex w-100 justify-content-between">
                <div class="text-muted">
                    <small><i class="fa fa-th-list"></i> <?= $post['category'] ?></small>
                </div>
                <div class="text-muted">
                    <small class="me-3"><i class="fa fa-user"></i> <?= $post['author'] ?></small>
                    <small class=""><i class="far    fa-clock"></i> <?= date("M d, Y h:i A", strtotime($post['updated_at'])) ?></small>
                </div>
            </div>
            <div class="py-3">
                <?= htmlspecialchars_decode($post['content']) ?>
            </div>
            <div>
                <?php 
                $tags = explode(",", $post['tags']);
                foreach($tags as $tag){
                    echo '<small class="badge bg-gradient bg-secondary px-3 me-2 rounded-pill">'.$tag.'</small>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>