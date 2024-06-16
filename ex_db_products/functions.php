<?php

$conn = mysqli_connect("localhost", "root", "", "ex_products");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function queryGet($sql, $conn) {
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $err = mysqli_error($conn);
        echo "Query error: " . $err;
        return false; // Return false to indicate error
    }

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function query($conn, $sql) {
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $err = mysqli_error($conn);
        echo "Query error: " . $err;
        return false; // Return false to indicate error
    }

    return true; // Return true on success
}

function queryInsert($sql) {
    global $conn;
    
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $err = mysqli_error($conn);
        echo "Insert query error: " . $err;
        return false; // Return false to indicate error
    }

    return true; // Return true on success
}

function queryDelete($sql) {
    global $conn;
    
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $err = mysqli_error($conn);
        echo "Delete query error: " . $err;
        return false; // Return false to indicate error
    }

    return true; // Return true on success
}

?>
