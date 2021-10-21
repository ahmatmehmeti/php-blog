<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><b>Edit Category</b></div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/categories/update/<?php  echo $data['id']?>" method="post">
                        <div class="form-group">
                            <label for="name">Name: <sup>*</sup></label>
                            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['errors']['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
                            <span class="invalid-feedback"><?php echo $data['errors']['name_err']; ?></span>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Update" class="btn btn-success btn-block col-12 mt-2">
                            </div>
                    </form>
                    <div class="col">
                        <form action="<?php echo URLROOT; ?>/categories/delete/<?php echo  $data['id']; ?>" method="post">
                            <input type="submit" value="Delete" class="btn btn-danger col-12 inline-block mt-2">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>

