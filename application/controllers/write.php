<?php

class write extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$this->load->database();
		$this->load->model('write_model');
/*
		DataBase 설정

		$data = $this->write_model->gets("SELECT ");
		var_dump($data);
		exit();
*/


		header("Content-Type: text/html; charset=UTF-8");




		$config['upload_path'] = './tmp/';
		$config['allowed_types'] = '*';


		$zip = new ZipArchive();

		$this->load->library('upload', $config);


		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			echo "엄마가 죽었다고합니다";

			// $this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$filename = explode(".", $data["upload_data"]["file_name"])[0];
			$zip = new ZipArchive;
			if ($zip->open($data["upload_data"]["full_path"]) === FALSE) {
			    echo "압축파일을 여는중에 문제가 발생하였습니다";

			}
			$zip->extractTo($data["upload_data"]["file_path"]);
		    $zip->close();
		    

			$object = simplexml_load_file($data["upload_data"]["file_path"]."1.xml");
			//xml불러오기
			$description = (array)$object->PatentCAFDOC->description;
			$claims = (array)$object->PatentCAFDOC->claims;
			$abstract = (array)$object->PatentCAFDOC->abstract;
			$drawings = (array)$object->PatentCAFDOC->drawings;

			/*데이터 처리를 해볼까*/

			//description 시작
			$title = $description["invention-title"];
			$technical_field = (array)$description["technical-field"];
			// var_dump($);

			$background_art = (array)$description["background-art"];
			//summary_of_invention 시작
			$summary_of_invention = (array)$description["summary-of-invention"];
			$tech_problem = (array)$summary_of_invention["tech-problem"];
			$tech_solution = (array)$summary_of_invention["tech-solution"];
			$advantageous_effects = (array)$summary_of_invention["advantageous-effects"];
			//summary_of_invention 종료

			$description_of_drawings = (array)$description["description-of-drawings"];
			$description_of_embodiments = (array)$description["description-of-embodiments"];
			$reference_signs_list = (array)$description["reference-signs-list"];
			//description 종료

			//claims 시작
			$claim = (array)$claims['claim'];
			$claim_num = $claim["@attributes"]["num"];
			$claim_text = $claim["claim-text"];


			//claims 종료


			$abstract_summary = (array)$abstract["summary"];
			$abstract_figure =  (array)$abstract["abstract-figure"];
			$abstract_figure_p = (array)$abstract_figure["p"];
			$abstract_num = $abstract_figure_p["@attributes"]["num"];
			$abstract_article = (array)$abstract_figure_p[0];
			$abstract_article_id = $abstract_article["@attributes"]["id"];
			$abstract_article_he = $abstract_article["@attributes"]["he"];
			$abstract_article_wi = $abstract_article["@attributes"]["wi"];
			$abstract_article_file = $abstract_article["@attributes"]["file"];

			// exit();


			$drawingsdata = (array)$drawings["figure"];
			$drawings_num = $drawingsdata["@attributes"]["num"];
			$drawingsdata_article = (array)$drawingsdata[0];
			$drawingsdata_article_id = $drawingsdata_article["@attributes"]["id"];
			$drawingsdata_article_he = $drawingsdata_article["@attributes"]["he"];
			$drawingsdata_article_wi = $drawingsdata_article["@attributes"]["wi"];
			$drawingsdata_article_file = $drawingsdata_article["@attributes"]["file"];

			$INSERT = "INSERT INTO `petent_detail`(
				`invention-title`, 
				`technical-field`, 
				`background-art`, 
				`tech-problem`, 
				`tech-solution`, 
				`advantageous-effects`, 
				`description-of-drawings`, 
				`description-of-embodiments`, 
				`reference-signs-list`, 
				`claim-num`, 
				`claim-text`, 
				`abstract-num`, 
				`abstract-he`, 
				`abstract-wi`, 
				`abstract-file`,
				`figure-num`,
				`figure-id`,
				`figure-he`, 
				`figure-wi`, 
				`figure-file`, 
				`created`) VALUES ('".addslashes($title)."',
				'".addslashes($technical_field["p"])."',
				'".addslashes($background_art["p"])."',
				'".addslashes($tech_problem["p"])."',
				'".addslashes($tech_solution["p"])."',
				'".addslashes($advantageous_effects["p"])."',
				'".addslashes($description_of_drawings["p"])."',
				'".addslashes($description_of_embodiments["p"])."',
				'".addslashes($reference_signs_list["p"])."',
				'".addslashes($claim_num)."',
				'".addslashes($claim_text)."',
				'".addslashes($drawingsdata_article_id)."',
				'".addslashes($drawingsdata_article_he)."',
				'".addslashes($abstract_article_wi)."',
				'".addslashes($drawingsdata_article_file)."',
				'".addslashes($drawings_num)."',
				'".addslashes($drawingsdata_article_id)."',
				'".addslashes($drawingsdata_article_he)."',
				'".addslashes($drawingsdata_article_wi)."',
				'".addslashes($drawingsdata_article_file)."',
				'".date("Y-m-d H:i:s")."'

				)";
			
			echo $INSERT;

			copy()





		}
	}
}
?>