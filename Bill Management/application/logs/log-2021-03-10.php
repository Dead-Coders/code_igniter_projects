<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-03-10 11:46:17 --> Query error: Unknown column 'purchase.dbDt' in 'field list' - Invalid query: SELECT `purchase`.`customerRowId`, `purchase`.`dbDt`, `customers`.`customerName`, `customers`.`address`
FROM `purchase`
JOIN `customers` ON `customers`.`customerRowId` = `purchase`.`customerRowId`
WHERE `purchase`.`dbRowId` = '1623'
ERROR - 2021-03-10 11:46:54 --> Query error: Unknown column 'purchase.dbDt' in 'field list' - Invalid query: SELECT `purchase`.`customerRowId`, `purchase`.`dbDt`, `customers`.`customerName`, `customers`.`address`
FROM `purchase`
JOIN `customers` ON `customers`.`customerRowId` = `purchase`.`customerRowId`
WHERE `purchase`.`dbRowId` = '1623'
ERROR - 2021-03-10 11:47:31 --> Query error: Unknown column 'purchase.dbRowId' in 'where clause' - Invalid query: SELECT `purchase`.`customerRowId`, `purchase`.`purchaseDt`, `customers`.`customerName`, `customers`.`address`
FROM `purchase`
JOIN `customers` ON `customers`.`customerRowId` = `purchase`.`customerRowId`
WHERE `purchase`.`dbRowId` = '1623'
ERROR - 2021-03-10 11:49:59 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\bill\application\controllers\Purchase_Controller.php 217
ERROR - 2021-03-10 11:49:59 --> Severity: error --> Exception: Call to undefined method Purchase_Controller::numberTowords() C:\xampp\htdocs\bill\application\controllers\Purchase_Controller.php 219
ERROR - 2021-03-10 11:50:42 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\bill\application\controllers\Purchase_Controller.php 217
ERROR - 2021-03-10 11:51:11 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\bill\application\controllers\Purchase_Controller.php 218
