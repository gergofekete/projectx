<?php
include('../session.php');
access("USER");

include('../php/config.php');

// Get user input from the form
$termekId  = $_POST['termekId'];
$termekNev = $_POST['termekNev'];
$szelesseg = $_POST['szelesseg'];
$mennyiseg = $_POST['mennyiseg'];
$ar        = $_POST['ar'];

// Prepare SQL query to insert the data into the cart table
$query = "INSERT INTO kosar (termek_id, termek_neve, szelesseg, darab, ara) VALUES (?, ?, ?, ?, ?)";

if ($stmt = mysqli_prepare($con, $query)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "isiii", $termekId, $termekNev, $szelesseg, $mennyiseg, $ar);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Check for successful insertion
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Close statement
        mysqli_stmt_close($stmt);
        // Close connection
        mysqli_close($con);

        // Redirect to vasarlas.php
        header('Location: vasarlas.php');
        exit;
    } else {
        echo "Error adding product to cart.";
        // Close statement
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Error: " . mysqli_error($con);
}

// Close connection
mysqli_close($con);
?>

