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
</body>

</html>