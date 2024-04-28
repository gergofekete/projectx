<?php

include('../session.php');
access("USER");

include('../php/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if deletion was requested
    if (isset($_POST['delete'])) {
        // Delete the specified item
        $id = $_POST['delete'];
        $query = "DELETE FROM kosar WHERE kosar_id = ?";
        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        header('Location: kosar.php');
        exit;
    } elseif (isset($_POST['termek_id'])) { // Check if checkout process was requested
        $termek_ids = $_POST['termek_id'];
        $termek_nevek = $_POST['termek_neve'];
        $total = $_POST['total']; 
        $darabszamok = $_POST['darab'];

        for ($i = 0; $i < count($termek_ids); $i++) {
            $termek_id = $termek_ids[$i];
            $termek_nev = $termek_nevek[$i];
            $darab = $darabszamok[$i];

            // Adjust this query if 'ar' is supposed to be the price of individual items
            $query = "INSERT INTO rendeles (termek_id, termek_nev, ar, darab) VALUES (?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt, "isii", $termek_id, $termek_nev, $total, $darab); // Note: `$total` might be incorrect here
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
        header('Location: checkout.php');
        exit;
    }
}

// Close connection
mysqli_close($con);
?>
