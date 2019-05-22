<?php
  include_once "conf.php";
  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }
  $userID = $_SESSION["userID"];
  //Checks to see if a child has already been booked in
  function checkBooking() {
    return true;
  }

  function getChildren() {
    $children = [];
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $userID = $_SESSION["userID"];

    $sql = "SELECT childID, CONCAT(firstName, ' ', lastName) AS name
    FROM Child
    WHERE userID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $userID);
      if (mysqli_stmt_execute($stmt)) {
        //echo "Success";
        $result = mysqli_stmt_get_result($stmt);
        //Each child is a $row with attributes row[0], row[1]...
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
          array_push($children, array("childID" => $row[0], "name" => $row[1]));
        }
        return $children;
      }
      else {
        //echo "Execution failed";
      }
    }
  }

  function createSelect() {
    foreach (getChildren() as $child) {
      $childID = $child["childID"];
      $name = $child["name"];
      echo "<option value=$childID>$name</option>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Resources -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- jQuery Resources -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- CSS Resources -->
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="index.php">Oscar Booking System</a>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            My Children
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="addChild.php">Add a Child</a>
            <a class="dropdown-item" href="children.php">View Children</a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            My Account
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">View Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="booking.php"><b>Make a Booking</b></a>
        </li>
      </ul>
    </nav>
    <div class="container mainWindow">
      <h1>Booking</h1>
      <?php
      //echo "UserID: " . $_SESSION["userID"] . "<br>";
      //print_r(getChildren());
      ?>
      <form action="">
        <div class="form-group">
          <label for="kidSelect">Select a child</label>
          <select class="form-control" name="kidSelect">
            <?php createSelect() ?>
          </select>
        </div>
        <div class="form-group">
          <label for="bookingDate">Pick a date</label>
          <input type="date" class="form-control" name="bookingDate">
        </div>
        <button type="button" class="btn btn-success">Book</button>
      </form>
    </div>
