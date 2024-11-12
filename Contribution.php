<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';
 include 'header.php';
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];

    $stmt = $conn->prepare("INSERT INTO contributions (user_id, amount, contribution_date, status) VALUES (?, ?, NOW(), 'paid')");
    if ($stmt->execute([$user_id, $amount])) {
        echo "Contribution recorded successfully!";
    } else {
        echo "Error: Could not record contribution.";
    }
}

// Pata michango ya mtumiaji
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT amount, contribution_date FROM contributions WHERE user_id = ?");
$stmt->execute([$user_id]);
$contributions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <!-- Contribution Form -->
    <h1>Contribute Now</h1>
    <form method="POST" action="contribution.php">
        <input type="number" name="amount" placeholder="Contribution Amount" required>
        <button type="submit">Submit Contribution</button>
    </form>

    <!-- Onyesha Orodha ya Michango -->
    <h2>Michango Yako</h2>
    <table>
        <tr>
            <th>Kiasi</th>
            <th>Tarehe ya Mchango</th>
        </tr>
        <?php foreach ($contributions as $contribution): ?>
        <tr>
            <td><?php echo htmlspecialchars($contribution['amount']); ?></td>
            <td><?php echo htmlspecialchars($contribution['contribution_date']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


