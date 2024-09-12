<?php
require_once('database.php');

// Get all cards in mySQL card_db database
$query1 = 'SELECT * FROM cards 
          ORDER BY name';
$statement1 = $db->prepare($query1);
$statement1->execute();
$card_list = $statement1->fetchAll();
$statement1->closeCursor();

// Get all cart items in mySQL card_db database
$query2 = 'SELECT * FROM cart 
           ORDER BY cartID';
$statement2 = $db->prepare($query2);
$statement2->execute();
$cart_list = $statement2->fetchAll();
$statement2->closeCursor();

// Get all orders in mySQL card_db database
$query3 = 'SELECT * FROM orders 
           ORDER BY orderID';
$statement3 = $db->prepare($query3);
$statement3->execute();
$orders_list = $statement3->fetchAll();
$statement3->closeCursor();

$customerID_status = filter_input(INPUT_POST, 'customerID_status');

// Used customerID_status to find all cart items with same ID
foreach ($cart_list as $cart_item) {
    // Create a new order
    $query4 = 'INSERT INTO orders 
            (customerID, orderedAmount, cardID, name, description, price, quantity)
          VALUES 
              (:customerID, :orderedAmount, :cardID, :name, :description, :price, :quantity)';

    $statement4 = $db->prepare($query4);
    $statement4->bindValue(':customerID', $customerID_status);
    $statement4->bindValue(':orderedAmount', $cart_item['purchaseAmount']);
    $statement4->bindValue(':cardID', $cart_item['cardID']);
    $statement4->bindValue(':name', $cart_item['name']);
    $statement4->bindValue(':description', $cart_item['description']);
    $statement4->bindValue(':price', $cart_item['price'] * $cart_item['purchaseAmount']);
    $statement4->bindValue(':quantity', $cart_item['quantity']);
    $statement4->execute();
    $statement4->closeCursor();

    // New quantity
    $newQuantity = $cart_item['quantity'] - $cart_item['purchaseAmount'];
    $itemID = $cart_item['cardID'];

    // Update card inventory
    $query5 = "UPDATE cards
      SET quantity=$newQuantity
      WHERE cardID=$itemID";
    $statement5 = $db->prepare($query5);
    $statement5->execute();
    $statement5->closeCursor();
    $delete_error_msg = "";

    // Delete all items in cart
    $query = 'DELETE FROM cart';
    $statement = $db->prepare($query);
    $success = $statement->execute();
    $statement->closeCursor();
    $delete_error_msg = "";
}

include('customer.php');
