<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect to the login page if not logged in
    header("Location: ../back-end/login.php");
    exit();
}

// Handle form submission for editing a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
    include('../server.php');
    $id = $_POST['id'];
    $pro_name = $_POST['pro_name'];
    $pro_description = $_POST['pro_description'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];

    // Handle file upload if a new image is uploaded
    if ($_FILES['image']['name']) {
        $target_dir = "../image/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        $image = $_FILES['image']['name'];
        $sql_update = "UPDATE product SET pro_name='$pro_name', pro_description='$pro_description', price='$price', amount='$amount', image='$image' WHERE id='$id'";
    } else {
        $sql_update = "UPDATE product SET pro_name='$pro_name', pro_description='$pro_description', price='$price', amount='$amount' WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql_update)) {
        echo "success";
    } else {
        echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            background-color: #f9f9f9;
            color: #333;
            margin-top: 15vh;
        }

        header {
            background-color: #ffffff;
            padding: 20px 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            height: 60px;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .logo {
            flex: 1;
        }

        .logo h4 {
            margin: 0;
        }

        .nav-links {
            display: flex;
            justify-content: flex-end;
            flex: 2;
            list-style: none;
        }

        .nav-links li {
            margin-left: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            padding: 8px 12px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #007BFF;
        }

        @media (max-width: 768px) {
            header {
                padding: 10px 20px;
            }

            .nav-links {
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-links li {
                margin-left: 0;
                margin-top: 10px;
            }
        }

        .table img {
            width: 100px;
            height: auto;
        }

        .modal-content {
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h4>Back-end</h4>
            </div>
            <ul class="nav-links">
                <li><a href="../back-end/uploadproduct.php">Add Product</a></li>
                <li><a href="../edit-delete/edit.php">Edit</a></li>
                <li><a href="../back-end/logout.php" style="color: red;">Logout</a></li> <!-- Added Logout Button -->
            </ul>
        </nav>
    </header>
    <div class="container mt-5">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include('../server.php'); 
                    $sql_select = "SELECT * FROM product";
                    $result_select = mysqli_query($conn, $sql_select);

                    if (mysqli_num_rows($result_select) > 0) {
                        while($row = mysqli_fetch_assoc($result_select)) {
                            echo "<tr id='product{$row['id']}'>
                                    <td><img src='../image/{$row['image']}' class='card-img-top' alt='{$row['pro_name']}'></td>
                                    <td>{$row['pro_name']}</td>
                                    <td>{$row['pro_description']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['amount']}</td>
                                    <td>
                                        <button class='btn btn-primary' data-toggle='modal' data-target='#editModal{$row['id']}'>Edit</button>
                                        <button class='btn btn-danger' onclick='deleteProduct({$row['id']})'>Delete</button>
                                    </td>
                                  </tr>";

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
                                                <form id='editForm{$row['id']}' method='POST' enctype='multipart/form-data'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='edit_product' value='1'>
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
                                                    <button type='submit' class='btn btn-primary'>Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                  </div>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No product found.</td></tr>";
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function deleteProduct(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: 'delete_product.php',
                    type: 'POST',
                    data: { id: productId },
                    success: function(response) {
                        if (response.trim() === 'success') {
                            location.reload();
                        } else {
                            alert('Error deleting product: ' + response);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert('Error deleting product: ' + thrownError);
                    }
                });
            }
        }

        // AJAX form submission for editing a product
        $(document).ready(function() {
            $('form[id^="editForm"]').on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'edit.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.trim() === 'success') {
                            location.reload();
                        } else {
                            alert('Error editing product: ' + response);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert('Error editing product: ' + thrownError);
                    }
                });
            });
        });
    </script>

</body>
</html>
