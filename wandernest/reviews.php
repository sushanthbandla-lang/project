<?php

require_once "config/database.php";

$message = "";
$message_type = "";

/*
|--------------------------------------------------------------------------
| Fetch destinations for dropdown
|--------------------------------------------------------------------------
*/

$destination_stmt = $pdo->query(
    "SELECT id, name, country
     FROM destinations
     ORDER BY name ASC"
);

$destinations = $destination_stmt->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| Handle Review Submission
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $destination_id = isset($_POST["destination_id"])
        ? (int) $_POST["destination_id"]
        : 0;

    $customer_name = trim($_POST["customer_name"] ?? "");

    $rating = isset($_POST["rating"])
        ? (int) $_POST["rating"]
        : 0;

    $review = trim($_POST["review"] ?? "");


    /*
    |----------------------------------------------------------------------
    | Validation
    |----------------------------------------------------------------------
    */

    if ($destination_id <= 0) {

        $message = "Please select a destination.";
        $message_type = "danger";

    } elseif ($customer_name === "") {

        $message = "Please enter your name.";
        $message_type = "danger";

    } elseif ($rating < 1 || $rating > 5) {

        $message = "Please select a rating between 1 and 5 stars.";
        $message_type = "danger";

    } elseif ($review === "") {

        $message = "Please write your review.";
        $message_type = "danger";

    } else {

        /*
        |------------------------------------------------------------------
        | Check destination exists
        |------------------------------------------------------------------
        */

        $check_stmt = $pdo->prepare(
            "SELECT id
             FROM destinations
             WHERE id = ?"
        );

        $check_stmt->execute([$destination_id]);

        $destination_exists = $check_stmt->fetch(PDO::FETCH_ASSOC);


        if (!$destination_exists) {

            $message = "Invalid destination selected.";
            $message_type = "danger";

        } else {

            /*
            |--------------------------------------------------------------
            | Insert Review
            |--------------------------------------------------------------
            */

            $insert_stmt = $pdo->prepare(
                "INSERT INTO reviews
                (
                    destination_id,
                    customer_name,
                    rating,
                    review,
                    status
                )
                VALUES (?, ?, ?, ?, ?)"
            );

            $insert_stmt->execute([
                $destination_id,
                $customer_name,
                $rating,
                $review,
                "Approved"
            ]);

            $message = "Thank you! Your review has been submitted successfully.";
            $message_type = "success";
        }
    }
}


/*
|--------------------------------------------------------------------------
| Fetch Approved Reviews
|--------------------------------------------------------------------------
*/

$review_stmt = $pdo->query(
    "SELECT
        reviews.*,
        destinations.name AS destination_name,
        destinations.country
     FROM reviews
     INNER JOIN destinations
        ON reviews.destination_id = destinations.id
     WHERE reviews.status = 'Approved'
     ORDER BY reviews.created_at DESC"
);

$reviews = $review_stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reviews - WanderNest</title>

    <!-- Bootstrap CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Website CSS -->

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>


<body>


<?php include "includes/navbar.php"; ?>


<!-- =====================================================
     PAGE HEADER
===================================================== -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h1 class="fw-bold">
            Customer Reviews
        </h1>

        <p class="lead mb-0">
            Share your travel experience with the WanderNest community.
        </p>

    </div>

</section>



<!-- =====================================================
     REVIEW FORM
===================================================== -->

