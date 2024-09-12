<?php
require_once ('database.php');

// Get all cards in mySQL card_db database
$query = 'SELECT * FROM cards 
          ORDER BY name';
$statement = $db->prepare($query);
$statement->execute();
$card_list = $statement->fetchAll();
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
            <li><a href="admin_customer_orders.php">Customer Orders</a></li>
        </ul>
    </nav>
</header>
<div class="search-bar-small-screen">
    <input type="search" placeholder="Enter a card name..." id="search-box">
    <button id="search-button">Search</button>
</div>
<div class="add-card-content">
    <form action="add_card_view.php" method="post">
        <input type="submit" value="Add a New Card+" class="add-card-btn"><br>
    </form>
</div>
<div class="card-content">
    <p>Showing <?php echo count($card_list)?> out of <?php echo count($card_list)?> cards</p>
    <ul class="cards">
        <?php foreach ($card_list as $card) : ?>
            <li class="card">
                <p class="card-title"><?php echo $card['name'] ?></p>
                <p><?php echo $card['description'] ?></p>
                <p><?php echo "$" . number_format((float) $card['price'], 2, '.', ',') ?></p>
                <p><?php echo "Quantity: " . $card['quantity'] ?></p>
                <form action="card_view.php" method="post">
                    <p class="card-purchase">
                        <input type="hidden" name="card_id" value="<?php echo $card['cardID'] ?>">
                        <input type="hidden" name="card_name" value="<?php echo $card['name']; ?>">
                        <input type="hidden" name="card_description" value="<?php echo $card['description']; ?>">
                        <input type="hidden" name="card_price" value="<?php echo $card['price']; ?>">
                        <input type="hidden" name="card_quantity" value="<?php echo $card['quantity']; ?>">
                    </p>
                    <input type="submit" value="Modify" class="modify-btn"><br>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>

</html>