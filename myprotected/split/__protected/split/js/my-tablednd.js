//** ZEN JS **//
$(document).ready(function(){
// ---------
$("#main-table").tableDnD({
  onDragClass: "dragRow",
  onDrop: function(table, row) {
    var rows = table.tBodies[1].rows;
	var messageString = "Перемещена строка " + row.id + "<br />Новый порядок сортировки: ";
	for (var i=0; i<rows.length; i++) {
      messageString += rows[i].id + " ";
	  if(i%2 == 0)
	  	{
			$('tr#'+rows[i].id).addClass('trcolor');
		}else
		{
			$('tr#'+rows[i].id).removeClass('trcolor');
		}
    }
    $("#messageArea").html(messageString);
    $("#main-table").find("tr[@id='"+ row.id +"']").fadeOut(700, function () {
      $(this).fadeIn(300);
    });
  },
  onDragStart: function(table, row) {
    $("#messageArea").html("Перемещаем строку " + row.id);
  }
});
// ---------
});