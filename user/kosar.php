<?php

include('../session.php');
access("USER");

include('../php/config.php');

$query = "SELECT * FROM kosar";
$result = mysqli_query($con, $query);

$total = 0;

echo "<form action='process_checkout.php' method='post' class='container mt-5'>";
echo "<table class='table'>";
echo "<thead class='thead-dark'><tr><th>Termék Név</th><th>Szélesség</th><th>Darab</th><th>Ár</th><th>Művelet</th></tr></thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['darab'] * $row['ara'];
    $total += $subtotal;

    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['termek_neve']) . "</td>";
    echo "<input type='hidden' name='termek_neve[]' value='" . htmlspecialchars($row['termek_neve']) . "'>";
    echo "<input type='hidden' name='ara[]' value='" . $row['ara'] . "'>";
    echo "<input type='hidden' name='termek_id[]' value='" . $row['termek_id'] . "'>";
    echo "<input type='hidden' name='darab[]' value='" . $row['darab'] . "'>";
    echo "<td>" . htmlspecialchars($row['szelesseg']) . "</td>";
    echo "<td><input type='number' name='mennyiseg[" . $row['kosar_id'] . "]' value='" . $row['darab'] . "' min='1' class='form-control quantity' data-id='" . $row['kosar_id'] . "' onchange='updateQuantity(this)'></td>";
    echo "<td>" . $row['ara'] . " Ft/db</td>";
    echo "<td><button type='delete' name='delete' value='" . $row['kosar_id'] . "' class='btn btn-danger'>Törlés</button></td>";

    echo "</tr>";
}

echo "</tbody>";
echo "<tfoot><tr><th colspan='3'>Összesen</th><th>" . $total . " Ft</th><th></th></tr></tfoot>";
echo "<input type='hidden' name='total' value='" . $total . "'>";
echo "</table>";

echo "<a style=\"margin-bottom: 1%;\" href=\"vasarlas.php\" class='btn btn-primary'>Vásárlás folytatása</a>";
echo "</table>";
echo "<button type='submit' class='btn btn-primary'>Tovább a fizetésre</button>";
echo "</form>";

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    function updateQuantity(elem) {
        var kosarId = $(elem).data('id');
        var newQuantity = $(elem).val();
        $.ajax({
            url: 'update_cart_quantity.php',
            type: 'POST',
            data: { kosar_id: kosarId, quantity: newQuantity },
            success: function(response) {
                console.log('Quantity updated successfully');
                location.reload();
            },
            error: function() {
                alert('Error updating quantity');
            }
        });
    }
    </script>
</head>
<body>
    <header>
        <!-- Navigation placeholder -->
    </header>
    <div class="container">
        <!-- Main content -->
    </div>
</body>
</html>
