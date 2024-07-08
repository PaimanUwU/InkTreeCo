<?php
$pageTitle = "Home";
$showSidebar = true;
$showNavBar = true;
$showFooter = true;
$contentFlexDirection = "row";
$contentPadding = "10em";

$currentPage = "home.php";

if (!file_exists('session_Maker.php')) {
    require '../session_Maker.php';
} else {
    require 'session_Maker.php';
}

$productArray[] = 1;
$productArray[] = 21;
$productArray[] = 13;

// integrate with data inside a database
// for month, month today with 6 month before is calculated
$currentMonth = date("F");
$last6Month = [];


$arrayMonth = ["January", "February", "March", "April", "May", "June", "July"];
$arrayTreePlanted = [65, 59, 80, 81, 56, 55, 40]; 


ob_start();

?>
<!--------------------------------------------CSS-------------------------------------------->
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../assets/card css/productCard.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
$pageCSS = ob_get_clean();

ob_start();
?>
<!------------------------------------------Content------------------------------------------>
<div class="sectionControlled">
    <div class="sectionControlledContent">
        <div class="headerContainer"><h2>Goals</h2></div>
        <!-- graph -->
        <canvas id="myChart"></canvas>
        <hr style="border: 1px solid white; width: 100%;"/>
        <div id="treeHistogram">
            <!-- should be a php script where it count the total of trees planted overall -->
            <h3>Total of trees planted: <?php echo count($arrayTreePlanted); ?></h3>
            <div class="treeHistogramContainer">
                <?php ?>
            </div>
        </div>

    </div>
    <div class="sectionControlledContent">
        <div class="headerContainer"><h2>Contributions</h2></div>
        <div style="height: 50em; background-color: white;">

        </div>
    </div>
</div>
<!--discover-->
<div class="sectionControlled">
    <div class="sectionControlledContent">    
        <div class="headerContainer"><h2>Promotions</h2></div>
        
        <?php 
        include '../php/productCard_Display.php';
        ?>
    </div>
</div>

<?php
$pageContents = ob_get_clean();

ob_start();
?>

<!------------------------------------------Script-------------------------------------------->

<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($arrayMonth); ?>,
        datasets: [{
            label: 'Tree planted',
            data: <?php echo json_encode($arrayTreePlanted); ?>,
            fill: true,
            borderColor: 'rgb(215, 229, 202)',
            backgroundColor: 'rgba(215, 229, 202, 0.5)',
            tension: 0.5
        }]
    }
});
</script>

<?php
$pageScript = ob_get_clean();

include '../layout/layout.php';
?>