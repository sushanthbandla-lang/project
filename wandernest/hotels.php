<?php

require_once "config/database.php";

// Fetch all hotels
$sql = "SELECT * FROM hotels
        ORDER BY id ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hotels - WanderNest</title>

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
     HOTELS SECTION
========================= -->

<section class="py-5">

    <div class="container">

        <!-- Page Heading -->

        <div class="text-center mb-5">

            <h1 class="fw-bold">
                Hotels
            </h1>

            <p class="text-muted">
                Find comfortable and luxurious hotels for your next journey.
            </p>

        </div>


        <!-- Hotel Cards -->

        <div class="row g-4">

            <?php if (empty($hotels)): ?>

                <div class="col-12">

                    <div class="alert alert-info text-center">

                        No hotels are currently available.

                    </div>

                </div>

            <?php else: ?>


                <?php foreach ($hotels as $hotel): ?>

                    <div class="col-lg-4 col-md-6">

                        <div class="card h-100 shadow-sm">


                            <!-- =========================
                                 HOTEL IMAGE
                            ========================== -->

                            <?php if (!empty($hotel['image'])): ?>

                                <img
                                    src="assets/images/hotels/<?= htmlspecialchars($hotel['image']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($hotel['hotel_name']) ?>"
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
                                 HOTEL DETAILS
                            ========================== -->

                            <div class="card-body d-flex flex-column">


                                <!-- Hotel Name -->

                                <h5 class="card-title">

                                    <?= htmlspecialchars($hotel['hotel_name']) ?>

                                </h5>


                                <!-- Room Type -->

                                <?php if (!empty($hotel['room_type'])): ?>

                                    <span class="badge bg-primary align-self-start mb-2">

                                        <?= htmlspecialchars($hotel['room_type']) ?>

                                    </span>

                                <?php endif; ?>


                                <!-- Description -->

                                <p class="card-text text-muted">

                                    <?= htmlspecialchars($hotel['description'] ?? '') ?>

                                </p>


                                <!-- Price -->

                                <h5 class="text-success mt-auto">

                                    ₹<?= number_format($hotel['price_per_night'], 2) ?>

                                    <small class="text-muted fs-6">
                                        / night
                                    </small>

                                </h5>


                                <!-- View Details -->

                                <a
                                    href="hotel-details.php?id=<?= $hotel['id'] ?>"
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