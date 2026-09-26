<?php

require_once "config/database.php";

/*
|--------------------------------------------------------------------------
| Get destination ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid destination.");
}

$destination_id = (int) $_GET['id'];


/*
|--------------------------------------------------------------------------
| Fetch destination
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare(
    "SELECT * FROM destinations WHERE id = ?"
);

$stmt->execute([$destination_id]);

$destination = $stmt->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Check whether destination exists
|--------------------------------------------------------------------------
*/

if (!$destination) {
    die("Destination not found.");
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
        <?= htmlspecialchars($destination['name']) ?>
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

<?php include "includes/navbar.php"; ?>


<!-- Destination Header -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h1 class="display-4 fw-bold">

            <?= htmlspecialchars($destination['name']) ?>

        </h1>

        <p class="lead">

            <?= htmlspecialchars($destination['country']) ?>

        </p>

    </div>

</section>


<!-- Destination Details -->

<section class="py-5">

    <div class="container">

        <div class="row g-5">


            <!-- Information -->

            <div class="col-lg-8">

                <h2>

                    About
                    <?= htmlspecialchars($destination['name']) ?>

                </h2>

                <p class="mt-3">

                    <?= htmlspecialchars(
                        $destination['description']
                    ) ?>

                </p>


                <hr class="my-4">


                <h3>
                    Destination Information
                </h3>


                <div class="row mt-3">

                    <div class="col-md-6 mb-3">

                        <div class="card shadow-sm">

                            <div class="card-body">

                                <h6 class="text-muted">
                                    Country
                                </h6>

                                <h5>
                                    <?= htmlspecialchars(
                                        $destination['country']
                                    ) ?>
                                </h5>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <div class="card shadow-sm">

                            <div class="card-body">

                                <h6 class="text-muted">
                                    Best Time to Visit
                                </h6>

                                <h5>
                                    <?= htmlspecialchars(
                                        $destination['best_time']
                                    ) ?>
                                </h5>

                            </div>

                        </div>

                    </div>


                    <div class="col-md-6 mb-3">

                        <div class="card shadow-sm">

                            <div class="card-body">

                                <h6 class="text-muted">
                                    Starting Price
                                </h6>

                                <h5 class="text-primary">

                                    ₹<?= number_format(
                                        $destination['starting_price']
                                    ) ?>

                                </h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Booking Panel -->

            <div class="col-lg-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h4 class="card-title">
                            Plan Your Journey
                        </h4>

                        <p class="text-muted">
                            Explore available packages
                            and accommodation.
                        </p>


                        <a
                            href="trips.php?destination=<?= $destination['id'] ?>"
                            class="btn btn-primary w-100 mb-2"
                        >
                            ✈ View Trips
                        </a>


                        <a
                            href="hotels.php?destination=<?= $destination['id'] ?>"
                            class="btn btn-outline-primary w-100"
                        >
                            🏨 View Hotels
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- Reviews Preview -->

<section class="bg-light py-5">

    <div class="container text-center">

        <h2>
            Enjoy <?= htmlspecialchars($destination['name']) ?>
        </h2>

        <p class="text-muted">
            Find trips, hotels and rental options for
            your journey.
        </p>

        <a
            href="reviews.php"
            class="btn btn-dark"
        >
            ⭐ Read Reviews
        </a>

    </div>

</section>


<?php include "includes/footer.php"; ?>
