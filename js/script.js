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

// Button topup
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

// Button Comment
$(".btn-comment").click((e) => {
  const user_id = $("#user_comment_id").val()
  const product_id = $("#product_comment_id").val()
  const comment = $("#comments").val();

  if (comment != "") {
    $.post("../AddComment.php", {
      user_id,
      product_id,
      comment
    }, (data, status) => {
      $(".review-container").html(data);

      const total_comments = $("#total_comments").val();
      $(".total-comments").html(total_comments);

      $("#comments").val("");

      const comments_container = document.querySelector(".review-container");
      comments_container.scrollTop =
        comments_container.scrollHeight - comments_container.clientHeight;
    })
  }
});

if (window.location.href.includes("detail.php")) {
  const comments_container = document.querySelector(".review-container");
  comments_container.scrollTop =
    comments_container.scrollHeight - comments_container.clientHeight;
}



