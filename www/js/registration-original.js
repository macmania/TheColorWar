
var merchantID = "711318365992931";
$(function() {
  $("body").on("keyup", ".cart-item .quantity", function(e) {
    updatePrice($(this).parents(".cart-item"));
  });
  $(".waiver").mousedown(function(e) {
    enableProductNext();
  });
  $(".product .add-cart").click(function(e) {
    addToCart($(this));
  });
  $(".product .option").change(function(e) {
    var product = getProduct($(this));
    product.node.attr("data-option", $(this).val());
  });
  $(".products a.button.next").click(function(e) {
    sendCart();
    if (!$(this).hasClass("disabled")) {
      if (verifyCart()) {
        switchToStage(2, true);
      }
    }
  });
  $(".user-details a.button.next").click(function(e) {
    if (!$(this).hasClass("disabled")) {
      if (verifyCart() && verifyBio()) {
        switchToStage(3, true);
      }
    }
  });

  $(".checkout a.button.next").click(function(e) {
    if (!$(this).hasClass("disabled") && verifyCart() && verifyBio() && verifyMarketing()) {
      $(this).addClass("disable");
      var soakCount = $("[data-identifier=soak] .quantity").val() || 0;
      var splashCount = $("[data-identifier=splash] .quantity").val() || 0;
      var sprinkleCount = $("[data-identifier=sprinkle] .quantity").val() || 0;
      var serialized = $("form").serialize() + "&soak=" + soakCount + "&splash=" + splashCount + "&sprinkle=" + sprinkleCount;
      $.post("/registration", serialized, function(data) {
        var form = createForm();
        $("body").append(form);
        form.submit();
      });
    }
  })

  $(".user-details [name=phone]").mask("(999) 999-9999");
  $(".user-details [name=dob]").mask("99/99/9999");
  switchToStage(1, false);
});

function sendCart() {
  var form = createForm();
  form.append(hiddenInput("submit", "cart"));
  $.post("/registration", form.serialize(), function(data) {
    console.log(data);
  });
}

function createForm() {
  var form = $('<form />');
  form.attr("method", "POST");
  form.attr("action", "https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/" + merchantID);
  $(".cart-item").each(function(i, elem) {
    var index = i + 1;
    var $elem = $(elem);
    var pricePer = parseFloat($elem.attr("data-price-per"));
    var quantity = parseInt($elem.find(".quantity").val());
    if (quantity > 0) {
      form.append(hiddenInput("item_name_" + index, $elem.attr("data-title")));
      form.append(hiddenInput("item_description_" + index, $elem.attr("data-description")));
      form.append(hiddenInput("item_price_" + index, pricePer));
      form.append(hiddenInput("item_currency_" + index, "USD"));
      form.append(hiddenInput("item_quantity_" + index, quantity));
      form.append(hiddenInput("item_merchant_id_" + index, merchantID));
    }
  });
  return form;
}

function hiddenInput(key, value) {
  return $("<input type='hidden' />").attr("name", key).attr("value", value);
}

function addToCart(elem) {
  var product = getProduct(elem);
  var item = $(".cart").find(".cart-" + product.identifier);
  if (!item.length) {
    item = $(
      "<div class='cart-item'>" + 
        "<input name='quantity' class='quantity' value='0' />" + 
        "<div class='title'>" + product.fullTitle + "</div>" +
        "<div class='price'>0</div>" + 
        "<div class='clear'></div>" + 
      "</div>");
    item.addClass("cart-" + product.identifier);
    item.attr("data-group", product.group);
    item.attr("data-identifier", product.identifier);
    item.attr("data-price-per", product.price + product.extra);
    item.attr("data-package", product.package ? 1 : 0);
    item.attr("data-description", product.description);
    item.attr("data-title", product.fullTitle);
    $(".cart").append(item);
  }
  var current = parseInt(item.find(".quantity").val());
  item.find(".quantity").val(current + 1);
  updatePrice(item);
}

function enableProductNext() {
  $(".products a.button.next.disabled").removeClass("disabled");
}

function switchToStage(stage, scroll) {
  var box = $(".content-box[data-stage=" + stage + "]");
  $(".content-box[data-stage]").each(function(i, elem) {
    if (parseInt($(elem).attr("data-stage")) > stage) {
      addOverlay($(elem));
    } else {
      removeOverlay($(elem));
    }
  });
  if (scroll) {
    $('html, body').animate({
       scrollTop: box.offset().top - 100
    }, 500);
  }
}

