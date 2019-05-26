<?php
  require_once "conf.php";

  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*if (isset($_POST["userID"], $_POST["address"], $_POST["homePhone"], $_POST["school"], $_POST["email"],
    $_POST["doctorName"], $_POST["doctorPhone"], $_POST["medicalCenter"],
    $_POST["motherName"], $_POST["motherWorkplace"], $_POST["motherWorkPhone"], $_POST["motherMobile"],
    $_POST["fatherName"], $_POST["fatherWorkplace"], $_POST["fatherWorkPhone"], $_POST["fatherMobile"])) {

      $userID = $_SESSION["userID"];

      $address = trim($_POST["address"]);
      $homePhone = trim($_POST["homePhone"]);
      $school = trim($_POST["school"]);
      $email = trim($_POST["email"]);
      $doctorName = trim($_POST["doctorName"]);
      $doctorPhone = trim($_POST["doctorPhone"]);
      $medicalCenter = trim($_POST["medicalCenter"]);

      $motherName = trim($_POST["motherName"]);
      $motherWorkplace = trim($_POST["motherWorkplace"]);
      $motherWorkPhone = trim($_POST["motherWorkPhone"]);
      $motherMobile = trim($_POST["motherMobile"]);
      $fatherName = trim($_POST["fatherName"]);
      $fatherWorkplace = trim($_POST["fatherWorkplace"]);
      $fatherWorkPhone = trim($_POST["fatherWorkPhone"]);
      $fatherMobile = trim($_POST["fatherMobile"]);
      echo "vars set";
    }*/
    $userID = $_SESSION["userID"];

    $address = trim($_POST["address"]);
    $homePhone = trim($_POST["homePhone"]);
    $school = trim($_POST["school"]);
    $email = trim($_POST["email"]);
    $doctorName = trim($_POST["doctorName"]);
    $doctorPhone = trim($_POST["doctorPhone"]);
    $medicalCenter = trim($_POST["medicalCenter"]);

    $motherName = trim($_POST["motherName"]);
    $motherWorkplace = trim($_POST["motherWorkplace"]);
    $motherWorkPhone = trim($_POST["motherWorkPhone"]);
    $motherMobile = trim($_POST["motherMobile"]);
    $fatherName = trim($_POST["fatherName"]);
    $fatherWorkplace = trim($_POST["fatherWorkplace"]);
    $fatherWorkPhone = trim($_POST["fatherWorkPhone"]);
    $fatherMobile = trim($_POST["fatherMobile"]);

    if ($_SESSION["isSetup"]) {

      $sql = "UPDATE parent SET
        address = ?,
        homePhone = ?,
        school = ?,
        email = ?,
        doctorName = ?,
        doctorPhone = ?,
        medicalCenter = ?,
        motherName = ?,
        motherWorkplace = ?,
        motherWorkPhone = ?,
        motherMobile = ?,
        fatherName = ?,
        fatherWorkplace = ?,
        fatherWorkPhone = ?,
        fatherMobile = ?
        WHERE userID = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssssssssssssi", $address, $homePhone, $school, $email, $doctorName, $doctorPhone, $medicalCenter, $motherName, $motherWorkplace, $motherWorkPhone, $motherMobile, $fatherName, $fatherWorkplace, $fatherWorkPhone, $fatherMobile, $userID);
        if (mysqli_stmt_execute($stmt)) {
          //echo "Success";
        }
        else {
          //echo "Execution failed";
        }
      }
      else {
        //echo "preparing stmt failed";
      }
      mysqli_stmt_close($stmt);
      mysqli_close($link);
      header("location: index.php");
    }
    else {
      $sql = "INSERT into parent (
        userID,
        address,
        homePhone,
        school,
        email,
        doctorName,
        doctorPhone,
        medicalCenter,
        motherName,
        motherWorkplace,
        motherWorkPhone,
        motherMobile,
        fatherName,
        fatherWorkplace,
        fatherWorkPhone,
        fatherMobile)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
          mysqli_stmt_bind_param($stmt, "isssssssssssssss", $userID, $address, $homePhone, $school, $email, $doctorName, $doctorPhone, $medicalCenter, $motherName, $motherWorkplace, $motherWorkPhone, $motherMobile, $fatherName, $fatherWorkplace, $fatherWorkPhone, $fatherMobile);
          if (mysqli_stmt_execute($stmt)) {
            //echo "Successfully setup account";
          }
          else {
            //echo "Something went wrong";
          }
        }
        else {
          //echo "Preparing stmt failed";
        }
        mysqli_stmt_close($stmt);