<section class="py-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow-sm">

                    <div class="card-body p-4">

                        <h3 class="mb-4">
                            ⭐ Write a Review
                        </h3>


                        <!-- Success / Error Message -->

                        <?php if ($message !== ""): ?>

                            <div
                                class="alert alert-<?= $message_type ?>"
                                role="alert"
                            >
                                <?= htmlspecialchars($message) ?>
                            </div>

                        <?php endif; ?>


                        <form
                            method="POST"
                            action="reviews.php"
                        >


                            <!-- Destination -->

                            <div class="mb-3">

                                <label
                                    for="destination_id"
                                    class="form-label fw-bold"
                                >
                                    Destination
                                </label>

                                <select
                                    name="destination_id"
                                    id="destination_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select Destination
                                    </option>

                                    <?php foreach ($destinations as $destination): ?>

                                        <option
                                            value="<?= $destination['id'] ?>"
                                        >

                                            <?= htmlspecialchars($destination['name']) ?>,
                                            <?= htmlspecialchars($destination['country']) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>



                            <!-- Customer Name -->

                            <div class="mb-3">

                                <label
                                    for="customer_name"
                                    class="form-label fw-bold"
                                >
                                    Your Name
                                </label>

                                <input
                                    type="text"
                                    name="customer_name"
                                    id="customer_name"
                                    class="form-control"
                                    placeholder="Enter your name"
                                    maxlength="150"
                                    required
                                >

                            </div>



                            <!-- Rating -->

                            <div class="mb-3">

                                <label
                                    for="rating"
                                    class="form-label fw-bold"
                                >
                                    Rating
                                </label>

                                <select
                                    name="rating"
                                    id="rating"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select Rating
                                    </option>

                                    <option value="5">
                                        ⭐⭐⭐⭐⭐ — Excellent
                                    </option>

                                    <option value="4">
                                        ⭐⭐⭐⭐ — Very Good
                                    </option>

                                    <option value="3">
                                        ⭐⭐⭐ — Good
                                    </option>

                                    <option value="2">
                                        ⭐⭐ — Average
                                    </option>

                                    <option value="1">
                                        ⭐ — Poor
                                    </option>

                                </select>

                            </div>



                            <!-- Review -->

                            <div class="mb-4">

                                <label
                                    for="review"
                                    class="form-label fw-bold"
                                >
                                    Your Review
                                </label>

                                <textarea
                                    name="review"
                                    id="review"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Write about your travel experience..."
                                    required
                                ></textarea>

                            </div>



                            <!-- Submit -->

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                ⭐ Submit Review
                            </button>


                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



<!-- =====================================================
     APPROVED REVIEWS
===================================================== -->

<section class="py-5 bg-light">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                What Our Travelers Say
            </h2>

            <p class="text-muted">
                Read experiences shared by WanderNest travelers.
            </p>

        </div>


        <div class="row g-4">


            <?php if (empty($reviews)): ?>

                <div class="col-12">

                    <div class="alert alert-info text-center">

                        No reviews have been submitted yet.
                        Be the first to share your experience!

                    </div>

                </div>


            <?php else: ?>


                <?php foreach ($reviews as $review_item): ?>

                    <div class="col-lg-4 col-md-6">


                        <div class="card h-100 shadow-sm">


                            <div class="card-body">


                                <!-- Customer -->

                                <h5 class="card-title">

                                    <?= htmlspecialchars(
                                        $review_item["customer_name"]
                                    ) ?>

                                </h5>


                                <!-- Destination -->

                                <p class="text-muted mb-2">

                                    📍
                                    <?= htmlspecialchars(
                                        $review_item["destination_name"]
                                    ) ?>,
                                    <?= htmlspecialchars(
                                        $review_item["country"]
                                    ) ?>

                                </p>


                                <!-- Rating -->

                                <div class="mb-3">

                                    <?php for (
                                        $i = 1;
                                        $i <= 5;
                                        $i++
                                    ): ?>

                                        <?php if (
                                            $i <= $review_item["rating"]
                                        ): ?>

                                            <span>⭐</span>

                                        <?php else: ?>

                                            <span>☆</span>

                                        <?php endif; ?>

                                    <?php endfor; ?>

                                </div>


                                <!-- Review Text -->

                                <p class="card-text">

                                    "
                                    <?= htmlspecialchars(
                                        $review_item["review"]
                                    ) ?>
                                    "

                                </p>


                                <!-- Date -->

                                <small class="text-muted">

                                    Reviewed on
                                    <?= date(
                                        "d M Y",
                                        strtotime(
                                            $review_item["created_at"]
                                        )
                                    ) ?>

                                </small>


                            </div>

                        </div>


                    </div>

                <?php endforeach; ?>


            <?php endif; ?>


        </div>

    </div>

</section>



<?php include "includes/footer.php"; ?>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>