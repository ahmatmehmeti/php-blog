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
                    <?php if (empty($data['pagination']['articles'])): ?>
                        <div class="text-center"><?php echo 'No data available'; ?></div>
                    <?php else: ?>
                        <table class="table table-stripped table-hover table-bordered">
                            <thead  style="background-color: ghostwhite;">
                                <tr>
                                    <th>*</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                    <th>Created at</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="row_positions ">
                                <?php foreach ($data['pagination']['articles'] as $article) : ?>
                                    <tr data-index="<?php echo $article->id; ?>" data-position="<?php echo $article->position?>">
                                        <td><?php echo $article->id; ?></td>
                                        <td><?php echo $article->title; ?></td>
                                        <td><?php echo substr(strip_tags($article->body), 0, 50), strlen($article->body) > 50 ? "..." : ""  ?></td>
                                        <td><?php echo $article->created_at; ?></td>
                                        <td class="text-center">
                                            <?php if(isAdmin() && $article->status == 0): ?>
                                                <a href="<?php echo URLROOT; ?>/articles/approveArticle/<?php echo $article->id; ?>" class="btn btn-warning ;">Approve</a>
                                                <a href="<?php echo URLROOT; ?>/articles/edit/<?php echo $article->id; ?>" target="_blank" class="btn btn-warning ;">Edit</a>
                                            <?php else:?>
                                                <a href="<?php echo URLROOT; ?>/articles/edit/<?php echo $article->id; ?>" target="_blank" class="btn btn-warning ;">Edit</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <div class="links text-center">
                            <?php for($page = 1; $page<= $data['pagination']['totalAll']; $page++):  ?>
                                <a href="<?php echo URLROOT; ?>/articles/index/<?php echo $page; ?>" class="btn btn-primary"><?php echo $page?> </a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
    $(document).ready(function () {
        $(".table .row_positions").sortable({
             update:function (event,ui){
                 $(this).children().each(function (index){
                    if($(this).attr('data-position') != (index+1)){
                        $(this).attr('data-position', (index+1)).addClass('updated');
                    }
                 });
                 saveNewPositions();
             }
        });
    });

     function saveNewPositions()
     {
        var positions = [];
        $('.updated').each(function (){
           positions.push([$(this).attr('data-index'),$(this).attr('data-position')]);
           $(this).removeClass('updated');
        });

        $.ajax({
           url:'<?php echo URLROOT;?>/articles/articlesSort',
           method:'POST',
           dataType:'text',
           data:{
               update: 1,
               positions:positions
           },success:function (response){
               console.log(response);
            }
        });
     }

</script>
