<?php
    declare(strict_types = 1);
    require_once __DIR__."/php/sql-connection.php";
    $redirectUrl = isset($_GET["r"]) ? urldecode($_GET["r"]) : "/index.php";
    $creatingAccount = isset($_GET["new"]);

    $errorMessage = null;
    session_start();

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
            else if (strlen($password) === 0)
            {
                $errorMessage = "Password must not be empty";
            }
            else if (strlen($password) < 4)
            {
                $errorMessage = "Password must be at least 4 characters long";
            }
            else if (strlen($password) > 72)
            {
                $errorMessage = "Password must be at most 72 characters long";
            }
            else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                $errorMessage = "Email is not valid";
            }
            else if (strlen($email) > 320)
            {
                $errorMessage = "Email is too long";
            }
            else if (strlen($username) < 1)
            {
                $errorMessage = "Username must not be empty";
            }
            else if (strlen($username) > 32)
            {
                $errorMessage = "Username must be at most 32 characters long";
            }
            else if (!preg_match('/^[a-zA-Z0-9_]+$/', $username))
            {
                $errorMessage = "Username contains invalid characters";
            }
            else
            {
                $userId = random_int(0x10000000, 0xFFFFFFFF);

                $stmt = $connection->prepare(
                    "INSERT INTO users (id, username, email, password) VALUES (?, ?, ?, ?)");
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $stmt->bind_param(
                    "isss",
                    $userId,
                    $username,
                    $email,
                    $hashedPassword);

                if ($stmt->execute())
                {
                    $_SESSION["user_id"] = $userId;
                    $_SESSION["username"] = $username;
                    header("Location: ." . $redirectUrl, true);
                    die;
                }
                else
                {
                    define("DUPLICATE_ENTRY", 1062);

                    if ($connection->errno === DUPLICATE_ENTRY)
                    {
                        $errorMessage = "An account with that email already exists";
                    }
                    else
                    {
                        $errorMessage = "An unknown error occurred";
                        log_error("Database error " . $connection->errno . ": " . $connection->error);
                    }
                }
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

            if (strlen($password) === 0)
            {
                $errorMessage = "Password must not be empty";
            }
            else if (strlen($password) < 4)
            {
                $errorMessage = "Password would be at least 4 characters long";
            }
            else if (strlen($password) > 72)
            {
                $errorMessage = "Password would be at most 72 characters long";
            }
            else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
            {
                $errorMessage = "Email is not valid";
            }
            else if (strlen($email) > 320)
            {
                $errorMessage = "Email is too long";
            }
            else
            {
                $stmt = $connection->prepare(
                    "SELECT (id, password) FROM users WHERE email = ?");
                $stmt->bind_param(
                    "s",
                    $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0)
                {
                    $errorMessage = "No account with that email exists";
                }
                else if (!password_verify($password, $result->fetch_assoc()["password"]))
                {
                    $errorMessage = "Incorrect password";
                }
                else
                {
                    $_SESSION["user_id"] = $result->fetch_assoc()["id"];
                    $_SESSION["username"] = $username;
                    header("Location: ." . $redirectUrl, true);
                    die;
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Comparathing</title>
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
        <button type="submit">Create Account</button>
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
        <button type="submit">Login</button>
        <a href="./login.php?new&r=<?php echo urlencode($redirectUrl) ?>">Create Account Instead</a>
        <?php
            }
        ?>
    </form>
    <a href="<?php echo urlencode($redirectUrl) ?>"></a>
</body>
</html>