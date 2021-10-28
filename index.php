<?php
session_start();
require_once("./components/head.php");
$sortArr = ['New Releases', 'Top Commented', 'Top Selling', 'Favorite Books'];
$isLoggedin = isset($_SESSION['user']);
$btn_text = $isLoggedin ? "Logout" : "Login";
$btn_href = $isLoggedin ? "./includes/logout.php" : "./login.php";
?>

<body>
  <?php require_once("./components/navbar.php"); ?>
  <main class="container px-3">
    <input class="input-form p-2 mt-4" style="width: 85%" type="text" placeholder="Search book...">
    <button class="btn-search ms-2" name="search" type="submit">
      <i class="icofont-search-1"></i>
    </button>

    <?php if ($isLoggedin) : ?>
      <div class="card mt-4">
        <div style="border-radius: 8px;" class="card-body bg-dark" style="color:white;">

          <div class="row card-info">
            <span class="col-9">
              <p style="color:white;" class="mb-0">Total saldo</p>
              <h1 style="color:white;">IDR 700.000</h1>
            </span>

            <span class='col-3 d-flex align-items-center justify-content-center'>
              <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn-topup">
                <i class="icofont-plus"></i>
                <p style="font-size:0.35rem; font-weight:bold;">Top Up</p>
              </button>
            </span>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="h-100 w-100 modal-dialog d-flex justify-content-center align-items-center">
                <img width="100%" src="https://images.tokopedia.net/img/cache/500-square/product-1/2018/11/8/39617213/39617213_91fd0f0c-03c2-43b4-861a-64e9f04e8f24_700_700.jpeg">
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php endif; ?>

    <div class="mt-4">
      <h1 class="mb-1">SORT BY</h1>
      <div class="category-container">
        <?php for ($i = 0; $i < count($sortArr); $i++) : ?>
          <span class="category-list mt-2 me-3"><?= $sortArr[$i] ?></span>
        <?php endfor; ?>
      </div>
    </div>

    <?php for ($i = 0; $i <= 3; $i++) : ?>
      <div class="row my-3 mb-5">
        <?php for ($j = 0; $j < 3; $j++) : ?>
          <div class="col-4">
            <div class="px-2">
              <img width=100% src="https://picsum.photos/200/300">
              <h1 style="font-size:1rem">Judul buku</h1>
              <p>IDR 20.000</p>
            </div>
          </div>
        <?php endfor; ?>
      </div>
    <?php endfor; ?>
  </main>

  <?php require_once("./components/footer.php") ?>
</body>

</html>