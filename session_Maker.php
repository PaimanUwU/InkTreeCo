<?php
session_start();

// Check if session variables are set
if (isset($_SESSION["id"]) && isset($_SESSION["email"])) {
    // Assign session variables
    $custID = $_SESSION["id"];
    $custEmail = $_SESSION["email"];
    $isLoggedIn = $_SESSION["loggedin"];
} else {
    $custID = null;
    $custEmail = "";
    $isLoggedIn = false;
}
?>