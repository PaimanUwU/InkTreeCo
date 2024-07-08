<?php
$pageTitle = "Register";
$showSidebar = false;
$showNavBar = false;
$showFooter = false;
$contentFlexDirection = "column";

$redirect = $_GET['redirect'];
$currentPage = $_GET['currentPage'];

if (!file_exists('session_Maker.php')) {
    require '../session_Maker.php';
} else {
    require 'session_Maker.php';
}

require 'php/db_connection.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

ob_start();

?>
<!--------------------------------------------CSS-------------------------------------------->
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="stylesheet" type="text/css" href="css/default.css">

<?php
$pageCSS = ob_get_clean();

ob_start();
?>
<!------------------------------------------Content------------------------------------------>
<div class="container">
    <form action="register.php?redirect=<?php echo $redirect; ?>&currentPage=<?php echo $currentPage; ?>" method="post">
        <div class="formContainer">
            <div class="formInnerContaier">
                <h1>Register</h1>
                <p>Enter your email and password to register.</p>
            </div>
            <div class="formInnerContaier">
                <div class="inputContainer">
                    <input class="formInputBox" type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="inputContainer">
                    <input class="formInputBox" type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="inputContainer">
                    <input class="formInputBox" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                </div>
            </div>
            <p>Already have an account? <a href="login.php?redirect=<?php echo $redirect;?>&currentPage=<?php echo $currentPage;?>">Login</a></p>
        </div>
        <input class="formSubmitButton" type="submit" value="Register">
    </form>
    <div class="backButton"><a href="index.php?redirect=goback&currentPage=<?php echo $currentPage;?>""><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="m252-176-74-76 227-228-227-230 74-76 229 230 227-230 74 76-227 230 227 228-74 76-227-230-229 230Z"/></svg><h3>Go Back</h3></a></div>
</div>

<?php
$pageContents = ob_get_clean();

ob_start();
?>

<!------------------------------------------Script---------------------------------------------->


<?php
$pageScript = ob_get_clean();

include 'layout/layout.php';
?>