<?php
require_once("./includes/Products.php");
$url = "";
if (isset($_GET['id'])) {
    $product = new Products();
    $result = $product->readById($_GET['id']);
    $url = $result["file"];
}
?>

<!DOCTYPE html>
<html>

<?php require_once("./components/head.php") ?>

<body>
    <div>
        <iframe class="pdf-viewer" type="application/pdf" src="./pdf/<?= $url ?>#view=fitH"></iframe>
        <a href="./pdf/<?= $url ?>" target="_blank">ABC PDF file</a>
    </div>

</body>

</html>