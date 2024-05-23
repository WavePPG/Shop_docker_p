<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<nav>
    <?php include('navbar_edit_delete.php')?>
</nav>
<div class="container mt-5">
    <div class="row">
        <?php 
        include('../server.php'); 
        include('update_product.php');
        // Fetch and display data from the product table
        $sql_select = "SELECT * FROM product";
        $result_select = mysqli_query($conn, $sql_select);

        if (mysqli_num_rows($result_select) > 0) {
            $count = 0;
            while($row = mysqli_fetch_assoc($result_select)) {
                if ($count % 4 == 0 && $count != 0) {
                    echo "</div><div class='row mt-4'>";
                }
                // Add ID to each product card
                echo "<div class='col-md-3 mb-4' id='product{$row['id']}'>
                        <div class='card'>
                            <img src='../image/{$row['image']}' class='card-img-top' alt='{$row['pro_name']}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$row['pro_name']}</h5>
                                <p class='card-text'>
                                    Description: {$row['pro_description']}<br>
                                    Price: {$row['price']}<br>
                                    Amount: {$row['amount']}
                                </p>
                                <button class='btn btn-primary' data-toggle='modal' data-target='#editModal{$row['id']}'>Edit</button>
                                <button class='btn btn-danger' onclick='deleteProduct({$row['id']})'>Delete</button>
                            </div>
                        </div>
                      </div>";

                // Edit Modal
                echo "<div class='modal fade' id='editModal{$row['id']}' tabindex='-1' aria-labelledby='editModalLabel{$row['id']}' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='editModalLabel{$row['id']}'>Edit Product</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <form action='update_product.php' method='POST' enctype='multipart/form-data'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <div class='form-group'>
                                            <label for='pro_name'>Product Name</label>
                                            <input type='text' class='form-control' id='pro_name' name='pro_name' value='{$row['pro_name']}' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='pro_description'>Description</label>
                                            <input type='text' class='form-control' id='pro_description' name='pro_description' value='{$row['pro_description']}' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='price'>Price</label>
                                            <input type='number' class='form-control' id='price' name='price' value='{$row['price']}' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='amount'>Amount</label>
                                            <input type='number' class='form-control' id='amount' name='amount' value='{$row['amount']}' required>
                                        </div>
                                        <div class='form-group'>
                                            <label for='image'>Product Image</label>
                                            <input type='file' class='form-control-file' id='image' name='image'>
                                        </div>
                                        <button type='submit' id='saveChangesBtn' class='btn btn-primary'>Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                      </div>";
                $count++;
            }
            echo "</div>";
        } else {
            echo "<p>No product found.</p>";
        }

        mysqli_close($conn);
        ?>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function redirectToProducts() {
        window.location.href = "product.php";
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("saveChangesBtn").addEventListener("click", redirectToProducts);
    });

    function deleteProduct(productId) {
        if (confirm("คุณต้องการลบสินค้านี้ใช่หรือไม่?")) {
            // ส่ง request ไปยังไฟล์ PHP เพื่อลบข้อมูล
            $.ajax({
                url: 'delete_product.php',
                type: 'POST',
                data: { id: productId },
                success: function(response) {
                    console.log('Response from server: ', response); // เพิ่มการดีบัก
                    if (response.trim() === 'success') { // เพิ่ม trim เพื่อความแน่นอน
                        // รีเฟรชหน้าเว็บหลังจากทำการลบข้อมูลเรียบร้อย
                        location.reload();
                    } else {
                        alert('เกิดข้อผิดพลาดในการลบข้อมูล: ' + response);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert('เกิดข้อผิดพลาดในการลบข้อมูล: ' + thrownError);
                }
            });
        }
    }
</script>

</body>
</html>
