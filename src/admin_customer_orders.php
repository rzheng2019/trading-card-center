<?php
require_once('database.php');

// Get all cards in mySQL card_db database
$query = 'SELECT * FROM orders 
           ORDER BY orderID';
$statement = $db->prepare($query);
$statement->execute();
$orders_list = $statement->fetchAll();
$statement->closeCursor();
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
            <li><a href="admin_customer_orders.php"> Customer Orders</a></li>
        </ul>
    </nav>
</header>
<div class="customer-list">
    <table class="customer-table">
        <tr class="customer-table-row">
            <td class="customer-table-data">customerID</td>
            <td class="customer-table-data">Amount of Orders</td>
            <td class="customer-table-data">Modify</td>
        </tr>
        <?php
            // Map that holds customers and their amount of orders
            $customerStorage = array();

            foreach ($orders_list as $order) {
                if (!array_key_exists($order['customerID'], $customerStorage)) {
                    $customerStorage[$order['customerID']] = 1;
                }
                else {
                    $customerStorage[$order['customerID']] += 1;
                }
            }
        ?>
        <?php
            foreach ($customerStorage as $customerID => $ordersAmount) {?>
                <form action="admin_edit_customer_order.php" method="post">
                    <tr class="customer-table-row">
                        <td class="customer-table-data"><?php echo $customerID ?></td>
                        <td class="customer-table-data"><?php echo $ordersAmount ?></td>
                        <td class="customer-table-data">
                            <input type="hidden" name="customerID_status" value="<?php echo $customerID ?>" class="order-field">
                            <input type="submit" value="Edit" class="modify-btn"><br>
                        </td>
                    </tr>
                </form>
        <?php
            }
        ?>
    </table>
</div>
</body>
</html>
