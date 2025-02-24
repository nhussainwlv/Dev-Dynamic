<!DOCTYPE html>

<?php

include_once 'header.php';

?>

<html>
    <head>
        <title>Account Sign Up</title>
        <meta charset="UTF-8">
        <meta name="description" content="User Registeration Page.">
        <link rel="stylesheet" href="css/styles.css" >
    </head>
    <body>

        <h1>Sign Up:</h1><hr class="subtitle-hr"><br><br>

        <?php

            if (isset($_GET["errorcode"])) {

                if($_GET["errorcode"] == "MissingArgument") {
                    echo '<div class="alert alert-danger" role="alert">
                    You have not entered all boxes! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "InvalidEmail") {
                    echo '<div class="alert alert-danger" role="alert">
                    Entered E-Mail is invalid! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "InvalidCharactersInput") {
                    echo '<div class="alert alert-danger" role="alert">
                    You have entered invalid characters! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "InvalidUsernameLength") {
                    echo '<div class="alert alert-danger" role="alert">
                    Your username length is invalid! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "InvalidPasswordLength") {
                    echo '<div class="alert alert-danger" role="alert">
                    Your password length is invalid! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "EmailsDontMatch") {
                    echo '<div class="alert alert-danger" role="alert">
                    Entered E-mails do not match! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "PasswordsDontMatch") {
                    echo '<div class="alert alert-danger" role="alert">
                    Entered passwords do not match! Please try again.
                    
                    </div>';
                }

                if($_GET["errorcode"] == "UsernameAlreadyExists") {
                    echo '<div class="alert alert-danger" role="alert">
                    Username already exists! Please chose another.
                    </div>';
                }

                if($_GET["errorcode"] == "none") {
                    echo '<div class="alert alert-success" role="alert">
                    Account created successfully!
                    </div>';
                }

            }


        ?>

        <form class="row g-3" action="includes/signup.inc.php" method="post">

            <div class="container text-center">
                <div class="row justify-content-md-center">

                    <div class="row col-md-3"></div>
                    <div class="row col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="Email" placeholder="Enter Email:">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Confirm Email</label>
                        <input type="email" class="form-control" name="ConfirmEmail" placeholder="Confirm Email:">
                    </div>
                    <div class="col-md-3"></div>
                    <br><br><br>

                    <div class="row col-md-3"></div>
                    <div class="row col-md-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="Password" placeholder="Enter Password: (7-32 Characters)">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="ConfirmPassword" placeholder="Confirm Password:">
                    </div>
                    <div class="col-md-3"></div>
                    <br><br><br>

                    <div class="col-12">
                        <button type="submit" name="Submit" class="btn btn-outline-light">Sign Up</button>
                    </div>
                
                </div>
            </div>

        </form>

    </body>
</html>


<?php

    include_once 'footer.php';

?>