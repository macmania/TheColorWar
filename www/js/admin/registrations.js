$(function() {
  $(".registrations").on("click", ".item .expand", function() {
    $(this).parents(".item").find(".expander").slideToggle(200);
  });

  $(".registrations").on("click", ".pickedup", function() {
    $.post("/admin/registrations", {
      modify: 1,
      key: "picked_up",
      value: "1",
      registration_id: $(this).parents(".item").attr("data-id")
    });
    $(this).addClass("disable")
    $(this).parents(".item").addClass("claimed");
  });



  /*var colors = ["#499ee9", "#e7183b", "#f65cd6", "#ec642b", "#65c300"];

  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(function() {
    setTimeout(drawCharts, 1000);
  });

  var colors = ["#499ee9", "#e7183b", "#f65cd6", "#ec642b", "#65c300"];


  drawCharts();
  */
});

function drawChart(id, columns) {
  var data = new google.visualization.DataTable();
  var chart = new google.visualization.PieChart(document.getElementById(id));
  data.addColumn("string", "hi");
  data.addColumn("number", "hello");
  data.addRows(columns);
  chart.draw(data, {
    backgroundColor: { fill: "transparent" },
    colors: colors,
    is3D: true,
    legend: 'none',
    width: 300,
    height: 250
  });
}

function drawCharts() {
  drawChart("source-graph", sourceData);
  drawChart("reason-graph", reasonData);
  drawChart("package-graph", packageData);
}