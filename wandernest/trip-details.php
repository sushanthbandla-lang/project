<?php

require_once "config/database.php";


/*
|--------------------------------------------------------------------------
| Check Trip ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    die("Invalid trip.");

}


$trip_id = (int) $_GET['id'];


/*
|--------------------------------------------------------------------------
| Get Trip Information
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    "SELECT
        trips.*,
        destinations.name AS destination_name,
        destinations.country AS destination_country,
        destinations.description AS destination_description
     FROM trips
     INNER JOIN destinations
        ON trips.destination_id = destinations.id
     WHERE trips.id = ?"
);

$stmt->execute([$trip_id]);

$trip = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Check Trip Exists
|--------------------------------------------------------------------------
*/

if (!$trip) {

    die("Trip not found.");

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

        <?= htmlspecialchars($trip['package_name']) ?>

        - WanderNest

    </title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Custom CSS -->

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>


<body>


<!-- Navigation -->

<?php include "includes/navbar.php"; ?>


<!-- Trip Header -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h1 class="display-5 fw-bold">

            <?= htmlspecialchars(
                $trip['package_name']
            ) ?>

        </h1>


        <p class="lead">

            📍

            <?= htmlspecialchars(
                $trip['destination_name']
            ) ?>

            ,

            <?= htmlspecialchars(
                $trip['destination_country']
            ) ?>

        </p>

    </div>

</section>


<!-- Trip Details -->

<section class="py-5">

    <div class="container">

        <div class="row g-4">


            <!-- Main Information -->

            <div class="col-lg-8">

                <div class="card shadow-sm">


                    <!-- Trip Image -->

                    <?php if (!empty($trip['image'])): ?>

                        <img
                            src="assets/images/trips/<?= htmlspecialchars($trip['image']) ?>"
                            class="card-img-top"
                            alt="<?= htmlspecialchars($trip['package_name']) ?>"
                            style="height: 350px; object-fit: cover;"
                        >

                    <?php else: ?>

                        <div
                            class="bg-light d-flex align-items-center justify-content-center"
                            style="height: 350px;"
                        >

                            <span class="text-muted">
                                No Image Available
                            </span>

                        </div>

                    <?php endif; ?>


                    <div class="card-body p-4">


                        <h2>

                            <?= htmlspecialchars(
                                $trip['package_name']
                            ) ?>

                        </h2>


                        <p class="text-muted">

                            📍

                            <?= htmlspecialchars(
                                $trip['destination_name']
                            ) ?>

                        </p>


                        <hr>


                        <h4>
                            About This Trip
                        </h4>


                        <p class="mt-3">

                            <?= htmlspecialchars(
                                $trip['description']
                            ) ?>

                        </p>


                        <h4 class="mt-4">

                            Trip Duration

                        </h4>


                        <p>

                            <?= $trip['duration_days'] ?>

                            Days /

                            <?= $trip['duration_nights'] ?>

                            Nights

                        </p>


                        <h4 class="mt-4">

                            Destination

                        </h4>


                        <p>

                            <?= htmlspecialchars(
                                $trip['destination_description']
                            ) ?>

                        </p>


                    </div>

                </div>

            </div>


            <!-- Booking Summary -->

            <div class="col-lg-4">

                <div class="card shadow-sm">

                    <div class="card-body p-4">


                        <h4>
                            Trip Price
                        </h4>


                        <h2 class="text-primary">

                            ₹<?= number_format(
                                $trip['price']
                            ) ?>

                        </h2>


                        <p class="text-muted">

                            Price per person

                        </p>


                        <hr>


                        <p>

                            <strong>
                                Destination:
                            </strong>

                            <?= htmlspecialchars(
                                $trip['destination_name']
                            ) ?>

                        </p>


                        <p>

                            <strong>
                                Duration:
                            </strong>

                            <?= $trip['duration_days'] ?>

                            Days /

                            <?= $trip['duration_nights'] ?>

                            Nights

                        </p>


                        <!-- Booking Button -->

                        <a
                            href="book-trip.php?id=<?= $trip['id'] ?>"
                            class="btn btn-primary w-100 mt-3"
                        >

                            ✈️ Book This Trip

                        </a>


                        <!-- Back Button -->

                        <a
                            href="trips.php?destination=<?= $trip['destination_id'] ?>"
                            class="btn btn-outline-secondary w-100 mt-2"
                        >

                            ← Back to Trips

                        </a>


                    </div>

                </div>

            </div>


        </div>

    </div>

</section>


<!-- Footer -->

<?php include "includes/footer.php"; ?>


</body>

</html>