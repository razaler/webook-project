<?php
require_once("./includes/Users.php");
$user = new Users();

if (isset($_POST['login'])) {
  $user->email = $_POST['email'];
  $user->password = $_POST['password'];
  $result = $user->signin();
  if ($result) {
    session_start();
    $_SESSION['user'] = $result;
    header("Location: index.php");
  }
}

require_once("./components/head.php");
?>

<body>
  <?php
  $btn_text = "Register";
  $btn_href = "./register.php";
  require_once("./components/navbar.php");
  ?>

  <?php if ($_COOKIE['isSuccess']) : ?>
    <div class="alert alert-success position-absolute w-100" role="alert">
      You successfully create an account!
    </div>
  <?php endif; ?>

  <main class="container h-75 w-100 d-flex align-items-center justify-content-center">
    <form class="login-form mt-4 mb-5 d-flex flex-column" action="" method="post">
      <p class="mb-0">Email</p>
      <input class="input-form mb-3" type="text" name="email" id="email" placeholder="Email">
      <p class="mb-0">Password</p>
      <input class="input-form mb-3" type="password" name="password" id="password" placeholder="Password">
      <button name="login" class="btn-primary-webook py-1" type="submit">Login</button>
    </form>
  </main>

  <?php require_once("./components/footer.php") ?>
</body>

</html>