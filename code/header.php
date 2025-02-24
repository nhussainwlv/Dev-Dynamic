<?php
  session_start();
?>

<!DOCTYPE html>

<html lang="en">

<head>

        <title>WLV Open Day</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="css\styles.css"> <!-- Links to the stylesheet 'styles.css' in 'css' Folder -->
    
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary">

  <div class="container-fluid">

    <a class="navbar-brand" href="#">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="http://localhost/tests/code/index.php">Homepage</a>
		    <img class="icon" src="img/homepage_icon.png" alt="Icon of a house.">
        </li>

        <?php

        if (isset($_SESSION["UID"])) {

          echo '<li class="nav-item">
          <a class="nav-link" href="http://localhost/tests/code/logout.inc.php">Logout</a>
		      <img class="icon" src="img/register_icon.png" alt="Icon of an ID badge.">
          </li>';

        }

        else {

          echo '<li class="nav-item">
          <a class="nav-link" href="http://localhost/tests/code/signup.php">Sign-up</a>
		      <img class="icon" src="img/register_icon.png" alt="Icon of an ID badge.">
          </li>';

          echo '<li class="nav-item">
          <a class="nav-link" href="http://localhost/tests/code/login.php">Login</a>
          <img class="icon" src="img/register_icon.png" alt="Icon of an ID badge.">
          </li>';

        }

        ?>

      </ul>
      <form id="SearchForm" class="d-flex" role="search">
      <img class="icon" src="img/search_icon.png" alt="Icon of a magnifying glass.">
        <input class="form-control me-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>

  </div>

</nav>