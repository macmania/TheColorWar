$(function() {
  $("body").on("click", "a.button", function(e) {
    if ($(this).hasClass("disabled")) {
      alert($(this).attr("data-error"));
      e.preventDefault();
      e.stopPropagation();
    }
    if ($(this).hasClass("disable")) {
      $(this).addClass("disabled");
    }
  })
})

function _trackEvent(category, action, label, value) {
  _gaq.push(['_trackEvent', category, action, label, value]);
}
function positionToInt(po) {
  var result = parseFloat(po.replace(/[^0-9.]/, ""));
  if (!result) return 0;
  return result;
}

function addOverlay(nodes, callback) {
  nodes.each(function(i, elem) {
    elem = $(elem);
    removeOverlay(elem);
    elem.addClass("disabled");
    var overlay = $("<div class='overlay'></div>");
    if (callback) {
      overlay.addClass("clickable");
      overlay.click(callback);
    }
    elem.prepend(overlay);
  });
}

function removeOverlay(elem) {
  elem.removeClass("disabled");
  elem.find(".overlay").remove();
}