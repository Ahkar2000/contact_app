<?php

require_once "base.php";

function old($inputName)
{
    if (isset($_POST[$inputName])) {
        return $inputName;
    } else {
        return "";
    }
}
function text_filter($text)
{
    $text = trim($text);
    $text = htmlentities($text, ENT_QUOTES);
    $text = stripslashes($text);
    return $text;
}
function setError($inputName, $message)
{
    $_SESSION['error'][$inputName] = $message;
}
function getError($inputName)
{
    if (isset($_SESSION['error'][$inputName])) {
        return $_SESSION['error'][$inputName];
    } else {
        return "";
    }
}
function clearError()
{
    $_SESSION['error'] = [];
}
function register()
{
    $errorStatus = 0;
    $name = "";
    $email = "";
    $password = "";
    $photo = "";
    $password = "";
    if (empty($_POST['name'])) {
        setError('name', 'Please fill your name.');
        $errorStatus = 1;
    } else {
        if (strlen($_POST['name']) < 5 || strlen($_POST['name']) > 20) {
            setError('name', 'Name must be between 5 and 20 alphabets.');
            $errorStatus = 1;
        } else {
            if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST['name'])) {
                setError('name', "Only letters and white space allowed.");
                $errorStatus = 1;
            } else {
                $name = text_filter($_POST['name']);
            }
        }
    }

    if (empty($_POST['email'])) {
        setError('email', 'Please fill your email.');
        $errorStatus = 1;
    } else {
        if (strlen($_POST['email']) < 5) {
            setError('email', 'Email is incorrect.');
            $errorStatus = 1;
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                setError('email', "Please fill correct email.");
                $errorStatus = 1;
            } else {
                $email = text_filter($_POST['email']);
            }
        }
    }

    if (empty($_POST['password']) || empty($_POST['cpassword'])) {
        setError('password', 'Please fill your password.');
        $errorStatus = 1;
    } else {
        if (strlen($_POST['password']) != 8) {
            $errorStatus = 1;
            setError('password', 'Password should be 8 characters.');
        } else {
            if ($_POST['password'] !=  $_POST['cpassword']) {
                setError('cpassword', 'Password do not match.');
                $errorStatus = 1;
            } else {
                $password = text_filter($_POST['password']);
                $spassword = password_hash($password, PASSWORD_DEFAULT);
            }
        }
    }

    $pname = $_FILES['photo']['name'];
    $fileNameArr = $_FILES['photo']['name'];
    $fileTempArr = $_FILES['photo']['tmp_name'];
    if (!$pname) {
        setError('photo', 'Please upload your photo.');
    } else {
        $supportType = ["image/jpeg", "image/png"];

        $savefolder = "store/";
        if (!in_array($_FILES['photo']['type'], $supportType)) {
            setError('photo', 'File is not supported');
        } else {
            $photo = $savefolder . uniqid() . "-" . $fileNameArr;
            move_uploaded_file($fileTempArr, $photo);
        }
    }

    if (!$errorStatus) {
        $sql = "INSERT INTO user (name,email,password,photo) VALUES ('$name','$email','$spassword','$photo')";
        mysqli_query(con(), $sql);
        header("location:signin.php");
    }
}
function alert($data, $color = "danger")
{
    return "<p class='alert alert-$color'>$data</p>";
}
function signin()
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email ='$email'";
    $query = mysqli_query(con(), $sql);
    $row = mysqli_fetch_assoc($query);
    if (!$row) {
        return alert("Email or Passwords do not match");
    } else {
        if (!password_verify($password, $row['password'])) {
            return alert("Email or Passwords do not match");
        } else {
            session_start();
            $_SESSION['user'] = $row;
            header('location:dashboard.php');
        }
    }
}

