<?php
require_once('database.php');

// Get all cards in mySQL card_db database
$query = 'SELECT * FROM orders 
           ORDER BY orderID';
$statement = $db->prepare($query);
$statement->execute();
$orders_list = $statement->fetchAll();
$statement->closeCursor();

// Get all cards in mySQL card_db database
$query2 = 'SELECT * FROM cart 
           ORDER BY cartID';
$statement2 = $db->prepare($query2);
$statement2->execute();
$cart_list = $statement2->fetchAll();
$statement2->closeCursor();

$customerID_status = filter_input(INPUT_POST, 'customerID_status');
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
<div class="add-card-content">
    <form action="retrieve_customer_orders.php" method="post">
        <div class="confirm-order-content">
            <p>Please enter a Customer ID to search orders below:</p>
            <input type="text" name="customerID_status" value="" class="order-field">
            <input type="submit" value="Search" class="confirm-purchase-btn"><br>
        </div>
    </form>
</div>
<div class="card-content">
    <?php
    $customerOrderAmount = 0;
    $totalPrice = 0.00;
    foreach ($orders_list as $order) {
        if ($customerID_status == $order['customerID']) {
            $customerOrderAmount += 1;
            $totalPrice += $order['price'];
        }
    }
    ?>
    <p>Results for Customer ID: <?php echo "<b>" . $customerID_status . "</b>"?></p>
    <p> <?php echo "Total: $" . number_format((float) $totalPrice, 2, '.', ',') ?> </p>
    <br>
    <p>Showing <?php echo $customerOrderAmount?> out of <?php echo $customerOrderAmount?> orders</p>
    <ul class="cards">
<?php
foreach ($orders_list as $order) {
    if ($customerID_status == $order['customerID']) {?>
        <li class="card">
            <p class="card-title"><?php echo $order['name'] ?></p>
            <p><?php echo $order['description'] ?></p>
            <p><?php echo "Purchase Amount: " . $order['orderedAmount'] ?></p>
            <p><?php echo "Total: $" . number_format((float) $order['price'], 2, '.', ',') ?></p>
        </li>
<?php
    }
}
?>
    </ul>
</div>
</body>
</html>