<?php
require_once ('database.php');

// Get all cards in mySQL card_db database
$query = 'SELECT * FROM cards 
          ORDER BY name';
$statement = $db->prepare($query);
$statement->execute();
$card_list = $statement->fetchAll();
$statement->closeCursor();

// Get all cards in mySQL card_db database
$query2 = 'SELECT * FROM cart 
           ORDER BY cartID';
$statement2 = $db->prepare($query2);
$statement2->execute();
$cart_list = $statement2->fetchAll();
$statement2->closeCursor();

// Store data for add to cart updates
$purchase_amount = filter_input(INPUT_POST, 'purchase_amount');
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$card_price = filter_input(INPUT_POST, 'card_price');
$card_quantity = filter_input(INPUT_POST, 'card_quantity');
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
    <div class="search-bar-small-screen">
        <input type="search" placeholder="Enter a card name..." id="search-box">
        <button id="search-button">Search</button>
    </div>
    <div class="card-content">
        <p>Showing <?php echo count($card_list)?> out of <?php echo count($card_list)?> cards</p>
        <?php
            if (isset($purchase_amount)) {
                if ($purchase_amount > $card_quantity) {
                    echo "<p class='confirmation-msg'>
                            <b> Error: </b> Order of $card_name ($purchase_amount) is greater than available quantity ($card_quantity).
                          </p>";
                }
                else if ($purchase_amount == "" || $purchase_amount <= 0) {
                    echo "<p class='confirmation-msg'>
                            <b> Error: </b> Please enter a valid purchase amount. 
                          </p>";
                }
                else {
                    echo "<p class='confirmation-msg'>
                            Order of $card_name ($purchase_amount) has been added to cart.
                         </p>";
                }
            }
        ?>
        <ul class="cards">
            <?php foreach ($card_list as $card) : ?>
                <li class="card">
                    <p class="card-title"><?php echo $card['name'] ?></p>
                    <p><?php echo $card['description'] ?></p>
                    <p><?php echo "$" . number_format((float) $card['price'], 2, '.', ',') ?></p>
                    <p><?php echo "Quantity: " . $card['quantity'] ?></p>
                    <form action="add_to_cart.php" method="post">
                        <p class="card-purchase">
                            <?php echo "Purchase Amount: " ?>
                            <input type="number" name="purchase_amount" class="order-field">
                            <input type="hidden" name="card_id" value="<?php echo $card['cardID'] ?>">
                            <input type="hidden" name="card_name" value="<?php echo $card['name']; ?>">
                            <input type="hidden" name="card_description" value="<?php echo $card['description']; ?>">
                            <input type="hidden" name="card_price" value="<?php echo $card['price']; ?>">
                            <input type="hidden" name="card_quantity" value="<?php echo $card['quantity']; ?>">
                        </p>
                        <input type="submit" value="Buy" class="buy-btn"><br>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>