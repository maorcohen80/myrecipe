<?php
require_once 'app/helpers.php';
sess_start('myrecipy');

if (isset($_SESSION['user_id'])) {
    header('location: blog.php');
    exit;
}
$page_title = 'Sign in';
$error = '';


if (isset($_POST['submit'])) {

    if (isset($_POST['token']) && isset($_SESSION['csrf_token']) && $_POST['token'] == $_SESSION['csrf_token']) {

        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

        if (!$email) {

            $error = '* A valid email is required';
        } elseif (!$password) {

            $error = '* Password is required';
        } else {

            $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
            mysqli_query($link, "SET NAMES utf8");
            $email = mysqli_real_escape_string($link, $email);
            $password = mysqli_real_escape_string($link, $password);
            $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) == 1) {

                $user = mysqli_fetch_assoc($result);

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    header('location: blog.php?sm= '.$user['name'] . ', Welcome back!');
                    exit;
                
            } else {

                $error = '* Wrond email/password';
            }
        } else {
            $error = '* Wrond email/password';
        }
      }
    }
    $token = csrf_token();
} else {

    $token = csrf_token();
}
?>

<?php include 'tpl/header.php'; ?>

<main style="min-height: 600px;">
    <div class="container-fluid" style="background-image: url('images/pexels-photo-461430.jpeg'); background-size: cover;background-repeat: no-repeat; min-height: 800px">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="display-4 pt-5 ml-4 pl-2"><strong>Sign in</strong></h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="card ml-5">
                <div class="card-header">
                    Here you can sign in with your account  
                </div>
                <div class="card-body">
                    <form action="" method="POST" novalidate="novalidate" autocomplete="off">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <div class="form-group">
                            <label for="email"><span class="text-danger">*</span> Email:</label>
                            <input value="<?= old('email') ?>" type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="text-danger">*</span> Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <input type="submit" name="submit" value="Sign in" class="btn btn-warning btn-block">
                        <?php if ($error): ?>
                            <div class="alert alert-danger mt-2"> <?= $error ?> </div>
                        <?php endif; ?>
                    </form>
                </div>

            </div>
           
        </div>
        
        
    </div>
</main>

<?php include 'tpl/footer.php'; ?>     