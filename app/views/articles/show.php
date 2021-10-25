<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class='panel-body'>
                                        <img src="<?php echo URLROOT; ?>/<?php echo $data['article']->image; ?>"
                                             style="width: 200px;height: 300px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class='panel-heading'><h3><?php echo $data['article']->title?></h3></div>
                                    <p><b>Description</b>: <?php echo $data['article']->body?></p><br>
                                </div>
                                <div class="col-md-3">
                                    <?php foreach ($data['categories'] as $category): ?>
                                        <?php if($data['article']->category_id == $category->id): ?>
                                            <p><b>Category: </b><?php echo $category->name; ?></p><br>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <?php foreach ($data['users'] as $user): ?>
                                        <?php if($data['article']->user_id == $user->id): ?>
                                            <p><b>Author: </b><?php echo $user->name; ?></p><br>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <p><b>Publish date:</b>: <?php echo date("d-m-Y", strtotime($data['article']->created_at ))?></p><br>

                                    <?php foreach ($data['tags'] as $tag): ?>
                                        <button type="button" class="btn btn-secondary btn-sm"><?php echo $tag; ?></button>
                                    <?php endforeach; ?>


                                </div>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
