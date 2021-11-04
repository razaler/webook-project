<?php
require_once("./includes/Products.php");
require_once("./includes/like.php");
require_once("./includes/Users.php");
require_once("./includes/Transactions.php");

session_start();

//Transaction
$transaction = new Transactions();
$transaction->user_id = $_SESSION['user']['id'];
$transaction->product_id = $_GET['id'];

//Check Transaction
$isTransaction = isset($transaction->read()[0]);
$isTransactionSuccess = null;

if (isset($_POST['btn-buy']) && !$isTransaction) {
  $_POST['btn-buy'] = null;
  $result  = $transaction->buy();
  $isTransactionSuccess = $result;
  header("Location: detail.php?id=" . $_GET['id']);
}

// Likes
$like = new Like();
$like->user_id = $_SESSION['user']['id'];
$like->product_id = $_GET['id'];

$isLoggedin = isset($_SESSION['user']);

// Product by ID
$product = new Products();
$data = $product->readById($_GET['id']);

// Security
if (is_null($product->readById($_GET['id']))) {
  header("Location: index.php");
}

//Total Likes
$totalLikes = $like->totallike($_GET['id']);

//Dapetin Balance terbaru
$user = new Users();
$currentBalance = $user->read($_SESSION['user']['id'])['balance'];
?>

<?php require_once("./components/head.php") ?>
<?php require_once("./components/navbar.php") ?>

<body>
  <?php
  if (!$isTransactionSuccess && !is_null($isTransactionSuccess)) {
    echo '<div class="alert alert-danger w-100" role="alert">
      Uang Anda tidak mencukupi
    </div>';
  }
  ?>
  <div class="container border-bottom pb-4">

    <div class="row">
      <div class="col-6">
        <img class="w-100" src="./img/<?= $data['photo'] ?>" alt="">

        <div class="post-desc d-flex my-0 align-items-center"></div>
        <input type="hidden" id="user_id" value=<?= $_SESSION['user']['id'] ?>>
        <input type="hidden" id="product_id" value=<?= $_GET['id'] ?>>

        <span class="d-flex align-items-center">
          <i style="color: var(--black);" class="<?= ($like->isLiked()) ? "fas" : "far" ?> likes-button fa-thumbs-up me-2"></i>
          <p class="mb-0 likes-number"><?= $totalLikes ?></p>
        </span>

        <span class="d-flex align-items-center">
          <i style="color: var(--black);" class="icofont-speech-comments me-2"></i>
          <p class="mb-0">200000</p>
        </span>
      </div>

      <div class="col-6">
        <h1><?= $data['book_title'] ?></h1>
        <p class="fs-res"><?= substr($data['description'], 0, 200) ?></p>
        <div>
          <?php if (!$isTransaction) : ?>
            <button class="w-100 btn-primary-webook px-4 py-2 fs-res" data-bs-toggle="modal" data-bs-target="#modal"><b>BUY</b> IDR <?= number_format($data['price'], 0, ',', '.'); ?></button>
            <p class="fs-res text-center"><b>Balance</b> IDR <?= number_format($currentBalance, 0, ',', '.'); ?></p>
          <?php else : ?>
            <a href="./pdf/contoh.pdf" download>Download</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              Do you want to buy this book?
            </div>
            <div class="modal-footer">
              <form action="" method="post">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                <button name="btn-buy" type="submit" class="btn-primary-webook">YES</button>
              </form>
            </div>
          </div>
        </div>
      </div>



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