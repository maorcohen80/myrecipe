<?php
require_once 'app/helpers.php';
sess_start('myrecipy');
require_once 'vendor/autoload.php';

use Gregwar\Captcha\CaptchaBuilder;

$builder = new CaptchaBuilder;
$builder->build();
$_SESSION['phrase'] = $builder->getPhrase();
if($builder->testPhrase($userInput)) {
    echo 'good';
}
else {
    echo 'wrong';
}


if (isset($_SESSION['user_id'])) {
    header('location: blog.php');
    exit;
}
$page_title = 'Sign up';
$error['name']=$error['email']=$error['password']= '';


if (isset($_POST['submit'])) {

    if (isset($_POST['token']) && isset($_SESSION['csrf_token']) && $_POST['token'] == $_SESSION['csrf_token']) {
        
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
        $cpassword = trim(filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING));
        $form_valid = true;
        
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
        mysqli_query($link, "SET NAMES utf8");
        $name = mysqli_real_escape_string($link, $name);
        $email = mysqli_real_escape_string($link, $email);
        $password = mysqli_real_escape_string($link, $password);
        if ( !$name || mb_strlen($name) < 2 ){
            $error['name'] = '* Name is required (min 2 char)';
            $form_valid = true;
            
        }
        
        if (!$email){
            
            $error['email'] = '* A valid Email is required';
            $form_valid = 'false';
        }elseif (email_exist($link, $email)) {
            $error['email'] = "* Email is taken";
            $form_valid = false;
        }
        
        if (!$password){
            
           $error['password'] = '* Password is required';
           $form_valid = false;
          }elseif ($password != $cpassword){
           $error['password'] = '* Password confirmation wrong';
           $form_valid = false;
        }
        
        if ($form_valid){
            
            
            $file_name = 'avatar_image.png';
            
            if (isset($_FILES['image']['error']) && $_FILES['image']['error']== 0){
                
                $ex = ['png','jpg','bmp','jpeg','gif'];
                define('MAX_FILE_SIZE', 1024*1024*5);
                
                if (is_uploaded_file($_FILES['image']['tmp_name'])){
                    
                    if ($_FILES['image']['size']<= MAX_FILE_SIZE){
                        
                        $fileinfo = pathinfo($_FILES['image']['name']);
                        
                        if (in_array(strtolower($fileinfo['extension']), $ex)){
                            
                            $file_name = date('Y.m.d.h.i.s') .'-'. $_FILES['image']['name'];
                            move_uploaded_file($_FILES['image']['tmp_name'],'images/'.$file_name);
                        }
                    }
                }
            }
            
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users VALUES ('','$name','$email','$password')";
            $result = mysqli_query($link, $sql);
            
            if ($result && mysqli_affected_rows($link) > 0){
                
                $uid = mysqli_insert_id($link);
                $sql = "INSERT INTO profile_images VALUES ('', $uid, '$file_name')";
                $result = mysqli_query($link, $sql);
                
                if ($result && mysqli_affected_rows($link) > 0 ){
                    
                    header('location: signin.php?sm=You signed up, now you can sign in with your account');
                    exit;
                }
                
                
            }
            
        }
         
        
    }
    $token = csrf_token();
} else {

    $token = csrf_token();
}
?>

<?php include 'tpl/header.php'; ?>

<main style="min-height: 800px; background-image: url('images/blue-bright-citrus-405031.jpg'); background-size: cover">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                
                <h1 class="display-4 pt-5 pb-3"><strong>Sign Up Page</strong></h1>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header">
                    Here you can sign up with new account  
                </div>
                <div class="card-body">
                    <form action="" method="POST" novalidate="novalidate" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        <div class="form-group">
                            <label for="name"><span class="text-danger">*</span> Name:</label>
                            <input value="<?= old('name') ?>" type="text" name="name" id="name" class="form-control">
                            <span class="text-danger mt-2"> <?= $error['name']; ?> </span>
                        </div>
                        <div class="form-group">
                            <label for="email"><span class="text-danger">*</span> Email:</label>
                            <input value="<?= old('email') ?>" type="email" name="email" id="email" class="form-control">
                            <span class="text-danger mt-2"> <?= $error['email']; ?> </span>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="text-danger">*</span> Password:</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <span class="text-danger mt-2"> <?= $error['password']; ?> </span>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password"><span class="text-danger">*</span> Confirm Password:</label>
                            <input type="password" name="confirm_password" id="confirm-password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image"> Profile image:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                        </div>


                        <input type="submit" name="submit" value="Sign up" class="btn btn-warning btn-block"><br>
                        <img src="<?php echo $builder->inline(); ?>" />
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>

<?php include 'tpl/footer.php'; ?>     