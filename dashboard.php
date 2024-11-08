<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';
include 'header.php';

// Fetch user contributions
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM contributions WHERE user_id = ?");
$stmt->execute([$user_id]);
$contributions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
    <h2>Your Contributions</h2>
    <table>
        <tr>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
        <?php foreach ($contributions as $contribution): ?>
            <tr>
                <td><?php echo htmlspecialchars($contribution['contribution_date']); ?></td>
                <td><?php echo htmlspecialchars($contribution['amount']); ?></td>
                <td><?php echo htmlspecialchars($contribution['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>
