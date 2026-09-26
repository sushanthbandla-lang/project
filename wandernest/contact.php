<?php

require_once "config/database.php";

$success = "";
$error = "";


// Handle contact form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');


    // Validate required fields
    if ($name === "" || $email === "" || $message === "") {

        $error = "Please fill in all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        // Insert message
        $sql = "INSERT INTO contact_messages
                (
                    name,
                    email,
                    phone,
                    subject,
                    message,
                    status
                )
                VALUES
                (
                    :name,
                    :email,
                    :phone,
                    :subject,
                    :message,
                    'Unread'
                )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':subject' => $subject,
            ':message' => $message
        ]);

        $success = "Thank you! Your message has been sent successfully.";

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

    <title>Contact Us - WanderNest</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<?php include "includes/navbar.php"; ?>


<!-- Header -->

<section class="bg-primary text-white py-5">

    <div class="container text-center">

        <h1 class="fw-bold">
            Contact Us
        </h1>

        <p class="lead mb-0">
            We would love to hear from you.
        </p>

    </div>

</section>


<div class="container py-5">

    <div class="row g-5">


        <!-- Contact Information -->

        <div class="col-lg-5">

            <h2 class="fw-bold mb-4">
                Get In Touch
            </h2>

            <p class="text-muted">
                Have a question about a destination, trip, hotel,
                or vehicle rental? Send us a message and our team
                will get back to you.
            </p>


            <div class="mt-4">


                <div class="d-flex mb-4">

                    <div class="fs-3 me-3">
                        📍
                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Address
                        </h5>

                        <p class="text-muted mb-0">
                            WanderNest Travel Office
                        </p>

                    </div>

                </div>


                <div class="d-flex mb-4">

                    <div class="fs-3 me-3">
                        📧
                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Email
                        </h5>

                        <p class="text-muted mb-0">
                            support@wandernest.com
                        </p>

                    </div>

                </div>


                <div class="d-flex mb-4">

                    <div class="fs-3 me-3">
                        📞
                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Phone
                        </h5>

                        <p class="text-muted mb-0">
                            +91 98765 43210
                        </p>

                    </div>

                </div>


                <div class="d-flex">

                    <div class="fs-3 me-3">
                        🕐
                    </div>

                    <div>

                        <h5 class="fw-bold mb-1">
                            Working Hours
                        </h5>

                        <p class="text-muted mb-0">
                            Monday - Saturday
                        </p>

                        <p class="text-muted">
                            9:00 AM - 6:00 PM
                        </p>

                    </div>

                </div>


            </div>

        </div>


        <!-- Contact Form -->

        <div class="col-lg-7">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4 p-md-5">

                    <h3 class="fw-bold mb-4">
                        Send Us a Message
                    </h3>


                    <?php if ($success): ?>

                        <div class="alert alert-success">
                            <?= htmlspecialchars($success) ?>
                        </div>

                    <?php endif; ?>


                    <?php if ($error): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>


                    <form method="POST">


                        <!-- Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name *
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                required
                            >

                        </div>


                        <!-- Email -->

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address *
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
                            >

                        </div>


                        <!-- Subject -->

                        <div class="mb-3">

                            <label class="form-label">
                                Subject
                            </label>

                            <input
                                type="text"
                                name="subject"
                                class="form-control"
                            >

                        </div>


                        <!-- Message -->

                        <div class="mb-4">

                            <label class="form-label">
                                Message *
                            </label>

                            <textarea
                                name="message"
                                class="form-control"
                                rows="5"
                                required
                            ></textarea>

                        </div>


                        <!-- Submit -->

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100"
                        >
                            Send Message
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