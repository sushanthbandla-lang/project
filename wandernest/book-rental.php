<?php

require_once "config/database.php";


// Get rental ID
$rental_id = $_GET['id'] ?? 0;


// Fetch rental information
$sql = "SELECT * FROM rentals
        WHERE id = :id
        AND available = 1";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $rental_id
]);

$rental = $stmt->fetch(PDO::FETCH_ASSOC);


// Check whether rental exists
if (!$rental) {

    die("Rental vehicle not found.");

}


// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customer_name = trim($_POST['customer_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];


    // Calculate number of rental days
    $pickup = new DateTime($pickup_date);
    $return = new DateTime($return_date);

    $days = $pickup->diff($return)->days;


    // Minimum one day
    if ($days < 1) {
        $days = 1;
    }


    // Calculate total price
    $total_price = $days * $rental['price_per_day'];


    // Insert booking
    $sql = "INSERT INTO rental_bookings
            (
                rental_id,
                customer_name,
                email,
                phone,
                pickup_date,
                return_date,
                total_price,
                status
            )
            VALUES
            (
                :rental_id,
                :customer_name,
                :email,
                :phone,
                :pickup_date,
                :return_date,
                :total_price,
                'Pending'
            )";


    $stmt = $pdo->prepare($sql);


    $stmt->execute([

        ':rental_id' => $rental_id,

        ':customer_name' => $customer_name,

        ':email' => $email,

        ':phone' => $phone,

        ':pickup_date' => $pickup_date,

        ':return_date' => $return_date,

        ':total_price' => $total_price

    ]);


    // Get inserted booking ID
    $booking_id = $pdo->lastInsertId();


    // Redirect to confirmation page
    header(
        "Location: rental-booking-success.php?id=" . $booking_id
    );

    exit;

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
        Book <?= htmlspecialchars($rental['vehicle_name']) ?> - WanderNest
    </title>


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


            <div class="card shadow-sm">

                <div class="card-body p-4">


                    <h2 class="fw-bold mb-4">

                        Book Your Rental

                    </h2>


                    <!-- Selected Vehicle -->

                    <div class="alert alert-info">

                        <strong>
                            <?= htmlspecialchars($rental['vehicle_name']) ?>
                        </strong>

                        <br>

                        <?= htmlspecialchars($rental['vehicle_type']) ?>

                        <br>

                        ₹<?= number_format($rental['price_per_day'], 2) ?>
                        / day

                    </div>


                    <!-- Booking Form -->

                    <form method="POST">


                        <!-- Customer Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="customer_name"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Email -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Phone -->

                        <div class="mb-3">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                required
                            >

                        </div>


                        <div class="row">


                            <!-- Pickup Date -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Pickup Date
                                </label>

                                <input
                                    type="date"
                                    name="pickup_date"
                                    class="form-control"
                                    required
                                >

                            </div>


                            <!-- Return Date -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Return Date
                                </label>

                                <input
                                    type="date"
                                    name="return_date"
                                    class="form-control"
                                    required
                                >

                            </div>


                        </div>


                        <!-- Submit -->

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100"
                        >

                            Confirm Rental Booking

                        </button>


                    </form>


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