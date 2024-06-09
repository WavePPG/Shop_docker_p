<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// The rest of your code goes here
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../server.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" >

</head>
<body>
    <nav>
        <?php include('navbaronback-end.php')?>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
            <div class="alert alert-primary h4 text-center" role="alert">เพิ่มข้อมูลสินค้า</div>
                <form name="form1" method="post" action="insert_product.php" enctype="multipart/form-data">
                    <label>ชื่อสินค้า:</label>
                    <input type="text" name="pname" class="form-control" placeholder="ชื่อสินค้า..." required> <br>
                    <label>description:</label>
                    <input type="text" name="pro_description" class="form-control" placeholder="description..." required> <br>

                    <label>ประเภทสินค้า:</label>
                    <select class="form-select" name="typeID">
                        <?php 
                        $sql="SELECT * FROM type ORDER BY type_name";
                        $hand=mysqli_query($conn,$sql);
                        while($row=mysqli_fetch_array($hand)){ 
                        ?>
                        <option value="<?php echo $row['type_id']; ?>"><?php echo $row['type_name']; ?></option>
                        <?php 
                        } 
                        mysqli_close($conn);
                        ?>
                    </select>
                    <label>ราคา:</label>
                    <input type="price" name="price" class="form-control" placeholder="ราคา..." required> <br>

                    <label>จำนวน:</label>
                    <input type="num" name="num" class="form-control" placeholder="จำนวน..." required> <br>
                    <label>รูปภาพ:</label><br>
                    <input type="file" name="file1" require > <br>
                    <button type="submit" class="btn btn-secondary mt-4">Submit</button>
                    <button class="btn btn-danger mt-4" type="cancle" >Cancle</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