//Updates the isSetup variable for the user once they have successfully setup their account
        $sql = "UPDATE User SET isSetup = 1 WHERE userID = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
          mysqli_stmt_bind_param($stmt, "i", $userID);
          if (mysqli_stmt_execute($stmt)) {
            //echo "Successfully setup account";
            $_SESSION["isSetup"] = true;
          }
          else {
            //echo "Execution failed";
          }
        }
        else {
          //echo "Preparing stmt failed";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        header("location: index.php");
      }
    }

  function getUserInformation() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "select address, homePhone, school, email, doctorName, doctorPhone, medicalCenter,
    motherName, motherWorkplace, motherWorkPhone, motherMobile, fatherName, fatherWorkplace, fatherWorkPhone, fatherMobile
    from Parent where userID = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $param_userID);
      $param_userID = $_SESSION["userID"];
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $address, $homePhone, $school, $email, $doctorName, $doctorPhone,
        $medicalCenter, $motherName, $motherWorkplace, $motherWorkPhone, $motherMobile, $fatherName, $fatherWorkplace,
        $fatherWorkPhone, $fatherMobile);

        if (mysqli_stmt_fetch($stmt)) {
          $userInfo["address"] = $address;
          $userInfo["homePhone"] = $homePhone;
          $userInfo["school"] = $school;
          $userInfo["email"] = $email;
          $userInfo["doctorName"] = $doctorName;
          $userInfo["doctorPhone"] = $doctorPhone;
          $userInfo["medicalCenter"] = $medicalCenter;
          $userInfo["motherName"] = $motherName;
          $userInfo["motherWorkplace"] = $motherWorkplace;
          $userInfo["motherWorkPhone"] = $motherWorkPhone;
          $userInfo["motherMobile"] = $motherMobile;
          $userInfo["fatherName"] = $fatherName;
          $userInfo["fatherWorkplace"] = $fatherWorkplace;
          $userInfo["fatherWorkPhone"] = $fatherWorkPhone;
          $userInfo["fatherMobile"] = $fatherMobile;
          return $userInfo;
        }
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
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
      <?php
        if ($_SESSION["isAdmin"]) {
          echo '<ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                  </li>
                </ul>';
        }
      ?>
    </nav>
    <div class="container mainWindow">
      <?php $userInfo = getUserInformation() ?>
      <h2>Personal Information</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" class="form-control" value="<?php echo($userInfo["address"]) ?>">
        </div>
        <div class="form-group">
          <label>Home Phone</label>
          <input type="text" name="homePhone" class="form-control" value="<?php echo($userInfo["homePhone"]) ?>">
        </div>
        <div class="form-group">
          <label>School</label>
          <input type="text" name="school" class="form-control" value="<?php echo($userInfo["school"]) ?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="<?php echo($userInfo["email"]) ?>">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Doctor</span>
          </div>
          <input type="text" name="doctorName" class="form-control" value="<?php echo($userInfo["doctorName"]) ?>">
          <input type="text" name="doctorPhone" class="form-control" value="<?php echo($userInfo["doctorPhone"]) ?>">
          <input type="text" name="medicalCenter" class="form-control" value="<?php echo($userInfo["medicalCenter"]) ?>">
        </div>
        <h2>Contact Information</h2>
        <h5>Parent/Caregiver Information</h5>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Mother/Caregiver</span>
          </div>
          <input type="text" name="motherName" class="form-control"value="<?php echo($userInfo["motherName"]) ?>">
          <input type="text" name="motherWorkplace" class="form-control" value="<?php echo($userInfo["motherWorkplace"]) ?>">
          <input type="text" name="motherWorkPhone" class="form-control" value="<?php echo($userInfo["motherWorkPhone"]) ?>">
          <input type="text" name="motherMobile" class="form-control" value="<?php echo($userInfo["motherMobile"]) ?>">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Father/Caregiver</span>
          </div>
          <input type="text" name="fatherName" class="form-control" value="<?php echo($userInfo["fatherName"]) ?>">
          <input type="text" name="fatherWorkplace" class="form-control" value="<?php echo($userInfo["fatherWorkplace"]) ?>">
          <input type="text" name="fatherWorkPhone" class="form-control" value="<?php echo($userInfo["fatherWorkPhone"]) ?>">
          <input type="text" name="fatherMobile" class="form-control" value="<?php echo($userInfo["fatherMobile"]) ?>">
        </div>
        <h5>Emergency Contact Information</h5>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Save">
        </div>
      </form>
    </div>
  </body>
</html>
