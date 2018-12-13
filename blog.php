<?php
require_once 'app/helpers.php';
sess_start('myrecipy');
$page_title = 'Blog';

$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
mysqli_query($link, "SET NAMES utf8");
$sql = "SELECT u.name,pi.file_name, p.*, DATE_FORMAT(p.updated_at, '%d/%m/%Y') udate FROM posts p "
        . "JOIN users u ON u.id = p.user_id "
        . "JOIN profile_images pi ON u.id = pi.user_id "
        . "ORDER BY p.created_at DESC";

$result = mysqli_query($link, $sql);

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
}
?>

<?php include 'tpl/header.php'; ?>

<main style="min-height: 600px; background-image:url('images/pexels-photo-952482.jpeg'); background-size: cover; background-repeat: no-repeat">
    <div class="container">
        <div class="row mt-3">
            <div class="col-sm-12">
                <h1 class="display-4 text-white" style="background-color: rgba(56,56,56,0.5);"> <strong>Recipe zone</strong>  </h1>
                <?php if (user_verify()): ?>
                    <p class="mt-5">
                        <a href="add_post.php" class="btn btn-warning btn-lg">
                            <i class="fas fa-plus-circle"></i> Add your post</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <div class="row mt-3">
                <?php while ($post = mysqli_fetch_assoc($result)): ?>
                    <div class="col-sm-12 mb-5">
                        <div class="card">
                            <div class="card-header">
                                <img class="rounded-circle" width="40" height="40" src="images/<?= $post['file_name']; ?>">
                                <span class="ml-3"><?= htmlspecialchars($post['name']); ?></span> <span class="float-right"><?= $post['udate'] ?></span>
                            </div>
                            <div class="card-body">
                                <h3><?= str_to_rtl(htmlspecialchars($post['title'])) ?></h3>
                                <p><?= str_to_rtl(str_replace("\n", '<br>', htmlspecialchars($post['article']))); ?></p>
                                <?php if (!empty($uid) && $post['user_id'] == $uid) : ?>
                                    <p class="float-left">
                                        <a href="delete_post.php?pid=<?=$post['id'];?>" class="btn btn-outline-danger btn-sm delete-post-btn float-right">
                                            <i class="far fa-trash-alt"></i> Delete</a></p>
                                    <p class="float-right">
                                        <a href="edit_post.php?pid=<?=$post['id'];?>" class="btn btn-outline-warning btn-sm"><i class="fas fa-pen"></i> Edit</a>
                                    </p>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
       
        

    </div>
</main>

<?php include 'tpl/footer.php'; ?>     