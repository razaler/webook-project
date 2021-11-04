<?php
require_once("./includes/Users.php");

if (isset($_POST['user_id'])) {
    $user = new Users();
    $user->id = $_POST['user_id'];
    $balance  = $user->TopUp();
}

?>

<input type="hidden" id="currentBalance" value=<?= number_format($balance, 0, ',', '.'); ?>>
<h1 class="user-balance" style="color:white;" class="fs-6 fs-lg-4">IDR <?= number_format($balance, 0, ',', '.'); ?></h1>