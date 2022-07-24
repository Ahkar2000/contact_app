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
    <title>Sign in</title>
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
                        <form method="post">
                            <h4 class="text-warning fw-bolder">Sign in</h4>
                            <div class="form-group mb-2 text-warning">
                                <label class="form-label" for="email" class=" form-label">Email</label>
                                <input class="form-control" type="text" name="email" id="email">
                            </div>
                            <div class="form-group mb-2 text-warning">
                                <label class="form-label" for="email" class=" form-label">Password</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                            <?php if(isset($_POST['signin'])){
                                echo signin();
                            }
                            ?>
                            <div class="text-end">
                                <button class="btn btn-warning" name="signin">
                                    Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>