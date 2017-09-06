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
use Cake\Network\Session\DatabaseSession;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */

class CatalogController extends AppController
{
	
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
	
	public function product(){
		
		$conn = ConnectionManager::get('default');
		
		// PRODACT CARD
				$prodCard = $conn->query("
					SELECT M.id, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."details as details,  M.".RATE_PREFIX."price as price, M.".RATE_PREFIX."sale_price as sale_price, M.cat_id, M.obj_id, M.alias, M.model, M.sku, M.code, M.color_id, M.video, M.".LANG_PREFIX."title as meta_title, M.".LANG_PREFIX."keys as meta_keys, M.".LANG_PREFIX."desc as meta_desc, M.collection_id,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_name,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=M.obj_id AND id!=0 LIMIT 1) as obj_name,
								(SELECT alias FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_alias,  
								(SELECT filename FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_file, 
								(SELECT crop FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_crop,
								(SELECT alias FROM osc_shop_catalog WHERE id=M.cat_id LIMIT 1) as cat_alias,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_collections WHERE id=M.collection_id AND id !=0 LIMIT 1) as collection_name,								
								(SELECT ".LANG_PREFIX."country FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_country,
								(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '6' LIMIT 1) as sale_id,
								(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '1' LIMIT 1) as new_id,
								(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '7' LIMIT 1) as delivery,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_colors WHERE id=M.color_id AND id!=0 LIMIT 1) as color,
								(SELECT id FROM osc_shop_like WHERE `session_id` = '".SESID."' AND `uid` = '".UID."' AND `prod_id` = M.id ORDER BY `id` LIMIT 1) as prod_like,
								(SELECT id FROM osc_shop_products WHERE id<M.id ORDER BY id DESC LIMIT 1) as left_id,
								(SELECT id FROM osc_shop_products WHERE id>M.id ORDER BY id LIMIT 1) as right_id
								FROM osc_shop_products as M 
								WHERE M.alias='".LA."' 
								AND  M.block=0
								LIMIT 1
				")->fetch('assoc');
				//echo "<pre>"; print_r($prodCard); echo "</pre>";  exit();				
					
				
				$_prod_id = $prodCard['id'];
				$catId = $prodCard['cat_id'];
				$collectionId = $prodCard['collection_id'];				
				
				$left_id = $prodCard['left_id'];
				$right_id = $prodCard['right_id'];
				
				$allCollection = $conn->query("
					SELECT M.id, M.".LANG_PREFIX."name as name, M.alias, M.".RATE_PREFIX."price as price, M.width, M.depth, M.height, M.diameter, M.obj_id,
								(SELECT crop FROM osc_files_ref WHERE ref_id=M.id AND `ref_table` = 'shop_products' ORDER BY id LIMIT 1) as img,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_name,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=M.obj_id AND id!=0 LIMIT 1) as obj_name
								FROM osc_shop_products as M
								WHERE M.collection_id = '$collectionId' AND
								M.collection_id !=0 AND
								M.id != '$_prod_id' AND
								M.block = 0
								ORDER BY M.".RATE_PREFIX."price
								LIMIT 200
				")->fetchAll('assoc');
				$this->set("allCollection", $allCollection);//все предметы коллекции
				//echo "<pre>"; print_r($allCollection); echo "</pre>";  exit();
				
				$objGroup = $conn->query("
					SELECT M.id, M.".LANG_PREFIX."name as name, M.alias, M.width, M.depth, M.height, M.diameter,
								(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=M.obj_id AND id!=0 LIMIT 1) as obj_name
								FROM osc_shop_object_prod_ref as R
								LEFT JOIN osc_shop_products as M ON M.id = R.object_id
								WHERE R.prod_id = '$_prod_id' AND
								M.block = 0
								ORDER BY obj_name
								LIMIT 200
				")->fetchAll('assoc');
				$this->set("objGroup", $objGroup);//все предметы коллекции
				//echo "<pre>"; print_r($objGroup); echo "</pre>";  exit();								
				
				$prevProd = $conn->query("
					SELECT M.id, M.".LANG_PREFIX."name as name, M.alias, M.cat_id,
								(SELECT crop FROM osc_files_ref WHERE ref_id=M.id AND `ref_table` = 'shop_products' ORDER BY id LIMIT 1) as file
								FROM osc_shop_products as M
								WHERE M.id < '$_prod_id' AND
								M.cat_id = '$catId'
								ORDER BY M.id DESC
								LIMIT 1
				")->fetch('assoc');
				//$this->set("prevProd", $prevProd);//предыдущий товар				
				
				$nextProd = $conn->query("
					SELECT M.id, M.".LANG_PREFIX."name as name, M.alias, M.cat_id,
								(SELECT crop FROM osc_files_ref WHERE ref_id=M.id AND `ref_table` = 'shop_products' ORDER BY id LIMIT 1) as file
								FROM osc_shop_products as M
								WHERE M.id > '$_prod_id' AND
								M.cat_id = '$catId'
								ORDER BY M.id
								LIMIT 1
				")->fetch('assoc');
				$this->set("nextProd", $nextProd);//следующий товар				
				//echo "<pre>"; print_r($nextProd); echo "</pre>";  exit();
				
				if ($prodCard) {
					$this->set("prodCard", $prodCard);
					
					/*if ($prodCard['meta_title']) {
					$metaTitle = $prodCard['meta_title'];
					$this->set("metaTitle", $metaTitle);//title страницы
					}*/		
				
					$prodObj 	= (isset($prodCard['obj_name']) ? $prodCard['obj_name'] : "");	
					$prodName 	= (isset($prodCard['name']) ? $prodCard['name'] : "");	
					$mfTxt 		= (LANG_PREFIX == "en_" ? "factory" : "фабрика");	
					$prodMf 	= (isset($prodCard['mf_name']) ? $prodCard['mf_name'] : "");	
					$skuTxt 	= (LANG_PREFIX == "en_" ? "sku" : "арт.");	
					$prodSku 	= (isset($prodCard['sku']) ? $prodCard['sku'] : "");
					
					$metaTitle = $prodObj." ".$prodName.", ".$mfTxt." ".$prodMf.", ".$skuTxt." ".$prodSku." - Comodo";
					$this->set("metaTitle", $metaTitle);//сгенерированный title товара
					
					if ($prodCard['meta_keys']) {
					$metaKeys = $prodCard['meta_keys'];
					$this->set("metaKeys", $metaKeys);//keywords страницы
					}
					
					if ($prodCard['meta_desc']) {
					$metaDesc = $prodCard['meta_desc'];
					}else{
						$metaDesc = "";
						}
					$this->set("metaDesc", $metaDesc);//description страницы
					
					$_prod_color = $prodCard['color_id'];		
					$_prod_price = $prodCard['price'];
					$min_price = $_prod_price - (($_prod_price*30)/100);
					$max_price = $_prod_price + (($_prod_price*30)/100);
					
					$breadCrumbs = [];
					
					$cat = $conn->query("
						SELECT id, parent, ".LANG_PREFIX."name as name, alias
									FROM osc_shop_catalog
									WHERE id = '$catId'
									LIMIT 1
					")->fetch('assoc');
					$this->set("prodCatName", $cat['name']);
					
					array_push ($breadCrumbs, $cat);
					
					while ($cat['parent']>0){
						$cat = $conn->query("
						SELECT id, parent, ".LANG_PREFIX."name as name, alias
									FROM osc_shop_catalog
									WHERE id = '".$cat['parent']."'
									LIMIT 1
						")->fetch('assoc');
						array_push ($breadCrumbs, $cat);
						}
					
					$breadCr = array_reverse ($breadCrumbs);
					$this->set("breadCr", $breadCr);
					//echo "<pre>"; print_r($breadCr); echo "</pre>";  exit();
					
					$prodChars = $conn->query("
						SELECT M.char_id, M.prod_id, M.filter, C.".LANG_PREFIX."name as name, C.measure
									FROM osc_shop_chars_prod_ref as M 
									JOIN osc_shop_chars as C ON M.char_id=C.id 
									WHERE 
										M.prod_id=$_prod_id	AND 
										C.block=0
									GROUP BY M.char_id
									ORDER BY C.pos, C.".LANG_PREFIX."name
									LIMIT 100
					")->fetchAll('assoc');
					
					foreach ($prodChars as &$pr_ch){															
						$pr_ch['values'] = $conn->query("
						SELECT V.".LANG_PREFIX."value as value, M.val_id , M.id as ref_id
									FROM osc_shop_chars_prod_ref as M 
									LEFT JOIN osc_shop_chars_values as V on V.id=M.val_id 
									WHERE M.char_id=".$pr_ch['char_id']."
									AND  M.prod_id=".$pr_ch['prod_id']."
									AND  V.".LANG_PREFIX."value != ''
									ORDER BY V.".LANG_PREFIX."value
									LIMIT 50
						")->fetchAll('assoc');					
					}
					
					$this->set("prodChars", $prodChars);					
					//echo "<pre>"; print_r($prodChars); echo "</pre>";  exit();
					
					$prodColors = $conn->query("
						SELECT M.id, M.name, M.value 
						FROM osc_shop_colors as M 
						LEFT JOIN osc_shop_color_prod_ref as R on M.id = R.color_id 
						WHERE R.prod_id = $_prod_id 
						AND	M.id!=0
						ORDER BY M.order_id 
						LIMIT 100
					")->fetchAll('assoc');
					$this->set("prodColors", $prodColors);
					//echo "<pre>"; print_r($prodColors); echo "</pre>";  exit();
					
					$prodImgs = $conn->query("
						SELECT R.file, R.crop, R.".LANG_PREFIX."title as title
									FROM osc_files_ref as R 
									WHERE R.ref_table='shop_products'
									AND R.ref_id=$_prod_id
									ORDER BY R.order_pos
									LIMIT 40
					")->fetchAll('assoc');
					$this->set("prodImgs", $prodImgs);
					//echo "<pre>"; print_r($prodImgs); echo "</pre>";  exit();
					
					$prodDecors = $conn->query("
						SELECT R.file, R.crop, R.".LANG_PREFIX."title as title 
									FROM osc_finishes_ref as R 
									WHERE R.prod_id=$_prod_id
									LIMIT 50
					")->fetchAll('assoc');
					$this->set("prodDecors", $prodDecors);
					//echo "<pre>"; print_r($prodDecors); echo "</pre>";  exit();
					
					$prodSizes = $conn->query("
						SELECT width, depth, height, diameter
									FROM osc_shop_products
									WHERE id=$_prod_id	AND 
										  block=0
									ORDER BY id
									LIMIT 1
					")->fetch('assoc');
					$this->set("prodSizes", $prodSizes);
					//echo "<pre>"; print_r($prodSizes); echo "</pre>";  exit();					
					
					$similarProds= $conn->query("
									SELECT M.id, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."details as details,  M.".RATE_PREFIX."price as price, M.".RATE_PREFIX."sale_price as sale_price, M.alias, M.cat_id,
									(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=M.id ORDER BY id LIMIT 1 ) as img
									FROM osc_shop_products as M 
									WHERE 
										M.".RATE_PREFIX."price >= $min_price  	AND 
										M.".RATE_PREFIX."price <= $max_price 	AND
										M.id != $_prod_id 	AND
										M.block=0
									GROUP BY M.id
									ORDER BY M.".RATE_PREFIX."price
									LIMIT 10
					")->fetchAll('assoc');
					$this->set("similarProds", $similarProds);	
					//echo "<pre>"; print_r($similarProds); echo "</pre>";  exit();		
					
					
					$viewedProds= $conn->query("
									SELECT M.*, P.".LANG_PREFIX."name as name, P.".RATE_PREFIX."price as price, P.alias as alias, P.".LANG_PREFIX."name as name, P.".RATE_PREFIX."sale_price as sale_price, P.obj_id,
									(SELECT crop FROM osc_files_ref WHERE ref_id=P.id AND `ref_table` = 'shop_products' ORDER BY id LIMIT 1) as img,
									(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_name,
									(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=P.obj_id AND id!=0 LIMIT 1) as obj_name
									FROM osc_shop_viewed AS M
									LEFT JOIN osc_shop_products AS P on P.id = M.prod_id
									WHERE `uid`='".UID."'				
									AND  `session_id`='".SESID."'
									ORDER BY id DESC
									LIMIT 16
					")->fetchAll('assoc');
					$this->set("viewedProds", $viewedProds);	
					//echo "<pre>"; print_r($viewedProds); echo "</pre>";  exit();	
				}
				else 
				{ $prodCard = "";
					$this->set("prodCard", $prodCard);
				}
				
				$prodComments = $conn->query("
						SELECT M.*, M.name as table_name,
							(SELECT name FROM osc_users WHERE id = M.user_id LIMIT 1) as name
							FROM osc_shop_product_comments as M
							WHERE M.prod_id = '$_prod_id' AND
							M.block = 0
							ORDER BY M.dateCreate DESC
							LIMIT 100
					")->fetchAll('assoc');
					$this->set("prodComments", $prodComments);
				// END PRODACT CARD	
		}
		
	protected function init(){
        $cat_alias = LA;

        $cat = $this->Help->getCatByAlias($cat_alias); 
        if ($cat['child_cat']) {
            $prod_price_info = $this->Help->getProdPriceInfo($cat);
            $min_price = $prod_price_info['prices']['min_price'];
            $max_price = $prod_price_info['prices']['max_price'];
            $ri_url_split = explode("?",$_SERVER['REQUEST_URI']);
            $ri_url = $ri_url_split[0];

            return array(
                'main_c' => $cat['main_cat'],
                'child_c' => $cat['child_cat'],
                'min_price' => $min_price,
                'max_price' => $max_price,
                'cat' => $cat,
                'ri_url' => $ri_url,
                'filter_group_id' => ($cat['child_cat'] ? $cat['child_cat']['specs_group_id'] : $cat['main_cat']['specs_group_id'])
            );
        }else{
			// $this->Help->_pre($cat, true);
            $this->Help->r2(RS.'404/');
        }
        
    }
	 
	public function index(){
		$conn = ConnectionManager::get('default');
		
		//echo "<pre>"; print_r(SESID); echo "</pre>";  exit();
		//echo "<pre>"; print_r(UID); echo "</pre>";  exit();
		//echo "<pre>"; print_r(LANG); echo "</pre>"; exit();	
		
		if ( LA == "catalog" )
		{
			$mpCatalog = $conn->query("
				SELECT C.".LANG_PREFIX."name as name, C.alias, C.id, C.filename,
				(SELECT COUNT(P.id) FROM `osc_shop_products` AS P WHERE P.block=0 AND P.cat_id = C.id) as count_prods 
				FROM osc_shop_catalog as C
				WHERE C.block = 0
				ORDER BY C.pos 
				LIMIT 100
			")->fetchAll('assoc');
			$this->set("mpCatalog", $mpCatalog);
			
			$this->render("catalogIndex");
		}else
		{
			// DECLARING VARIABLES
			$num_pages = false;
			$prods = false;
			$init_arr = false;
			
			$filter_colors = false;
			$filter_objects = false;
			$filter_collections = false;
			$filter_mfs = false;
			
			$filter_countries = false;
			$filter_chars = false;
	
			$ri = $_SESSION['ri'];
			
			$showSeo = 1;
	
			if (isset($_GET['page']) && $_GET['page'] > 0){
				$cur_page = $_GET['page'];
				$main_cat = $ri[count($ri)-3];
				$showSeo = 0;
			}else{
				$cur_page = 1;
				$main_cat = $ri[count($ri)-2];
				$showSeo = 1;
			}
			$this->set("showSeo", $showSeo);
			
			$cat_exist = $this->Help->check_cat(LA, false); // $this->ri[1]
			$catID = $cat_exist['id'];
			
			if(isset($_GET['filter']) && isset($_GET['value']))
			{
				switch($_GET['filter'])
				{
					case 'mfs':
					{
						$_id = (int)$_GET['value'];
						
						$_SESSION['prods_filter'] = [];
						$_SESSION['mfs_filter'] = [];
						$_SESSION['mfs_filter'][$catID] = [ $_id ];
						$this->Help->r2(RS.LANG."/catalog/".LA."/");
						break;
					}
					case 'collections':
					{
						$_id = (int)$_GET['value'];
						
						$_SESSION['prods_filter'] = [];
						$_SESSION['collections_filter'] = [];
						$_SESSION['collections_filter'][$catID] = [ $_id ];
						$this->Help->r2(RS.LANG."/catalog/".LA."/");
						break;
					}
					case 'objects':
					{
						$_id = (int)$_GET['value'];
						
						$_SESSION['prods_filter'] = [];
						$_SESSION['objects_filter'] = [];
						$_SESSION['objects_filter'][$catID] = [ $_id ];
						$this->Help->r2(RS.LANG."/catalog/".LA."/");
						break;
					}
					default: break;
				}
			}
	
			// GET META
			$get_meta = $this->Help->getCategoryMeta($catID);
			if ($get_meta['meta_title']) {
				$meta_title = $get_meta['meta_title'];
				$this->set('meta_title', $meta_title);
			}
			if ($get_meta['meta_desc']) {
				$meta_desc = $get_meta['meta_desc'];
				$this->set('meta_desc', $meta_desc);
			}
			if ($get_meta['meta_keys']) {
				$meta_keys = $get_meta['meta_keys'];
				$this->set('meta_keys', $meta_keys);
			}
			if ($get_meta['index']) {
				$cat_index = $get_meta['index'];
				$this->set('cat_index', $cat_index);
			}else{
				$this->set('cat_index', 0);
			}
	
	
	
			if ($cat_exist) {
				$cat_id = $cat_exist['id'];
				$cat_alias = LA;
					$init_arr = $this->init();
					
					$filterPrepare = $this->Help->filterPrepare(
						$cat_id,
						$init_arr['filter_group_id'],
						$init_arr['min_price'],
						$init_arr['max_price']
					);
	 
	
					$products_by_cat = $this->Help->getCategoryProductsById(
						$cat_id,
						$cur_page,
						$filterPrepare['filter_prods_by_page'],
						$filterPrepare['filters_1'].
						$filterPrepare['and_colors_filter'], 
						$filterPrepare['filter_joins_1'], 
						$filterPrepare['sql_order_vector']
					);
	
					// debug($products_by_cat); exit();
	
					$prods = $products_by_cat['items'];
					$num_pages = $products_by_cat['rows']['rows'] / PR_QTY; // $filterPrepare['filter_prods_by_page'];
	
					$cat = $init_arr['cat'];
	
					$filter_chars = $this->Help->getCatChars($cat);
	
					// debug($filter_chars);
					
					//$filter_colors 		= $this->Help->getUniColorsFromOneCategory($cat_id);
					//$filter_objects 	= $this->Help->getUniObjectsFromOneCategory($cat_id);        
					//$filter_collections = $this->Help->getUniCollectionsFromOneCategory($cat_id);        
					//$filter_mfs 		= $this->Help->getUniMfsFromOneCategory($cat_id);       
					
					// Calculate count for products table filters
					
					$productsTableFilters = [
						'color_id' 		=> $this->Help->getUniColorsFromOneCategory($cat_id),
						'obj_id' 		=> $this->Help->getUniObjectsFromOneCategory($cat_id),        
						'collection_id' => $this->Help->getUniCollectionsFromOneCategory($cat_id),        
						'mf_id' 		=> $this->Help->getUniMfsFromOneCategory($cat_id)
					]; 
					
					 
					// Get filters from SESSION
					 
					$post_filter = (
							isset($_SESSION['prods_filter']) ? 
								isset($_SESSION['prods_filter'][$cat_id]) ?  
										$_SESSION['prods_filter'][$cat_id]
								: []
							: []
							);
							
					
					// $filtersPrepeared = $this->Help->filters_calc_query($post_filter, 0, $cat_id);
			
					// echo "<pre>"; print_r($filtersPrepeared); echo "</pre>";
			
					$filters_xf      = $filterPrepare['filters_1']; //          . $filtersPrepeared['filters'];
					$filter_joins_xf = $filterPrepare['filter_joins_1']; //     . $filtersPrepeared['filter_joins'];
					
					foreach($productsTableFilters as $xf_name => &$xf_list_item)
					{
						foreach($xf_list_item as $xfi => $x_item)
						{
							$xf_list_item[$xfi]['ref_md5'] = md5( $xf_name.$x_item['id'] . trim(mb_strtolower($x_item['name'])) );
							
							$xf_list_item[$xfi]['count'] = 0;
							
							$currXfCountResult = $this->Help->countXFilterValues($cat_id, ['name'=>$xf_name, 'id'=>$x_item['id']], $filters_xf, $filter_joins_xf);  
							// Количество товаров учитывая все фильтры по заданному field_id в таблице Products
						
							if($currXfCountResult) $xf_list_item[$xfi]['count'] = $currXfCountResult['count'];
						}
					}          
	
					// echo "<pre>"; print_r($productsTableFilters); echo "</pre>";
	
					$this->set(array(
						'cat_id' => $cat_id,
						'products' => $prods,
						'num_pages' => ceil($num_pages),
						'cur_page' => $cur_page,
						'main_cat' => $main_cat,
						'cat_alias' => $cat_alias,
						'prod_count' => $products_by_cat['rows']['rows'],
						'main_c' => $init_arr['main_c'],
						'child_c' => $init_arr['child_c'],
						'min_price' => $init_arr['min_price'],
						'max_price' => $init_arr['max_price'],
						'filter_chars' => $filter_chars,
						
						'filter_colors' 		=> $productsTableFilters['color_id'], //$filter_colors,
						'filter_objects' 		=> $productsTableFilters['obj_id'], //$filter_objects,
						'filter_collections' 	=> $productsTableFilters['collection_id'], //$filter_collections,
						'filter_mfs' 			=> $productsTableFilters['mf_id'], //$filter_mfs,
						
						'ri_url' => $init_arr['ri_url'],
						'filter_group_id' => $init_arr['filter_group_id'],
						'filter_min_price' => $filterPrepare['min_price'],
						'filter_max_price' => $filterPrepare['max_price'],
						
						'checked_colors' 		=> $filterPrepare['colors'],
						'checked_objects' 		=> $filterPrepare['objects'],
						'checked_collections' 	=> $filterPrepare['collections'],
						'checked_mfs' 			=> $filterPrepare['mfs'],
						
						'checked_chars' => $filterPrepare['checked_chars'],
						'charsList' => $filterPrepare['charsList'],
						'sort_vector' => $filterPrepare['sort_vector'],
						'filter_prods_by_page' => $filterPrepare['filter_prods_by_page']
					));
					
					// echo "<pre>"; print_r($filterPrepare['charsList']); echo "</pre>";
					
			}else{
				debug($cat_exist);
				// $this->Help->r2(RS.'404/');
			}
			
					// PRODUCT LIST	
			
					$f_pag_lim = PR_QTY; // Количество товаров на странице
					$this->set("f_pag_lim", $f_pag_lim);
			
					$f_page_size = 5; // Максимальное количество отображаемых страниц в пагинации
					$this->set("f_page_size", $f_page_size);
					
					$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
					$this->set("f_page_num", $f_page_num);
					
					$filterPriceMin = ((isset($_GET['minPrice']) ? (int)$_GET['minPrice'] : 0));
					$filterPriceMax = ((isset($_GET['maxPrice']) ? (int)$_GET['maxPrice'] : 0));
					
					$filterWhere = "";
					$filterJoin = "";
					
					/*$productsPricesLimit = $conn->query("
						SELECT 
							MIN(P.".RATE_PREFIX."price) as min_price, 
							MAX(P.".RATE_PREFIX."price) as max_price 
						FROM osc_shop_products as P 
						".$filterJoin."
						WHERE 1 ".$filterWhere."
						")->fetch('assoc');
						
					$filterPriceMin = $productsPricesLimit['min_price'];
					$filterPriceMax = $productsPricesLimit['max_price'];
					
					$sliderPriceLeftLimit = $productsPricesLimit['min_price'];
					$sliderPriceRightLimit = $productsPricesLimit['max_price'];
					
					$this->set("sliderPriceLeftLimit", $sliderPriceLeftLimit);
					$this->set("sliderPriceRightLimit", $sliderPriceRightLimit);
					
					$_GET['filter_price_min'] = $productsPricesLimit['min_price'];
					$_GET['filter_price_max'] = $productsPricesLimit['max_price'];*/
					
					//echo "<pre>"; print_r($productsPricesLimit); echo "</pre>"; exit();
					
					$category = $conn->query("
						SELECT M.*, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."details as details, M.".LANG_PREFIX."meta_title as meta_title, M.".LANG_PREFIX."meta_keys as meta_keys, M.".LANG_PREFIX."meta_desc as meta_desc
						FROM osc_shop_catalog as M 
						WHERE M.alias = '".LA."' 
						LIMIT 1
					")->fetch('assoc');
					$this->set("category", $category);					
					
					if ( !$category )
					{
						header("HTTP/1.1 301 Moved Permanently"); 
						header("Location: ".RS."404/"); 
						exit();
					}
					
					$catId = $category['id'];		
					$this->set("catId", $catId);
					
					$catName = $category['name'];		
					$this->set("catName", $catName);
					
					if ($category['meta_title']) {
						$metaTitle = $category['meta_title'];
					}else{
						$metaTitle = $category['name'];
						}
					$this->set("metaTitle", $metaTitle);//title страницы
					
					if ($category['meta_keys']) {
						$metaKeys = $category['meta_keys'];
					}else{
						$metaKeys = "";
						}
					$this->set("metaKeys", $metaKeys);//keywords страницы
					
					if ($category['meta_desc']) {
						$metaDesc = $category['meta_desc'];
					}else{
						$metaDesc = "";
						}
					$this->set("metaDesc", $metaDesc);//description страницы
					
					$breadCrumbs = [];
						
					$cat = $conn->query("
						SELECT id, parent, ".LANG_PREFIX."name as name, alias
									FROM osc_shop_catalog
									WHERE id = '$catId'
									LIMIT 1
					")->fetch('assoc');
					$this->set("prodCatName", $cat['name']);
					
					array_push ($breadCrumbs, $cat);
					
					while ($cat['parent']>0){
						$cat = $conn->query("
						SELECT id, parent, ".LANG_PREFIX."name as name, alias
									FROM osc_shop_catalog
									WHERE id = '".$cat['parent']."'
									LIMIT 1
						")->fetch('assoc');
						array_push ($breadCrumbs, $cat);
						}
					
					$breadCr = array_reverse ($breadCrumbs);
					$this->set("breadCr", $breadCr);			
					//echo "<pre>"; print_r($breadCr); echo "</pre>";  exit();
					
					
					$prodList = $prods;
					
					$this->set("prodList", $prodList);					
					
					$prodListReverse = array_reverse($prodList);
					$this->set("prodListReverse", $prodListReverse);
				
					$this->set("f_total_rows", $products_by_cat['rows']['rows'] );
				
					$this->set("f_pages_count", ceil($num_pages) );
								
						
					
					// END PRODACT LIST	
		}
		// end of else if catalog Index
    }
	
	public function filter(){
        if ($this->request->is('ajax')) {
            $response = $this->Help->filter();
            echo json_encode($response); exit();
        }
    }  
	
}
