<?php

require_once "config/database.php";


// Get rental ID from URL
$id = $_GET['id'] ?? 0;


// Fetch rental details
$sql = "SELECT * FROM rentals
        WHERE id = :id
        AND available = 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$rental = $stmt->fetch(PDO::FETCH_ASSOC);


// If rental does not exist
if (!$rental) {

    die("Rental vehicle not found.");

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($rental['vehicle_name']) ?> - WanderNest
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>


<?php include "includes/navbar.php"; ?>


<div class="container py-5">

    <div class="row g-5">


        <!-- VEHICLE IMAGE -->

        <div class="col-md-6">

            <?php if (!empty($rental['image'])): ?>

                <img
                    src="assets/images/rentals/<?= htmlspecialchars($rental['image']) ?>"
                    class="img-fluid rounded shadow"
                    alt="<?= htmlspecialchars($rental['vehicle_name']) ?>"
                    style="width: 100%; max-height: 450px; object-fit: cover;"
                >

            <?php else: ?>

                <div
                    class="bg-light rounded shadow d-flex align-items-center justify-content-center"
                    style="height: 400px;"
                >

                    <span class="text-muted fs-5">
                        No Image Available
                    </span>

                </div>

            <?php endif; ?>

        </div>


        <!-- VEHICLE INFORMATION -->

        <div class="col-md-6">


            <span class="badge bg-primary mb-3">

                <?= htmlspecialchars($rental['vehicle_type']) ?>

            </span>


            <h1 class="fw-bold">

                <?= htmlspecialchars($rental['vehicle_name']) ?>

            </h1>


            <p class="text-muted mt-3">

                <?= htmlspecialchars(
                    $rental['description'] ?? ''
                ) ?>

            </p>


            <h3 class="text-success mt-4">

                ₹<?= number_format(
                    $rental['price_per_day'],
                    2
                ) ?>

                <small class="text-muted fs-6">
                    / day
                </small>

            </h3>


            <div class="alert alert-success mt-4">

                Vehicle is currently available for booking.

            </div>


            <!-- BOOK NOW -->

            <a
                href="book-rental.php?id=<?= $rental['id'] ?>"
                class="btn btn-primary btn-lg mt-2"
            >

                Book Now

            </a>


            <!-- BACK -->

            <a
                href="rentals.php"
                class="btn btn-outline-secondary btn-lg mt-2 ms-2"
            >

                Back to Rentals

            </a>


        </div>

    </div>

</div>


<?php include "includes/footer.php"; ?>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>