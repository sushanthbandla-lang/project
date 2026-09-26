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
        destinations.country AS destination_country
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


/*
|--------------------------------------------------------------------------
| Booking Variables
|--------------------------------------------------------------------------
*/

$success = "";
$error = "";


/*
|--------------------------------------------------------------------------
| Process Booking Form
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $customer_name = trim($_POST['customer_name'] ?? '');

    $email = trim($_POST['email'] ?? '');

    $phone = trim($_POST['phone'] ?? '');

    $travel_date = $_POST['travel_date'] ?? '';

    $adults = (int) ($_POST['adults'] ?? 1);

    $children = (int) ($_POST['children'] ?? 0);

    $special_requests = trim(
        $_POST['special_requests'] ?? ''
    );


    /*
    |--------------------------------------------------------------------------
    | Validate Form
    |--------------------------------------------------------------------------
    */

    if (
        $customer_name === '' ||
        $email === '' ||
        $travel_date === ''
    ) {

        $error = "Please fill in all required fields.";

    }


    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    }


    elseif ($adults < 1) {

        $error = "At least one adult is required.";

    }


    elseif ($children < 0) {

        $error = "Number of children cannot be negative.";

    }


    else {


        /*
        |--------------------------------------------------------------------------
        | Calculate Total Price
        |--------------------------------------------------------------------------
        |
        | Price is per adult.
        | Children are currently charged at 50%.
        |
        */

        $adult_price = $trip['price'];

        $child_price = $trip['price'] * 0.50;


        $total_price =
            ($adults * $adult_price)
            +
            ($children * $child_price);


        /*
        |--------------------------------------------------------------------------
        | Insert Booking
        |--------------------------------------------------------------------------
        */

        $insert = $pdo->prepare(
            "INSERT INTO trip_bookings
            (
                trip_id,
                customer_name,
                email,
                phone,
                travel_date,
                adults,
                children,
                total_price,
                special_requests,
                status
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                'Pending'
            )"
        );


        $insert->execute([
            $trip_id,
            $customer_name,
            $email,
            $phone,
            $travel_date,
            $adults,
            $children,
            $total_price,
            $special_requests
        ]);


        $success =
            "Your trip booking has been submitted successfully.";

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

        Book
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


<!-- Page Header -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h1>
            Book Your Trip
        </h1>

        <p class="lead">

            <?= htmlspecialchars(
                $trip['package_name']
            ) ?>

        </p>

    </div>

</section>


<!-- Booking Section -->

<section class="py-5">

    <div class="container">

        <div class="row g-4">


            <!-- Booking Form -->

            <div class="col-lg-8">

                <div class="card shadow-sm">

                    <div class="card-body p-4">


                        <h3 class="mb-4">
                            Your Details
                        </h3>


                        <?php if ($success): ?>

                            <div class="alert alert-success">

                                <?= htmlspecialchars($success) ?>

                                <br><br>

                                <strong>
                                    Total Booking Amount:
                                </strong>

                                ₹<?= number_format(
                                    $total_price
                                ) ?>

                            </div>

                        <?php endif; ?>


                        <?php if ($error): ?>

                            <div class="alert alert-danger">

                                <?= htmlspecialchars($error) ?>

                            </div>

                        <?php endif; ?>


                        <form
                            method="POST"
                            action="book-trip.php?id=<?= $trip['id'] ?>"
                        >


                            <!-- Name -->

                            <div class="mb-3">

                                <label
                                    for="customer_name"
                                    class="form-label"
                                >
                                    Full Name *
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="customer_name"
                                    name="customer_name"
                                    required
                                >

                            </div>


                            <!-- Email -->

                            <div class="mb-3">

                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    Email Address *
                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    required
                                >

                            </div>


                            <!-- Phone -->

                            <div class="mb-3">

                                <label
                                    for="phone"
                                    class="form-label"
                                >
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                >

                            </div>


                            <!-- Travel Date -->

                            <div class="mb-3">

                                <label
                                    for="travel_date"
                                    class="form-label"
                                >
                                    Travel Date *
                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="travel_date"
                                    name="travel_date"
                                    required
                                >

                            </div>


                            <div class="row">


                                <!-- Adults -->

                                <div class="col-md-6 mb-3">

                                    <label
                                        for="adults"
                                        class="form-label"
                                    >
                                        Adults *
                                    </label>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="adults"
                                        name="adults"
                                        value="1"
                                        min="1"
                                        required
                                    >

                                </div>


                                <!-- Children -->

                                <div class="col-md-6 mb-3">

                                    <label
                                        for="children"
                                        class="form-label"
                                    >
                                        Children
                                    </label>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="children"
                                        name="children"
                                        value="0"
                                        min="0"
                                    >

                                </div>

                            </div>


                            <!-- Special Requests -->

                            <div class="mb-4">

                                <label
                                    for="special_requests"
                                    class="form-label"
                                >
                                    Special Requests
                                </label>

                                <textarea
                                    class="form-control"
                                    id="special_requests"
                                    name="special_requests"
                                    rows="4"
                                    placeholder="Any special requirements?"
                                ></textarea>

                            </div>


                            <!-- Submit -->

                            <button
                                type="submit"
                                class="btn btn-primary btn-lg"
                            >

                                Confirm Booking

                            </button>


                        </form>


                    </div>

                </div>

            </div>


            <!-- Trip Summary -->

            <div class="col-lg-4">

                <div class="card shadow-sm">

                    <div class="card-body p-4">


                        <h4>
                            Trip Summary
                        </h4>


                        <hr>


                        <h5>

                            <?= htmlspecialchars(
                                $trip['package_name']
                            ) ?>

                        </h5>


                        <p class="text-muted">

                            📍

                            <?= htmlspecialchars(
                                $trip['destination_name']
                            ) ?>

                            ,

                            <?= htmlspecialchars(
                                $trip['destination_country']
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


                        <p>

                            <strong>
                                Price per adult:
                            </strong>

                            ₹<?= number_format(
                                $trip['price']
                            ) ?>

                        </p>


                        <p class="text-muted">

                            Children are charged at
                            50% of the adult price.

                        </p>


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
