<?php
require_once("./includes/Products.php");
require_once("./includes/like.php");
require_once("./includes/Users.php");
require_once("./includes/Transactions.php");
require_once("./includes/Comments.php");

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
  if ($isTransactionSuccess) {
    header("Location: detail.php?id=" . $_GET['id']);
  }
}

// Likes
$like = new Like();
$like->user_id = $_SESSION['user']['id'];
$like->product_id = $_GET['id'];

$isLoggedin = isset($_SESSION['user']);

// Product by ID
$product = new Products();
$data = $product->readById($_GET['id']);

//Comment
$comment_obj = new Comments();
$datacomment = $comment_obj->read($_GET['id']);

// Security
if (is_null($product->readById($_GET['id']))) {
  header("Location: index.php");
}

//Total Likes
$totalLikes = $like->totallike($_GET['id']);

//Dapetin Balance terbaru
$user = new Users();
$currentBalance = $user->read($_SESSION['user']['id'])['balance'];

//Comments
$comments = new Comments();


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
      <div class="col-6 col-lg-3">
        <img class="book_cover_detail w-100" style="height: 15rem; object-fit: cover;" src="./img/<?= $data['photo'] ?>">

        <div class="post-desc d-flex my-0 align-items-center"></div>
        <input type="hidden" id="user_id" value=<?= $_SESSION['user']['id'] ?>>
        <input type="hidden" id="product_id" value=<?= $_GET['id'] ?>>

        <span class="d-flex align-items-center">
          <i style="color: var(--black);" class="<?= ($like->isLiked()) ? "fas" : "far" ?> likes-button fa-thumbs-up me-2"></i>
          <p class="mb-0 likes-number"><?= $totalLikes ?></p>
        </span>

        <span class="d-flex align-items-center">
          <i style="color: var(--black);" class="icofont-speech-comments me-2"></i>
          <p class="mb-0 total-comments"><?php echo count($datacomment) ?></p>
        </span>
      </div>

      <div class="col-6 col-lg-9">
        <h1><?= $data['book_title'] ?></h1>
        <p class="fs-res mb-1">Author : <?= $data['author'] ?></p>
        <p class="fs-res"><?= substr($data['description'], 0, 200) ?></p>
        <div>
          <?php if ($data['user_id'] == $_SESSION['user']['id']) : ?>
            <!-- Jika pengguna merupakan si penjual buku -->
            <a class="btn-primary-webook text-decoration-none px-3 py-2" href="./update_book.php?id=<?= $data['id'] ?>">Edit</a>
          <?php endif; ?>

          <?php if (!$isTransaction && !($data['user_id'] == $_SESSION['user']['id'])) : ?>
            <!-- Belum membeli -->
            <button class="w-100 btn-primary-webook px-4 py-2 fs-res" data-bs-toggle="modal" data-bs-target="#modal"><b>BUY</b> IDR <?= number_format($data['price'], 0, ',', '.'); ?></button>

            <p class="fs-res text-center"><b>Balance</b> IDR <?= number_format($currentBalance, 0, ',', '.'); ?></p>

          <?php else : ?>

            <!-- Sudah membeli -->
            <a class="btn-primary-webook text-decoration-none px-3 py-2" href="./pdf.php?id=<?= $data['id'] ?>">Read</a>

          <?php endif; ?>

        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modal" style="overflow: hidden;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog h-100 d-flex justify-content-center align-items-center">
          <div class="modal-content" style="height: 10rem;">
            <div class="modal-body">
              Do you want to buy this book?
            </div>
            <div class="modal-footer">
              <form action="" method="post">
                <button type="button" class="btn-secondary-webook px-3 py-1" data-bs-dismiss="modal">NO</button>
                <button name="btn-buy" type="submit" class="btn-primary-webook px-3 py-1">YES</button>
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
      <?php for ($i = 0; $i < count($datacomment); $i++) : ?>
        <div class="row">
          <b class="fs-res"><?= $user->read($datacomment[$i]['user_id'])["first_name"] . " " . $user->read($datacomment[$i]['user_id'])["last_name"] . " | " . $datacomment[$i]['created_at'] ?></b>
          <p class="fs-res"><?= $datacomment[$i]['comment'] ?></p>
        </div>
      <?php endfor; ?>
    </div>

    <div class="row">
      <div class="col-9 col-lg-11">
        <input type="hidden" id="product_comment_id" name="product_id" value=<?= $_GET['id'] ?>>
        <input type="hidden" id="user_comment_id" name="user_id" value=<?= $_SESSION['user']['id'] ?>>
        <input style="border:none; border:2px solid black; border-radius: 4px;" class="mt-2 w-100 px-3 py-2 mb-5" type="text" id="comments" name="reviews" placeholder="Write your comments here!">
      </div>
      <div class="col-3 col-lg-1 mt-3 align-items-center">
        <button class="btn-comment btn-primary-webook px-2">SEND</button>
      </div>
    </div>
  </div>
</body>

<?php require_once('./components/footer.php'); ?>