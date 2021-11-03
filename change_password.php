<?php
require_once("./includes/Users.php");
session_start();
$result = null;

// Changes password
if (isset($_POST['change_password'])) {
    if ($_POST['n_password'] == $_POST['nc_password']) {
        $user = new Users();
        $user->password = $_POST['n_password'];
        $user->id = $_SESSION['user']['id'];
        $result = $user->changePassword($_POST['o_password'], $_SESSION['user']['password']);
    }
}

?>

<?php require_once("./components/head.php") ?>

<body>
    <?php
    $btn_text = "Login";
    $btn_href = "./login.php";
    require_once("./components/navbar.php");
    ?>

    <?php if ($result && !is_null($result)) : ?>
        <div class="alert alert-success w-100" role="alert">
            You successfully change your password!
        </div>
    <?php elseif (!$result && !is_null($result)) : ?>
        <div class="alert alert-danger w-100" role="alert">
            Wrong old password!
        </div>
    <?php endif; ?>

    <main class="container w-100 d-flex justify-content-center">
        <form class="login-form mt-4 mb-5 d-flex flex-column" style="width: 20rem;" action="" method="post">
            <p class="mb-0">Old Password</p>
            <input class="input-form mb-3" type="o_password" name="o_password" id="o_password" placeholder="Old Password" required>

            <p class="mb-0">New Password</p>
            <input class="input-form mb-3" type="password" name="n_password" id="n_password" placeholder="New Password" required>

            <p class="mb-0">Confirm New Password</p>
            <input class="input-form mb-3" type="password" name="nc_password" id="nc_password" placeholder="Rewrite your new password" required>

            <button name="change_password" class="btn-primary-webook py-1 mt-2" type="submit">Change Password</button>
        </form>
    </main>

    <?php require_once("./components/footer.php") ?>
</body>

</html>