<?php
$pageTitle = "Store";
$showSidebar = true;
$showNavBar = true;
$showFooter = true;
$contentFlexDirection = "row";
$contentPadding = "2em";

$currentPage = "store.php";

if (!file_exists('session_Maker.php')) {
    require '../session_Maker.php';
} else {
    require 'session_Maker.php';
}

if (isset($_GET['view'])) {
    $view = $_GET['view'];
} else {
    $view = "stationary";
}

ob_start();

?>
<!--------------------------------------------CSS-------------------------------------------->
<link rel="stylesheet" href="../css/store.css">
<link rel="stylesheet" href="../assets/card css/productCard.css">

<?php
$pageCSS = ob_get_clean();

ob_start();
?>
<!------------------------------------------Content------------------------------------------>
<div class="storeNavigation">
    <a href="store.php?view=stationary"><div class="viewLine" id="stationaryLine" style="height:100%;"></div><h3 id="stationaryH3">Stationaries</h3></a>
    <a href="store.php?view=accessory"><div class="viewLine" id="accessoryLine" style="height:100%;"></div><h3 id="accessoryH3">Accessories</h3></a>
    <a href="store.php?view=life"><div class="viewLine" id="lifeLine" style="height:100%;"></div><h3 id="lifeH3">Lifestyles</h3></a>
    <a href="store.php?view=jewel"><div class="viewLine" id="jewelLine" style="height:100%;"></div><h3 id="jewelH3">Jewelries</h3></a>
    <a href="store.php?view=pet"><div class="viewLine" id="petLine" style="height:100%;"></div><h3 id="petH3">Pet's Accessories</h3></a>
    <a href="store.php?view=plush"><div class="viewLine" id="plushLine" style="height:100%;"></div><h3 id="plushH3">Plushies</h3></a>  

    <style>
        #<?php echo $view; ?>Line {
            border-left:2px solid #404040;
        }

        #<?php echo $view; ?>H3 {
            background-color: #fff6b5;
        }
    </style>
</div>
<!--discover-->
<div class="sectionControlled">
    <div class="sectionControlledContent contentGrid">    
        <?php include '../storeView/' . $view . '.php'?>
    </div>
</div>

<?php
$pageContents = ob_get_clean();

ob_start();
?>

<!------------------------------------------Script------------------------------------------->


<?php
$pageScript = ob_get_clean();

include '../layout/layout.php';
?>