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
    SELECT *
    FROM hotels
    WHERE id = ?
");

$stmt->execute([$hotel_id]);

$hotel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$hotel) {
    die("Hotel not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_name = trim($_POST["customer_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];
    $rooms = (int) $_POST["rooms"];
    $guests = (int) $_POST["guests"];

    if (
        $customer_name === "" ||
        $email === "" ||
        $check_in === "" ||
        $check_out === ""
    ) {

        $error = "Please fill in all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif ($check_out <= $check_in) {

        $error = "Check-out date must be after check-in date.";

    } else {

        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);

        $nights = $check_in_date->diff($check_out_date)->days;

        $total_price =
            $nights *
            $rooms *
            $hotel["price_per_night"];

        $stmt = $pdo->prepare("
            INSERT INTO hotel_bookings
            (
                hotel_id,
                customer_name,
                email,
                phone,
                check_in,
                check_out,
                rooms,
                guests,
                total_price,
                status
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
        ");

        $stmt->execute([
            $hotel_id,
            $customer_name,
            $email,
            $phone,
            $check_in,
            $check_out,
            $rooms,
            $guests,
            $total_price
        ]);

        header("Location: hotel-details.php?id=" . $hotel_id . "&booking=success");
        exit;
    }
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
        Book <?= htmlspecialchars($hotel["hotel_name"]) ?> - WanderNest
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

        .booking-section {
            padding: 50px 0;
        }

        .booking-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.10);
        }

        .hotel-preview {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .hotel-name {
            font-size: 30px;
            font-weight: bold;
            margin-top: 20px;
        }

        .hotel-price {
            color: #198754;
            font-size: 24px;
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
        }

    </style>

</head>

<body>

<?php include "includes/navbar.php"; ?>


<div class="container booking-section">

    <div class="row g-5">


        <!-- HOTEL PREVIEW -->

        <div class="col-lg-6">

            <?php

            $image = trim($hotel["image"]);

            if ($image !== "") {

                $image_path =
                    "assets/images/hotels/" . $image;

            } else {

                $image_path =
                    "assets/images/home.jpg";

            }

            ?>

            <img
                src="<?= htmlspecialchars($image_path) ?>"
                alt="<?= htmlspecialchars($hotel["hotel_name"]) ?>"
                class="hotel-preview"
            >


            <h2 class="hotel-name">

                <?= htmlspecialchars($hotel["hotel_name"]) ?>

            </h2>


            <p class="text-muted">

                🛏️

                <?= htmlspecialchars(
                    $hotel["room_type"] ?? "Room"
                ) ?>

            </p>


            <div class="hotel-price">

                ₹<?= number_format(
                    $hotel["price_per_night"],
                    2
                ) ?>

                <small class="text-muted">

                    / night

                </small>

            </div>


            <?php if (!empty($hotel["description"])): ?>

                <p class="mt-3 text-muted">

                    <?= nl2br(
                        htmlspecialchars($hotel["description"])
                    ) ?>

                </p>

            <?php endif; ?>

        </div>


        <!-- BOOKING FORM -->

        <div class="col-lg-6">

            <div class="booking-card">

                <h2 class="mb-4">

                    🏨 Book Your Stay

                </h2>


                <?php if ($error !== ""): ?>

                    <div class="alert alert-danger">

                        <?= htmlspecialchars($error) ?>

                    </div>

                <?php endif; ?>


                <form method="POST">


                    <div class="mb-3">

                        <label class="form-label">

                            Full Name *

                        </label>

                        <input
                            type="text"
                            name="customer_name"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Email *

                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label class="form-label">

                            Phone

                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                        >

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Check-in *

                            </label>

                            <input
                                type="date"
                                name="check_in"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Check-out *

                            </label>

                            <input
                                type="date"
                                name="check_out"
                                class="form-control"
                                required
                            >

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Rooms

                            </label>

                            <input
                                type="number"
                                name="rooms"
                                class="form-control"
                                value="1"
                                min="1"
                                required
                            >

                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Guests

                            </label>

                            <input
                                type="number"
                                name="guests"
                                class="form-control"
                                value="1"
                                min="1"
                                required
                            >

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary btn-lg w-100 mt-3"
                    >

                        Confirm Hotel Booking

                    </button>


                    <a
                        href="hotel-details.php?id=<?= $hotel["id"] ?>"
                        class="btn btn-outline-secondary w-100 mt-3"
                    >

                        ← Back to Hotel

                    </a>

                </form>

            </div>

        </div>

    </div>

</div>


<?php include "includes/footer.php"; ?>


</body>

</html>