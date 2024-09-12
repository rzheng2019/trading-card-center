<?php
require_once 'database.php';

// Get all cards in mySQL card_db database
$query2 = 'SELECT * FROM cart 
           ORDER BY cartID';
$statement2 = $db->prepare($query2);
$statement2->execute();
$cart_list = $statement2->fetchAll();
$statement2->closeCursor();

$customerID_error = "";

$customerID_status = filter_input(INPUT_POST, 'customerID_status');

if ($customerID_status == null || $customerID_status == "" || count($cart_list) < 1) {
    if ($customerID_status == "") {
        $customerID_error = "Customer ID is required";
    }
    else if (count($cart_list) < 1) {
        $customerID_error = "There are no items in your cart.";
    }
    else {
        $customerID_error = "Customer ID is required";
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Trading Card Center</title>
        <link rel="stylesheet" href="./main.css" type="text/css">
    </head>

    <body>
    <header>
        <div class="logo">
            <div>
                <a href="customer.php">Customer Card Center</a>
            </div>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Switch User</a></li>
                <li><a href="customer_orders.php">Orders</a></li>
                <li><a href="cart.php">Cart (<?php echo count($cart_list) ?>)</a></li>
            </ul>
        </nav>
    </header>
    <div class="card-content">
        <p>Showing <?php echo count($cart_list)?> out of <?php echo count($cart_list)?> cards</p>
        <ul class="cards">
            <?php foreach ($cart_list as $cart_item) : ?>
                <li class="card">
                    <p class="card-title"><?php echo $cart_item['name'] ?></p>
                    <p><?php echo $cart_item['description'] ?></p>
                    <p><?php echo "$" . number_format((float) $cart_item['price'], 2, '.', ',') ?></p>
                    <p><?php echo "Available Quantity: " . $cart_item['quantity'] ?></p>
                    <p><?php echo "Purchase Amount: " . $cart_item['purchaseAmount'] ?></p>
                    <form action="remove_cart_item.php" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $cart_item['cartID'] ?>">
                        <input type="submit" value="Remove" class="delete-btn">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="add-card-content">
        <form action="create_order.php" method="post">
            <div class="confirm-order-content">
                <input type="hidden" name="card_id" value="<?php echo $cart_item['cardID'] ?>">
                <input type="hidden" name="card_name" value="<?php echo $cart_item['name']; ?>">
                <input type="hidden" name="card_description" value="<?php echo $cart_item['description']; ?>">
                <input type="hidden" name="card_price" value="<?php echo $cart_item['price']; ?>">
                <input type="hidden" name="card_quantity" value="<?php echo $cart_item['quantity']; ?>">
                <p style="color: red">
                    <?php
                    if ($customerID_error != "") {
                        echo $customerID_error;
                    }
                    ?>
                </p>
                <p>Please enter a Customer ID below:</p>
                <input type="text" name="customerID_status" value="" class="order-field">
                <input type="submit" value="Confirm Purchase" class="confirm-purchase-btn"><br>
            </div>
        </form>
    </div>
    </body>

    </html>

<?php
}
else {
    $customerID_error = "";
    include ("orders.php");
}
?>