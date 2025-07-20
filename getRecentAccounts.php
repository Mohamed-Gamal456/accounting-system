<?php
header('Content-Type: application/json');
require_once '../config.php';

// إحصائيات النظام
$stats = [
    'totalAccounts' => 0,
    'totalTransactions' => 0,
    'systemBalance' => 0,
    'recentAccounts' => []
];

// جلب عدد الحسابات
$result = $conn->query("SELECT COUNT(*) as count FROM accounts");
if ($result) {
    $stats['totalAccounts'] = $result->fetch_assoc()['count'];
}

// جلب عدد المعاملات
$result = $conn->query("SELECT COUNT(*) as count FROM transactions");
if ($result) {
    $stats['totalTransactions'] = $result->fetch_assoc()['count'];
}

// جلب رصيد النظام (مجموع أرصدة الحسابات)
$result = $conn->query("SELECT SUM(current_balance) as balance FROM accounts");
if ($result) {
    $stats['systemBalance'] = $result->fetch_assoc()['balance'] ?? 0;
}

// جلب آخر 5 حسابات مضافة
$result = $conn->query("SELECT code, name FROM accounts ORDER BY id DESC LIMIT 5");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $stats['recentAccounts'][] = $row;
    }
}

echo json_encode($stats);
$conn->close();
?>
