<?php
    declare(strict_types = 1);
    require_once __DIR__."/php/sql-connection.php";
    $redirectUrl = isset($_GET["r"]) ? urldecode($_GET["r"]) : "/index.php";
    session_start();

    unset($_SESSION["user_id"]);
    unset($_SESSION["username"]);
    header("Location: " . $redirectUrl);
    die;
?>