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

    if (!isset($_GET["id"]) || !is_numeric($_GET["id"]))
    {
        header("Location: /index.php");
        die;
    }

    $itemId = (int)$_GET["id"];

    $stmt = $connection->prepare(
        "SELECT name, description, image_file, background
        FROM items
        WHERE id = ?");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0)
    {
        header("Location: /index.php");
        die;
    }

    $item = $result->fetch_assoc();

    $backgroundStyle = "";
    switch ($item["background"])
    {
        case "auto":
            $backgroundStyle = "background-color: #BABABA;
                background-color: light-dark(#BABABA, #000000)";
            break;
        case "white":
            $backgroundStyle = "background-color: #FFFFFF";
            break;
        case "black":
            $backgroundStyle = "background-color: #000000";
            break;
        default:
            exit("Unknown background type");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Comparathing</title>
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
                <a href="./logout.php?r=<?php echo urlencode("/item.php"); if (isset($_GET["id"])) echo urlencode("&id=" . $_GET["id"]); ?>">Logout</a>
            </div>
            <?php
    }
    else
    {
            ?>
            <div>
                <a href="./login.php?r=<?php echo urlencode("/item.php"); if (isset($_GET["id"])) echo urlencode("&id=" . $_GET["id"]); ?>">Login</a>
            </div>
            <?php
    }
            ?>
        </nav>
        <section
            style="
                display: flex;
                flex-direction: row;
                gap: 20px;
                margin-top: 20px">
            <aside
                style="
                    display: flex;
                    flex-direction: column;
                    padding-block: 20px;
                    gap: 20px;
                    align-items: center;
                    width: 30%">
                <div
                    style="
                        aspect-ratio: 1 / 1;
                        width: calc(100% - 40px);
                        <?php echo $backgroundStyle ?>">
                    <img
                        src="./image/<?php
                                echo pathinfo($item["image_file"], PATHINFO_FILENAME)
                            ?>_thumb.<?php
                                echo pathinfo($item["image_file"], PATHINFO_EXTENSION)
                            ?>"
                        style="
                            width: 100%;
                            height: 100%;
                            object-fit: contain"
                        alt="<?php echo $item["name"] ?>"/>
                </div>
                <span class="item-name"><?php echo $item["name"] ?></span>
            </aside>
            <div>
                <h2>Reviews</h2>
                Not implemented yet.
            </div>
        </section>
    </main>
</body>
</html>