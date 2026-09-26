<?php

require_once "config/database.php";

// Fetch available rentals
$sql = "SELECT * FROM rentals
        WHERE available = 1
        ORDER BY id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rentals - WanderNest</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Website CSS -->
    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<?php include "includes/navbar.php"; ?>


<!-- =========================
     RENTALS SECTION
========================= -->

<section class="py-5">

    <div class="container">

        <!-- Page Heading -->
        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Vehicle Rentals
            </h1>

            <p class="text-muted">
                Explore our vehicles and choose the perfect rental for your journey.
            </p>

        </div>


        <!-- Rental Cards -->

        <div class="row g-4">

            <?php if (empty($rentals)): ?>

                <div class="col-12">

                    <div class="alert alert-info text-center">

                        No rental vehicles are currently available.

                    </div>

                </div>

            <?php else: ?>


                <?php foreach ($rentals as $rental): ?>

                    <div class="col-lg-4 col-md-6">

                        <div class="card h-100 shadow-sm">


                            <!-- =========================
                                 RENTAL IMAGE
                            ========================== -->

                            <?php if (!empty($rental['image'])): ?>

                                <img
                                    src="assets/images/rentals/<?= htmlspecialchars($rental['image']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($rental['vehicle_name']) ?>"
                                    style="height: 220px; object-fit: cover;"
                                >

                            <?php else: ?>

                                <div
                                    class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 220px;"
                                >

                                    <span class="text-muted">
                                        No Image Available
                                    </span>

                                </div>

                            <?php endif; ?>


                            <!-- =========================
                                 RENTAL DETAILS
                            ========================== -->

                            <div class="card-body d-flex flex-column">


                                <!-- Vehicle Type -->

                                <span class="badge bg-primary align-self-start mb-2">

                                    <?= htmlspecialchars($rental['vehicle_type']) ?>

                                </span>


                                <!-- Vehicle Name -->

                                <h5 class="card-title">

                                    <?= htmlspecialchars($rental['vehicle_name']) ?>

                                </h5>


                                <!-- Description -->

                                <p class="card-text text-muted">

                                    <?= htmlspecialchars($rental['description'] ?? '') ?>

                                </p>


                                <!-- Price -->

                                <h5 class="text-success mt-auto">

                                    ₹<?= number_format($rental['price_per_day'], 2) ?>

                                    <small class="text-muted fs-6">
                                        / day
                                    </small>

                                </h5>


                                <!-- View Details Button -->

                                <a
                                    href="rental-details.php?id=<?= $rental['id'] ?>"
                                    class="btn btn-primary mt-3"
                                >
                                    View Details
                                </a>


                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>


            <?php endif; ?>

        </div>

    </div>

</section>


<?php include "includes/footer.php"; ?>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>