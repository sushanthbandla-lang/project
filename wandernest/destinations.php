<?php

require_once "config/database.php";

$stmt = $pdo->query(
    "SELECT * FROM destinations ORDER BY id ASC"
);

$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Destinations - WanderNest</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<?php include "includes/navbar.php"; ?>


<section class="py-5">

    <div class="container">

        <div class="section-title">

            <h1>Explore Destinations</h1>

            <p>
                Discover beautiful places around the world.
            </p>

        </div>


        <div class="row g-4">

            <?php foreach ($destinations as $destination): ?>

                <div class="col-lg-4 col-md-6">

                    <div class="card h-100 shadow-sm">

                        <!-- Destination Image -->
                        <?php if (!empty($destination['image'])): ?>

                            <img
                                src="assets/images/destinations/<?= htmlspecialchars($destination['image']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($destination['name']) ?>"
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

                            <h3 class="card-title">
                                <?= htmlspecialchars($destination['name']) ?>
                            </h3>

                            <h6 class="text-primary">
                                <?= htmlspecialchars($destination['country']) ?>
                            </h6>

                            <p class="card-text mt-3">
                                <?= htmlspecialchars($destination['description']) ?>
                            </p>

                            <p>
                                <strong>
                                    Starting from:
                                </strong>

                                ₹<?= number_format(
                                    $destination['starting_price']
                                ) ?>
                            </p>

                            <p>
                                <strong>
                                    Best time:
                                </strong>

                                <?= htmlspecialchars(
                                    $destination['best_time']
                                ) ?>
                            </p>

                            <a
                                href="destination.php?id=<?= $destination['id'] ?>"
                                class="btn btn-primary"
                            >
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>


<?php include "includes/footer.php"; ?>

</body>

</html>