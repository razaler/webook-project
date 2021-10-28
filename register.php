<?php
require_once("./includes/Users.php");
// Register user
if (isset($_POST['register'])) {
  if ($_POST['password'] == $_POST['c_password']) {
    $user = new Users();
    $user->email = $_POST['email'];
    $user->first_name = $_POST['first_name'];
    $user->last_name = $_POST['last_name'];
    $user->password = $_POST['password'];
    if ($user->create()) {
      setcookie("isSuccess", true, time() + 1);
      header("location: ./login.php");
    }
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

  <main class="container w-100 d-flex justify-content-center">
    <form class="login-form mt-4 mb-5 d-flex flex-column" style="width: 20rem;" action="" method="post">
      <p class="mb-0 mt-3">Email</p>
      <input class="input-form mb-3" type="text" name="email" id="email" placeholder="Email">

      <p class="mb-0">First name</p>
      <input class="input-form mb-3" type="text" name="first_name" id="first_name" placeholder="First name">

      <p class="mb-0">Last name</p>
      <input class="input-form mb-3" type="text" name="last_name" id="last_name" placeholder="Last name">

      <p class="mb-0">Password</p>
      <input class="input-form mb-3" type="password" name="password" id="password" placeholder="Password">

      <p class="mb-0">Confirm password</p>
      <input class="input-form mb-3" type="password" name="c_password" id="c_password" placeholder="Rewrite your password">
      <button name="register" class="btn-primary-webook py-1 mt-2" type="submit">Register</button>
    </form>
  </main>

  <?php require_once("./components/footer.php") ?>
</body>

</html>