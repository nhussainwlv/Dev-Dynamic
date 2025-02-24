<!DOCTYPE html>

<?php

include_once 'header.php';

?>

<html>
    <head>
        <title>Account Login</title>
        <meta charset="UTF-8">
        <meta name="description" content="User Registeration Page.">
        <link rel="stylesheet" href="css/styles.css" >
    </head>
    <body>

        <h1>Login:</h1><hr class="subtitle-hr"><br><br>

        <?php

            if (isset($_GET["errorcode"])) {

                if($_GET["errorcode"] == "incorrectUsername") {
                    echo '<div class="alert alert-danger" role="alert">
                    Username has been entered incorrectly! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "incorrectPassword") {
                    echo '<div class="alert alert-danger" role="alert">
                    Password has been entered incorrectly! Please try again.
                    </div>';
                }

                if($_GET["errorcode"] == "LoginSuccessful") {
                    echo '<div class="alert alert-success" role="alert">
                    Account logged in successfully!
                    </div>';
                }

            }


        ?>

        <form class="row g-3" action="includes/login.inc.php" method="post">

            <div class="container text-center">
                <div class="row justify-content-md-center">

                    <div class="row col-md-5"></div>
                    <div class="col-md-2">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="Username" placeholder="Enter Email: ">
                    </div>
                    <div class="col-md-5"></div>
                    <br><br><br>

                    <div class="row col-md-5"></div>
                    <div class="col-md-2">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="Password" placeholder="Enter Password: ">
                    </div>
                    <div class="col-md-5"></div>
                    <br><br><br>

                    <div class="col-12">
                        <button type="submit" name="Submit" class="btn btn-outline-light">Login</button>
                    </div>
                
                </div>
            </div>

        </form>

    </body>
</html>


<?php

    include_once 'footer.php';

?>