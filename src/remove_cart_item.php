<?php
require_once ('database.php');

$cart_id = filter_input(INPUT_POST, 'cart_id');

$query = 'DELETE FROM cart
              WHERE cartID = :cart_id';
$statement = $db->prepare($query);
$statement->bindValue(':cart_id', $cart_id);
$success = $statement->execute();
$statement->closeCursor();
$delete_error_msg = "";
include ('cart.php');