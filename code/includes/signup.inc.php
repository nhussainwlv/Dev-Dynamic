<?php

if (isset($_POST["Submit"])) {
    
    $userEmail = $_POST['Email'];
    $userConfirmEmail = $_POST['ConfirmEmail'];
    $userPassword = $_POST['Password'];
    $userConfirmPassword = $_POST['ConfirmPassword'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (missingArgument($userEmail, $userConfirmEmail, $userPassword, $userConfirmPassword) !== false) {
        header("location: ../signup.php?errorcode=MissingArgument");
        exit();
    }

    if (invalidEmail($userEmail) !== false) {
        header("location: ../signup.php?errorcode=InvalidEmail");
        exit();
    }

    if (passwordLength($userPassword, $userConfirmPassword) !== false) {
        header("location: ../signup.php?errorcode=InvalidPasswordLength");
        exit();
    }

    if (emailMatch($userEmail, $userConfirmEmail) !== false) {
        header("location: ../signup.php?errorcode=EmailsDontMatch");
        exit();
    }

    if (passwordMatch($userPassword, $userConfirmPassword) !== false) {
        header("location: ../signup.php?errorcode=PasswordsDontMatch");
        exit();
    }


     if (existingEmail($dbconnection, $userEmail) !== false) {
        header("location: ../signup.php?errorcode=EmailAlreadyExists");
        exit();
    }

    createUserInfo($dbconnection, $userEmail, $userPassword);
}



 else {
    header("location: ../signup.php");
}