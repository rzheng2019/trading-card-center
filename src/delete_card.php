<?php
require_once ('database.php');

$card_id = filter_input(INPUT_POST, 'card_id');
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$card_price = filter_input(INPUT_POST, 'card_price');
$card_quantity = filter_input(INPUT_POST, 'card_quantity');
$delete_status = filter_input(INPUT_POST, 'delete_status');
$delete_error_msg = "";

if ($delete_status == "Delete Card") {
    $query = 'DELETE FROM cards
              WHERE cardID = :card_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':card_id', $card_id);
    $success = $statement->execute();
    $statement->closeCursor();
    $delete_error_msg = "";
    include ('admin.php');
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
                <form action="modify_card.php" method="post">
                    <p>Title</p>
                    <input type="hidden"
                           name="card_id"
                           value="<?php echo $card_id ?>">
                    <input type="text"
                           name="card_name"
                           value="<?php echo $card_name ?>"
                           class="order-field">
                    <p>Description</p>
                    <input type="text"
                           name="card_description"
                           value="<?php echo $card_description ?>"
                           class="order-field">
                    <p>Price</p>
                    <input step="any"
                           type="number"
                           name="card_price"
                           value="<?php echo number_format((float) $card_price, 2, '.', ',')?>"
                           class="order-field">
                    <p>Quantity</p>
                    <input step="any"
                           type="number"
                           name="card_quantity"
                           value="<?php echo $card_quantity ?>"
                           class="order-field">
                    <div class="buttons">
                        <input type="submit"
                               value="Modify"
                               class="modify-btn">
                        <p>To delete, please type 'Delete Card' below and click delete button.</p>
                    </div>
                </form>
                <form action="delete_card.php" method="post">
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
                           name="card_price"
                           value="<?php echo number_format((float) $card_price, 2, '.', ',')?>"
                           class="order-field">
                    <input step="any"
                           type="hidden"
                           name="card_quantity"
                           value="<?php echo $card_quantity ?>"
                           class="order-field">
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