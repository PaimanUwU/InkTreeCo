<?php
$pageTitle = "Home";
$showSidebar = true;
$showNavBar = true;
$showFooter = true;
$contentFlexDirection = "row";

$currentPage = "home.php";

include '../php/session_Maker.php';

ob_start();

?>
<!--------------------------------------------CSS-------------------------------------------->
<link rel="stylesheet" href="../css/home.css">

<?php
$pageCSS = ob_get_clean();

ob_start();
?>
<!------------------------------------------Content------------------------------------------>
<div class="sectionControlled">
    <div class="sectionControlledContent">
        <div class="headerContainer"><h2>Goals</h2></div>

    </div>
    <div class="sectionControlledContent">
        <div class="headerContainer"><h2>Contributions</h2></div>

    </div>
</div>
<!--discover-->
<div class="sectionControlled">
    <div class="sectionControlledContent">    
        <div class="headerContainer"><h2>Promotions</h2></div>
        
    </div>
</div>

<?php
$pageContents = ob_get_clean();

ob_start();
?>

<!------------------------------------------Script---------------------------------------------->


<?php
$pageScript = ob_get_clean();

include '../layout/layout.php';
?>