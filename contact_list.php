<?php
require_once "auth.php";
require_once "base.php";
require_once "functions.php";
?>
<?php foreach (contacts($_SESSION['user']['id']) as $rows) { ?>
    <div class="col-12 col-md-4">
        <div class="card bg-light shadow mb-3">
            <div class="card-body addContact">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex justify-content-center mb-2" style="
                                width: 100px;
                                height: 100px;
                                border-radius: 50%;
                                overflow: hidden;
                                ">
                        <img src="<?php echo $rows['photo'] ?>" class="w-100" alt="">
                    </div>
                    <div class="d-flex flex-column justify-content-center text-warning">
                        <h4 class="text-nowrap mb-2">
                            <i class="feather-user"></i>
                            <?php echo $rows['name'] ?>
                        </h4>
                        <p class="mb-2">
                            <i class="feather-phone"></i>
                            <?php echo $rows['phone'] ?>
                        </p>
                        <p class="mb-2">
                            <i class="feather-mail"></i>
                            <?php echo $rows['email'] ?>
                        </p>
                    </div>
                    <div>
                        <a data-id="<?php echo $rows['id'] ?>" class="btn btn-danger" id="delContact" onclick="return confirm('Are you sure to Delete this?')">Delete</a>
                        <a data-id="<?php echo $rows['id'] ?>" class="btn btn-warning" id="UpdateContact">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>