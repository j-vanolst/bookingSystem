<?php
  require_once "conf.php";
  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = htmlspecialchars(trim($_POST["type"]));
    $childID = htmlspecialchars(trim($_POST["childID"]));

    if (isset($_POST["firstName"], $_POST["lastName"], $_POST["birthdate"], $_POST["gender"], $_POST["allergies"])) {
      $firstName = htmlspecialchars(trim($_POST["firstName"]));
      $lastName = htmlspecialchars(trim($_POST["lastName"]));
      $birthdate = htmlspecialchars(trim($_POST["birthdate"]));
      $gender = htmlspecialchars(trim($_POST["gender"]));
      $allergies = htmlspecialchars(trim($_POST["allergies"]));

      if ($type === "edit") {
        editChild($childID, $firstName, $lastName, $birthdate, $gender, $allergies);
      }
    }
    else {
      echo "Not set";
    }

    if ($type === "delete") {
      deleteChild($childID);
    }

  }

  function deleteChild($childID) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "DELETE FROM Child where childID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $childID);
      if (mysqli_stmt_execute($stmt)) {
        echo "Child deleted";
      }
      else {
        echo "Execution Failed";
      }
    }
    else {
      echo "Preparing stmt failed";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
  }

  function editChild($childID, $firstName, $lastName, $birthdate, $gender, $allergies) {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "UPDATE Child SET
    firstName = ?,
    lastName = ?,
    birthdate = ?,
    gender = ?,
    allergies = ?
    WHERE childID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "sssssi", $firstName, $lastName, $birthdate, $gender, $allergies, $childID);
      if (mysqli_stmt_execute($stmt)) {
        echo "Child updated";
      }
      else {
        echo "Execution Failed";
      }
    }
    else {
      echo "Prepating stmt failed";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
  }
?>
