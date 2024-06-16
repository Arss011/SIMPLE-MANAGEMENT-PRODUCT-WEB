<?php
    require_once "../functions.php";
    $reportMessage = ""; 

    

    
    if (isset($_POST["submit"])) {
        $selectId = $_POST["id"];

        $stmt = $conn->prepare("DELETE FROM soap_products WHERE id = ?");

        $stmt->bind_param("i", $selectId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $reportMessage = "products with id " . $selectId . " has been deleted";
            }
        } else {
            $reportMessage = "Error: " . $stmt->error;
        }

        // if (isset($_POST["submit"])) {
        //     mysqli_query($conn, "DELETE FROM soap_products WHERE id = $selectID");

        //     if (mysqli_affected_rows($conn) > 0) {
        //         $reportMessage = "Product with id 6 hasbeen remove";
        //     } else {
        //         $reportMessage = "Failed during delete product";
        //     }
        // }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Data</title>
</head>
<body>
<br>
    <?php
        if (isset($_POST["submit"])) {
            if (!empty($reportMessage)) { ?>
                <h1><?=$reportMessage;?></h1>
            <?php
            } else { ?>
                <h1><?="error";?> </h1>
            <?php }
        }
    ?>

    <h1>Delete data by ID</h1>
    <form action="" method="post">
        <ul>
            <li>
            <label for="id">Select ID</label>
            <input type="text" id="id" name="id">
            </li>
        </ul>

        <button type="submit" name="submit">Delete</button>
    </form>
</body>
</html>