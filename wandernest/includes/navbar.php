<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php?home=1">
            WanderNest
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="collapse navbar-collapse"
            id="navbarNav"
        >

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="index.php?home=1">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="destinations.php">
                        Destinations
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="trips.php">
                        Trips
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="hotels.php">
                        Hotels
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="rentals.php">
                        Rentals
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="reviews.php">
                        Reviews
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                        About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact.php">
                        Contact
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav">

                <?php if (isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <span class="nav-link">
                            Welcome,
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link text-warning"
                            href="logout.php"
                        >
                            Logout
                        </a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            Register
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>