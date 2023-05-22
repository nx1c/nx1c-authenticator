<?php

session_start();

require ('global_functions.php');

$language = (string) filter_input(INPUT_GET, "lang", FILTER_SANITIZE_ADD_SLASHES);
$user_name = (string) filter_input(INPUT_POST, "username", FILTER_SANITIZE_ADD_SLASHES);
$password = (string) filter_input(INPUT_POST, "password", FILTER_SANITIZE_ADD_SLASHES);
$_SESSION["product-id"] = (string) filter_input(INPUT_POST, "product-id", FILTER_DEFAULT);
$_SESSION["user-name"] = $user_name;
$_SESSION["activation-complete"] = false;
$error = null;

// enter database information here
$database_server_name = "";
$database_user_name = "";
$database_password = "";
$database_name = "";

if ($language == null) redirect("auth.php?lang=en");
if ($user_name != null && $password != null) {
    $database = new mysqli(
        $database_server_name,
        $database_user_name,
        $database_password,
        $database_name
    );
    if ($database->connect_error) $error = "Failed to connect";
    // enter sql query here
    // i.e. SELECT UserPassword FROM Users WHERE UserName = '$user_name'
    $returned_fields = $database->query("");
    if ($returned_fields->num_rows == 0) $error = "Account not found";
    // enter password column name
    // i.e. UserPassword
    if ($error == null && (($returned_fields)->fetch_assoc())[""] === $password) {
        $_SESSION["user-logged-in"] = true;
        $database->close();
        redirect("activate.php?lang=$language");
    }
}

if ($error == null) readfile("languages/login_$language.html");

// replace this with error handling
if ($error != null) echo "Error: $error";