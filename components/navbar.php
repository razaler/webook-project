<nav class="navbar navbar-expand-lg navbar-light bg-light px-lg-5 px-sm-3 pt-3">
  <div class="container-fluid px-lg-5">
    <a class="navbar-brand px-lg-5" href="./index.php">WEBOOK</a>

    <?php if (!$isLoggedin) : ?>
      <a href="<?= $btn_href ?>" class="btn-primary-webook ml-auto text-decoration-none px-4 py-1"><?= $btn_text ?></a>
    <?php else : ?>
      <div class="row w-50">
        <div class="col-9 pe-0">
          <p class="m-0 fw-bold text-end" style="font-size:0.6rem"><?= $_SESSION['user']["first_name"] . ' ' . $_SESSION['user']["last_name"] ?></p>
          <p class="m-0 text-end" style="font-size:0.6rem">IDR 700.000</p>
        </div>

        <div class="col-3 px-0 d-flex justify-content-center align-items-center">
          <i class="icofont-user-male" style="font-size:1.35rem"></i>
        </div>
      </div>
    <?php endif; ?>
  </div>
  </div>
</nav>