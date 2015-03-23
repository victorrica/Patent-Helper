<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class search extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->database();
		//$this->load->model('topic_model');
	}
	function index()
	{
		$this->load->view('head');
		$this->load->view('search');
		$this->load->view('footer');
	}

	function GetKiprisData(){
		$keyword = $this->input->post('keyword');
		$page = $this->input->post("page");
		$i=0;
		/*파라미터 정의*/

 		if(!$keyword){
 			$arr = array("return"=>"404","msg"=>"Parameter ERROR");
 			echo json_encode($arr);
 			exit();
 		}
 		$url = "http://m.kipris.or.kr/mobile/search/data/search_patent.do";

 		if(!$page){
 			$page =1;
 		}


		/*
			POST http://m.kipris.or.kr/mobile/search/data/search_patent.do
			searchKeyword
			searchExpression
			page
		*/


		$ch = curl_init();
		$data = "searchKeyword={$keyword}&searchExpression={$keyword}&page={$page}";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);



		// CURL 데이터 가져오기

		$object = simplexml_load_string($result, 'SimpleXMLElement',LIBXML_NOCDATA);
		//XML Object화

		// /var_dump($object);


		if($object->flag->__toString() == "ERROR"){
				$obj["return"]=500;
				$obj["error_msg"]=$object->message->__toString();
				echo json_encode($obj, JSON_UNESCAPED_UNICODE);
				exit();

		}

		$obj["return"]=200;
		$obj["keyword"]=$object->search->searchKeyword->__toString();
		//$obj["nowPage"] = $object->search->page->searchPage->__toString();
		$obj["totalPage"] = $object->search->page->totalPage->__toString()/10;
		$obj["articleCount"] = $object->search->searchFound->__toString();

		/*
			return=>"200" 성공
			return=>"500" 오류
		*/

		foreach ($object->search->articles->article as $key => $value) {
			// echo $value->VdkVgwKey;
			// $no = ;
			$no = (array)$value->VdkVgwKey;
			$title = (array)$value->TTL;
			$status = (array)$value->LSTV;
			$image = (array)$value->IMG->src;
			$APV = (array)$value->APV;


			$i++;
			$dataresult[$i]["number"] = $no[0];
			$dataresult[$i]["title"] = $title[0];
			// $dataresult[$i]["LST"] = $value->LST;
			$dataresult[$i]["status"] = $status[0];
			$dataresult[$i]["apv"] = $APV[0];
			$dataresult[$i]["url"] = "http://m.kipris.or.kr/mobile/search/view_patent.do?applno=".$no[0];

			// $dataresult[$i]["IPC"] = $value->IPC;
			// $dataresult[$i]["APV"] = $value->APV;
			// $dataresult[$i]["ADV"] = $value->ADV;
			if($image[0] == "/mobile/images/search/no_image_70x70.gif")
				$image[0] = "http://kipris.or.kr/mobile/images/search/no_image_70x70.gif";
			$dataresult[$i]["image"] = $image[0];
			/*
			POST http://kpat.kipris.or.kr/kpat/biblioa.do?method=biblioFrame HTTP/1.1
			Host: kpat.kipris.or.kr
			Connection: keep-alive
			Content-Length: 343
			Cache-Control: max-age=0

			POST
			applno=1019880006993&index=0&kindOfReq=&isMyConcern=&isMyFolder=&query=&expression=LED&sortField1=&sortField2=&sortState1=&sortState2=&searchInTrans=N&currentPage=1&searchFg=Y&collections=&rights=&merchandiseString=&start=biblio&numPerPage=30&sortField=&sortState=&FROM=&BOOKMARK=&REBOOKMARK=&pub_reg=&cntry=&next=biblioFrame&openPageId=View01

			*/

 		}

		$obj["data"] = $dataresult;
		echo json_encode($obj, JSON_UNESCAPED_UNICODE);




	}
	function postTest(){
		var_dump($_POST);
		$headers = apache_request_headers();
		foreach ($headers as $header => $value) {
			echo "$header: $value <br />\n";
		}
		exit();
	}


	function GetGoogleData(){
		$i=0;
		$post = curl_init();
		$keyword = urlencode($this->input->post('keyword'));
		$page = urlencode($this->input->post('page'));
		$url = "https://ajax.googleapis.com/ajax/services/search/patent?v=1.0&q={$keyword}&userip=61.108.14.235&start={$page}";
	    curl_setopt($post, CURLOPT_URL, $url);
	    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
	    $curlresult = curl_exec($post);

	    $returnjson = json_decode($curlresult,true);
	    // echo $curlresult;
	   	if(!$keyword){
	   		$obj["return"] = 404;
	    	$obj["msg"] = "파라미터에 이상이 있습니다";
			echo json_encode($obj, JSON_UNESCAPED_UNICODE);
		    exit();
	   	}

	    if($returnjson["responseStatus"] == "404"){
	    	$obj["return"] = 500;
	    	$obj["msg"] = "데이터가 존재하지 않습니다";
			echo json_encode($obj, JSON_UNESCAPED_UNICODE);
		    exit();
	    }

	    $obj["return"] = 200;
	    $obj["msg"] ="성공";
	    $obj["keyword"] = $keyword;
	    $noImg = "http://bks9.books.google.com/patents?id=mcVtBAARERAJ&printsec=drawing&img=1&zoom=1&sig=ACfU3U1kNam1klK5-ZtK94MdALKpztcz8Q";
	    // var_dump($)

	    $obj["totalPage"] = floor($returnjson["responseData"]["cursor"]["estimatedResultCount"]/4);
 		// var_dump();
 		// exit();
 		foreach ($returnjson["responseData"]["results"] as $key => $value) {
	    		$i++;
	    	$data[$i]["url"] = $value["unescapedUrl"];
	    	$data[$i]["title"] = strip_tags($value["title"]);
	    	// $data[$i]["titleNoFormatting"] = $value["titleNoFormatting"];
	    	$data[$i]["number"] = $value["patentNumber"];
	    	$data[$i]["status"] = $value["patentStatus"];
	    	$data[$i]["content"] = $value["content"];
	    	// $data[$i]["content"] = strip_tags($value["content"]);
	    	if(!$value["tbUrl"]){
	    		$data[$i]["image"] = $noImg;
	    	}else{
	    		$data[$i]["image"] = $value["tbUrl"];
	    	}

 	    }
 	    $obj["data"] = $data;
		echo json_encode($obj, JSON_UNESCAPED_UNICODE);
	    exit();

	}
}
?>
