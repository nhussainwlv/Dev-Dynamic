<?php

function missingArgument($userEmail, $userConfirmEmail, $userPassword, $userConfirmPassword) {
    return empty($userEmail) || empty($userConfirmEmail) || empty($userPassword) || empty($userConfirmPassword);
}

function invalidEmail($userEmail) {
    return !filter_var($userEmail, FILTER_VALIDATE_EMAIL);
}

function passwordLength($userPassword) {
    return strlen($userPassword) < 7 || strlen($userPassword) > 32;
}

function emailMatch($userEmail, $userConfirmEmail) {
    return $userEmail !== $userConfirmEmail;
}

function passwordMatch($userPassword, $userConfirmPassword) {
    return $userPassword !== $userConfirmPassword;
}

function existingUserEmail($dbconnection, $userEmail) {
    // SQL query to find the user by email
    $sql_existingUser = "SELECT * FROM openday_user_info WHERE userEmail = ?;";
    $stmt_existingUser = mysqli_stmt_init($dbconnection);

    // Prepare the SQL statement
    if (!mysqli_stmt_prepare($stmt_existingUser, $sql_existingUser)) {
        header("location: ../login.php?errorcode=stmtError");
        exit();
    }

    // Bind the email parameter and execute the statement
    mysqli_stmt_bind_param($stmt_existingUser, "s", $userEmail);
    mysqli_stmt_execute($stmt_existingUser);

    // Fetch the result
    $result = mysqli_stmt_get_result($stmt_existingUser);
    $row = mysqli_fetch_assoc($result);

    // Close the statement and return the result
    mysqli_stmt_close($stmt_existingUser);

    return $row ? $row : false; // Return user data if found, or false if not found
}

function createUserInfo($dbconnection, $fullName, $userEmail, $userPassword) {
    $sql_createUserInfo = "INSERT INTO openday_user_info (fullName, userEmail, userPassword) VALUES (?, ?, ?);";
    $stmt_createUserInfo = mysqli_stmt_init($dbconnection);

    if (!mysqli_stmt_prepare($stmt_createUserInfo, $sql_createUserInfo)) {
        header("location: ../signup.php?errorcode=stmtError");
        exit();
    }

    $hashed_userPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt_createUserInfo, "sss", $fullName, $userEmail, $hashed_userPassword);
    mysqli_stmt_execute($stmt_createUserInfo);
    mysqli_stmt_close($stmt_createUserInfo);

    header("location: ../signup.php?errorcode=none");
    exit();
}

function missingLoginArgument($userEmail, $userPassword) {
    return empty($userEmail) || empty($userPassword);
}

function loginUser($dbconnection, $userEmail, $userPassword) {
    $userExists = existingUserEmail($dbconnection, $userEmail);

    if (!$userExists) {
        header("location: ../login.php?errorcode=incorrectEmail");
        exit();
    }

    if (!password_verify($userPassword, $userExists["userPassword"])) {
        header("location: ../login.php?errorcode=incorrectPassword");
        exit();
    }

    session_start();
    $_SESSION["UID"] = $userExists["UID"];
    header("location: ../dashboards/dashboard.php?errorcode=LoginSuccessful");
    exit();
}