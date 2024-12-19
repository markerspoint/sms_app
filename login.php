<?php
require_once 'db/database.php';

$username = $number = $password = "";
$errors = [];

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $number = trim($_POST['number']);
    $password = trim($_POST['password']);

    // Validate required fields
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($number)) {
        $errors[] = "Phone number is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check credentials in the database
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE username = :username AND number = :number");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':number', $number);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Redirect to messaging menu after successful login
                header('Location: messaging.php');
                exit;
            } else {
                $errors[] = "Invalid username, phone number, or password.";
            }
        } else {
            $errors[] = "Invalid username or phone number.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Linking the new CSS file -->
</head>

<body>
    <h1>Login</h1>
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div class="formL">
            <div>
                <label for="username"></label><br> <!-- Username -->
                <input type="text" id="username" name="username" placeholder="Username"
                    value="<?php echo htmlspecialchars($username); ?>" required><br><br>
            </div>
            <div>
                <label for="number"></label><br> <!-- Phone Number -->
                <input type="text" id="number" name="number" placeholder="Phone Number"
                value="<?php echo htmlspecialchars($number); ?>" required><br><br>
            </div>
            <div>
                <label for="password"></label><br> <!-- Password -->
                <input type="password" id="password" name="password" placeholder="Password" required><br><br>
            </div>
        </div>
        <button type="submit">Login</button>

            <!-- Register link -->
            <p>Don't have an account? <a href="register.php" id="register-link">Register here</a></p>
    </form>
</body>

</html>
