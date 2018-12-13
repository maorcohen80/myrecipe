<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <title>My Recipe | <?= $page_title ?> </title>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark fixed-top">
                <a class="navbar-brand text-white" href="./"><img src="images/iconfinder-icon (1).png" class="mr-3" style="width: 50px;">My Recipe</a>


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="blog.php">Blog</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if (!user_verify()): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="signin.php">Sign in</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="signup.php">Sign up</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="index.php">Hi  <?= htmlspecialchars($_SESSION['user_name']); ?></a>
                                
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="logout.php">Log out</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>
        <br><br>
        <?php if (!empty($_GET['sm'])): ?>
            <div id="sm-box" class="container mt-5">
                <div class="row">
                    <div class="col-sm-12">
                        <div class=" alert alert-success">
                            <?= $_GET['sm']; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

