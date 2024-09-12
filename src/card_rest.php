<?php
require_once('database.php');

// Get format and action provided in url
$format = filter_input(INPUT_GET, 'format', FILTER_SANITIZE_STRING);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$card_name = filter_input(INPUT_GET, 'card_name', FILTER_SANITIZE_STRING);
$priceRange1 = filter_input(INPUT_GET, 'range1', FILTER_SANITIZE_STRING);
$priceRange2 = filter_input(INPUT_GET, 'range2', FILTER_SANITIZE_STRING);

// Get all courses
$query = 'SELECT * FROM cards
          ORDER BY cardID';
$statement = $db->prepare($query);
$statement->execute();
$cards = $statement->fetchAll();
$statement->closeCursor();

if (strtolower($format) == "xml"
    && strtolower($action) == "cards"
    && count($_GET) < 3) {
    // XML Card Listing

    // Setup XML document
    $doc = new DOMDocument('1.0' );
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    $xml_cards = $doc->createElement("cards");
    $doc->appendChild($xml_cards);

    // Insert card information
    foreach ($cards as $card) {
        $new_card = $doc->createElement("card");
        $xml_cards->appendChild($new_card);

        $new_card->appendChild($doc->createElement("id", $card['cardID']));
        $new_card->appendChild($doc->createElement("name", $card['name']));
        $new_card->appendChild($doc->createElement("description", $card['description']));
        $new_card->appendChild($doc->createElement("price", $card['price']));
        $new_card->appendChild($doc->createElement("quantity", $card['quantity']));
    }

    header('Content-type: application/xml');
    echo $doc->saveXML();
}
else if (strtolower($format) == "xml"
    && strtolower($action) == "cards"
    && strtolower($card_name) != ""
    && count($_GET) < 4) {
    // XML Card Listing

    // Setup XML document
    $doc = new DOMDocument('1.0' );
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    $xml_cards = $doc->createElement("cards");
    $doc->appendChild($xml_cards);

    // Insert card information
    foreach ($cards as $card) {
        if ($card_name == strtolower($card['name'])) {
            $new_card = $doc->createElement("card");
            $xml_cards->appendChild($new_card);

            $new_card->appendChild($doc->createElement("id", $card['cardID']));
            $new_card->appendChild($doc->createElement("name", $card['name']));
            $new_card->appendChild($doc->createElement("description", $card['description']));
            $new_card->appendChild($doc->createElement("price", $card['price']));
            $new_card->appendChild($doc->createElement("quantity", $card['quantity']));
        }
    }

    header('Content-type: application/xml');
    echo $doc->saveXML();
}
else if (strtolower($format) == "xml"
    && strtolower($action) == "cards"
    && $priceRange1 != ""
    && $priceRange2 != ""
    && count($_GET) < 5) {
    // XML Card Listing for specific range

    // Setup XML document
    $doc = new DOMDocument('1.0' );
    $doc->preserveWhiteSpace = false;
    $doc->formatOutput = true;

    $xml_cards = $doc->createElement("cards");
    $doc->appendChild($xml_cards);

    // Insert card information
    foreach ($cards as $card) {
        if ($card['price'] >= floatval($priceRange1) && $card['price'] <= floatval($priceRange2)) {
            $new_card = $doc->createElement("card");
            $xml_cards->appendChild($new_card);

            $new_card->appendChild($doc->createElement("id", $card['cardID']));
            $new_card->appendChild($doc->createElement("name", $card['name']));
            $new_card->appendChild($doc->createElement("description", $card['description']));
            $new_card->appendChild($doc->createElement("price", $card['price']));
            $new_card->appendChild($doc->createElement("quantity", $card['quantity']));
        }
    }

    header('Content-type: application/xml');
    echo $doc->saveXML();
}
else if (strtolower($format) == "json"
    && strtolower($action) == "cards"
    && count($_GET) < 3) {
    // JSON Card Listing
    $card_listing = [];

    // Add each card to JSON file
    foreach ($cards as $card) {
        $card_info = ["id" => $card['cardID'],
                        "name" => $card['name'],
                        "description" => $card['description'],
                        "price" => number_format($card['price'], 2, '.', ','),
                        "quantity" => $card['quantity']];
        $card_listing[] = $card_info;
    }

    if (json_encode($card_listing, JSON_PRETTY_PRINT)) {
        header('content-type: application/json');
        echo json_encode($card_listing, JSON_PRETTY_PRINT);
    }
    else {
        echo "<h1>Error!</h1>";
    }
}
else if (strtolower($format) == "json"
    && strtolower($action) == "cards"
    && strtolower($card_name) != ""
    && count($_GET) < 4) {
    // JSON Card Listing
    $card_listing = [];

    // Add each card to JSON file
    foreach ($cards as $card) {
        if ($card_name == strtolower($card['name'])) {
            $card_info = ["id" => $card['cardID'],
                "name" => $card['name'],
                "description" => $card['description'],
                "price" => number_format($card['price'], 2, '.', ','),
                "quantity" => $card['quantity']];
            $card_listing[] = $card_info;
        }
    }

    if (json_encode($card_listing, JSON_PRETTY_PRINT)) {
        header('content-type: application/json');
        echo json_encode($card_listing, JSON_PRETTY_PRINT);
    }
    else {
        echo "<h1>Error!</h1>";
    }
}
else if (strtolower($format) == "json"
    && strtolower($action) == "cards"
    && $priceRange1 != ""
    && $priceRange2 != ""
    && count($_GET) < 5) {
    // JSON Card Listing
    $card_listing = [];

    // Add each card to JSON file
    foreach ($cards as $card) {
        if ($card['price'] >= floatval($priceRange1) && $card['price'] <= floatval($priceRange2)) {
            $card_info = ["id" => $card['cardID'],
                "name" => $card['name'],
                "description" => $card['description'],
                "price" => number_format($card['price'], 2, '.', ','),
                "quantity" => $card['quantity']];
            $card_listing[] = $card_info;
        }
    }

    if (json_encode($card_listing, JSON_PRETTY_PRINT)) {
        header('content-type: application/json');
        echo json_encode($card_listing, JSON_PRETTY_PRINT);
    }
    else {
        echo "<h1>Error!</h1>";
    }
}
else {
    echo "<h1>Error!</h1>";
    echo "<p>Please provide url with a format like below.</p>";
    echo "<p>(Ex: .../CS602_Term_Project_Zheng/card_rest.php?format=format_type&action=cards)</p>";
    echo "<p>(Ex: .../CS602_Term_Project_Zheng/card_rest.php?format=format_type&action=cards&card_name=card name)</p>";
    echo "<p>(Ex: .../CS602_Term_Project_Zheng/card_rest.php?format=format_type&action=cards&range1=0.99&range2=10.99)</p>";
}