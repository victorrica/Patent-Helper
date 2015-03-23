$(window).load(function(){
	$(".navbar-fixed-top").addClass("top-nav-collapse");
	$(".navbar-fixed-top").addClass("top_bar_color");
});
function range(a,b){
	return a>b?[]:[a].concat(range(++a,b))
}
$(window).scroll(function() {
    $(".navbar-fixed-top").addClass("top-nav-collapse");
	$(".navbar-fixed-top").addClass("top_bar_color");
});
function getGoogleData( keyword , page ){

	var url = "/PH/search/getGoogleData";
	var params = "keyword=" + keyword + "&page=" + page;

	$.ajax({
        type: "POST",
        url: url,
        data: params,
        success: function(res){

            var obj = jQuery.parseJSON( res );
            var length = Object.keys(obj.data).length;

			if(obj.return != "200")
			{
				alert('Error!');
				return;
			}

			for(var i=1;i<=length;i++)
			{
				var temp = '<a href="#" class="list-group-item">'
				+ '<img class="p_image" src="' + obj.data[i].image + '">'
				+ '<p class="p_title">' + obj.data[i].title + '</p>'
				+ '<p class="p_content">' + obj.data[i].content + '</p>'
				+ '<p class="p_number">' + obj.data[i].number + '</p>'
				+ '<p class="p_status">' + obj.data[i].status + '</p>'
				+ '<input type="hidden" class="p_url" value="' + obj.data[i].url + '">'
				+ '</a>';
				$("#getGoogleData > .list-group").append(temp);
				temp = '';
			}
			$("#getGoogleData > .list-group > .list-group-item").click(function(){
				window.open($(this).children(".p_url").val(), "특허 도우미 :: " + $(event.target).closest(".p_title").val(), "width=1000, height=800" );
			});
			Pagination(obj.totalPage,page,10,'getGoogleData');
        },
        beforeSend:function(){
			$("#getGoogleData > .list-group").empty();
			$("#getGoogleData > .list-group").html('<img class="wrap-loading" src="/PH/static/img/loading.gif" style="display: none;">');
            $('.wrap-loading').css('display','');
	    },
	    complete:function(){
	        $('.wrap-loading').css('display','none');
	    },
        error:function(e){
            alert(e.responseText);
        }
    });
}
function getKiprisData( keyword , page ){

	var url = "/PH/search/getKiprisData";
	var params = "keyword=" + keyword + "&page=" + page;

	$.ajax({
        type: "POST",
        url: url,
        data: params,
        success: function(res){

            var obj = jQuery.parseJSON( res );
            var length = Object.keys(obj.data).length;

			if(obj.return != "200")
			{
				alert('Error!');
				return;
			}

			for(var i=1;i<=length;i++)
			{
				var temp = '<a href="#" class="list-group-item">'
				+ '<img class="p_image" src="' + obj.data[i].image + '">'
				+ '<p class="p_title">' + obj.data[i].title + '</p>'
				+ '<p class="p_apv">' + obj.data[i].apv + '</p>'
				+ '<p class="p_number">' + obj.data[i].number + '</p>'
				+ '<p class="p_status">' + obj.data[i].status + '</p>'
				+ '<input type="hidden" class="p_url" value="' + obj.data[i].url + '">'
				+ '</a>';
				$("#getKiprisData > .list-group").append(temp);
				temp = '';
			}
			$("#getKiprisData > .list-group > .list-group-item").click(function(){
				window.open($(this).children(".p_url").val(), "특허 도우미 :: " + $(event.target).closest(".p_title").val(), "width=800, height=700" );
			});
			Pagination(obj.totalPage,page,10,'getKiprisData');
        },
        beforeSend:function(){
	        $("#getKiprisData > .list-group").empty();
	        $("#getKiprisData > .list-group").html('<img class="wrap-loading" src="/PH/static/img/loading.gif" style="display: none;">');
            $('.wrap-loading').css('display','');
	    },
	    complete:function(){
	        $('.wrap-loading').css('display','none');
	    },
        error:function(e){
            alert(e.responseText);
        }
    });
}
/*
function openurl(verb, url, header, data, target) {

	var JsonData = new Array();
	var PostToJson1 = data.split("&");
	for(var i=0;i<PostToJson1.length;i++)
	{
		var PostToJson2 = PostToJson1[i].split("=");
		var key = PostToJson2[0];
		var val = PostToJson2[1];
		JsonData[key] = val;
		PostToJson2 = null;
	}

	var form = document.createElement("form");

	header = header.split(";");

	for(var i=0;i<header.length;i++)
		document.cookie = header[i];

	form.action = url;
	form.method = verb;
	form.target = target || "_self";
	form.value = JsonData;
	if (JsonData) {
		for (var key in JsonData) {
		  var input = document.createElement("textarea");
		  input.name = key;
		  input.value = typeof JsonData[key] === "object" ? JSON.stringify(JsonData[key]) : JsonData[key];
		  form.appendChild(input);
		}
	}
	form.style.display = 'none';
	document.body.appendChild(form);
	form.submit();
};
*/
$("#submit_btn").click(function(){

	var keyword = $(".search-query").val();

	getKiprisData(keyword, '1');
    getGoogleData(keyword, '1');
});
$(".search-query").keypress(function(event){
	if ( event.which == 13 ) {
		$("#submit_btn").click();
	}
});
function Pagination(totalPages, nowPage, limit, id)
{
	console.log(totalPages + " " + nowPage + " " + limit + " " + id);
	$('#' + id +  ' > .pagination').empty();
	$('#' + id +  ' > .pagination').html('<li class="active"><a href="#">PREV</a>');
	var currentPage = lowerLimit = upperLimit = Math.min(nowPage, totalPages);

	for (var b = 1; b < limit && b < totalPages;) {
	    if (lowerLimit > 1 ) { lowerLimit--; b++; }
	    if (b < limit && upperLimit < totalPages) { upperLimit++; b++; }
	}

	for (var i = lowerLimit; i <= upperLimit; i++) {
	    if (i == currentPage) $('#' + id +  ' > .pagination').append('<li class="active"><a href="#">' + i + '</a></li>');
	    else $('#' + id +  ' > .pagination').append('<li><a href="#">' + i + '</a></li>');
	}
	$('#' + id +  ' > .pagination').append('<li class="active"><a href="#">NEXT</a></li>');

	$(".pagination > li > a").click(function(){
		var id = $(this).parents('.tab-pane').attr('id');
		var page = $(this).text();
		console.log(id);
		if(id == "getGoogleData")
			getGoogleData($(".search-query").val() , page);
		else if(id == "getKiprisData")
			getKiprisData($(".search-query").val() , page);
	});
}