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

   return !empty($flavors);
}