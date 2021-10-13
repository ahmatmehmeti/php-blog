<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="list-group">
                <a href="" class="list-group-item list-group-item-action active">Categories</a>
                <?php /*@foreach($dataas $category) : */?>

                <a href="" class="list-group-item list-group-item-action">
                    <p>Category name</p>
                    <p>Category name</p>
                    <p>Category name</p>
                </a>
               <?php /*endforeach */?>
            </div>


        </div>
        <div class="row col-md-10">
            <!-- --><?php /*foreach($books as $book) */?>
            <div class='col-md-3' style="margin-bottom: 5px">
                <div class='panel panel-info'>
                    <div class='panel-body'>
                        <a href=""><img src="" style="width: 200px;height: 300px;"></a>
                        <h5>first post</h5>
                        <p><b>asticle article</b></p>
                        <a href="" class="btn btn-outline-primary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
            <?php /*endforeach */?>
            <div class="links" style="margin-top: 10px; margin-bottom: 10px">

            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
