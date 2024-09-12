<?php
require_once ('database.php');

// Get all orders in mySQL card_db database
$query = 'SELECT * FROM orders 
           ORDER BY orderID';
$statement = $db->prepare($query);
$statement->execute();
$orders_list = $statement->fetchAll();
$statement->closeCursor();

// Get all cards in mySQL card_db database
$query2 = 'SELECT * FROM cards 
          ORDER BY name';
$statement2 = $db->prepare($query2);
$statement2->execute();
$card_list = $statement2->fetchAll();
$statement2->closeCursor();

$order_id = filter_input(INPUT_POST, 'order_id');
$customerID_status = filter_input(INPUT_POST, 'customerID_status');
$card_id = filter_input(INPUT_POST, 'card_id');
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$total_price = filter_input(INPUT_POST, 'total_price');
$ordered_amount = filter_input(INPUT_POST, 'ordered_amount');

$total_price_error = "";
$ordered_amount_error = "";
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
            <a href="admin.php">Admin Card Center</a>
        </div>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="index.php">Switch User</a></li>
            <li><a href="admin_customer_orders.php">Customer Orders</a></li>
        </ul>
    </nav>
</header>
<div class="search-bar-small-screen">
    <input type="search" placeholder="Enter a card name..." id="search-box">
    <button id="search-button">Search</button>
</div>
<div class="card-content">
    <ul class="cards">
        <li class="card">
            <form action="admin_modify_order.php" method="post">
                <input type="hidden"
                       name="order_id"
                       value="<?php echo $order_id ?>">
                <p>Name</p>
                <input type="hidden"
                       name="customerID_status"
                       value="<?php echo $customerID_status ?>">
                <input type="hidden"
                       name="card_id"
                       value="<?php echo $card_id ?>">
                <input type="text"
                       name="card_name"
                       value="<?php echo $card_name ?>"
                       class="order-field" readonly>
                <p>Description</p>
                <input type="text"
                       name="card_description"
                       value="<?php echo $card_description ?>"
                       class="order-field" readonly>
                <p>Total Price ($)</p>
                <input type="number"
                       name="total_price"
                       value="<?php echo $total_price ?>"
                       class="order-field" readonly>
                <input type="hidden"
                       name="total_price_original"
                       value="<?php echo $total_price ?>"
                       class="order-field" readonly>
                <p>Ordered Amount</p>
                <input step="any"
                       type="number"
                       name="ordered_amount"
                       value="<?php echo $ordered_amount ?>"
                       class="order-field">
                <input step="any"
                       type="hidden"
                       name="ordered_amount_original"
                       value="<?php echo $ordered_amount ?>"
                       class="order-field">
                <div class="buttons">
                    <input type="submit"
                           value="Modify"
                           class="modify-btn">
                    <p>To delete, please type 'Delete Card' below and click delete button.</p>
                </div>
            </form>
            <form action="admin_delete_order.php" method="post">
                <input type="hidden"
                       name="order_id"
                       value="<?php echo $order_id ?>">
                <input type="hidden"
                       name="customerID_status"
                       value="<?php echo $customerID_status ?>">
                <input type="hidden"
                       name="card_id"
                       value="<?php echo $card_id ?>">
                <input type="hidden"
                       name="card_name"
                       value="<?php echo $card_name ?>"
                       class="order-field">
                <input type="hidden"
                       name="card_description"
                       value="<?php echo $card_description ?>"
                       class="order-field">
                <input step="any"
                       type="hidden"
                       name="total_price"
                       value="<?php echo $total_price ?>"
                       class="order-field">
                <input step="any"
                       type="hidden"
                       name="ordered_amount"
                       value="<?php echo $ordered_amount ?>"
                       class="order-field">
                <input step="any"
                       type="hidden"
                       name="ordered_amount_original"
                       value="<?php echo $ordered_amount ?>"
                       class="order-field">
                <input type="text" name="delete_status" value="" class="order-field">
                <input type="submit" value="Delete" class="delete-btn">
            </form>
        </li>
    </ul>
</div>
</body>

</html>