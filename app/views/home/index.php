<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
                <a href="" class="list-group-item list-group-item-action active">Categories</a>
                <?php foreach ($data['categories'] as $category) : ?>
                    <a href="<?php echo URLROOT; ?>/articles/getArticlesByCategory/<?php echo $category->id; ?>"
                       class="list-group-item list-group-item-action"><?php echo $category->name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row col-md-10">
            <?php if (empty($data['articles'])): ?>
                <div class="text-center"><?php echo 'No data available'; ?></div>
            <?php else: ?>
                <?php foreach ($data['pagination']['articles'] as $article): ?>
                    <div class='col-md-3' style="margin-bottom: 5px">
                        <div class='panel panel-info'>
                            <div class='panel-body'>
                                <img src="<?php echo URLROOT;?>/<?php echo $article->image; ?>" style="width: 200px;height: 300px;">
                                <h5><?php echo substr(strip_tags($article->title), 0, 46), strlen($article->body) > 46 ? "..." : ""  ?></h5>
                                <a href="<?php echo URLROOT; ?>/articles/show/<?php echo $article->slug; ?>"
                                   class="btn btn-outline-primary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="links text-center">
                    <?php if (isset($data['pagination']['totalAll'])) : ?>
                        <?php for ($page = 1; $page <= $data['pagination']['totalAll']; $page++): ?>

                            <a href="<?php echo URLROOT; ?>/home/index/<?php echo $page ?>"
                               class="btn btn-primary"><?php echo $page ?></a>
                            </a>
                        <?php endfor; ?>

                    <?php endif; ?>

                    <?php if (isset($data['pagination']['totalCat'])) : ?>
                        <?php for ($page = 1; $page <= $data['pagination']['totalCat']; $page++): ?>

                            <a href="<?php echo URLROOT; ?>/articles/getArticlesByCategory/<?php echo $data['pagination']['id'] ?>/<?php echo $page ?>"
                               class="btn btn-primary"><?php echo $page ?></a>

                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
