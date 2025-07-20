<?php
header('Content-Type: application/json');
require_once '../config.php';

$sql = "SELECT a.*, at.name as type_name 
        FROM accounts a
        JOIN account_types at ON a.type_id = at.id
        ORDER BY a.code";
$result = $conn->query($sql);

$accounts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
}

echo json_encode($accounts);
$conn->close();
?>
