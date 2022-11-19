<?php
include_once "db_connect.php";
$db = $GLOBALS['db'];

$posts = $db->getPosts();


?>
<?php foreach ($posts as $key => $post) : ?>
    <article class="col-12 col-md-6 tm-post">
        <hr class="tm-hr-primary">
        <a href="post.php?id=<?php echo $key ?>" class="effect-lily tm-post-link tm-pt-60">
            <div class="tm-post-link-inner">
                <img src="<?php echo $post['img'] ?>" alt="Image" class="img-fluid">
            </div>
            <h2 class="tm-pt-30 tm-color-primary tm-post-title"><?php echo $post['title'] ?></h2>
        </a>
        <p class="tm-pt-30">
            <?php echo substr($post['content'], 0, 50), "..." ?>
        </p>
        <div class="d-flex justify-content-between tm-pt-45">
            <span class="tm-color-primary">
                <?php foreach ($post['categories'] as $category) {
                    echo $category, ". ";
                } ?>
            </span>
            <span class="tm-color-primary">
                <?php
                $phpdate = strtotime($post['created_at']);
                echo date("F j, Y", $phpdate);
                ?>
            </span>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <span>36 comments</span>
            <span>by <?php echo $post['first_name'], " ", $post['last_name'] ?></span>
        </div>
    </article>
<?php endforeach; ?>