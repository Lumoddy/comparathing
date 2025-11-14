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
                <a href="./logout.php?r=<?php echo urlencode("/index.php") ?>">Logout</a>
            </div>
            <?php
    }
    else
    {
            ?>
            <div>
                <a href="./login.php?r=<?php echo urlencode("/index.php") ?>">Login</a>
            </div>
            <?php
    }
            ?>
        </nav>
        <?php
    $stmt = $connection->prepare(
        "SELECT id, name, image_file, background
        FROM items
        ORDER BY RAND()
        LIMIT 2");
    $stmt->execute();
    $result = $stmt->get_result();
        ?>
        <aside>
            <h1
                style="
                    text-align:center">Which is better?</h1>
            <div
                style="
                    display: flex;
                    justify-content: space-around;
                    align-items: center;
                    padding-block: 40px">
                <?php
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
                <a
                    href="./item.php?id=<?php echo $item["id"] ?>"
                    style="
                        width: 40%">
                    <div
                        style="
                            aspect-ratio: 1 / 1;
                            <?php echo $backgroundStyle ?>">
                        <img
                            src="./image/<?php
                                    echo pathinfo($item["image_file"], PATHINFO_FILENAME)
                                ?>.<?php
                                    echo pathinfo($item["image_file"], PATHINFO_EXTENSION)
                                ?>"
                            alt="<?php echo htmlspecialchars($item["name"]) ?>"
                            style="
                                width: 100%;
                                height: 100%;
                                object-fit: contain">
                    </div>
                    <span><?php echo htmlspecialchars($item["name"]) ?></span>
                </a>
                <span style="font-weight: bold; font-size: 48px">VS</span>
                <?php
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
                <a
                    href="./item.php?id=<?php echo $item["id"] ?>"
                    style="
                        width: 40%">
                    <div
                        style="
                            aspect-ratio: 1 / 1;
                            <?php echo $backgroundStyle ?>">
                        <img
                            src="./image/<?php
                                    echo pathinfo($item["image_file"], PATHINFO_FILENAME)
                                ?>.<?php
                                    echo pathinfo($item["image_file"], PATHINFO_EXTENSION)
                                ?>"
                            alt="<?php echo htmlspecialchars($item["name"]) ?>"
                            style="
                                width: 100%;
                                height: 100%;
                                object-fit: contain">
                    </div>
                    <span><?php echo htmlspecialchars($item["name"]) ?></span>
                </a>
            </div>
        </aside>
        <div>
            <h2
                style="
                    text-align: center;
                    margin-bottom: 20px">Browse Items</h2>
            <div
                style="
                    display: flex;
                    flex-wrap: wrap;
                    gap: 20px;
                    justify-content: center">
                <?php
    $stmt = $connection->prepare(
        "SELECT id, name, image_file, background
        FROM items
        ORDER BY RAND()");
    $stmt->execute();
    $result = $stmt->get_result();
    for ($i = 0; $i < $result->num_rows; $i++)
    {
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
                <a
                    href="./item.php?id=<?php echo $item["id"] ?>">
                    <div
                        style="
                            aspect-ratio: 1 / 1;
                            width: 200px;
                            <?php echo $backgroundStyle ?>">
                        <img
                            src="./image/<?php
                                    echo pathinfo($item["image_file"], PATHINFO_FILENAME)
                                ?>_thumb.<?php
                                    echo pathinfo($item["image_file"], PATHINFO_EXTENSION)
                                ?>"
                            alt="<?php echo htmlspecialchars($item["name"]) ?>"
                            style="
                                width: 100%;
                                height: 100%;
                                object-fit: contain">
                    </div>
                    <span><?php echo htmlspecialchars($item["name"]) ?></span>
                </a>
                <?php
    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>