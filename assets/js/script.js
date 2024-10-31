jQuery("document").ready(function ($) {
  $(".form-submit").submit(function (event) {
    event.preventDefault();
    let submitBtn = $(this).find("input[type=submit]");
    submitBtn.attr("disabled", "disabled");
    toggle_loader();
    let form = $(this);
    let formData = new FormData(this);
    formData.append('nonce', askaques_ajax.nonce);
    let formType = $(this).data("form-type");
    clear_input_error_msg();
    $.ajax({
      url: askaques_ajax.url,
      type: "POST",
      data:formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (res) {
        if (res.status) {
          clear_input_error_msg();
          alert(res.message);
          if (formType == "modal") {
            $("button[data-bs-dismiss=modal]").click();
            form[0].reset();
          }
        } else {
          clear_input_error_msg();
          "message" in res
            ? alert(res.message)
            : display_input_errors(res, formType);
        }
        toggle_loader();
        submitBtn.removeAttr("disabled");
      },
      error: function (xhr, status, error) {
        alert(error);
        toggle_loader();
        submitBtn.removeAttr("disabled");
      },
    });
  });

  $(".asked-ques-btn").click(function () {
    toggle_loader();
    let ques_type = $(this).data("type");
    $.ajax({
      url: askaques_ajax.url,
      type: "GET",
      data: {
        action: "askaques_custom_paginate",
        type: ques_type,
        nonce: askaques_ajax.nonce,
      },
      success: function (res) {
        toggle_loader();
        $(".asked-ques").html(res);
        if (ques_type == "new_ques") {
          $(".paginate").attr("data-ques-type", "new_ques");
        }
      },
      error: function(xhr, status, error) {
        alert(error);
        toggle_loader();
      },
    });
  });

  $("#btn-test-mail").click(function () {
    toggle_loader();
    $.ajax({
      url: askaques_ajax.url,
      type: "post",
      data: { action: "askaques_send_test_mail",
        nonce: askaques_ajax.nonce,
       },
       dataType:'json',
      success: function (res) {
        toggle_loader();
        alert(res.message);
      },
      error: function(xhr, status, error) {
        alert(error);
        toggle_loader();
      },
    });
  });

  $("#query_status").change(function () {
    let status = $(this).val();
    let query_id = $("input[name=query_id]").val();
    toggle_loader();
    $.ajax({
      url: askaques_ajax.url,
      type: "post",
      data: {
        action: "askaques_update_query_status",
        status: status,
        nonce: askaques_ajax.nonce,
        query_id: query_id,
      },

      success: function (res) {
        toggle_loader();
        alert(res);
      },

      error: function(xhr, status, error) {
        alert(error);
        toggle_loader();
      },
     
    });
  });

  $(".modal").on("hide.bs.modal", function () {
    clear_input_error_msg();
  });

  $(".card-tab-config, #new_questions").click(function () {
    $(".nav-link").removeClass("active");
    $(".tab-pane").removeClass("show active");
    let target = $(this).data("tab");
    if (target != "#askedQues") {
      $("#configuration-tab").addClass("show active");
      $("#configuration-tab-pane").addClass("show active");
    } else {
      $("#generalConfig-tab").addClass("active");
      $("#generalConfig-tab-pane").addClass("show active");
    }
    $(target + "-tab-pane").addClass("show active");
    $(target + "-tab").addClass("show active");
  });

  $(document).on("click", ".pagination .page-link", function (event) {
    event.preventDefault();
    let pageItem = $(this).closest(".page-item");
    let page_no = pageItem.data("page-no");
    let ques_type = pageItem.data("ques-type");
    $(".page-item").removeClass("active");
    pageItem.addClass("active");
    toggle_loader();
    $.ajax({
      url: askaques_ajax.url,
      type: "GET",
      data: {
        action: "askaques_custom_paginate",
        page_no: page_no,
        type: ques_type,
        nonce: askaques_ajax.nonce,
      },
      success: function (res) {
        toggle_loader();
        $(".asked-ques").html(res);
      },
      error: function(xhr, status, error) {
        alert(error);
        toggle_loader();
      },
    });
  });

  if (!$("div.woocommerce").hasClass("ct-woo-account")) {
    $("div.woocommerce").addClass("ct-woo-account");
  }

  $(document).on("click", ".askaques_queries", function () {
    let query_id = $(this).data("query-id");
    $("input[name=query_id]").val(query_id);
    toggle_loader();
    $.ajax({
      url: askaques_ajax.url,
      type: "post",
      data: {
        action: "askaques_get_query_reply",
        query_id: query_id,
        nonce: askaques_ajax.nonce,
      },
      success: function (res) {
        toggle_loader();
        $(".query-description").html(
          "<strong>" + res.user_name + "</strong><br>"
        );
        $(".query-description").append(res.description);
        $(".wholeChat").html(res.replies);
        $("#customer").html(res.customer_name);
        $("#query_id").html(res.query_id);
        $("#title").html(res.title);
        $("#queryViewModal").modal("show");
        $('#query_status').val(res.status);
      },
      error: function(xhr, status, error) {
        alert(error);
        toggle_loader();
      },
    });
  });
});

function clear_input_error_msg() {
  jQuery("small.text-danger").remove();
  jQuery(".form-control").removeAttr("style");
}

function display_input_errors(res, formType) {
  res.errors.forEach((field) => {
    let ele = jQuery("[name=" + Object.keys(field)[0] + "]");
    jQuery(
      '<small class="text-danger d-block">' +
        Object.values(field)[0] +
        " </small>"
    ).insertAfter(ele);
    ele.css("border-color", "red");
  });
  if ("modal" != formType) {
    jQuery("html, body").animate(
      {
        scrollTop: jQuery("small.text-danger").first().parent().position().top,
      },
      10
    );
  }
}

function toggle_loader() {
  jQuery(".custom-loader").toggle();
}
