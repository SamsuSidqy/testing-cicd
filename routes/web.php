<?php


// Untuk GUest / Anonym
require __DIR__ . '/guest/routes.php';

// Authentication Users
require __DIR__ . "/services/authentication/routes.php";
// Master Services
require __DIR__ . '/services/master/routes.php';

// Page Dashbaord
require __DIR__ . '/auth/routes.php';

//Page Developer
require __DIR__ . '/developer/routes.php';