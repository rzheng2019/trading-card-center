<?php
require_once('database.php');

// Get all cards in mySQL card_db database
$query = 'SELECT * FROM cart 
          ORDER BY cartID';
$statement = $db->prepare($query);
$statement->execute();
$card_list = $statement->fetchAll();
$statement->closeCursor();

$purchase_amount = filter_input(INPUT_POST, 'purchase_amount');
$card_id = filter_input(INPUT_POST, 'card_id');
$card_name = filter_input(INPUT_POST, 'card_name');
$card_description = filter_input(INPUT_POST, 'card_description');
$card_price = filter_input(INPUT_POST, 'card_price');
$card_quantity = filter_input(INPUT_POST, 'card_quantity');

if ($purchase_amount == null
    || $card_id == null
    || $card_name == null
    || $card_description == null
    || $card_price == null
    || $card_quantity == null) {
    include('customer.php');
}
else {
    if ($purchase_amount > $card_quantity || $purchase_amount <= 0) {
        // Display home page
        include('customer.php');
    }
    else {
        $query = 'INSERT INTO cart
                (purchaseAmount, cardID, name, description, price, totalPrice, quantity)
              VALUES 
                  (:purchaseAmount, :cardID, :name, :description, :price, :totalPrice, :quantity)';

        $statement = $db->prepare($query);
        $statement->bindValue(':purchaseAmount', $purchase_amount);
        $statement->bindValue(':cardID', $card_id);
        $statement->bindValue(':name', $card_name);
        $statement->bindValue(':description', $card_description);
        $statement->bindValue(':price', $card_price);
        $statement->bindValue(':totalPrice', 0);
        $statement->bindValue(':quantity', $card_quantity);
        $statement->execute();
        $statement->closeCursor();

        // Display home page
        include('customer.php');
    }
}