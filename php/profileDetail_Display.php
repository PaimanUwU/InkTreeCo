<?php
require 'db_connection.php';

if (isset($_SESSION["id"])) {
    $query = "SELECT * FROM customer WHERE customer_id =" . $_SESSION["id"] . ";";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    $name = $row['CUSTOMER_NAME'];
    $email = $row['CUSTOMER_EMAIL'];
    $phone = $row['CUSTOMER_PHONE'];
    $address = $row['CUSTOMER_ADDRESS'];
     
    
// $customerId = 1;


ob_start();
?>

<div class="profileBoxControlled">
    <div class="profileBox">
        <h1>Profile</h1>
    </div>
    <form class="profileDetail" action="../php/profileDetail_Update.php?id=<?php echo $_SESSION["id"]; ?>&currentPage=<?php echo $currentPage; ?>" method="POST">
        <div class="profileDetailName inputField">
            <h3>Name</h3>
            <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Enter your name">
        </div>
        <div class="profileDetailEmail inputField">
            <h3>Email</h3>
            <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
        </div>
        <div class="profileDetailPhone inputField">
            <h3>Phone Number</h3>
            <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Enter your email">
        </div>
        <div class="profileDetailAddress inputField">
            <h3>Address</h3>
            <textArea type="text" name="address" placeholder="Enter your address"><?php echo $address; ?></textArea>
        </div>    
        <button class="profileDetailSubmit button" type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></button>
    </form>
    <div class="profileAction">
        <a href="../logout.php" class="button buttonFlex"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg><h3>Logout</h3></a>
        <a href="../resetPassword.php" class="button buttonFlex"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="M520-120q-74 0-138.5-27.5T268-223l57-57q38 37 88 58.5T520-200q116 0 198-82t82-198q0-116-82-198t-198-82q-116 0-198 82t-82 198v7l73-73 57 56-170 170L30-490l57-56 73 74v-8q0-75 28.5-140.5t77-114q48.5-48.5 114-77T520-840q75 0 140.5 28.5t114 77q48.5 48.5 77 114T880-480q0 150-105 255T520-120Zm-80-200q-17 0-28.5-11.5T400-360v-120q0-17 11.5-28.5T440-520v-40q0-33 23.5-56.5T520-640q33 0 56.5 23.5T600-560v40q17 0 28.5 11.5T640-480v120q0 17-11.5 28.5T600-320H440Zm40-200h80v-40q0-17-11.5-28.5T520-600q-17 0-28.5 11.5T480-560v40Z"/></svg><h3>Reset Password</h3></a>
    </div>
</div>
<div class="searchContainer" onclick="closeProfile()"></div> 

<?php
$profileContent = "`" . ob_get_clean() . "`";

}

echo $profileContent;
?>