<?php
require_once("./includes/Products.php");

session_start();
$isLoggedin = isset($_SESSION['user']);
$product = new Products();
$data = $product->readById($_GET['id']);

// Security
if (is_null($product->readById($_GET['id']))) {
  header("Location: index.php");
}

?>

<?php require_once("./components/head.php") ?>
<?php require_once("./components/navbar.php") ?>

<body>
  <div class="container border-bottom pb-4">
    <div class="row">
      <div class="col-6">
        <img class="w-100" src="./img/<?= $data['photo'] ?>" alt="">

        <div class="post-desc d-flex my-0 align-items-center">
          <i style="color: var(--black);" class="far fa-thumbs-up me-2"></i>
          <p class="mb-0">200000</p>
        </div>
        <div class="d-flex align-items-center">
          <i style="color: var(--black);" class="icofont-speech-comments me-2"></i>
          <p class="mb-0">200000</p>
        </div>
      </div>
      <div class="col-6">
        <h1><?= $data['book_title'] ?></h1>
        <p class="fs-res"><?= substr($data['description'], 0, 200) ?></p>

        <div>
          <button class="w-100 btn-primary-webook px-4 py-2 fs-res"><b>BUY</b> IDR 20.000</button>
          <p class="fs-res text-center"><b>Balance</b> IDR 700.000</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <h1>Reviews and Comments</h1>

    <div class="review-container">
      <?php for ($i = 0; $i < 10; $i++) : ?>
        <div class="row">
          <b class="fs-res">Orang 1</b>
          <p class="fs-res">Keren banget bukunya!</p>
        </div>
      <?php endfor; ?>
    </div>
    <input style="border:none; border:2px solid black; border-radius: 4px;" class="mt-2 w-100 px-3 py-2 mb-5" type="text" name="reviews" placeholder="Write your comments here!">
  </div>
</body>

<?php require_once('./components/footer.php') ?>