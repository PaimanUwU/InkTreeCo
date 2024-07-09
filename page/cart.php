<?php
$pageTitle = "Cart";
$showSidebar = true;
$showNavBar = true;
$showFooter = true;
$contentFlexDirection = "row";
$contentPadding = "3em";

$currentPage = "cart.php";

if (!file_exists('session_Maker.php')) {
    require '../session_Maker.php';
} else {
    require 'session_Maker.php';
}

require '../php/db_connection.php';

$query = "SELECT * FROM customer WHERE customer_id = " . $_SESSION['id'] . ";";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$customerCart = $row['CUSTOMER_CART'];

$customerCart = json_decode($customerCart, true);

//array size
$cartSize = count($customerCart);

$totalPrice = 0.0;

ob_start();

$loopIndex = 0;
foreach ($customerCart as $i) {
    $query = "SELECT * FROM product WHERE product_id = " . $i . ";";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $productName = $row['PRODUCT_NAME'];
    $productPrice = $row['PRODUCT_PRICE'];
    $productImage = $row['PRODUCT_IMAGE'];

    $totalPrice = $totalPrice + $productPrice;
?>
<div class="productContainer">
    <div class="productDetailContainer">
        <div class="productImageContainer">
            <img src="<?php echo $productImage; ?>" alt="">
        </div>
        <div class="productInfoContainer">
            <h3 class="productName"><?php echo $productName; ?></h3>
            <h3 class="productPrice"><?php echo $productPrice; ?></h3>
        </div>
    </div>
    <a href="../php/removeProductFromCart.php?index=<?php echo $loopIndex; ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></a href="../php/removeProductFromCart.php?id=">
</div>
<?php
    $loopIndex = $loopIndex + 1;
}

$cartProductListing = ob_get_clean();


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $isProceedPayment = true;

    if (!isset($_POST['paymentMethod'])) {
        echo "<script>alert('Please select a payment method.')</script>";
        $isProceedPayment = false;
    }

    //check if other field is empty
    if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['postcode']) || empty($_POST['country'])) {
        echo "<script>alert('Please fill in all the required fields.')</script>";
        $isProceedPayment = false;
    }

    if ($isProceedPayment) {
        $paymentMethod = trim($_POST['paymentMethod']);
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $postalCode = trim($_POST['postcode']);
        $country = trim($_POST['country']);

        // unique identfier for transaction referential number
        // date.time.productid.customerid
        $transactionRefNum = date("Y.m.d.H.i.s") . $cartSize . $_SESSION['id'];

        foreach ($customerCart as $i) {
            $query = "SELECT * FROM product WHERE product_id = " . $i . ";";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $productPurchaseName = $row['PRODUCT_NAME'];

            // unique identifire for purchase track number
            // date.time.productid.customerid.transactionreferentialnumber
            $productPurTrackNum = date("Y.m.d.H.i.s") . $i . $_SESSION['id'] . $transactionRefNum;

            // purchase table : PURCHASE_ID 	PURCHASE_TRACK_NUM 	PRODUCT_ID 	TRANSACTION_REFERENTIAL_NUM 	
            $query = "INSERT INTO purchase (PURCHASE_TRACK_NUM, PRODUCT_ID, TRANSACTION_REFERENTIAL_NUM) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "sii", $productPurTrackNum, $i, $transactionRefNum);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // customerpurchase table :  	CUSTOMER_ID 	PURCHASE_ID 	CUSTOMERPURCHASE_DETAILS 	
            $query = "INSERT INTO customerpurchase (CUSTOMER_ID, CUSTOMERPURCHASE_DETAILS) VALUES (?, ?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "is", $_SESSION['id'], $productPurchaseName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Store purchase details as JSON
        $purchaseDetail = json_encode([
            'lastName' => $lastName,
            'firstName' => $firstName,
            'email' => $email,
            'phone' => $phoneNumber,
            'address' => $address,
            'postalCode' => $postalCode,
            'country' => $country
        ]);

        $transactionDate = date("Y-m-d");

        // transaction table : TRANSACTION_REFERENTIAL_NUM (primary key), TRANSACTION_TYPE, TRANSACTION_DATE, TRANSACTION_AMOUNT, TRANSACTION_DETAIL, CUSTOMER_ID 	
        $query = "INSERT INTO transaction (TRANSACTION_REFERENTIAL_NUM, TRANSACTION_TYPE, TRANSACTION_DATE, TRANSACTION_AMOUNT, TRANSACTION_DETAIL, CUSTOMER_ID) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $transactionRefNum, $paymentMethod, $transactionDate, $totalPrice, $purchaseDetail, $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // empty cart
        $customerCart = [];
        $customerCart = json_encode($customerCart);

        $query = "UPDATE customer SET CUSTOMER_CART = ? WHERE customer_id = " . $_SESSION['id'] . ";";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $customerCart);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<script>alert('Payment successful.')</script>";
    } else {
        echo "<script>alert('Payment failed.')</script>";
    }

    // refresh page
    header("Refresh:0");
}




ob_start();

?>
<!--------------------------------------------CSS-------------------------------------------->
<link rel="stylesheet" href="../css/cart.css">

<?php
$pageCSS = ob_get_clean();

ob_start();
?>
<!------------------------------------------Content------------------------------------------>
<div class="sectionControlled" style="max-width: 30vw;">
    <div class="paymentContainer">
        <div class="line"></div>
        <div class="cartSizeContainer">
            <h3>item: </h3>
            <h2><?php echo $cartSize; ?></h2>
        </div>
        <div class="line"></div>
        <div class="totalPriceContainer">
            <h3>Total price: </h3>
            <h2>RM<?php echo $totalPrice; ?></h2>
        </div>
        <form class="paymentForm" action="cart.php" method="post">
            <div class="paymentMethodContainer">
                <h3>Payment method: </h3>
                <select name="paymentMethod" id="paymentMethod" class="paymentMethod">
                    <option value="" disabled selected>Select payment method</option>
                    <option value="TnG E-Wallet">TnG E-Wallet</option>
                    <option value="Credit">Credit</option>
                    <option value="Debit">Debit</option>
                </select>
            </div>
            <div class="paymentDetailContainer">
                <h3>Payment detial: </h3>
                <div class="paymentDetailName">
                    <input class="inputBox" type="text" name="firstName" placeholder="First Name">
                    <input class="inputBox" type="text" name="lastName" placeholder="Last Name">
                </div>
                <input class="inputBox" type="email" name="email" placeholder="Email">
                <input class="inputBox" type="text" name="phone" placeholder="Phone Number">
                <input class="inputBox" type="text" name="address" placeholder="Address">
                <div class="paymentDetailBottomAddress">
                    <input class="inputBox" type="text" name="country" placeholder="Country">
                    <input class="inputBox" type="text" name="postcode" placeholder="Postcode">
                </div>
            </div>
            <input type="submit" value="Checkout" class="paymentSubmitButton">
        </form>
    </div>
</div>
<!--discover-->
<div class="sectionControlled">
    <div class="sectionControlledContent" style="width: 100%;">    
        <div class="headerContainer"><h2>Shopping cart</h2></div>
        <div class="productListContainer">
            <?php echo $cartProductListing; ?>
        </div>
    </div>
</div>

<?php
$pageContents = ob_get_clean();

ob_start();
?>

<!------------------------------------------Script------------------------------------------->
<script>
    // ask for confimation before going to checkout, if yes then precced to checkout
    

</script>

<?php
$pageScript = ob_get_clean();

include '../layout/layout.php';
?>