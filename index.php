<?php
require_once 'app/helpers.php';
sess_start('myrecipy');
$page_title = 'Home page';
?>

    <?php include 'tpl/header.php'; ?>

        <main style="min-height: 800px;">

            <div class="container-fluid" style="background-image:url('images/bg_img.jpg'); background-repeat: no-repeat; background-size: cover; background-position:center; min-height: 800px">
                <div class="row">
                    <div class="col-sm-6 m-auto text-center" style="background-color: rgba(56,56,56,0.2)">
                        <h1 class="display-4 text-white pt-5 lead">Join our growing community and share your own recipes and insights</h1>
                        <p><a href="blog.php" class="btn btn-warning btn-lg mt-5">Let's Cook!</a></p>
                    </div>

                </div>
            </div>
        </main>
        <?php include 'tpl/footer.php'; ?>
