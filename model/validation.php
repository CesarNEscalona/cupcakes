<?php

/*
 * validation.php
 * Validation for the cupcakes
 */

// user name cannot be empty
function validName($name){
    return !empty($name);
}

// user must select at least one cupcake flavor
function validFlavors($flavors){

    // checks flavors until it finds a checked one
    foreach ($flavors as $flavor){
        if(isset($flavor)){
            return true;
        }
    }
    return false;
}