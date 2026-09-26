<?php

session_start();

require_once "config/database.php";

$booking_id = $_GET['id'] ?? 0;

if (!$booking_id) {
    header("Location: hotels.php");
    exit;
}

$sql = "SELECT 
            hb.*,
            h.hotel_name,
            h.room_type,
            h.image
        FROM hotel_bookings hb
        INNER JOIN hotels h ON hb.hotel_id = h.id
        WHERE hb.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id' => $booking_id
]);

$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hotel Booking Successful - WanderNest</title>

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

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow text-center">

                <div class="card-body p-5">

                    <h1 class="text-success mb-3">
                        Booking Confirmed!
                    </h1>

                    <p class="lead">
                        Thank you for booking with WanderNest.
                    </p>

                    <hr>

                    <h4 class="mb-4">
                        Booking Details
                    </h4>

                    <div class="text-start">

                        <p>
                            <strong>Booking ID:</strong>
                            <?= htmlspecialchars($booking['id']) ?>
                        </p>

                        <p>
                            <strong>Hotel:</strong>
                            <?= htmlspecialchars($booking['hotel_name']) ?>
                        </p>

                        <p>
                            <strong>Room Type:</strong>
                            <?= htmlspecialchars($booking['room_type']) ?>
                        </p>

                        <p>
                            <strong>Name:</strong>
                            <?= htmlspecialchars($booking['customer_name']) ?>
                        </p>

                        <p>
                            <strong>Email:</strong>
                            <?= htmlspecialchars($booking['email']) ?>
                        </p>

                        <p>
                            <strong>Phone:</strong>
                            <?= htmlspecialchars($booking['phone']) ?>
                        </p>

                        <p>
                            <strong>Check-in:</strong>
                            <?= htmlspecialchars($booking['check_in']) ?>
                        </p>

                        <p>
                            <strong>Check-out:</strong>
                            <?= htmlspecialchars($booking['check_out']) ?>
                        </p>

                        <p>
                            <strong>Rooms:</strong>
                            <?= htmlspecialchars($booking['rooms']) ?>
                        </p>

                        <p>
                            <strong>Guests:</strong>
                            <?= htmlspecialchars($booking['guests']) ?>
                        </p>

                        <p>
                            <strong>Total Price:</strong>
                            ₹<?= number_format($booking['total_price'], 2) ?>
                        </p>

                        <p>
                            <strong>Status:</strong>
                            <?= htmlspecialchars($booking['status']) ?>
                        </p>

                    </div>

                    <hr>

                    <a
                        href="hotels.php"
                        class="btn btn-primary"
                    >
                        Back to Hotels
                    </a>

                    <a
                        href="index.php?home=1"
                        class="btn btn-outline-secondary"
                    >
                        Go to Home
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>

</html>