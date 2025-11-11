<?php
    declare(strict_types = 1);
    session_start();

    if (isset($_POST["q"]) && !empty($_POST["q"]))
    {
        $searchQuery = urlencode($_POST["q"]);
        header("Location: ./search.php?q=" . $searchQuery, true);
        die;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Comparathing</title>
</head>
<body>
    <nav id="navigation-bar">
        <div>
            <span class="logo">Logo</span>
        </div>
        <form method="post">
            <input
                type="search"
                name="q"
                placeholder="Search..."
                required>
            <button type="submit"></button>
        </form>
        <?php
            if (isset($_SESSION["username"]))
            {
        ?>
        <div>
            <span><?php echo $_SESSION["username"] ?></span>
        </div>
        <?php
            }
        ?>
    </nav>
</body>
</html>