<?php
    declare(strict_types = 1);

    $connection = new mysqli("localhost", "root", "", "comparathing");

    if ($connection->connect_error)
        die("Connection failed: " . $connection->connect_error);
?>