<?php
header('Content-Type: application/json');
require_once '../config.php';

$response = ['success' => false, 'message' => ''];

if (isset($_GET['id'])) {
    $account_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE id = ?");
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $response['success'] = true;
        $response['data'] = $result->fetch_assoc();
    } else {
        $response['message'] = 'الحساب غير موجود';
    }
    
    $stmt->close();
} else {
    $response['message'] = 'معرف الحساب مطلوب';
}

echo json_encode($response);
$conn->close();
?>
