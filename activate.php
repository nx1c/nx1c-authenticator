<?php

session_start();

require ('global_functions.php');

$language = (string) filter_input(INPUT_GET, "lang", FILTER_SANITIZE_ADD_SLASHES);
$do_activation = (int) filter_input(INPUT_POST, "do-activation", FILTER_VALIDATE_INT);
$mac_address = get_mac_address();

$database_server_name = "";
$database_user_name = "";
$database_password = "";
$database_name = "";
$database = new mysqli(
    $database_server_name,
    $database_user_name,
    $database_password,
    $database_name
);
if ($database->connect_error) $error = "Failed to connect";

if (!isset($_SESSION["user-logged-in"])) redirect("auth.php?lang=$language");

if ($do_activation !== 1) {
    // enter sql query here
    // i.e. SELECT ProductThumb FROM Products WHERE ProductId = '$_SESSION["product-id"]'
    $product_row = $database->query("");
    if ($product_row->num_rows == 0) $error = "Product not found";
    // enter password column name
    // i.e. ProductThumb
    $product_thumbnail_url = ($product_row->fetch_assoc())[""];
    echo str_replace(
        "<product-thumbnail-url>",
        $product_thumbnail_url,
        file_get_contents("languages/activate_$language.html")
    );
} else {
    // enter sql query here
    // i.e. UPDATE Users SET ... WHERE UserName = '$_SESSION["user-name"]'
    if ($database->query("") !== true) {
        // replace this with error handling
        $error = "Failed to update user record";
    } else {
        readfile("languages/activated_$language.html");
    }
}

$database->close();