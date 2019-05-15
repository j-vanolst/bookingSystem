<?php
  require_once "conf.php";

  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }

  function getChildren () {
    $children = [];
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $userID = $_SESSION["userID"];

    $sql = "SELECT CONCAT(firstName, ' ', lastName), birthdate, gender, allergies from Child WHERE userID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $userID);
      if (mysqli_stmt_execute($stmt)) {
        //echo "Success";
        $result = mysqli_stmt_get_result($stmt);
        //Each child is a $row with attributes row[0], row[1]...
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
          array_push($children, createCard($row[0], $row[1], $row[2]));
        }
        return $children;
      }
      else {
        //echo "Execution failed";
      }
    }
    //return "<p>Hello there</p>";
    //return $_SESSION["userID"];
  }
  function createCard ($name, $birthdate, $gender) {
    return "
    <div class='card child'>
      <div class='card-body'>
        <h4 class='card-title'>$name</h4>
        <p>Birthdate: $birthdate</p>
        <p>Gender: $gender</p>
      </div>
    </div>";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Bootstrap Resources -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
    </nav>
    <div class="container mainWindow">
      <h1>Your Children</h1>
      <?php
        foreach (getChildren() as $child) {
          echo $child;
        }
      ?>
    </div>
  </body>
</html>
