<?php
    declare(strict_types = 1);
    require_once __DIR__."/php/sql-connection.php";
    session_start();

    if (isset($_POST["q"]) && !empty($_POST["q"]))
    {
        $searchQuery = urlencode($_POST["q"]);
        header("Location: /search.php?q=" . $searchQuery);
        die;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Comparathing</title>
    <link rel="stylesheet" href="./css/page.css">
</head>
<body>
    <main
        style="
            max-width: 1200px;
            margin-inline: auto">
        <nav
            id="navigation-bar"
            style="
                display: flex;
                justify-content: space-between;
                padding: 10px;
                border-bottom: 1px solid #CCCCCC;
                align-items: center">
            <div>
                <a
                    class="logo"
                    href="./">Logo</a>
            </div>
            <form method="post">
                <input
                    type="search"
                    name="q"
                    placeholder="Search..."
                    required>
                <button type="submit">Search</button>
            </form>
            <?php
    if (isset($_SESSION["username"]))
    {
            ?>
            <div>
                <span><?php echo $_SESSION["username"] ?></span>
            </div>
            <div>
                <a href="./logout.php?r=<?php echo urlencode("/search.php"); if (isset($_GET["q"])) echo urlencode("&q=" . $_GET["q"]); ?>">Logout</a>
            </div>
            <?php
    }
    else
    {
            ?>
            <div>
                <a href="./login.php?r=<?php echo urlencode("/search.php"); if (isset($_GET["q"])) echo urlencode("&q=" . $_GET["q"]); ?>">Login</a>
            </div>
            <?php
    }
            ?>
        </nav>
        <form method="post">
            <fieldset class="search-bar">
                <legend>Search</legend>
                <input
                    type="search"
                    name="q"
                    placeholder="Search..."
                    required,
                    value="<?php
                        if (isset($_GET["q"]))
                            echo htmlspecialchars($_GET["q"]);
                    ?>"
                    <?php
                        if (isset($_GET["q"]))
                            echo "autofocus";
                    ?>>
                <button type="submit">Search</button>
            </fieldset>
            <?php
    if (isset($_GET["q"]) && !empty($_GET["q"]))
    {
        // Select items where search is included in the name in order of
        // most letters matched then by closest to start:
        $stmt = $connection->prepare(
            "SELECT id, name, image_file
            FROM items
            WHERE name LIKE CONCAT('%', ?, '%')
            ORDER BY
                LENGTH(name) - LENGTH(REPLACE(LOWER(name), LOWER(?), '')) DESC,
                INSTR(LOWER(name), LOWER(?)) ASC,
                LENGTH(name) ASC");
        $stmt->bind_param("sss", $_GET["q"], $_GET["q"], $_GET["q"]);
        $stmt->execute();
        $result = $stmt->get_result();
            ?>
            <ul class="results">
                <?php
        for ($i = 0; $i < $result->num_rows; $i++)
        {
            $item = $result->fetch_assoc();
            $shortName = htmlspecialchars($item["name"]);
                ?>
                <li>
                    <a
                        class="item"
                        href="./item.php?id=<?php echo $item["id"] ?>">
                        <div class="item-image">
                            <img
                                src="./image/<?php
                                        echo pathinfo($item["image_file"], PATHINFO_FILENAME)
                                    ?>_thumb.<?php
                                        echo pathinfo($item["image_file"], PATHINFO_EXTENSION)
                                    ?>"
                                alt="<?php echo $shortName ?>"/>
                        </div>
                        <span class="item-name"><?php echo $shortName ?></span>
                    </a>
                </li>
                <?php
        }
                ?>
            </ul>
        <?php
    }
    else
    {
        ?>
            <ul class="results">
                <li>No results found.</li>
            </ul>
        <?php
    }
        ?>
        </form>
    </main>
</body>
</html>