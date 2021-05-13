<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once('vendor/autoload.php');

// Instantiate the base class..similar to Java - Base f3 = new Base();
$f3 = Base::instance();

// Define a default route
$f3->route('GET|POST /', function ($f3) {
    //Reinitialize session array
    $_SESSION = array();

    // initialize variables to store user input
    $userFlavors = array();

    //If the form has been submitted, validate the data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        // Get user input and assign it to the variable
        $userFlavors = $_POST['flavors'];
        //If condiments are valid
        if (validFlavors($userFlavors)) {
            $_SESSION['flavors'] = implode(", ", $userFlavors);
        } else {
            $f3->set('errors["flavors"]', 'Invalid selection');
        }
        //If the error array is empty, redirect to summary page
        if (empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    // Add the data to the hive
    $f3->set('userFlavors', $userFlavors);

    // Display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Run fat free
$f3->run();