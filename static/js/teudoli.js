$( "#Char" ).draggable();

$("#tooltip_content").on('change',function(){
	alert("changed");
	$(".tooltips").css("top",-$("#tooltip_content").text().length);
});

var emotion = ["blank","smile","question"];
var nowemotion = "blank";

$("#character").click(function(){
	$(this).hide();
	$(this).removeClass(nowemotion);
	nowemotion = emotion[Math.floor((Math.random() * 3))];
	$(this).addClass(nowemotion);
	$(this).fadeIn(1000);
});