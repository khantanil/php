<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About iDiscuss - A Developer Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'partials/header.php'; ?>

<!-- Hero Section -->
<section class="py-2 text-white" style="background-color: #198754;">
    <div class="container text-center">
        <h1 class="display-5 fw-bold">Welcome to iDiscuss</h1>
        <p class="lead">Your go-to platform for programming help, tech discussions, and community-driven learning.</p>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="assets/about2.jpeg " alt="Forum Illustration" class="img-fluid rounded shadow" width="100%">
            </div>
            <div class="col-md-6">
                <h2>What is iDiscuss?</h2>
                <p class="text-muted">
                    iDiscuss is a Q&A-style forum platform inspired by Stack Overflow. It provides a collaborative space where developers of all levels can post questions, answer others, and learn by participating in discussions.
                </p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">📌 Post your programming-related questions.</li>
                    <li class="list-group-item">🤝 Help fellow developers by sharing your knowledge.</li>
                    <li class="list-group-item">🗂️ Explore discussions by categories for better organization.</li>
                    <li class="list-group-item">🛡️ Clean, minimal, and beginner-friendly interface.</li>
                    <li class="list-group-item">🧑‍💻 Currently supports anonymous posting (user profiles coming soon).</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-4">
    <div class="container text-center">
        <h2 class="mb-4">Our Vision & Mission</h2>
        <p class="lead">
            We aim to create an open, respectful, and resourceful space for every coder, learner, and tech enthusiast to grow and collaborate.
        </p>
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title">👀 Vision</h5>
                        <p class="card-text">
                            To build a global online hub where anyone can find answers, ask questions, and improve their skills — no matter their background.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title">🎯 Mission</h5>
                        <p class="card-text">
                            To make programming help accessible, friendly, and community-focused. Our mission is to lower the barrier to entry and encourage learning by doing.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Future Plans -->
<section class="py-3 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">What’s Coming Next?</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="p-4 border rounded shadow-sm h-100">
                    <h5>🔐 User Authentication</h5>
                    <p class="text-muted">Login/signup features to track user activity and build profiles.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="p-4 border rounded shadow-sm h-100">
                    <h5>📊 Voting System</h5>
                    <p class="text-muted">Upvotes/downvotes to highlight the best answers in threads.</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="p-4 border rounded shadow-sm h-100">
                    <h5>🏷️ Tagging & Search</h5>
                    <p class="text-muted">Advanced tagging and search to help users find relevant discussions faster.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<?php include 'partials/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
