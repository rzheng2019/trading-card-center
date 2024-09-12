<?php
require_once ('database.php');

$card_id = filter_input(INPUT_POST, 'card_id');
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$card_price = filter_input(INPUT_POST, 'card_price');
$card_quantity = filter_input(INPUT_POST, 'card_quantity');

$card_name_error = "";
$card_description_error = "";
$card_price_error = "";
$card_quantity_error = "";
$delete_error_msg = "";

if ($card_name == null
    || $card_description == null
    || $card_price == null
    || $card_price <= 0
    || $card_quantity == null
    || $card_quantity <= 0) {
    $delete_error_msg = 'Error deleting record. Please enter "Delete Card" above.';
    $card_name_error = "Please enter a valid card name";
    $card_description_error = "Please enter a valid card description";
    $card_price_error = "Please enter a valid card price";
    $card_quantity_error = "Please enter a valid card quantity";
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
                <form action="modify_card.php" method="post">
                    <p>Name</p>
                    <p style="color: red">
                        <?php
                        if ($card_name_error != "" && $card_name == null) {
                            echo $card_name_error;
                        }
                        ?>
                    </p>
                    <input type="hidden"
                           name="card_id"
                           value="<?php echo $card_id ?>">
                    <input type="text"
                           name="card_name"
                           value="<?php echo $card_name ?>"
                           class="order-field">
                    <p>Description</p>
                    <p style="color: red">
                        <?php
                        if ($card_description_error != "" && $card_description == null) {
                            echo $card_description_error;
                        }
                        ?>
                    </p>
                    <input type="text"
                           name="card_description"
                           value="<?php echo $card_description ?>"
                           class="order-field">
                    <p>Price</p>
                    <p style="color: red">
                        <?php
                        if ($card_price_error != "" && $card_price == null) {
                            echo $card_price_error;
                        }
                        else if ($card_price <= 0) {
                            echo $card_price_error;
                        }
                        ?>
                    </p>
                    <input step="any"
                           type="number"
                           name="card_price"
                           value="<?php
                           if ($card_price_error != "" && $card_price == null) {
                                echo $card_price;
                           }
                           else {
                                echo number_format((float) $card_price,
                                    2,
                                    '.',
                                    ',');
                           }
                           ?>"
                           class="order-field">
                    <p>Quantity</p>
                    <p style="color: red">
                        <?php
                        if ($card_quantity_error != "" && $card_quantity == null) {
                            echo $card_quantity_error;
                        }
                        else if ($card_quantity <= 0) {
                            echo $card_quantity_error;
                        }
                        ?>
                    </p>
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
                    <input type="text" name="delete_status" value="" class="order-field">
                    <input type="submit" value="Delete" class="delete-btn">
                </form>
            </li>
        </ul>
    </div>
    </body>

    </html>
}
<?php
} else {
    // Update card
    $query = "UPDATE cards 
          SET name='$card_name', description='$card_description', price=$card_price, quantity=$card_quantity  
          WHERE cardID=$card_id";
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
    $delete_error_msg = "";
    include 'admin.php';
}
?>