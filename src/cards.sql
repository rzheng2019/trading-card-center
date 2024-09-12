CREATE TABLE cards (
    cardID         INT(20)        NOT NULL AUTO_INCREMENT,
    name           VARCHAR(30)    NOT NULL,
    description    VARCHAR(255)   NOT NULL,
    price          FLOAT(10)      NOT NULL,
    quantity       INT(20)        NOT NULL,
 PRIMARY KEY (cardID)
);

CREATE TABLE orders (
    orderID         INT(20)        NOT NULL AUTO_INCREMENT,
    customerID      VARCHAR(20)    NOT NULL,
    orderedAmount   INT(20)        NOT NULL,
    cardID          INT(20)        NOT NULL,
    name            VARCHAR(30)    NOT NULL,
    description     VARCHAR(255)   NOT NULL,
    price           FLOAT(10)      NOT NULL,
    quantity        INT(20)        NOT NULL,
    PRIMARY KEY (orderID)
);

CREATE TABLE cart (
    cartID          INT(20)         NOT NULL AUTO_INCREMENT,
    purchaseAmount  Int(20)         NOT NULL,
    cardID          INT(20)         NOT NULL,
    name            VARCHAR(30)     NOT NULL,
    description     VARCHAR(255)    NOT NULL,
    price           FLOAT(10)       NOT NULL,
    totalPrice      FLOAT(10)       NOT NULL,
    quantity        INT(20)         NOT NULL,
    PRIMARY KEY (cartID)
);

INSERT INTO cards VALUES
(1, 'Flying Banana', 'A strong willed flying fruit.', 1.99, 500),
(2, 'Flying Watermelon', 'A strong willed flying fruit.', 2.99, 500),
(3, 'Flying Apple', 'A strong willed flying fruit.', 3.99, 500),
(4, 'Flying Orange', 'A strong willed flying fruit.', 4.99, 500),
(5, 'Flying Pineapple', 'A strong willed flying fruit.', 5.99, 500),
(6, 'Flying Strawberry', 'A strong willed flying fruit.', 6.99, 500),
(7, 'Flying Grape', 'A strong willed flying fruit.', 7.99, 500),
(8, 'Flying Avocado', 'A strong willed flying fruit.', 8.99, 500),
(9, 'Flying Winter Melon', 'A strong willed flying fruit.', 9.99, 500),
(10, 'Flying Chicken', 'A strong willed flying animal.', 10.99, 500),
(11, 'Flying Cookie', 'A strong willed flying snack.', 11.99, 500),
(12, 'Flying Chocolate', 'A strong willed flying snack.', 12.99, 500),
(13, 'Flying Cat', 'A strong willed flying animal.', 13.99, 500),
(14, 'Flying Panther', 'A strong willed flying animal.', 14.99, 500),
(15, 'Flying Dog', 'A strong willed flying animal.', 15.99, 500),
(16, 'Flying Wolf', 'A strong willed flying animal.', 16.99, 500),
(17, 'Flying Beaver', 'A strong willed flying animal.', 17.99, 500),
(18, 'Flying Otter', 'A strong willed flying animal.', 18.99, 500),
(19, 'Flying Falcon', 'A strong willed flying animal.', 19.99, 500),
(20, 'Flying Lion', 'A strong willed flying animal.', 20.99, 500);