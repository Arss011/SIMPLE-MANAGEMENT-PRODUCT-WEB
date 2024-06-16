<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require "../functions.php";
    $reportMessage = null;

    if (isset($_POST["submit"])) {
        $name = $_POST["nama"];
        $description = $_POST["description"];
        $qty = $_POST["qty"];
        $price = $_POST["price"];
        
        if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
            $allowed = array("jpg", "jpeg", "png", "gif");
            $fileName = $_FILES["picture"]["name"];
            $fileType = $_FILES["picture"]["type"];
            $fileSize = $_FILES["picture"]["size"];
            $fileTemp = $_FILES["picture"]["tmp_name"];
    
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed)) {
                $reportMessage = "Error: Please select a valid image file.";
            } else {
                $maxSize = 5 * 1024 * 1024;
                if ($fileSize > $maxSize) {
                    $reportMessage = "Error: File size is too large.";
                } else {
                    $uploadPath = "../img/";
                    $newFileName = uniqid() . "." . $ext;
                    if (move_uploaded_file($fileTemp, $uploadPath . $newFileName)) {
                        chmod($uploadPath . $newFileName, 0777);
                        $picture = $newFileName;

                        // Database operations
                        if ($conn) {
                            $stmt = $conn->prepare("INSERT INTO soap_products (name, description, qty, price, picture) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("ssiis", $name, $description, $qty, $price, $picture);

                            if ($stmt->execute()) {
                                $reportMessage = "Insert Data Success!";
                            } else {
                                $reportMessage = "Failed during data insertion.";
                            }

                            $stmt->close();
                            $conn->close();
                        } else {
                            $reportMessage = "Failed to connect to the database.";
                        }
                    } else {
                        $reportMessage = "Error: Failed to move uploaded file.";
                    }
                }
            }
        } else {
            $reportMessage = "Error: There was an error during the file upload.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <style>
        form {
            width: 320px;
        }
        ul {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        ul li {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        form button {
            margin-left: 40px;
        }
    </style>
</head>
<body>
    <h1>Insert Data</h1>
    <br>
    <?php if ($reportMessage !== null): ?>
        <h1><?= htmlspecialchars($reportMessage); ?></h1>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" required>
            </li>
            <li>
                <label for="description">Description</label>
                <input type="text" id="description" name="description" required>
            </li>
            <li>
                <label for="qty">Qty</label>
                <input type="number" id="qty" name="qty" required>
            </li>
            <li>
                <label for="price">Price</label>
                <input type="number" step="0.01" id="price" name="price" required>
            </li>
            <li style="gap:50px;">
                <label for="picture">Picture</label>
                <input type="file" id="picture" name="picture" required>
            </li>
        </ul>
        <button type="submit" name="submit">Insert Data</button>
    </form>
</body>
</html>
