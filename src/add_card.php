<?php
require_once ('database.php');

// Store data for add to cart updates
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$card_price = filter_input(INPUT_POST, 'card_price');
$card_quantity = filter_input(INPUT_POST, 'card_quantity');

$card_name_error = "";
$card_description_error = "";
$card_price_error = "";
$card_quantity_error = "";

if ($card_name == null
    || $card_description == null
    || $card_price == null
    || $card_quantity == null
    || $card_quantity <= 0
    || $card_price <= 0) {
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
                <form action="add_card.php" method="post">
                    <p>Name</p>
                    <p style="color: red">
                        <?php
                        if ($card_name_error != "" && $card_name == null) {
                            echo $card_name_error;
                        }
                        ?>
                    </p>
                    <input type="text"
                           name="card_name"
                           placeholder="Please enter a name"
                           value="<?php if ($card_name != null) { echo $card_name; }?>"
                           class="order-field">
                    <p>Description</p>
                    <p style="color: red">
                        <?php
                        if ($card_description_error != "" && $card_description== null) {
                            echo $card_description_error;
                        }
                        ?>
                    </p>
                    <input type="text"
                           name="card_description"
                           placeholder="Please enter a description"
                           value="<?php if ($card_description != null) { echo $card_description; }?>"
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
                           placeholder="Please enter a price"
                           value="<?php if ($card_price != null) { echo $card_price; }?>"
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
                           placeholder="Please enter a quantity"
                           value="<?php if ($card_quantity != null) { echo $card_quantity; }?>"
                           class="order-field">
                    <div class="buttons">
                        <p class="add-btn-instructions">To add new card, please type click "Add Card +" button below.</p>
                        <input type="submit" value="Add Card +" class="confirm-add-btn">
                    </div>
                </form>
            </li>
        </ul>
    </div>
    </body>

    </html>

<?php
} else {
    $query = 'INSERT INTO cards 
                (name, description, price, quantity)
              VALUES 
                  (:name, :description, :price, :quantity)';

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $card_name);
    $statement->bindValue(':description', $card_description);
    $statement->bindValue(':price', $card_price);
    $statement->bindValue(':quantity', $card_quantity);
    $statement->execute();
    $statement->closeCursor();

    include('admin.php');
}