<?php

function missingArgument($userEmail, $userConfirmEmail, $userPassword, $userConfirmPassword) {

    $validationCheck = '';

    if (empty($userEmail) || empty($userConfirmEmail) || empty($userPassword) || empty($userConfirmPassword)) {
        $validationCheck = true;
    }
    
    else {
        $validationCheck = false;
    }

    return $validationCheck;
}

function invalidEmail($userEmail) {

    $validationCheck = '';

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $validationCheck = true;
    }
    else {
        $validationCheck = false;
    }

    return $validationCheck;
}

function passwordLength($userPassword) {

    $validationCheck = '';

    if (strlen($userPassword) < 7) {
        $validationCheck = true;
    }

    if (strlen($userPassword) > 32) {
        $validationCheck = true;
    }

    else {
        $validationCheck = false;
    }

    return $validationCheck;
}

function emailMatch($userEmail, $userConfirmEmail) {

    $validationCheck = '';

    if ($userEmail !== $userConfirmEmail) {
        $validationCheck = true;
    }

    else {
        $validationCheck = false;
    }

    return $validationCheck;
}

function passwordMatch($userPassword, $userConfirmPassword) {

    $validationCheck = '';

    if ($userPassword !== $userConfirmPassword) {
        $validationCheck = true;
    }

    else {
        $validationCheck = false;
    }

    return $validationCheck;
}

function existingEmail($dbconnection, $userEmail) {

    $validationCheck = '';

    $sql_existingEmail = "SELECT * FROM user_info WHERE userEmail = ?;";
    $stmt_existingEmail = mysqli_stmt_init($dbconnection);

    if (!mysqli_stmt_prepare($stmt_existingEmail, $sql_existingEmail)) {
        header("location: ../signup.php?errorcode=stmtError");
        exit();
    }

    mysqli_stmt_bind_param($stmt_existingEmail, "s", $userEmail);
    mysqli_stmt_execute($stmt_existingEmail);

    $checkDatabase = mysqli_stmt_get_result($stmt_existingEmail);

    if ($row = mysqli_fetch_assoc($checkDatabase)) {
        return $row;
    }

    else {
        $validationCheck = false;
        return $validationCheck;
    }

    mysqli_stmt_close($stmt_existingEmail);

}

function createUserInfo($dbconnection, $userEmail, $userPassword) {

    $validationCheck = '';

    $sql_createUserInfo = "INSERT INTO user_info (userEmail, userPassword) VALUES (?, ?, ?);";
    $stmt_createUserInfo = mysqli_stmt_init($dbconnection);

    if (!mysqli_stmt_prepare($stmt_createUserInfo, $sql_createUserInfo)) {
        header("location: ../signup.php?errorcode=stmtError");
        exit();
    }

    $hashed_userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt_createUserInfo, "ss", $userEmail, $hashed_userPassword);
    mysqli_stmt_execute($stmt_createUserInfo);
    mysqli_stmt_close($stmt_createUserInfo);
    header("location: ../signup.php?errorcode=none");
    exit();

}

function missingLoginArgument($userEmail, $userPassword) {

    $validationCheck = '';

    if (empty($userEmail) || empty($userPassword)) {
        $validationCheck = true;
    }
    
    else {
        $validationCheck = false;
    }

    return $validationCheck;
}

function LoginUser($dbconnection, $userEmail, $userPassword) {

    $userExists = existingEmail($dbconnection, $userEmail, $userEmail);

    if ($userExists === false) {
        header("location: ../login.php?errorcode=incorrectEmail");
        exit();
    }

    $hashed_userPassword = $userExists["userPassword"];
    $validatePassword = password_verify($userPassword, $hashed_userPassword);

    if ($validatePassword === false) {
        header("location: ../login.php?errorcode=incorrectPassword");
        exit();
    }

    else if ($validatePassword === true) {
        session_start();
        $_SESSION["UID"] =  $userExists["UID"];
        header("location: ../index.php?errorcode=LoginSuccessful");
    }

}