<?php
require_once('database.php');

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
                    <form action="admin_modify_card_view.php" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $order['orderID'] ?>">
                        <input type="hidden" name="customerID_status" value="<?php echo $customerID_status ?>">
                        <input type="hidden" name="card_id" value="<?php echo $order['cardID'] ?>">
                        <input type="hidden" name="card_name" value="<?php echo $order['name']; ?>">
                        <input type="hidden" name="card_description" value="<?php echo $order['description']; ?>">
                        <input type="hidden" name="ordered_amount" value="<?php echo $order['orderedAmount']; ?>">
                        <input type="hidden" name="total_price" value="<?php echo $order['price']?>"">
                        <input type="submit" value="Modify" class="modify-btn"><br>
                    </form>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>
</body>
</html>