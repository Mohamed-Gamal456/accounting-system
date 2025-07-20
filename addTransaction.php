<?php
header('Content-Type: application/json');
require_once '../config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account_id = $_POST['account_id'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    $description = $_POST['description'] ?? '';
    
    if (empty($account_id) || empty($amount)) {
        $response['message'] = 'الحساب والمبلغ مطلوبان';
        echo json_encode($response);
        exit;
    }
    
    // بدء معاملة قاعدة البيانات
    $conn->begin_transaction();
    
    try {
        // إدخال المعاملة
        $stmt = $conn->prepare("INSERT INTO transactions (account_id, amount, description) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $account_id, $amount, $description);
        $stmt->execute();
        
        // تحديث رصيد الحساب
        $updateStmt = $conn->prepare("UPDATE accounts SET current_balance = current_balance + ? WHERE id = ?");
        $updateStmt->bind_param("di", $amount, $account_id);
        $updateStmt->execute();
        
        $conn->commit();
        $response['success'] = true;
        $response['message'] = 'تمت إضافة المعاملة بنجاح';
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = 'حدث خطأ: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'طريقة الطلب غير صحيحة';
}

echo json_encode($response);
$conn->close();
?>
