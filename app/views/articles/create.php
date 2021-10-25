<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ><b>Add new article</b></div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/articles/store" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Title:</label>
                            <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['errors']['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']?>">
                            <span class="invalid-feedback"><?php echo $data['errors']['title_err']; ?></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="body">Description:</label>
                            <textarea class="form-control <?php echo (!empty($data['errors']['body_err'])) ? 'is-invalid' : '' ?>" name="body" id="editor" rows="10"><?php echo $data['body']?></textarea>
                            <span class="invalid-feedback"><?php echo $data['errors']['body_err'] ?></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="name">Image:</label>
                            <input type="file" name="image" class="image form-control form-control-lg <?php echo (!empty($data['errors']['image_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['errors']['image_err']; ?></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="tags">Tags:</label>
                            <select multiple="multiple" class="form-control multiple <?php echo (!empty($data['errors']['tags_err'])) ? 'is-invalid' : '' ?>" name="tags[]" id="tags">
                                <?php foreach ($data['tags'] as $tag) : ?>
                                    <option value="<?php echo $tag->id ?>"><?php echo $tag->name ?></option>
                                <?php endforeach;?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['errors']['tags_err'] ?></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="category">Category:</label>
                            <select class="form-control <?php echo (!empty($data['errors']['category_id_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category">
                                <?php foreach ($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->id ?>"> <?php echo $category->name ?></option>
                                <?php endforeach;?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['errors']['category_id_err'] ?></span>
                        </div>

                        <div class="form-group mt-2">
                            <label for="name">Select Date:</label>
                            <input type="datetime-local" name="created_at" class="form-control form-control-lg <?php echo (!empty($data['errors']['created_at_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['errors']['created_at_err']; ?></span>
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