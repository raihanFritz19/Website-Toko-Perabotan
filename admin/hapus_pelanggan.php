<?php
// Include the database connection file with the correct path
include '../koneksi.php';

// Check if the id parameter is present in the URL
if (isset($_GET['id'])) {
    $id_pelanggan = $_GET['id'];

    // Prepare the delete query
    $query = "DELETE FROM pelanggan WHERE id_pelanggan = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_pelanggan);

    if ($stmt->execute()) {
        // Data deleted successfully
        header("Location: index.php?halaman=pelanggan");
        exit();
    } else {
        // Error handling
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Redirect if no id is provided
    header("Location: index.php?halaman=pelanggan");
    exit();
}

$koneksi->close();
?>
