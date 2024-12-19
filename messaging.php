<?php
require_once 'db/database.php';

// Fetch all registered contacts
$stmt = $pdo->query("SELECT id, name, number, email FROM contacts ORDER BY created_at DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaging Menu</title>
    <script src="js/messaging.js" defer></script>
    <link rel="stylesheet" href="css/messaging.css">
</head>
<body>
    <h1>Messaging Menu</h1>

    <!-- Button to toggle sidebar -->
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">☰ Menu</button>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <ul>
            <li><a href="javascript:void(0);" onclick="showContactsModal()">View Contacts</a></li>
            <li><a href="#send-message">Send a Message</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Modal for Contacts -->
    <div id="contactsModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeContactsModal()">&times;</span>
            <h2>Registered Contacts</h2>
            <?php if (!empty($contacts)): ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                <td><?php echo htmlspecialchars($contact['number']); ?></td>
                                <td><?php echo htmlspecialchars($contact['email'] ?? 'N/A'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No contacts found.</p>
            <?php endif; ?>
        </div>
    </div>

    <h2 id="send-message">Send a Message</h2>
    <form action="send_message.php" method="POST">
        <label for="contact">Select Contact:</label><br>
        <select id="contact" name="contact" required>
            <?php foreach ($contacts as $contact): ?>
                <option value="<?php echo $contact['id']; ?>">
                    <?php echo htmlspecialchars($contact['name'] . " (" . $contact['number'] . ")"); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Send</button>
    </form>
</body>
</html>
