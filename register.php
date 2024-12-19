<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db/database.php';

// Initialize variables
$name = $username = $number = $email = $password = $confirmPassword = "";
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $number = trim($_POST['number']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Validate required fields
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($number)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match('/^\+?\d{10,15}$/', $number)) {
        $errors[] = "Invalid phone number format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, insert into database
    if (empty($errors)) {
        try {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO contacts (name, username, number, email, password) VALUES (:name, :username, :number, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                // Redirect to login page after registration
                header('Location: login.php');
                exit;
            } else {
                echo "<p>Failed to register contact. Please try again.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Contact</title>
    <link rel="stylesheet" href="css/register.css"> <!-- Linking the CSS file -->
</head>
<body>
    <h1>Register Contact</h1>
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-row">
            <div>
                <label for="name"></label> <!-- contact name -->
                <input type="text" id="name" name="name" placeholder="Contact Name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div>
                <label for="username"></label> <!-- username -->
                <input type="text" id="username" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
        </div>

        <label for="number"></label> <!-- Phone number -->
        <input type="text" id="number" name="number" placeholder="Phone Number" value="<?php echo htmlspecialchars($number); ?>" required><br><br>

        <label for="email"></label> <!-- Email -->
        <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>"><br><br>

        <label for="password"></label> <!-- password -->
        <input type="password" id="password" name="password" placeholder="Password" required><br><br>

        <label for="confirm_password"></label> <!-- confirm password -->
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br><br>

        <button type="submit">Register</button>

        <!-- Sign in option -->
        <p>Already have an account? <a id="signin-link" href="login.php">Sign in</a></p>
    </form>
    

</body>
</html>
