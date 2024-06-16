<?php 
require "functions.php";

 if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }

    // $result = mysqli_query($conn,"SELECT * FROM soap_products");
    if(isset($_POST['search'])) {
        $searchInput = $_POST['search-input'];
        $query = "SELECT * FROM soap_products WHERE name LIKE '%$searchInput%' OR description LIKE '%$searchInput%' OR price LIKE '%$$searchInput%' OR qty LIKE '%$searchInput%' ORDER BY id";
    }else {
        $query = "SELECT * FROM soap_products";
    }

    $soapsProducts = queryGet($query, $conn);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Soap Products</title>

    <!-- <link rel="stylesheet" href="style.css"> -->
     <style>
        .search-bar {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
        }

        table, td, th {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
        padding: 20px;
        }

        table {
            width: 100%;
        }
     </style>

</head>

<body>
    <h1>List Soap Products</h1>

    <div class="management" style=" display: flex; flex-direction: row; gap:30px;">
        <h3><a href="insert_data/index.php">Insert New Data Product</a></h3>
        <h3><a href="delete_data/index.php">Delete Data product</a></h3>
        <div class="search-bar">
            <form action="" method="post"; >
                <input type="text" name="search-input" size="40px" placeholder="Search products" autofocus>
                <button type="submit" name="search">search</button>
            </form>
        </div>
    </div>

   

    <table>
        <tr>
            <th>No</th>
            <th>Picture</th>
            <th>Name</th>
            <th>Desc</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Update</th>
        </tr>

        <?php $no = 1;foreach ($soapsProducts as $row) : ?>
        <tr>
            <td><?= $no ?></td>
            <td><img style="width: 200px;" src="img/<?php echo $row["picture"] ?>" alt="<?php $row["picture"] ?>"></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["description"] ?></td>
            <td><?= $row["qty"] ?></td>
            <td><?= $row["price"] ?></td>
            <td><button onclick="window.location.href='update_data/index.php?id=<?= $row['id']?>'">Edit</button></td>
        </tr>
        <?php $no++; endforeach; ?>

    </table>

    <br>

</body>

</html>