<?php
session_start();
require_once("./includes/Products.php");
require_once("./includes/Users.php");
$user = new Users();
$result = false;
$isLoggedin = isset($_SESSION['user']);

if (isset($_GET['id'])) {
    $product = new Products();
    $data = $product->readById($_GET['id']);
}


if (isset($_POST['Sell'])) {
    $product = new Products();

    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $desc = $_POST['book_description'];
    $price = $_POST['book_price'];

    $product->id = $data['id'];
    $product->user_id = $_SESSION['user']['id'];
    $product->description = $desc;
    $product->book_title = $title;
    $product->price = $price;
    $product->author = $author;
    $product->update();
    $result = true;
}

require_once("./components/head.php");
?>

<body>
    <?php
    require_once("./components/navbar.php");
    ?>

    <?php
    if ($result) {
        echo '<div class="alert alert-success w-100" role="alert">
            Buku berhasil dijual
            </div>';
    }
    ?>


    <main style="height:100%;" class="container w-100 d-flex align-items-center justify-content-center">
        <form class="login-form mt-4 mb-5 d-flex flex-column" action="" enctype="multipart/form-data" method="post">
            <p class="mb-0">Book Title</p>
            <input class="input-form mb-3" type="text" name="book_title" id="book_title" placeholder="Book title" value="<?= $data["book_title"] ?>" required>
            <p class="mb-0">Book Author</p>
            <input class="input-form mb-3" type="text" name="book_author" id="book_author" placeholder="Book author" value="<?php echo $data['author']; ?>" required>
            <p class="mb-0">Book Price</p>
            <input class="input-form mb-3" type="text" name="book_price" id="book_price" placeholder="Book price" value="<?= $data["price"] ?>" required>
            <p class=" mb-0">Book Description</p>
            <textarea class="input-form mb-3" name="book_description" id="book_description" placeholder="Description" required><?= $data["description"] ?></textarea>

            <button name="Sell" class="btn-primary-webook py-1" type="submit">Update</button>
        </form>
    </main>
    <?php require_once("./components/footer.php") ?>
</body>

</html>