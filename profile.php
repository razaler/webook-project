<?php session_start();
$isLoggedin = isset($_SESSION['user']);
$tabs = [
  [
    "title" => "Changes Password",
    "link" => "./change_password.php"
  ],
  [
    "title" => "My Book",
    "link" => "#"
  ],
  [
    "title" => "Wishlist",
    "link" => "#"
  ],
  [
    "title" => "Sell Book",
    "link" => "#"
  ],
  [
    "title" => "Logout",
    "link" => "./includes/logout.php"
  ],
];


?>

<?php require_once("./components/head.php") ?>

<?php require_once("./components/navbar.php") ?>

<body style="background-color: var(--black);">
  <main class="container d-flex flex-column">

    <?php foreach ($tabs as $item) : ?>
      <div onclick="window.location.href='<?= $item['link'] ?>'" class="py-4 profile-tools d-flex align-items-center justify-content-between w-100" style="border-bottom: 2px solid white; cursor: pointer;">
        <p class="fs-4 m-0" style="color: white;"><?= $item['title'] ?></p>
        <i style="color: white; font-size:1.75rem" class="icofont-arrow-right"></i>
      </div>
    <?php endforeach; ?>

  </main>
</body>

<?php require_once("./components/footer.php") ?>