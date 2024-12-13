<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
    <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Posts</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/post_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Post</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row justify-content-center mb-3">
                <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                    <form action="<?= base_url("Main/posts") ?>" method="GET">
                    <div class="input-group">
                        <input type="search" id="search" name="search" placeholder="Search blog here." value="<?= $request->getVar('search') ?>" class="form-control">
                        <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                    </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="25%">
                    <col width="15%">
                    <col width="25%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Created/Updated</th>
                    <th class="p-1 text-center">Title</th>
                    <th class="p-1 text-center">Author</th>
                    <th class="p-1 text-center">Description</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($posts as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row['updated_at'])) ?></td>
                            <td class="px-2 py-1 align-middle"><?= ($row['title']) ?><a href="<?= base_url("Blog/view/".$row['id']) ?>" target="_blank" class="mx-1 text-muted text-decoration-none"><i class="fa fa-external-link"></i></a></td>
                            <td class="px-2 py-1 align-middle"><?= ($row['author']) ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <?php 
                                switch($row['status']){
                                    case 1:
                                        echo '<small class="badge rounded-pill bg-primary bg-gradient px-4">Publish</small>';
                                        break;
                                    case 0:
                                        echo '<small class="badge rounded-pill bg-light border text-dark bg-gradient px-4">Unpublish</small>';
                                        break;
                                    default:
                                        echo '<small class="badge rounded-pill bg-secondary bg-gradient px-4">N/A</small>';
                                        break;
                                }
                                ?>
                            </td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/post_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('Main/post_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete  <?= $row['title'] ?> from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($posts) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="6">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>