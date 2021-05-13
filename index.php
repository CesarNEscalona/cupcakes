<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

// Require the autoload file
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validation.php');

// Instantiate the base class..similar to Java - Base f3 = new Base();
$f3 = Base::instance();

// Define a default route
$f3->route('GET|POST /', function ($f3) {
    //Reinitialize session array
    $_SESSION = array();

    // initialize variables to store user input
    $userFlavors = array();
    $userName = "";
    $totalPrice = 0;

    //If the form has been submitted, validate the data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        $userName = $_POST['name'];
        if (validName($_POST['name'])) {
            $_SESSION['name'] = $_POST['name'];
        } else {
            $f3->set('errors["name"]', 'Name not good enough');
        }

        if (!empty($_POST['flavors'])) {
            // Get user input and assign it to the variable
            $userFlavors = $_POST['flavors'];
            //If condiments are valid
            if (validFlavors($userFlavors)) {
                // $_SESSION['flavors'] = implode(", ", $userFlavors);
                $_SESSION['flavors'] = $userFlavors;
            }
        }
        else {
            $f3->set('errors["flavors"]', 'Invalid selection');
        }

        // Set the price
        for ($x = 0; $x < sizeof($userFlavors); $x++){
            $totalPrice += 3.50;
        }

        $_SESSION['price'] = number_format($totalPrice, 2);


        //If the error array is empty, redirect to summary page
        if (empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    //Get the condiments from the Model and send them to the View
    $f3->set('flavors', getFlavors());

    // Add the data to the hive
    $f3->set('userFlavors', $userFlavors);
    $f3->set('userName', $userName);
    $f3->set('price', $totalPrice);

    // Display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /summary', function () {

    //Display the summary
    $view = new Template();
    echo $view->render('views/summary.html');
});

// Run fat free
$f3->run();