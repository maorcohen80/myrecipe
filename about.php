<?php
require_once 'app/helpers.php';
sess_start('myrecipy');
$page_title = 'About us';
?>

<?php include 'tpl/header.php'; ?>

<main style="min-height: 600px;">
    <div class="container pt-5 mt-3 text-center">

        <h4 class="lead"><strong>Discover world of stayles and flavors and get inpired for your next dish</strong></h4><br>
        <h4 class="lead">Here in My Recipe there so much to explore! share ideas, comments on others and get new ideas</h4>
        <h4 class="lead">From kitchens all around the world!</h4>
        <h4 class="lead">Our community is growind every day, join us!</h4>

        <?php if (isset($_SESSION['user_id'])): ?>
            <p><a href="blog.php" class="btn btn-warning btn-lg mt-3">Go to blog!</a></p>
        <?php else: ?>
            <p><a href="signup.php" class="btn btn-warning btn-lg mt-3">Sign Up Now!</a></p>
        <?php endif; ?>
    </div>
    <div class="container mb-3 text-center mt-3">
        <div class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/pexels-photo-769289.jpeg" alt="First slide">
                </div>

                <div class="carousel-item">
                    <img src="images/pexels-photo-691114.jpeg" alt="Second slide">
                </div>

                <div class="carousel-item">
                    <img src="images/pexels-photo-70497.jpeg" alt="Third slide">
                </div>
                
                <div class="carousel-item">
                    <img src="images/pexels-photo-376464.jpeg" alt="Fourth slide">
                </div>
                
                <div class="carousel-item">
                    <img src="images/food-salad-healthy-lunch.jpg" alt="Fifth slide">
                </div>
            </div>
        </div>
    </div>


</main>

<?php include 'tpl/footer.php'; ?>     