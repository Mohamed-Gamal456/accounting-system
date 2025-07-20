<?php
header('Content-Type: application/json');
require_once '../config.php';

$sql = "SELECT t.*, a.name as account_name 
        FROM transactions t
        JOIN accounts a ON t.account_id = a.id
        ORDER BY t.created_at DESC";
$result = $conn->query($sql);

$transactions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

echo json_encode($transactions);
$conn->close();
?>
