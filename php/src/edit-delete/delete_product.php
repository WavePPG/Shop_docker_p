<?php
include('../server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['id'];
    
    // ตรวจสอบว่ามี id ที่ส่งมาหรือไม่
    if (isset($productId)) {
        $sql_delete = "DELETE FROM product WHERE id = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("i", $productId);
        
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
        
        $stmt->close();
    } else {
        echo 'no_id';
    }
} else {
    echo 'invalid_request';
}

mysqli_close($conn);
?>