function getProduct(elem) {
  var pkg = new Object();
  if (elem.hasClass("product")) {
    pkg.node = elem;
  } else {
    pkg.node = elem.parents(".product");
  }
  var option = pkg.node.find(".option");
  var extra = 0;
  pkg.package = pkg.node.hasClass("package");
  if (option.length > 0) {
    pkg.option = [];
    pkg.extra = 0;
    option.each(function(i, opt) {
      pkg.option.push($(opt).val());
      pkg.extra += parseFloat($(opt).find(":selected").attr("data-extra")) || 0;
    })
    pkg.option = pkg.option.join(", ");
  } else {
    pkg.option = false;
    pkg.extra = 0;
  }
  pkg.title = pkg.node.attr("data-title");
  pkg.price = parseFloat(pkg.node.attr("data-price"));
  pkg.name = pkg.node.attr("name");
  pkg.description = pkg.node.find(".description").text();
  pkg.fullTitle = pkg.title + (pkg.option ? " - " + pkg.option : "");
  var id = pkg.name + (pkg.option ? pkg.option : "");
  pkg.identifier = id.toLowerCase().replace(/[^a-z0-9]/g, "");
  pkg.group = pkg.name.toLowerCase().replace(/[^a-z0-9]/g, "");
  if (!pkg.price) pkg.price = 0;
  return pkg;
}


function checkRequired(elem) {
  var good = true;
  elem.find(".pair").each(function(i, node) {
    var $pair = $(node);
    var required = $pair.find("[required=true]");
    if (required.length > 0) {
      if (required.attr("type") == "text" || required.attr("type") == "textfield" || required.prop("tagName").toLowerCase() == "select") {
        if (required.val().length == 0) {
          good = false;
        }
      } else if (required.attr("type") == "radio") {
        if (!$pair.find("[required=true]:checked").val()) {
          good = false;
        }
      } else if (required.prop("tagName")) {
        if (!$pair.find("[required=true] option:selected").length) {
          good = false;
        }
      }
    }
  });
  return good;
}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function isPhone(phone) {
  return phone.replace(/[^0-9]/g, "").length >= 10;
}

function verifyMarketing() {
  if (!checkRequired($(".marketing-questions"))) {
    alert("Please answer all the questions.");
    return false;
  }
  return true;
}

function verifyBio() {
  var error = false;
  var phone = $(".user-details [name=phone]").val();
  var email = $(".user-details [name=email]").val();

  if (!checkRequired($(".user-details"))) {
    error = "Please fill out all the required fields before continuing.";
  } else if (!isEmail(email)) {
    error = "Please enter a valid email address.";
  } else if (phone && !isPhone(phone)) {
    error = "Please enter a valid phone number.";
  }
  if (error) {
    alert(error);
    return false;
  }
  return true;
}

function verifyCart() {
  var items = 0;
  var error = false;
  var sprinkle = false;
  var packages = 0;
  $(".cart-item").each(function(i, elem) {
    var $elem = $(elem);
    var quantity = parseInt($elem.find(".quantity").val());
    if ($elem.attr("data-identifier") == "sprinkle") {
      if (quantity > 1) {
        error = "You can only have one Sprinkle Package at a time.";
      } else if (quantity == 1) {
        sprinkle = true;
      }
    }
    if (parseInt($elem.attr("data-package"))) {
      packages += quantity; 
    }
    items += quantity;
  });
  if (sprinkle && packages > 1) {
    error = "If you're signed up for either Soak or Splash you can't sign up for Sprinkle too.";
  }
  if (!items)
    error = "You have no items in your cart!";

  if (error) {
    alert(error);
    return false;
  }
  return true;
}

function updatePrice(elem) {
  if (elem && elem.hasClass("cart-item")) {
    var quantity = parseInt(elem.find(".quantity").val());
    var pricePer = parseFloat(elem.attr("data-price-per"));
    var finalPrice = parseFloat(quantity * pricePer) || 0;
    elem.find(".price").text("$" + finalPrice);
    elem.attr("data-price", finalPrice);
  }
  var price = 0;
  $(".cart-item").each(function(i, elem) {
    price += parseFloat($(elem).attr("data-price")) || 0;
  });
  $(".total-amount").text("$" + price.toFixed(2));
}

