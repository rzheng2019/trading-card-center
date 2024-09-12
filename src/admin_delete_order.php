<?php
require_once ('database.php');

$order_id = filter_input(INPUT_POST, 'order_id');
$customerID_status = filter_input(INPUT_POST, 'customerID_status');
$card_id = filter_input(INPUT_POST, 'card_id');
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$total_price = filter_input(INPUT_POST, 'total_price');
$total_price_original = filter_input(INPUT_POST, 'total_price_original');
$ordered_amount = filter_input(INPUT_POST, 'ordered_amount');
$ordered_amount_original = filter_input(INPUT_POST, 'ordered_amount_original');
$delete_status = filter_input(INPUT_POST, 'delete_status');
$delete_error_msg = "";

if ($delete_status == "Delete Card") {
    $query = 'DELETE FROM orders
              WHERE orderID = :order_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':order_id', $order_id);
    $success = $statement->execute();
    $statement->closeCursor();
    $delete_error_msg = "";

    // Get all cards in mySQL card_db database
    $query2 = 'SELECT * FROM cards
              ORDER BY name';
    $statement2 = $db->prepare($query2);
    $statement2->execute();
    $card_list = $statement2->fetchAll();
    $statement2->closeCursor();

    $currentQuantity = 0;
    $newQuantity = 0;

    foreach ($card_list as $card) {
        if ($card['cardID'] == $card_id) {
            $currentQuantity = $card['quantity'];
        }
    }

//    echo "Original Ordered Amount:" . $ordered_amount_original;
//    echo "Ordered Amount:" . $ordered_amount_original;

    if ($ordered_amount > 0) {
        $newQuantity = $currentQuantity + $ordered_amount;
    }
    else {
        $newQuantity = $currentQuantity + $ordered_amount_original;
    }

    // Update card quantity in cards
    $query3 = "UPDATE cards
          SET quantity=$newQuantity
          WHERE cardID=$card_id";
    $statement3 = $db->prepare($query3);
    $statement3->execute();
    $statement3->closeCursor();

    include ('admin_edit_customer_order.php');
}
else {
$delete_error_msg = 'Error deleting record. Please enter "Delete Card" above.';?>

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
                    <input step="any"
                           type="number"
                           name="total_price"
                           value="<?php echo $total_price ?>"
                           class="order-field" readonly>
                    <input type="hidden"
                           name="total_price_original"
                           value="<?php echo $total_price_original ?>">
                    <p>Ordered Amount</p>
                    <input step="any"
                           type="number"
                           name="ordered_amount"
                           value="<?php echo $ordered_amount ?>"
                           class="order-field">
                    <input type="hidden"
                           name="ordered_amount_original"
                           value="<?php echo $ordered_amount_original ?>">
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
                    <input type="hidden"
                           name="total_price_original"
                           value="<?php echo $total_price_original ?>">
                    <input step="any"
                           type="hidden"
                           name="ordered_amount"
                           value="<?php echo $ordered_amount ?>"
                           class="order-field">
                    <input type="hidden"
                           name="ordered_amount_original"
                           value="<?php echo $ordered_amount_original ?>">
                    <p style="color: red">
                        <?php
                        if ($delete_error_msg != "") {
                            echo $delete_error_msg;
                        }
                        ?>
                    </p>
                    <input type="text" name="delete_status" value="" class="order-field">
                    <input type="submit" value="Delete" class="delete-btn">
                </form>
            </li>
        </ul>
    </div>
    </body>

    </html>

<?php
}
    ?>