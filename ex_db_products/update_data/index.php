<?php
    require "../functions.php";

    $reportMessage = "";

    $id = $_GET['id'] ? intval($_GET['id']) :0;

    $product = queryGet("SELECT * FROM soap_products WHERE id = $id", $conn)[0];

    if (isset($_POST["submit"])) {
        $name = $_POST["name"];
        $description = $_POST["description"];
        $qty = $_POST["qty"];
        $price = $_POST["price"];
        $picture = $_POST["picture"];

        // query("UPDATE soap_products SET name='$name', description='$description', qty='$qty', price='$price', picture='$picture", $conn);

        $stmt = $conn->prepare("UPDATE soap_products SET name=?, description=?, qty=?, price=?, picture=? WHERE id=?");

        $stmt->bind_param("ssiisi", $name, $description, $qty, $price, $picture, $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $reportMessage = "products id" . $id . " has been update";
                header("Location: ../index.php");
                exit();
            }
        } else {
            $reportMessage = "Failed to Update Product";
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
</head>
<body>
    
    <h2>Change Data Product</h2>

    <?php if(empty($reportMessage)){
        echo $reportMessage;
    } else {
        echo $reportMessage . mysqli_error( $conn );
    }

    ?>

    <form action="" method="post">
            <ul>
                <li>
                    <h2>ID: <?=$id?></h2>
                </li>
                <li>
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="<?= $product["name"]?>">
                </li>
                <li>
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" value="<?= $product['description']?>">
                </li>
                <li>
                    <label for="qty">Qty</label>
                    <input type="text" id="qty" name="qty" value="<?= $product["qty"]?>">
                </li>
                <li>
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" value="<?= $product['price']?>">
                </li>
                <li>
                    <label for="picture">Picture</label>
                    <input type="text" id="picture" name="picture" value="<?= $product["picture"]?>">
                </li>
            </ul>
            <div style="display:inline-flex; gap:30px;">

            </div>
            <button type="submit" name="submit">Update Data</button>
            <!-- <button onclick="">Back to Home</button> -->
        </form>


</body>
</html>