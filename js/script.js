// const comments_container = document.querySelector(".review-container");
// comments_container.scrollTop =
//   comments_container.scrollHeight - comments_container.clientHeight;


// Likes
$('.likes-button').click((e) => {
  const user_id = $("#user_id").val()
  const product_id = $("#product_id").val()
  $.post(
    "../LikesProduct.php",
    {
      user_id,
      product_id
    }, (data, status) => {
      $(".likes-number").html(data)
    }
  )

  if ($('.likes-button').hasClass("far")) {
    // Like
    $('.likes-button').removeClass("far").addClass("fas");
  } else {
    // Dislike
    $('.likes-button').removeClass("fas").addClass("far");
  }

});

$(".btn-topup").click((e) => {
  const user_id = $("#user_id").val()

  $.post("../ToupBalance.php", {
    user_id,
  }, (data, status) => {
    $(".user-balance").html(data);
    const currentBalance = $("#currentBalance").val();
    $(".navbar-balance").html("IDR " + currentBalance)
  })
});