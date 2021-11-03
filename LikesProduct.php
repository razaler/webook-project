<?php
require_once("./includes/like.php");

$like = new Like();

if (isset($_POST['user_id']) && isset($_POST['product_id'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    $like->user_id = $user_id;
    $like->product_id = $product_id;

    if (!$like->isLiked()) {
        $like->user_id = $user_id;
        $like->product_id = $product_id;
        $like->create();
        $totalLikes = $like->totallike($product_id);
    } else {
        $like->user_id = $user_id;
        $like->product_id = $product_id;
        $like->hapus();
        $totalLikes = $like->totallike($product_id);
    }
}


?>

<p class="mb-0 likes-number"><?= $totalLikes ?></p>