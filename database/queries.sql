-- CREATE database `restoran`;

use `restoran`;

-- user table
CREATE TABLE user (
    id INT(11) AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(70) NOT NULL,
    password VARCHAR(225) NOT NULL,
    primary key(id)
);

CREATE TABLE food(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(225) NOT NULL,
    image VARCHAR(225) NOT NULL,
    description TEXT NOT NULL,
    price VARCHAR(30) NOT NULL,
    created_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

CREATE TABLE orders (
    id INT NOT NULL AUTO_INCREMENT,
    customer_id INT NOT NULL,
    price INT NOT NULL,
    ordered_food VARCHAR(255) NOT NULL,
    phone VARCHAR(13) NOT NULL,
    name VARCHAR(225) NOT NULL,
    address VARCHAR(300) NOT NULL,
    paid BOOLEAN NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE orders ALTER COLUMN paid SET DEFAULT false;

ALTER TABLE `orders` ADD `email` VARCHAR(225) NOT NULL AFTER  `name`;

CREATE TABLE booking (
    `id` INT NOT NULL AUTO_INCREMENT,
    `customer_id` INT NOT NULL,
    `email` VARCHAR(70) NOT NULL,
    `people` INT(5) NOT NULL,
    `request` VARCHAR(225) NOT NULL,
    `paid` BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (`id`)
);
ALTER TABLE `booking` ADD `time` DATE NOT NULL AFTER `email`;
ALTER TABLE `booking` CHANGE `time` `time` DATETIME NOT NULL;
ALTER TABLE `booking` CHANGE `paid` `status` VARCHAR(20) NOT NULL DEFAULT 'pending';
ALTER TABLE `booking` ADD `name` VARCHAR(50) NOT NULL AFTER `customer_id`;
ALTER TABLE `user` ADD `admin` BOOLEAN NOT NULL DEFAULT FALSE AFTER `password`;

INSERT INTO `food` (`id`, `name`, `image`, `description`, `price`, `created_At`) VALUES 
(NULL, 'chicken tikka', 'menu-1.jpg', 'This is famous food chicken tikka', '222', current_timestamp()),
(NULL, 'chicken pizza', 'menu-2.jpg', 'This is famous food chicken pizza', '132', current_timestamp()),
(NULL, 'beef', 'menu-3.jpg', 'This is famous food  beef', '412', current_timestamp()),
(NULL, 'mutton', 'menu-4.jpg', 'This is famous food  mutton', '523', current_timestamp());
