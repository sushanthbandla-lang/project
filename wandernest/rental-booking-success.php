<?php

require_once "config/database.php";


// Get booking ID
$booking_id = $_GET['id'] ?? 0;


// Fetch booking details
$sql = "SELECT 
            rb.*,
            r.vehicle_name,
            r.vehicle_type,
            r.price_per_day
        FROM rental_bookings rb
        INNER JOIN rentals r
            ON rb.rental_id = r.id
        WHERE rb.id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $booking_id
]);

$booking = $stmt->fetch(PDO::FETCH_ASSOC);


// Check booking
if (!$booking) {

    die("Booking not found.");

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

    <title>Booking Successful - WanderNest</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>


<body>


<?php include "includes/navbar.php"; ?>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">


            <div class="card shadow-sm border-0">

                <div class="card-body p-5 text-center">


                    <div class="mb-4">

                        <h1 class="text-success fw-bold">
                            Booking Successful!
                        </h1>

                        <p class="lead text-muted">
                            Your rental vehicle has been booked successfully.
                        </p>

                    </div>


                    <hr>


                    <div class="text-start mt-4">


                        <h4 class="fw-bold mb-3">
                            Booking Details
                        </h4>


                        <p>
                            <strong>Booking ID:</strong>
                            <?= htmlspecialchars($booking['id']) ?>
                        </p>


                        <p>
                            <strong>Vehicle:</strong>
                            <?= htmlspecialchars($booking['vehicle_name']) ?>
                        </p>


                        <p>
                            <strong>Vehicle Type:</strong>
                            <?= htmlspecialchars($booking['vehicle_type']) ?>
                        </p>


                        <p>
                            <strong>Customer Name:</strong>
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
                            <strong>Pickup Date:</strong>
                            <?= htmlspecialchars($booking['pickup_date']) ?>
                        </p>


                        <p>
                            <strong>Return Date:</strong>
                            <?= htmlspecialchars($booking['return_date']) ?>
                        </p>


                        <p>
                            <strong>Total Price:</strong>

                            <span class="text-success fw-bold">

                                ₹<?= number_format($booking['total_price'], 2) ?>

                            </span>

                        </p>


                        <p>
                            <strong>Status:</strong>

                            <span class="badge bg-warning text-dark">

                                <?= htmlspecialchars($booking['status']) ?>

                            </span>

                        </p>


                    </div>


                    <div class="mt-4">

                        <a
                            href="rentals.php"
                            class="btn btn-primary"
                        >
                            Back to Rentals
                        </a>

                        <a
                            href="index.php"
                            class="btn btn-outline-secondary ms-2"
                        >
                            Back to Home
                        </a>

                    </div>


                </div>

            </div>


        </div>

    </div>

</div>


<?php include "includes/footer.php"; ?>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>