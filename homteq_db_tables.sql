-- --------------------------------------------------------
-- 1. DROP EXISTING TABLES IN REVERSE ORDER TO AVOID CONSTRAINT LOCKS
-- --------------------------------------------------------
DROP TABLE IF EXISTS order_line;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS users;

-- --------------------------------------------------------
-- 2. CREATE SYSTEM TABLES
-- --------------------------------------------------------

CREATE TABLE Product (
    prodId INT AUTO_INCREMENT,
    prodName VARCHAR(200) NOT NULL,
    prodPicNameSmall VARCHAR(200) NOT NULL,
    prodPicNameLarge VARCHAR(200) NOT NULL,
    prodDescripShort VARCHAR(1000),
    prodDescripLong VARCHAR(2000),
    prodPrice DECIMAL(8,2) NOT NULL DEFAULT '0.00',
    prodQuantity INT NOT NULL DEFAULT '100',
    CONSTRAINT p_pid_pk PRIMARY KEY (prodId)
) ENGINE=InnoDB;

CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    userType VARCHAR(10) DEFAULT 'Customer', -- Can be 'Customer' or 'Admin'
    userFName VARCHAR(50) NOT NULL,
    userSName VARCHAR(50) NOT NULL,
    userEmail VARCHAR(100) UNIQUE NOT NULL,
    userPassword VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE orders (
    orderNo INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    orderDateTime DATETIME NOT NULL,
    orderTotal DECIMAL(10,2) NOT NULL,
    orderStatus VARCHAR(20) DEFAULT 'Pending',
    FOREIGN KEY (userId) REFERENCES users(userId) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE order_line (
    orderLineId INT AUTO_INCREMENT PRIMARY KEY,
    orderNo INT,
    prodId INT, 
    quantityOrdered INT NOT NULL,
    subTotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (orderNo) REFERENCES orders(orderNo) ON DELETE CASCADE,
    FOREIGN KEY (prodId) REFERENCES Product(prodId) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;


-- --------------------------------------------------------
-- 3. INITIAL INITIALIZATION SEED SEED DATA (INVENTORY SYSTEM)
-- --------------------------------------------------------

INSERT INTO Product 
(prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity)
VALUES
('HIVE Active Heating Thermostat', 'hivesmall.jpg', 'hivebig.jpg',
'Hive Active Heating connects you and your heating system via an app on your mobile device to give you convenient control over operating times from wherever you are.',
'With an all-new wall-mounted thermostat control unit, Hive Active Heating looks great and can reduce the heating bills in any home. With control from your mobile, laptop or tablet, you\'ll never need to heat an empty home again. Up to six heating events can be scheduled throughout the day, so you can wake up in comfort, cut the heating while the house is empty and return to a comfortable home after a long day at work.',
145.00, 35);

INSERT INTO Product 
(prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity)
VALUES
('Philips Hue Smart Bulb Starter Kit', 'huesmall.jpg', 'huebig.jpg',
'Philips Hue brings smart lighting to your home with full control from your mobile device.',
'The Philips Hue Starter Kit includes smart LED bulbs and a bridge that connects them to your Wi‑Fi network. You can adjust brightness, set schedules, and choose from millions of colours to create the perfect atmosphere. Compatible with major smart home systems, Hue lighting makes it easy to automate your home and save energy.',
89.99, 50);

INSERT INTO Product 
(prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity)
VALUES
('Ring Video Doorbell 3', 'ringsmall.jpg', 'ringbig.jpg',
'Ring Video Doorbell 3 lets you see, hear and speak to visitors from your phone, tablet or PC.',
'With improved motion detection, dual‑band Wi‑Fi and crisp 1080p video, the Ring Video Doorbell 3 enhances home security and convenience. Receive instant alerts when someone presses your doorbell or triggers motion sensors. Easy installation and integration with Alexa make it a seamless addition to any smart home.',
159.00, 40);

INSERT INTO Product 
(prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity)
VALUES
('Google Nest Protect Smoke & CO Alarm', 'nestsmall.jpg', 'nestbig.jpg',
'Nest Protect is a smart smoke and carbon monoxide alarm that keeps your home safe and connected.',
'Nest Protect uses advanced sensors to detect smoke and carbon monoxide quickly and accurately. It sends alerts to your phone, speaks with a clear human voice, and even tells you where the danger is. With a long‑lasting battery, self‑testing features and integration with the Google Home ecosystem, Nest Protect offers peace of mind for every room in your home.',
109.00, 28);

INSERT INTO Product
(prodName, prodPicNameSmall, prodPicNameLarge, prodDescripShort, prodDescripLong, prodPrice, prodQuantity)
VALUES
('Smart Home Hub', 'smarthubsmall.jpg', 'smarthubbig.jpg',
'The central brain of your automated home, connecting and controlling all your smart devices seamlessly from a single app.',
'Take absolute control of your living space with the Smart Home Hub. This sleek, ultra-compatible central gateway bridges your Wi-Fi, Zigbee, and Bluetooth devices into one unified network. Seamlessly manage smart lighting, security cameras, thermostats, and speakers from your smartphone, tablet, or via voice commands. Features advanced automation scheduling to let you build custom daily routines, optimize energy efficiency, and secure your home while you are away.',
99.99, 60);