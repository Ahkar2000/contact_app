<?php
require_once "auth.php";
require_once "base.php";
require_once "functions.php";

session_start();
session_unset();
session_destroy();
header("location:signin.php");