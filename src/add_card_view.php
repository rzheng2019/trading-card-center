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
                <input type="text"
                       name="card_name"
                       placeholder="Please enter a name"
                       value=""
                       class="order-field">
                <p>Description</p>
                <input type="text"
                       name="card_description"
                       placeholder="Please enter a description"
                       value=""
                       class="order-field">
                <p>Price</p>
                <input step="any"
                       type="number"
                       name="card_price"
                       placeholder="Please enter a price"
                       value=""
                       class="order-field">
                <p>Quantity</p>
                <input step="any"
                       type="number"
                       name="card_quantity"
                       placeholder="Please enter a quantity"
                       value=""
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