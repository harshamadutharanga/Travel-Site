<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="imgs/signin-image.jpg" alt="sing up image"></figure>
                    <a href="signup-user.php" class="signup-image-link">Create an account</a>
                </div>

                <div class="signin-form">
                <h2 class="form-title">Sign In</h2>
                <form action="login-user.php" method="POST" autocomplete="">
                    <p class="text-center">Login with your email and password.</p>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                    <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                        <input id="your_name" class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                    <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                        <input id="your_pass" class="form-control" type="password" name="password" placeholder="Password" required autocomplete="off">
                    </div>
                    <div class="label-agree-term"><a href="forgot-password.php">Forgot password?</a></div>
                    <div class="form-group">
                        <input class="form-submit" type="submit" name="login" value="Login">
                    </div>                    

                </form>
                <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>