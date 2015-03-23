<link rel="stylesheet" href="/PH/static/css/search.css">
	<h1 id="smartsearch_title">스마트 검색</h1>
	<div id="search_text" class="input-group form-search">
		<input class="form-control search-query" placeholder="검색어를 입력해주세요">
		<span class="input-group-btn"><button type="submit" id="submit_btn" class="btn btn-primary" data-type="last">Search</button></span>
	</div>
	<div id="search_menu" class="panel">
		<ul id="myTab1" class="nav nav-tabs nav-justified">
			<li class="active">
				<a href="#getKiprisData" data-toggle="tab">국내 특허</a>
			</li>
			<li>
				<a href="#getGoogleData" data-toggle="tab">외국 특허</a>
			</li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="getKiprisData">
				<div class="list-group">
					<img class="wrap-loading" src="/PH/static/img/loading.gif" style="display: none;">
				</div>
				<ul class="pagination"></ul>
			</div>

			<div class="tab-pane fade" id="getGoogleData">
				<div class="list-group">
					<img class="wrap-loading" src="/PH/static/img/loading.gif" style="display: none;">
				</div>
				<ul class="pagination"></ul>
			</div>
		</div>
	</div>
<script src="/PH/static/js/search.js"></script>