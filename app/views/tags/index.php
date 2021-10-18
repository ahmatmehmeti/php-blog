<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <?php flash('tags_message'); ?>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b>Tags</b></div>
                <div class="card-body" >
                    <?php if (empty($data['tags'])): ?>
                        <div class="text-center"><?php echo 'No data available'; ?></div>
                    <?php else: ?>
                    <table class="table table-bordered">
                        <thead  style="background-color: ghostwhite;">
                        <tr>
                            <th>Name</th>
                            <th>Created_at</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($data['tags'] as $tag) : ?>
                            <tr>
                                <td><?php echo $tag->name; ?></td>
                                <td><?php echo $tag->created_at; ?></td>
                                <td> <a href="<?php echo URLROOT; ?>/tags/edit/<?php echo $tag-> id ?> " class="btn btn-warning ;">Edit</a>
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
                <div class="card-header"><b>Add new tag</b></div>
                <div class="card-body">
                    <form action="<?php echo URLROOT; ?>/tags/add" method="post">
                        <div class="form-group">
                            <label for="name">Name: <sup>*</sup></label>
                            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
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