function addContact()
{
    $user_id = $_SESSION['user']['id'];
    $errorStatus = 0;
    $name = "";
    $email = "";
    $photo = "";
    $phone = "";
    if (empty($_POST['name'])) {
        setError('name', 'Please fill name.');
        $errorStatus = 1;
    } else {
        $name = text_filter($_POST['name']);
    }

    if (empty($_POST['email'])) {
        setError('email', 'Please fill email.');
        $errorStatus = 1;
    } else {
        if (strlen($_POST['email']) < 5) {
            setError('email', 'Email is incorrect.');
            $errorStatus = 1;
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                setError('email', "Please fill correct email.");
                $errorStatus = 1;
            } else {
                $email = text_filter($_POST['email']);
            }
        }
    }

    if (empty($_POST['phone'])) {
        setError('phone', 'Please fill phone number.');
        $errorStatus = 1;
    } else {
        if (!preg_match("/^[0-9 ]*$/", $_POST['phone'])) {
            setError('name', "Phone Number should be numbers.");
            $errorStatus = 1;
        } else {
            $phone = text_filter($_POST['phone']);
        }
    }

    $pname = $_FILES['photo']['name'];
    $fileNameArr = $_FILES['photo']['name'];
    $fileTempArr = $_FILES['photo']['tmp_name'];
    if (!$pname) {
        setError('photo', 'Please upload your photo.');
    } else {
        $supportType = ["image/jpeg", "image/png"];

        $savefolder = "store/";
        if (!in_array($_FILES['photo']['type'], $supportType)) {
            setError('photo', 'File is not supported');
            $errorStatus = 1;
        } else {
            $photo = $savefolder . uniqid() . "-" . $fileNameArr;
            move_uploaded_file($fileTempArr, $photo);
        }
    }

    if (!$errorStatus) {
        $sql = "INSERT INTO contact_list (name,email,photo,phone,user_id) VALUES ('$name','$email','$photo','$phone','$user_id')";
        mysqli_query(con(), $sql);
    }
    header("location:dashboard.php");
}

function contacts($id)
{
    $sql = "SELECT * FROM contact_list WHERE user_id='$id'";
    $query = mysqli_query(con(), $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($query)) {
        array_push($rows, $row);
    }
    return $rows;
}
function deleteContact($contact_id)
{
    $sql = "SELECT * FROM contact_list WHERE id='$contact_id'";
    $query = mysqli_query(con(), $sql);
    $row = mysqli_fetch_assoc($query);
    unlink($row['photo']);
    $sql = "DELETE FROM contact_list WHERE id='$contact_id'";
    mysqli_query(con(), $sql);
    header("location:dashboard.php");
}
function contact($id)
{
    $sql = "SELECT * FROM contact_list WHERE id='$id'";
    $query = mysqli_query(con(), $sql);
    $row = mysqli_fetch_assoc($query);
    return $row;
}
function updateContact($id)
{
    $errorStatus = 0;
    $name = "";
    $email = "";
    $photo = "";
    $phone = "";

    if (empty($_POST['name'])) {
        setError('name', 'Please fill name.');
        $errorStatus = 1;
    } else {
        $name = text_filter($_POST['name']);
    }

    if (empty($_POST['email'])) {
        setError('email', 'Please fill email.');
        $errorStatus = 1;
    } else {
        if (strlen($_POST['email']) < 5) {
            setError('email', 'Email is incorrect.');
            $errorStatus = 1;
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                setError('email', "Please fill correct email.");
                $errorStatus = 1;
            } else {
                $email = text_filter($_POST['email']);
            }
        }
    }

    if (empty($_POST['phone'])) {
        setError('phone', 'Please fill phone number.');
        $errorStatus = 1;
    } else {
        if (!preg_match("/^[0-9 ]*$/", $_POST['phone'])) {
            setError('name', "Phone Number should be numbers.");
            $errorStatus = 1;
        } else {
            $phone = text_filter($_POST['phone']);
        }
    }

    $pname = $_FILES['photo']['name'];
    $fileNameArr = $_FILES['photo']['name'];
    $fileTempArr = $_FILES['photo']['tmp_name'];
    $supportType = ["image/jpeg", "image/png"];
    $savefolder = "store/";
    if ($pname) {
        if (!in_array($_FILES['photo']['type'], $supportType)) {
            setError('photo', 'File is not supported');
            $errorStatus = 1;
        } else {
            $photo = $savefolder . uniqid() . "-" . $fileNameArr;
            move_uploaded_file($fileTempArr, $photo);
        }
    }

    if (!$errorStatus) {
        if (!$pname) {
            $sql = "UPDATE contact_list SET name='$name',email='$email',phone='$phone' WHERE id='$id'";
            mysqli_query(con(), $sql);
            header("location:dashboard.php");
        } else {
            $sql = "UPDATE contact_list SET name='$name',email='$email',phone='$phone',photo='$photo' WHERE id='$id'";
            mysqli_query(con(), $sql);
            header("location:dashboard.php");
        }
    }
}

function search($searchkey)
{
    $sql = "SELECT * FROM contact_list WHERE name LIKE '%$searchkey%' OR phone LIKE '%$searchkey%' OR email LIKE '%$searchkey%'";
    $query = mysqli_query(con(), $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($query)) {
        array_push($rows, $row);
    }
    return $rows;
}
