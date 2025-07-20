<?php
header('Content-Type: application/json');
require_once '../config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';
    $name = $_POST['name'] ?? '';
    $type_id = $_POST['type_id'] ?? '';
    $opening_balance = $_POST['opening_balance'] ?? 0;
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'active';
    
    // التحقق من البيانات
    if (empty($code) || empty($name) || empty($type_id)) {
        $response['message'] = 'جميع الحقول المطلوبة يجب أن تكون ممتلئة';
        echo json_encode($response);
        exit;
    }
    
    // إدخال الحساب الجديد
    $stmt = $conn->prepare("INSERT INTO accounts (code, name, type_id, opening_balance, current_balance, description, status, created_by) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, 'system')");
    $stmt->bind_param("ssiddss", $code, $name, $type_id, $opening_balance, $opening_balance, $description, $status);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'تم إضافة الحساب بنجاح';
    } else {
        $response['message'] = 'حدث خطأ أثناء إضافة الحساب: ' . $conn->error;
    }
    
    $stmt->close();
} else {
    $response['message'] = 'طريقة الطلب غير صحيحة';
}

echo json_encode($response);
$conn->close();
?>
