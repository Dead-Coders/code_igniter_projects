<?= $this->extend('layouts/main') ?>

<?= $this->section('custom_css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js" integrity="sha512-6F1RVfnxCprKJmfulcxxym1Dar5FsT/V2jiEUvABiaEiFWoQ8yHvqRM/Slf0qJKiwin6IDQucjXuolCfCKnaJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
    #img-viewer{
        width:100%;
        max-height:20em;
        object-fit:scale-down;
        object-position:center center;
    }
    .form-group.note-form-group.note-group-select-from-files {
        display: none;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Add New Post</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/Posts') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/post_add') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $session->login_id ?>">
                <?php if($session->getFlashdata('error')): ?>
                    <div class="alert alert-danger rounded-0">
                        <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($session->getFlashdata('success')): ?>
                    <div class="alert alert-success rounded-0">
                        <?= $session->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="category_id" class="control-label">Category</label>
                    <select class="form-select rounded-0" id="category_id" name="category_id" autofocus required="required">
                        <option value="" disabled selected></option>
                        <?php foreach($categories as $row): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="control-label">Title</label>
                    <input type="text" class="form-control rounded-0" id="title" name="title" value="<?= !empty($request->getPost('title')) ? $request->getPost('title') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="short_description" class="control-label">Description</label>
                    <textarea rows="4" class="form-control rounded-0" id="short_description" name="short_description" value="" required="required"><?= !empty($request->getPost('short_description')) ? $request->getPost('short_description') : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="content" class="control-label">Content</label>
                    <textarea rows="5" class="form-control rounded-0" id="content" name="content" value="" required="required"><?= !empty($request->getPost('content')) ? $request->getPost('content') : '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="tags" class="control-label">Tags</label>
                    <textarea rows="5" class="form-control rounded-0" id="tags" name="tags" value="" required="required"><?= !empty($request->getPost('tags')) ? $request->getPost('tags') : '' ?></textarea>
                    <small class="text-muted">(seperate your tags using ',' comma)</small>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="banner_img" class="form-label">Image</label>
                    <input class="form-control  rounded-0" type="file" name="banner_img" id="banner_img" onchange="display_img(this)" accept="image/*" required>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <center>
                        <img src="" alt="Browse Image" class="img-thumbnail p-0 border rounded-0 bg-dark bg-gradient bg-opacity-50" id="img-viewer">
                    </center>
                </div>
                <div class="mb-3 col-lg-6 col-md-6 col-sm-10 col-xs-12">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status" class="form-select rounded-0" required="required">
                        <option value="1">Published</option>
                        <option value="0">Unpublished</option>
                    </select>
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('custom_js') ?>
<script>
    function display_img(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#img-viewer').attr('src', e.target.result)
            }
            reader.readAsDataURL(input.files[0])
        }else{
            $('#img-viewer').attr('src', '')
        }
    }
    $(function(){
        $('#category_id').select2({
            placeholder:'Please select category here',
            width:'100%',
            containerCssClass:'form-control rounded-0 py-0 h-auto'
        })
        $('#content').summernote({
            placeholder:'Write your content here.',
            height:'20em',
            toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table', 'picture', 'video'] ],
		            [ 'view', [ 'undo', 'redo', 'help' ] ]
		        ]
        })
    })
</script>
<?= $this->endSection() ?>