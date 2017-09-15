<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
 
class FactoriesController extends AppController
{

	public function initialize()
	{		
		parent::initialize();
	}
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function index()
    {						
		$conn = ConnectionManager::get('default');
		// LIST	
		
		$alphabetMf = [];
		$blocksMf = [];
		
		$mfListType = MFVIEW;
		//echo "<pre>"; print_r($mfListType); echo "</pre>"; exit();
		
		$whereLetter = "";
		$letter = (isset($_GET['letter']) ? $_GET['letter'] : MFABC);
		
		if($letter){
			$whereLetter = 	 " AND (SUBSTRING(M.".LANG_PREFIX."name, 1, 1) = '".$letter."')";
		}
		//echo "<pre>"; print_r($whereLetter); echo "</pre>"; exit();
		
		$f_page_size = 5; // Максимальное количество отображаемых страниц в пагинации
		$this->set("f_page_size", $f_page_size);
		
		$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
		$this->set("f_page_num", $f_page_num);
		
		$alphabetList = $conn->query("
						SELECT SUBSTRING(M.".LANG_PREFIX."name, 1, 1) as letter
						FROM osc_shop_mf as M
						WHERE M.block=0				
						GROUP BY SUBSTRING(M.".LANG_PREFIX."name, 1, 1)
						ORDER BY SUBSTRING(M.".LANG_PREFIX."name, 1, 1)	
						LIMIT 70
					")->fetchAll('assoc');
		$this->set("alphabetList", $alphabetList);
		//echo "<pre>"; print_r($alphabetList); echo "</pre>"; exit();
				
		$allMfCount = $conn->query("
						SELECT COUNT(id) as count_mf
						FROM osc_shop_mf
						WHERE block=0
						LIMIT 1
					")->fetch('assoc');
		$this->set("allMfCount", $allMfCount);
		//echo "<pre>"; print_r($allMfCount); echo "</pre>"; exit();
		
		
		if ($mfListType){
			$f_pag_lim = 3; // Количество БУКВ на странице
			$this->set("f_pag_lim", $f_pag_lim);			
			
			$alphabetMf = $conn->query("
							SELECT SQL_CALC_FOUND_ROWS SUBSTRING(M.".LANG_PREFIX."name, 1, 1) as letter
							FROM osc_shop_mf as M
							WHERE M.block=0	$whereLetter			
							GROUP BY SUBSTRING(M.".LANG_PREFIX."name, 1, 1)
							ORDER BY SUBSTRING(M.".LANG_PREFIX."name, 1, 1)	
							LIMIT ".(($f_page_num-1)*$f_pag_lim).",$f_pag_lim
						")->fetchAll('assoc');
			
			foreach ($alphabetMf as &$mf_name){			
				$mf_name['mfs'] = $conn->query("
				SELECT M.".LANG_PREFIX."name as name, M.alias,			
							(SELECT COUNT(P.id) FROM `osc_shop_products` AS P WHERE P.block=0 AND P.mf_id = M.id) as count_prods
							FROM osc_shop_mf as M 
							WHERE SUBSTRING(M.".LANG_PREFIX."name, 1, 1)='".$mf_name['letter']."'
							AND  M.block=0
							ORDER BY M.".LANG_PREFIX."name
							LIMIT 1000
				")->fetchAll('assoc');			
			}
						
			$rows =  $conn->query("SELECT FOUND_ROWS() AS rows")->fetchAll('assoc'); // Запрос на глобальное количество букв на странице
			$this->set("rows", $rows);
			  
			//$f_total_rows = $rows['0']['rows']; // сохраняем общее количество букв на странице
			$f_total_rows = count($alphabetList); // сохраняем общее количество букв на странице
			$this->set("f_total_rows", $f_total_rows);
		
			$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
			$this->set("f_pages_count", $f_pages_count);	
			
			/*echo "<pre>"; print_r($f_total_rows); echo "</pre>";
			echo "<pre>"; print_r($f_pages_count); echo "</pre>";
			echo "<pre>"; print_r($f_page_num); echo "</pre>"; exit();	*/
		}else{
			$f_pag_lim = 24; // Количество Фабрик на странице
			$this->set("f_pag_lim", $f_pag_lim);
			
			$blocksMf = $conn->query("						
						SELECT M.id, M.".LANG_PREFIX."name as name, M.alias, M.filename, M.crop as logo
						FROM osc_shop_mf as M
						WHERE M.block=0 $whereLetter
						ORDER BY M.".LANG_PREFIX."name	
						LIMIT ".(($f_page_num-1)*$f_pag_lim).",$f_pag_lim
					")->fetchAll('assoc');
						
			
			foreach ($blocksMf as &$blmf){	
							
				$blmf['objects'] = $conn->query("
				SELECT O.".LANG_PREFIX."name as name
							FROM osc_shop_products as P 
							LEFT JOIN osc_shop_objects as O ON O.id=P.obj_id
							WHERE P.mf_id='".$blmf['id']."'
							AND  P.block=0  AND P.obj_id!=0
							GROUP BY P.obj_id
							ORDER BY O.".LANG_PREFIX."name
							LIMIT 300
				")->fetchAll('assoc');		
			}	
			
			
			$rows =  $conn->query("SELECT FOUND_ROWS() AS rows")->fetchAll('assoc'); // Запрос на глобальное количество фабрик на странице
			$this->set("rows", $rows);
			  
			$f_total_rows = count($alphabetList); // сохраняем общее количество фабрик на странице
			$this->set("f_total_rows", $f_total_rows);
		
			$f_pages_count = ceil($allMfCount['count_mf']/$f_pag_lim); // определяем количество страниц в пагинации
			$this->set("f_pages_count", $f_pages_count);	
			
			/*echo "<pre>"; print_r($f_total_rows); echo "</pre>";
			echo "<pre>"; print_r($f_pages_count); echo "</pre>";
			echo "<pre>"; print_r($f_page_num); echo "</pre>"; exit();*/
			}
			
			$this->set("alphabetMf", $alphabetMf);
			//echo "<pre>"; print_r($alphabetMf); echo "</pre>"; exit();
			
			$this->set("blocksMf", $blocksMf);
			//echo "<pre>"; print_r($blocksMf); echo "</pre>"; exit();
		
		
    }
	
	public function factory()
    {						
		$conn = ConnectionManager::get('default');
		
		$mfProdsLimit = 12;
		
		if (isset ($_GET['oll_prods']) && $_GET['oll_prods']==1) {
			$mfProdsLimit = 2000;
			}

        //fetch factory description from db
		$mfData = $conn->query("
						SELECT M.id, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."country as country, M.".LANG_PREFIX."meta_title as meta_title, M.".LANG_PREFIX."meta_keys as meta_keys, M.".LANG_PREFIX."meta_desc as meta_desc, M.".LANG_PREFIX."details as details, M.alias, M.filename, M.crop, M.video, M.site
						FROM osc_shop_mf as M
						WHERE M.block=0			
						AND M.alias='".LA."'
						LIMIT 1
					")->fetch('assoc');
		$this->set("mfData", $mfData);
		//echo "<pre>"; print_r($mfData); echo "</pre>"; exit();
		
		if ( !$mfData )
		{
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: ".RS."404/"); 
			exit();
		}
		
		$mfID = $mfData['id'];
		//echo "<pre>"; print_r($mfID); echo "</pre>"; exit();
		
		/*if ($mfData['meta_title']) {
		$metaTitle = $mfData['meta_title'];
		$this->set("metaTitle", $metaTitle);//title страницы
		}*/	
		
		$mfTxt 		= (LANG_PREFIX == "en_" ? "factory" : "фабрика");	
		$mfName 	= (isset($mfData['name']) ? $mfData['name'] : "");	
		$salonTxt 	= "салон элитной мебели";	
		if (LANG_PREFIX == "ua_") {$salonTxt 	= "салон елітних меблів";}	
		if (LANG_PREFIX == "en_") {$salonTxt 	= "salon of elite furniture";}		
		
		$metaTitle = $mfTxt." ".$mfName." - ".$salonTxt." Comodo";
		$this->set("metaTitle", $metaTitle);//сгенерированный title фабрики
		
		if ($mfData['meta_keys']) {
		$metaKeys = $mfData['meta_keys'];
		$this->set("metaKeys", $metaKeys);//keywords страницы
		}
		
		if ($mfData['meta_desc']) {
			$metaDesc = $mfData['meta_desc'];
		}else{
			$metaDesc = "";
		}
		$this->set("metaDesc", $metaDesc);//description страницы

        //stupid method just to take names of categories
		$mfObjects = $conn->query("
						SELECT O.id, O.".LANG_PREFIX."name as name
							FROM osc_shop_products as P 
							LEFT JOIN osc_shop_objects as O ON O.id=P.obj_id
							WHERE P.mf_id='".$mfID."'
							AND  P.block=0
							AND  P.obj_id>=1
							GROUP BY P.obj_id
							ORDER BY O.".LANG_PREFIX."name
							LIMIT 300
				")->fetchAll('assoc');

        // fetch all information about products in a group
		foreach ($mfObjects as &$mf_obj){			
				$mf_obj['products'] = $conn->query("
				SELECT P.".LANG_PREFIX."name as name, P.".RATE_PREFIX."price as price, P.".RATE_PREFIX."sale_price as sale_price, P.alias, P.id, 
							(SELECT crop FROM osc_files_ref WHERE `ref_id` = P.id AND `ref_table` = 'shop_products' ORDER BY `id` LIMIT 1) as img
							FROM osc_shop_products as P 
							WHERE P.obj_id='".$mf_obj['id']."'
							AND  P.mf_id='".$mfID."'
							AND  P.block=0
							ORDER BY P.".LANG_PREFIX."name
				")->fetchAll('assoc');			
			}			
		$this->set("mfObjects", $mfObjects); // СПИСОК ТОВАРОВ ПРОИЗВОДИТЕЛЯ СГРУПИРОВАННОГО ПО ПРЕДМЕТАМ
		//echo "<pre>"; print_r($mfObjects); echo "</pre>"; exit();

        // СПИСОК ТОВАРОВ ПРОИЗВОДИТЕЛЯ КОТОРЫМ НЕ НАЗНАЧЕН ПРЕДМЕТ
        //Забриаются  например столовая F111
		$mfProdsNobj = $conn->query("
						SELECT P.".LANG_PREFIX."name as name, P.".RATE_PREFIX."price as price, P.".RATE_PREFIX."sale_price as sale_price, P.alias, P.id, 
							(SELECT crop FROM osc_files_ref WHERE `ref_id` = P.id AND `ref_table` = 'shop_products' ORDER BY `id` LIMIT 1) as img
							FROM osc_shop_products as P 
							WHERE P.mf_id='".$mfID."'
							AND  P.block=0
							AND  (P.obj_id=0 OR P.obj_id IS NULL)
							ORDER BY P.".LANG_PREFIX."name
				")->fetchAll('assoc');		
		$this->set("mfProdsNobj", $mfProdsNobj); // СПИСОК ТОВАРОВ ПРОИЗВОДИТЕЛЯ КОТОРЫМ НЕ НАЗНАЧЕН ПРЕДМЕТ
		//echo "<pre>"; print_r($mfProdsNobj); echo "</pre>"; exit();		
		
		/*$mfCollections = $conn->query("
						SELECT C.id, C.".LANG_PREFIX."name as name,
							(SELECT COUNT(P.id) FROM `osc_shop_products` AS P WHERE P.block=0 AND P.collection_id = C.id) as count_prods
							FROM osc_shop_collections as C 
							WHERE C.mf_id='".$mfID."'
							ORDER BY C.".LANG_PREFIX."name
							LIMIT 1000
				")->fetchAll('assoc');
		$this->set("mfCollections", $mfCollections);
		//echo "<pre>"; print_r($mfCollections); echo "</pre>"; exit();*/
		
		$mfCollections = $conn->query("
						SELECT C.id, C.".LANG_PREFIX."name as name, P.cat_id
							FROM osc_shop_products as P 
							LEFT JOIN osc_shop_collections as C ON C.id=P.collection_id
							WHERE P.mf_id='".$mfID."'
							AND  P.block=0
							AND  P.collection_id>=1
							GROUP BY P.collection_id
							ORDER BY C.".LANG_PREFIX."name
							LIMIT 300
				")->fetchAll('assoc');	
				
		foreach ($mfCollections as &$mf_coll){			
				$mf_coll['products'] = $conn->query("
				SELECT P.cat_id, P.id, 
							(SELECT alias FROM osc_shop_catalog WHERE `id` = P.cat_id ORDER BY `id` LIMIT 1) as cat_alias
							FROM osc_shop_products as P 
							WHERE P.collection_id='".$mf_coll['id']."'
							AND  P.mf_id='".$mfID."'
							AND  P.block=0
							ORDER BY P.".LANG_PREFIX."name
							LIMIT 1000
				")->fetchAll('assoc');			
			}			
		$this->set("mfCollections", $mfCollections); // СПИСОК ТОВАРОВ ПРОИЗВОДИТЕЛЯ СГРУПИРОВАННОГО ПО КОЛЛЕКЦИИ
		//echo "<pre>"; print_r($mfCollections); echo "</pre>"; exit();
    }
}
