<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <?php flash('category_message'); ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b>Categories</b></div>
                <div class="card-body" >
                    <?php if (empty($data['categories'])): ?>
                        <div class="text-center"><?php echo 'No data available'; ?></div>
                    <?php else: ?>
                    <table class="table table-bordered">
                        <thead  style="background-color: ghostwhite;">
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($data['categories'] as $category) : ?>
                        <tr>
                            <td><?php echo $category->name; ?></td>
                            <td> <a href="<?php echo URLROOT; ?>/categories/edit/<?php echo $category-> id ?> " class="btn btn-warning ;">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </thead>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><b>Add new category</b></div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/categories/store" method="post">
                        <div class="form-group">
                            <label for="name">Name: <sup>*</sup></label>
                            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['errors']['name_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['errors']['name_err']; ?></span>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Submit" class="btn btn-success btn-block mt-1">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>

