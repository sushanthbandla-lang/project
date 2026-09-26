<?php

require_once "config/database.php";


/*
|--------------------------------------------------------------------------
| Check if a destination filter was provided
|--------------------------------------------------------------------------
*/

$destination_id = null;

if (
    isset($_GET['destination'])
    && is_numeric($_GET['destination'])
) {

    $destination_id = (int) $_GET['destination'];

}


/*
|--------------------------------------------------------------------------
| Get trips from database
|--------------------------------------------------------------------------
*/

if ($destination_id !== null) {

    $stmt = $pdo->prepare(
        "SELECT
            trips.*,
            destinations.name AS destination_name,
            destinations.country
         FROM trips
         INNER JOIN destinations
            ON trips.destination_id = destinations.id
         WHERE trips.destination_id = ?
         ORDER BY trips.id ASC"
    );

    $stmt->execute([$destination_id]);

} else {

    $stmt = $pdo->query(
        "SELECT
            trips.*,
            destinations.name AS destination_name,
            destinations.country
         FROM trips
         INNER JOIN destinations
            ON trips.destination_id = destinations.id
         ORDER BY trips.id ASC"
    );

}


$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Trips - WanderNest</title>


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


<!-- Trips Section -->

<section class="py-5">

    <div class="container">


        <!-- Page Heading -->

        <div class="section-title">

            <h1>
                Explore Our Trips
            </h1>

            <p>
                Choose a package for your next adventure.
            </p>

        </div>


        <?php if (empty($trips)): ?>


            <!-- No Trips -->

            <div class="alert alert-warning text-center">

                No trips are currently available
                for this destination.

            </div>


        <?php else: ?>


            <!-- Trip Cards -->

            <div class="row g-4">


                <?php foreach ($trips as $trip): ?>


                    <div class="col-lg-4 col-md-6">


                        <div class="card h-100 shadow-sm">


                            <!-- Trip Image -->

                            <?php if (!empty($trip['image'])): ?>

                                <img
                                    src="assets/images/trips/<?= htmlspecialchars($trip['image']) ?>"
                                    class="card-img-top"
                                    alt="<?= htmlspecialchars($trip['package_name']) ?>"
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


                            <div class="card-body">


                                <!-- Country -->

                                <span class="badge bg-primary mb-2">

                                    <?= htmlspecialchars(
                                        $trip['country']
                                    ) ?>

                                </span>


                                <!-- Package Name -->

                                <h4 class="card-title">

                                    <?= htmlspecialchars(
                                        $trip['package_name']
                                    ) ?>

                                </h4>


                                <!-- Destination -->

                                <h6 class="text-muted">

                                    📍

                                    <?= htmlspecialchars(
                                        $trip['destination_name']
                                    ) ?>

                                </h6>


                                <!-- Description -->

                                <p class="card-text mt-3">

                                    <?= htmlspecialchars(
                                        $trip['description']
                                    ) ?>

                                </p>


                                <!-- Duration -->

                                <p>

                                    <strong>
                                        Duration:
                                    </strong>

                                    <?= $trip['duration_days'] ?>

                                    Days /

                                    <?= $trip['duration_nights'] ?>

                                    Nights

                                </p>


                                <!-- Price -->

                                <h5 class="text-primary">

                                    ₹<?= number_format(
                                        $trip['price']
                                    ) ?>

                                </h5>


                                <!-- Details Button -->

                                <a
                                    href="trip-details.php?id=<?= $trip['id'] ?>"
                                    class="btn btn-primary mt-2"
                                >

                                    View Details

                                </a>


                            </div>

                        </div>

                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </div>

</section>


<!-- Footer -->

<?php include "includes/footer.php"; ?>


</body>

</html>