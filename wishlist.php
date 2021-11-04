<?php
session_start();
require_once("./components/head.php");
require_once("./includes/Products.php");
require_once("./includes/Users.php");
require_once("./includes/like.php");

$like = new Like();
$like->user_id = $_SESSION['user']['id'];
$isLoggedin = isset($_SESSION['user']);

$btn_text = $isLoggedin ? "Logout" : "Login";
$btn_href = $isLoggedin ? "./includes/logout.php" : "./login.php";

$data = $like->getWishlist();

// Dapetin balance terbaru
$user = new Users();
if (isset($_SESSION['user'])) {
    $currentBalance = $user->read($_SESSION['user']['id'])['balance'];
}

?>

<body class="px-2">
    <?php require_once("./components/navbar.php"); ?>

    <main class="container">
        <h1 class="header-title">Wishlist</h1>
        <!-- BOOKS SECTIONS -->
        <section class="books-section mt-3 mb-5">
            <?php foreach ($data as $item) : ?>
                <?php if ($isLoggedin) : ?>
                    <div onclick="window.location.href = 'detail.php?id=<?= $item['id'] ?>'" style="cursor:pointer;">
                    <?php else : ?>
                        <div onclick="window.location.href = 'login.php'" style="cursor:pointer;">
                        <?php endif; ?>
                        <img width="100%" style="height: 10rem; object-fit: cover;" src="./img/<?= $item['photo'] ?>">
                        <h1 class="mb-0 mt-2 ms-1 ms-lg-2" style="font-size:.75rem"><?= $item['book_title'] ?></h1>
                        <p class="ms-lg-2 ms-1" style="font-size: .55rem;">IDR <?= number_format($item['price'], 0, ',', '.'); ?></p>
                        </div>
                    <?php endforeach; ?>
        </section>
    </main>

    <?php require_once("./components/footer.php") ?>
</body>

</html>