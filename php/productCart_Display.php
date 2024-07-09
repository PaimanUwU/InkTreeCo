<?php
require '../php/db_connection.php';

if (!isset($productArray)) {
    echo "No produts found";
} else {
    foreach ($productArray as $i) {
        $query = "SELECT * FROM product WHERE product_id = $i";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);

        $productName = $row['PRODUCT_NAME'];
        $productPrice = $row['PRODUCT_PRICE'];
        $productImage = $row['PRODUCT_IMAGE'];
        $productLikes = $row['PRODUCT_LIKE'];
        $productId = $row['PRODUCT_ID'];
?>
<div class="productCardContainer">
    <div class="productLeft">
        <img src="<?php echo $productImage; ?>" alt="product image">
    </div>
    <div class="productRight">
        <div class="productDetail">
            <h1><?php echo $productName; ?></h1>
            <h2>RM<?php echo $productPrice; ?></h2>
        </div>
        <div class="productAction">
            <div class="productLike button" style="cursor:pointer;" onclick="likeProduct(<?php echo $productId; ?>)">
                <svg id="likeButton<?php echo $productId; ?>" class="likeButton<?php echo $productId; ?>" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#404040"><path d="m480-131-54-48.5q-99.27-89.57-164.13-154.54Q197-399 158.72-450.4q-38.29-51.4-53.5-94.48Q90-587.96 90-633q0-91.01 61-152 60.99-61 152-61 51.29 0 97.64 22Q447-802 480-761q34.5-41 80-63t97-22q91.01 0 152 61 61 60.99 61 152 0 45.04-15.22 88.12-15.21 43.08-53.5 94.48Q763-399 698.13-334.04 633.27-269.07 534-179.5L480-131Zm0-101q94-85 155-145.5T731.5-483q35.5-45 49.5-80.18 14-35.18 14-69.86 0-59.46-39.36-98.71Q716.28-771 657.25-771q-46.25 0-86 26.5t-56.25 69h-70q-16.5-42.5-56.25-69t-86-26.5q-59.03 0-98.39 39.25T165-633.04q0 34.68 14 69.86T228.5-483Q264-438 325-377.5T480-232Zm0-269.5Z"/></svg>
                <h3 id="likeCount<?php echo $productId; ?>" style="cursor:pointer;"><?php echo $productLikes; ?></h3>
            </div>
            <div class="productAddToCart button" style="cursor:pointer;" onclick="addToCart(<?php echo $productId; ?>)">
                <svg id="cartButton<?php echo $productId; ?>" class="cartButton<?php echo $productId; ?>" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="#404040"><path d="M267.79-106q-28.55 0-48.67-20.33T199-175.21q0-28.55 20.33-48.67T268.21-244q28.55 0 48.67 20.33T337-174.79q0 28.55-20.33 48.67T267.79-106Zm423 0q-28.55 0-48.67-20.33T622-175.21q0-28.55 20.33-48.67T691.21-244q28.55 0 48.67 20.33T760-174.79q0 28.55-20.33 48.67T690.79-106ZM255-695l83 192h296l82-192H255Zm-28.88-67H782.5q14 0 20 10.34t1 21.66L696.13-479.14q-7.63 19.64-24.88 31.39T633-436H319l-43 74h484v67H280.19q-41.86 0-61.77-34.4-19.92-34.41.58-68.6l52-88.78L142.12-789H58v-67h128l40.12 94ZM338-503h296-296Z"/></svg> 
                <h3 style="cursor:pointer;">Add to cart</h3> 
            </div>
        </div>
    </div>
    <style>
        .likeButton<?php echo $productId; ?>.inflate-animation {
            animation: inflate 1s infinite;
            animation-iteration-count: 1;
        }

        .cartButton<?php echo $productId; ?>.bounce-animation {
    /* shake animation */
            animation: bounce 1s infinite;
            animation-iteration-count: 1;
        }
    </style>
</div>
<?php
    }
}
?>