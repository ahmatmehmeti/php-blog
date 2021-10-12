<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ><b>Add new article</b></div>
                <div class="card-body"">
                    <form action="<?php echo URLROOT; ?>/articles/create" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Title: <sup>*</sup></label>
                            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="body">Description:*</label>
                            <textarea class="form-control <?php echo (!empty($data['body_err'])) ? 'is-invalid' : '' ?>" name="body" id="editor"
                                      rows="10"></textarea>
                            <span class="invalid-feedback"><?php echo $data['body_err'] ?></span>
                        </div>

                        <div class="form-group">
                            <label for="name">Image: <sup>*</sup></label>
                            <input type="file" name="image" class="form-control form-control-lg <?php echo (!empty($data['image_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['image_err']; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="tags">Tags:</label>
                            <select multiple="multiple" class="form-control multiple <?php echo (!empty($data['tags_err'])) ? 'is-invalid' : '' ?>" name="tags[]" id="tags">
                                <?php foreach ($data['tags'] as $tag) : ?>
                                    <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                                <?php endforeach;?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['tags_err'] ?></span>
                        </div>

                        <div class="form-group">
                            <label for="category">Category:*</label>
                            <select class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category">
                                <?php foreach ($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->id ?>"> <?php echo $category->name ?></option>
                                <?php endforeach;?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['category_err'] ?></span>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="submit"  class="btn btn-primary mt-2">Submit</button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
</script>