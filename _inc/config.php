<?php

/**
 * This file is used to start a session and include all necessary classes.
 */

// Start a new session
session_start();

// Include all necessary classes
require_once 'classes/Menu.php';
require_once 'classes/Page.php';
require_once 'classes/Database.php';
require_once 'classes/Contact.php';
require_once 'classes/Dishes.php';
require_once 'classes/Slider.php';
require_once 'classes/User.php';
require_once 'classes/Cart.php';
require_once 'classes/Order.php';