<?php
    declare(strict_types = 1);

    $connection = new mysqli("localhost", "root", "", "comparathing");

    if ($connection->connect_error)
        error_log("Connection failed: " . $connection->connect_error);
?>