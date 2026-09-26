<?php

session_start();

require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: hotels.php");
    exit;
}

$hotel_id = (int) $_GET["id"];

$stmt = $pdo->prepare("
    SELECT 
        h.*,
        d.name AS destination_name,
        d.country
    FROM hotels h
    LEFT JOIN destinations d 
        ON h.destination_id = d.id
    WHERE h.id = ?
");

$stmt->execute([$hotel_id]);

$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hotel) {
    die("Hotel not found.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= htmlspecialchars($hotel["hotel_name"]) ?> - WanderNest
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f8f9fa;
            font-family: Arial, Helvetica, sans-serif;
        }

        .hotel-details {
            padding: 60px 0;
        }

        .hotel-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .hotel-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .hotel-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .location {
            color: #777;
            margin-bottom: 20px;
        }

        .price {
            font-size: 28px;
            font-weight: bold;
            color: #198754;
            margin: 20px 0;
        }

        .room-type {
            background: #f1f3f5;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .description {
            line-height: 1.8;
            color: #555;
        }

    </style>

</head>

<body>

<?php include "includes/navbar.php"; ?>

<div class="container hotel-details">

    <div class="row g-5 align-items-start">

        <!-- HOTEL IMAGE -->

        <div class="col-lg-6">

            <?php

            $image = trim($hotel["image"]);

            if ($image !== "") {

                $image_path = "assets/images/hotels/" . $image;

            } else {

                $image_path = "assets/images/home.jpg";

            }

            ?>

            <img
                src="<?= htmlspecialchars($image_path) ?>"
                alt="<?= htmlspecialchars($hotel["hotel_name"]) ?>"
                class="hotel-image"
            >

        </div>


        <!-- HOTEL INFORMATION -->

        <div class="col-lg-6">

            <div class="hotel-card">

                <h1 class="hotel-title">

                    <?= htmlspecialchars($hotel["hotel_name"]) ?>

                </h1>


                <div class="location">

                    📍

                    <?= htmlspecialchars($hotel["destination_name"] ?? "Destination") ?>

                    <?php if (!empty($hotel["country"])): ?>

                        ,

                        <?= htmlspecialchars($hotel["country"]) ?>

                    <?php endif; ?>

                </div>


                <?php if (!empty($hotel["room_type"])): ?>

                    <div class="room-type">

                        🛏️

                        <?= htmlspecialchars($hotel["room_type"]) ?>

                    </div>

                <?php endif; ?>


                <p class="description">

                    <?= nl2br(htmlspecialchars($hotel["description"])) ?>

                </p>


                <div class="price">

                    ₹<?= number_format($hotel["price_per_night"], 2) ?>

                    <small class="text-muted fs-6">

                        / night

                    </small>

                </div>


                <a
                    href="book-hotel.php?id=<?= $hotel["id"] ?>"
                    class="btn btn-primary btn-lg w-100"
                >

                    🏨 Book This Hotel

                </a>


                <a
                    href="hotels.php"
                    class="btn btn-outline-secondary w-100 mt-3"
                >

                    ← Back to Hotels

                </a>

            </div>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>

</html>