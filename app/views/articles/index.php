<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <?php flash('articles_message');?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <b>Articles</b>
                    <a href="<?php echo URLROOT; ?>/articles/create" class="btn btn-primary">Add New</button></a>
                </div>


                <div class="card-body">
                    <table class="table table-bordered">
                        <thead  style="background-color: ghostwhite;">
                        <tr>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Created at</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($data['articles'] as $article) : ?>
                            <tr>
                                <td><?php echo $article->title; ?></td>
                                <td><?php echo $article->body; ?></td>
                                <td><?php echo $article->image; ?></td>
                                <td><?php echo $article->category_id; ?></td>
                                <td><?php echo $article->created_at; ?></td>
                                <td> <a href="<?php echo URLROOT; ?>/articles/edit/<?php echo $article-> id; ?>" class="btn btn-warning ;">Edit</a>
                                <a href="<?php echo URLROOT; ?>/articles/approveArticle/<?php echo $article-> id; ?>" class="btn btn-warning ;">Approve</a>

                                </td>
                            </tr>
                        <?php endforeach;?>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
