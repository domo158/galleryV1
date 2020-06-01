<?php

function classAutoLoader($class){
    $class = strtolower($class);

    $the_path = "includes/{$class}.php";

    if(file_exists($the_path) && !class_exists($class)){
        require_once($the_path);
    } else {
        die("This file named {$class}.php was not found!");
    }
}

function redirect($location) {
    header("Location: {$location}");
}

function printr($something) {
    echo "<pre>";
    print_r($something);
    echo "</pre>";
}

function vardump($something) {
    echo "<pre>";
    var_dump($something);
    echo "</pre>";
}



spl_autoload_register("classAutoLoader");