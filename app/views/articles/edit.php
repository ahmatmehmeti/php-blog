<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ><b>Edit this article</b></div>
                <div class="card-body"">
                <form action="<?php echo URLROOT; ?>/articles/update/<?php echo $data['id']?>" method="post">
                    <div class="form-group">
                        <label for="name">Title:</label>
                        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                    </div>
                    <div class="form-group mt-2">
                        <label for="name">Description:</label>
                        <textarea class="form-control <?php echo (!empty($data['errors']['body_err'])) ? 'is-invalid' : '' ?>" name="body" id="editor" rows="10"><?php echo $data['body']?></textarea>
                        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
                    </div>
                    <div class="form-group mt-2">
                        <label for="name">Image:</label>
                        <input type="file" name="image" class="image form-control form-control-lg">
                        <input type="hidden" name="image_old" value="<?php echo $data['image_old']; ?>">
                    </div>
                    <div class="form-group mt-2">
                            <label for="tags">Tags:</label>
                            <select multiple="multiple" class="form-control multiple <?php echo (!empty($data['tags_err'])) ? 'is-invalid' : '' ?>" name="tags[]" id="tags">
                                <?php foreach ($data['tags'] as $tag) : ?>
                                <?php if(in_array($tag->name, $data['articleTags'])): ?>
                                         <option selected="selected" value="<?php echo $tag->id; ?>"><?php echo $tag->name ?></option>
                                    <?php else:?>
                                        <option value="<?php echo $tag->id; ?>"><?php echo $tag->name ?></option>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['tags_err'] ?></span>
                        </div>
                    <div class="form-group mt-2">
                        <label for="category">Category:</label>
                        <select class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category_id">
                            <?php foreach ($data['categories'] as $category) : ?>
                                <?php if($category->id == $data['article']->category_id) :?>
                                     <option selected = "selected" value="<?php echo $category->id ?>"> <?php echo $category->name ?></option>
                                <?php else:?>
                                    <option value="<?php echo $category->id ?>"> <?php echo $category->name ?></option>
                                <?php endif;?>
                            <?php endforeach;?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['category_err'] ?></span>
                    </div>
                    <div class="form-group mt-2">
                        <label for="name">Select Date:</label>
                        <input type="date" name="created_at" class="form-control form-control-lg <?php echo (!empty($data['date_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['created_at']; ?>">
                        <span class="invalid-feedback"><?php echo $data['date_err']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary col-12 mt-2">Submit</button>
                        </div>
                </form>
                         <div class="col">
                             <form action="<?php echo URLROOT; ?>/articles/delete/<?php echo $data['id'] ?>" method="post">
                        <input type="submit" value="Delete" class="btn btn-danger col-12 mt-2">
                    </form>
                </div>
            </div>
            </div>

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