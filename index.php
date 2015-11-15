<?php
/*
 * @desc - Index page for all the request
 * @author - Vandish Gandhi
 * Version History 
 * 1.0 - Setting up server and creating cient side login date (8/9/2015)
 * 
 */

require 'libs/bootstrap.php'; 										// This initiates the receiving of URL
require 'libs/controller.php';										// This initialtes the controller for URL
require 'libs/view.php';											// This will trigger the view for the URL
require 'libs/model.php';											// This initiates business logic of website

//CONFIGURATION
require 'config/paths.php';

// Libraries
require 'libs/database.php';
require 'libs/session.php';

//Authentication
require 'libs/JWT.php';


// Initializing session
Session::init();

// initializing applciation
$app = new bootstrap();