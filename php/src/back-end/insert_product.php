

<?php

include('../server.php'); 

$p_name = $_POST['pname'];
$description = $_POST['pro_description'];
$type_id = $_POST['typeID'];
$price = $_POST['price'];
$num = $_POST['num'];

// Upload image
if (is_uploaded_file($_FILES['file1']['tmp_name'])) {
    $new_image_name = 'pro_' . uniqid() . "." . pathinfo(basename($_FILES['file1']['name']), PATHINFO_EXTENSION);
    $image_upload_path = "../image/" . $new_image_name;
    move_uploaded_file($_FILES['file1']['tmp_name'], $image_upload_path);
} else {
    $new_image_name = "";
}

// Insert data
$sql = "INSERT INTO product(pro_name, pro_description, type_id, price, amount, image) VALUES('$p_name', '$description', '$type_id', '$price', '$num', '$new_image_name')";

$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<script>alert('บันทึกข้อมูลเรียบร้อย');</script>";
    echo "<script>window.location='uploadproduct.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
}
?>
