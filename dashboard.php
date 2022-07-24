<?php
require_once "auth.php";
require_once "base.php";
require_once "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./bootstrap-5.2.0-beta1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./feather-icons-web/feather.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container vw-100 vh-100">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto mt-5">
                <div class="col-12" style="height: 100px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <span style="font-size: 4rem;" class="text-warning me-2">
                                <i class="feather-users"></i>
                            </span>
                            <h2 class="mb-0 text-warning fw-bolder">
                                Contact App
                            </h2>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class=" align-items-center">
                                <h5 class="mb-0 fw-bold"><?php echo $_SESSION['user']['name'] ?></h5>
                                <span><?php echo $_SESSION['user']['email'] ?></span>
                            </div>
                            <div class="">
                                <img src="<?php echo $_SESSION['user']['photo'] ?>" class="pp ms-3" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-12 col-md-8 mx-auto">
                <div class="col-12 d-flex justify-content-between mb-5">
                    <form class="d-flex" method="post" action="search.php" role="search" id="searchForm">
                        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-warning" name="searchBtn" type="submit" id="searchBtn">Search</button>
                    </form>
                    <div>
                        <a href="logout.php" class="btn btn-danger">
                            <i class="feather-lock"></i>
                            Log out
                        </a>
                        <button type="button" class="btn btn-warning addContact" data-bs-toggle="modal" data-bs-target="#add">
                            <i class="feather-plus"></i>
                            Add New Contact
                        </button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row" id="contactList">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Add New Contact</h5>
                    <span id="result"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php
                        if (isset($_POST['add'])) {
                            addContact();
                        }
                        ?>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <?php if (getError('name')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['name'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone">
                            <?php if (getError('phone')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['phone'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="email">
                            <?php if (getError('email')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['email'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="photo">Photo</label>
                            <input type="file" class=" form-control" name="photo" id="photo">
                            <?php if (getError('photo')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['photo'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="add" class="btn btn-warning">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Update Contact</h5>
                    <span id="result"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="update.php" enctype="multipart/form-data" id="updateForm">
                        <div class="form-group mb-3">
                            <input type="hidden" class="form-control" name="id" id="upid">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="upname">
                            <?php if (getError('name')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['name'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" name="phone" id="upphone">
                            <?php if (getError('phone')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['phone'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" id="upemail">
                            <?php if (getError('email')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['email'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="photo">Photo</label>
                            <input type="file" class=" form-control" name="photo" id="upphoto">
                            <?php if (getError('photo')) { ?>
                                <small class="text-danger fw-bold text-uppercase"><?php echo $_SESSION['error']['photo'] ?></small>
                            <?php } ?>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="update" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php clearError() ?>
    <script src="js/jquery.js"></script>
    <script src="./bootstrap-5.2.0-beta1-dist/js/bootstrap.min.js"></script>
    <script>
        document.querySelector('.addContact').addEventListener("click", function() {
            document.querySelector(".contactAdd").classList.toggle("none");
        })
        document.querySelector('.close').addEventListener("click", function(event) {
            event.preventDefault();
            document.querySelector(".contactAdd").classList.toggle("none");
        })

        function showContact() {
            $.get("contact_list.php", function(data) {
                $('#contactList').html(data);
            })
        }
        $('#searchBtn').click(function(e) {
            e.preventDefault();
            let current = $('#searchForm').serialize();
            $.post("search.php", current, function(data) {
                $('#contactList').html(data);
            })
        })
        $('#contactList').delegate("#UpdateContact","click",function(e){
            e.preventDefault();
            let currentId = $(this).attr("data-id")
            $("#update").modal("show");
            $.get("detail.php?id="+currentId,function(data){
                let current = JSON.parse(data);
                $('#upname').val(current.name);
                $('#upphone').val(current.phone);
                $('#upemail').val(current.email);
                $('#upid').val(current.id);
            })
        })
        $('#contactList').delegate("#delContact","click",function(e){
            e.preventDefault();
            let currentId = $(this).attr("data-id")
            $.get("delete.php?id="+currentId,function(data){
                if(data == "success"){
                    showContact();
                }
            })
        })
        showContact();
    </script>
</body>

</html>