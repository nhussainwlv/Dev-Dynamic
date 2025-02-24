<?php

if (isset($_POST["Submit"])) {
    
    $userEmail = $_POST['Email'];
    $userPassword = $_POST['Password'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (missingLoginArgument($userEmail, $userPassword) !== false) {
        header("location: ../login.php?errorcode=MissingArgument");
        exit();
    }

    loginUser($dbconnection, $userEmail, $userPassword);
}

else {

    exit();
}