<?php
require_once("./includes/Comments.php");
require_once("./includes/Users.php");
$data = [];
$user = new Users();

if (isset($_POST['user_id']) && isset($_POST['product_id']) && isset($_POST['comment'])) {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $comments = $_POST['comment'];

    $comment_obj = new Comments();
    $comment_obj->user_id = $user_id;
    $comment_obj->product_id = $product_id;
    $comment_obj->comment = $comments;

    $result = $comment_obj->create();
    if ($result) {
        $data = $comment_obj->read($product_id);
    }
}
?>

<?php for ($i = 0; $i < count($data); $i++) : ?>
    <input type="hidden" id="total_comments" value=<?= count($data) ?>>
    <div class="row">
        <b class="fs-res"><?= $user->read($data[$i]['user_id'])["first_name"] . " " . $user->read($data[$i]['user_id'])["last_name"] . " | " . $data[$i]['created_at'] ?></b>
        <p class="fs-res"><?= $data[$i]['comment'] ?></p>
    </div>
<?php endfor; ?>