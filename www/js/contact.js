$(function() {
  var form = $("#contact-form");
  form.submit(function(e) {
    
    var errors = [];
    if (form.find("input[name=name]").val().length < 2) {
      errors["name"] = "You have to know your own name!";
    }
    if (form.find("input[name=email]").val().length < 2) {
      errors["email"] = "What's your real email address.";
    }
    if (form.find("textarea[name=message]").val().length < 2) {
      errors["message"] = "Where's your message?!";
    }

    form.find("input, textarea").css("border", "");
    var errorCount = 0;
    for (key in errors) {
      errorCount++;
      form.find("[name=" + key + "]").css({
        "border": "solid 1px #900",
      }).attr("placeholder", errors[key]);
    }
    if (errorCount) {
      e.preventDefault();
    }
    return true;
  })
})