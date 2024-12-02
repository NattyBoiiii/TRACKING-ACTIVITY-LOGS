<?php
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

function displayAuditLogs($pdo) {
    $stmt = $pdo->query("SELECT * FROM audit_log ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$logs = displayAuditLogs($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Audit Log</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <h1>Audit Logs</h1>
    <style>
        body {
            font-family: "Arial";
        }
        input {
            font-size: 1.5em;
            height: 50px;
            width: 200px;
        }
        table, th, td {
            border:1px solid black;
        }
    </style>
    <table>
        <thead>
        <table style="width:100%; margin-top: 50px;">
            <tr>
                <th>Log ID</th>
                <th>Action</th>
                <th>Username</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo $log['log_id']; ?></td>
                    <td><?php echo htmlspecialchars($log['action']); ?></td>
                    <td><?php echo htmlspecialchars($log['username']); ?></td>
                    <td><?php echo $log['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <input type="submit" value="Return" onclick="window.location.href='index.php'">
</body>
</html>