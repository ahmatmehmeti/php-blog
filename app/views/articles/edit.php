<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" ><b>Add new article</b></div>
                <div class="card-body"">
                <form action="<?php echo URLROOT; ?>/articles/edit/<?php echo $data['id']?>" method="post">
                    <div class="form-group">
                        <label for="name">Title: <sup>*</sup></label>
                        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Body: <sup>*</sup></label>
                        <input type="text" name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['body']; ?>">
                        <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Image: <sup>*</sup></label>
                        <input type="file" name="image" class="form-control form-control-lg <?php echo (!empty($data['image_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['image']; ?>">
                        <span class="invalid-feedback"><?php echo $data['image_err']; ?></span>
                    </div>
                    <!--                        <div class="form-group">
                            <label for="tags">Tags:</label>
                            <select multiple="multiple" class="form-control multiple <?php /*echo (!empty($data['tags_err'])) ? 'is-invalid' : '' */?>" name="tags[]" id="tags">
                                <?php /*foreach ($data['tags'] as $tag) : */?>
                                    <option><?php /*echo $tag->name */?></option>
                                <?php /*endforeach;*/?>
                            </select>
                            <span class="invalid-feedback"><?php /*echo $data['tags_err'] */?></span>
                        </div>-->
                    <div class="form-group">
                        <label for="category">Category:*</label>
                        <select class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : '' ?>" name="category_id" id="category" value="<?php echo $data['category_id']; ?>">
                            <?php foreach ($data['categories'] as $category) : ?>
                                <option value="<?php echo $category->id ?>"> <?php echo $category->name ?></option>
                            <?php endforeach;?>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['category_err'] ?></span>
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