<?php
require_once "base.php";
require_once "functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./bootstrap-5.2.0-beta1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./feather-icons-web/feather.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 mx-auto mt-5">
                <div class="card">
                    <div class="card-body bg-light">
                        <?php if(isset($_POST['register'])){
                            register();
                        }
                        ?>
                        <form method="post" enctype="multipart/form-data">
                            <h4 class="text-warning fw-bolder">Register Form</h4>
                            <div class="form-group mb-2 text-warning">
                                <label class="form-label" for="name" class=" form-label">Name</label>
                                <input class="form-control" type="text" name="name" id="name">
                                <?php if(getError('name')){?>
                                    <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['name']?></small>
                                <?php }?>
                            </div>
                            <div class="form-group mb-2 text-warning">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="text" name="email" id="email">
                                <?php if(getError('email')){?>
                                    <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['email']?></small>
                                <?php }?>
                            </div>
                            <div class="form-group mb-2 text-warning">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password">
                                <?php if(getError('password')){?>
                                    <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['password']?></small>
                                <?php }?>
                            </div> 
                            <div class="form-group mb-2 text-warning">
                                <label class="form-label" for="cpassword">Confirm Password</label>
                                <input class="form-control" type="password" name="cpassword" id="cpassword">
                                <?php if(getError('password')){?>
                                    <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['password']?></small>
                                <?php }?>
                                <?php if(getError('cpassword')){?>
                                    <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['cpassword']?></small>
                                <?php }?>
                            </div> 
                            <div class="form-group mb-4 text-warning">
                                <label class="form-label" for="photo">Photo</label>
                                <input type="file" class=" form-control" name="photo" id="photo" enctype="multipart/form-data">
                                <?php if(getError('photo')){?>
                                    <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['photo']?></small>
                                <?php }?>
                            </div>
                            <div class="form-group mb-2 text-warning">
                                <button name="register" class="btn btn-outline-warning">Register</button>
                                <a href="signin.php" class="btn btn-warning">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php clearError()?>
</body>

</html>