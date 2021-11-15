<?php
session_start();
require_once("./components/head.php");
require_once("./includes/Products.php");
require_once("./includes/Users.php");

$products = new Products();
$sortArr = ['New Releases', 'Top Commented', 'Top Selling', 'Favorite Books'];

$isLoggedin = isset($_SESSION['user']);

$btn_text = $isLoggedin ? "Logout" : "Login";
$btn_href = $isLoggedin ? "./includes/logout.php" : "./login.php";
$data = $products->read();

// Dapetin balance terbaru
$user = new Users();
if (isset($_SESSION['user'])) {
  $currentBalance = $user->read($_SESSION['user']['id'])['balance'];
}

if (isset($_GET['sort'])) {
  $data = $products->sort($_GET['sort']);
}

?>

<body class="px-2">
  <?php require_once("./components/navbar.php"); ?>

  <main class="container">
    <input class="input-search p-2 mt-4" type="text" placeholder="Search book...">
    <button class="btn-search ms-2" name="search" type="submit">
      <i class="icofont-search-1"></i>
    </button>

    <!-- BALANCE CARD -->
    <?php if ($isLoggedin) : ?>
      <div class="card-info card mt-4">
        <div class="container px-3 py-2 d-flex justify-content-between">
          <span>
            <p style="color:white;" class="mb-0">Total saldo</p>
            <h1 class="user-balance" style="color:white;" class="fs-6 fs-lg-4">IDR <?= number_format($currentBalance, 0, ',', '.'); ?></h1>
          </span>

          <span class='d-flex align-items-center justify-content-center'>
            <input type="hidden" id="user_id" value=<?= $_SESSION['user']['id'] ?>>
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn-topup">
              <i class="icofont-plus"></i>
              <p class="mb-0" style="font-size:0.5rem; font-weight:bold;">Top Up</p>
            </button>
          </span>
        </div>

        <div class="modal topup-modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog w-100 h-75 d-flex flex-column justify-content-center align-items-center">
            <h1 class="mt-5 mb-1" style="color:white">Scan and Topup</h1>
            <img src="https://images.tokopedia.net/img/cache/500-square/product-1/2018/11/8/39617213/39617213_91fd0f0c-03c2-43b4-861a-64e9f04e8f24_700_700.jpeg">
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- SORT BY SECTION -->
    <div class="mt-4">
      <h1 class="mb-1">SORT BY</h1>
      <div class="category-container">
        <?php for ($i = 0; $i < count($sortArr); $i++) : ?>
          <?php $sort = strtolower(str_replace(" ", "-", $sortArr[$i])) ?>
          <span onclick="window.location.href = 'index.php?sort=<?= $sort ?>'" class="category-list mt-2 me-3">
            <p><?= $sortArr[$i] ?></p>
          </span>
        <?php endfor; ?>
      </div>
    </div>

    <!-- BOOKS SECTIONS -->
    <section class="books-section mt-3 mb-5">

      <?php foreach ($data as $item) : ?>
        <?php if ($isLoggedin) : ?>
          <div onclick="window.location.href = 'detail.php?id=<?= $item['id'] ?>'" style="cursor:pointer;">
          <?php else : ?>
            <div onclick="window.location.href = 'login.php'" style="cursor:pointer;">
            <?php endif; ?>
            <img class="book_cover" width="100%" src="./img/<?= $item['photo'] ?>">
            <h1 class="mb-0 mt-2 ms-1 ms-lg-2" style="font-size:.75rem"><?= $item['book_title'] ?></h1>
            <p class="ms-lg-2 ms-1" style="font-size: .55rem;">IDR <?= number_format($item['price'], 0, ',', '.'); ?></p>
            </div>
          <?php endforeach; ?>

    </section>
  </main>

  <?php require_once("./components/footer.php") ?>
</body>

</html>