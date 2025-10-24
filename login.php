<?php
    declare(strict_types = 1);
    require_once __DIR__."/php/sql-connection.php";
    $redirectUrl = isset($_GET["r"]) ? urldecode($_GET["r"]) : "/index.php";
    $creatingAccount = isset($_GET["new"]);

    $errorMessage = null;

    if ($creatingAccount)
    {
        if (isset($_POST["username"])
            && isset($_POST["email"])
            && isset($_POST["password"])
            && isset($_POST["confirm-password"]))
        {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            if ($_POST["confirm-password"] !== $password)
            {
                $errorMessage = "Passwords must match";
            }
            else
            {
                header("Location: ." . $redirectUrl, true);
                exit;
            }
        }
    }
    else
    {
        if (isset($_POST["email"])
            && isset($_POST["password"]))
        {
            $email = $_POST["email"];
            $password = $_POST["password"];

            {
                header("Location: ." . $redirectUrl, true);
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
</head>
<body>
    <form method="post">
        <?php require __DIR__.'/$/logo.php' ?>
        <?php
            if ($creatingAccount)
            {
        ?>
        <label for="login-username">
            <span>Username</span>
            <input
                type="text"
                id="login-username"
                name="username"
                placeholder="Username",
                autocomplete="username">
        </label>
        <label for="login-email">
            <span>Email</span>
            <input
                type="email"
                id="login-email"
                name="email"
                placeholder="your@email.com"
                autocomplete="email"
                required>
        </label>
        <label for="login-password">
            <span>Password</span>
            <input
                type="password"
                id="login-password"
                name="password"
                placeholder="Password"
                autocomplete="new-password"
                required>
        </label>
        <label for="login-confirm-password">
            <span>Confirm Password</span>
            <input
                type="password"
                id="confirm-password"
                name="confirm-password"
                placeholder="Confirm Password"
                required>
        </label>
        <?php
                if ($errorMessage !== null)
                {
        ?>
        <span class="error"><?php echo $errorMessage ?></span>
        <?php
                }
        ?>
        <button type="submit"></button>
        <a href="./login.php?r=<?php echo urlencode($redirectUrl) ?>">Use Existing Account Instead</a>
        <?php
            }
            else
            {
        ?>
        <label for="login-email">
            <span>Email</span>
            <input
                type="email"
                id="login-email"
                name="email"
                placeholder="your@email.com"
                autocomplete="email"
                required>
        </label>
        <label for="login-password">
            <span>Password</span>
            <input
                type="password"
                id="login-password"
                name="password"
                placeholder="Password"
                autocomplete="current-password"
                required>
        </label>
        <?php
                if ($errorMessage !== null)
                {
        ?>
        <span class="error"><?php echo $errorMessage ?></span>
        <?php
                }
        ?>
        <button
            type="submit"
            id=""></button>
        <a href="./login.php?new&r=<?php echo urlencode($redirectUrl) ?>">Create Account Instead</a>
        <?php
            }
        ?>
    </form>
    <a href="<?php echo urlencode($redirectUrl) ?>"></a>
</body>
</html>