<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");

class settingsHelp extends BasicHelp
{
   		public $dbh;
		
		public $table;
		public $id;
		public $item;
		
		public function __construct($dbh)
		{
			parent::__construct($dbh);
			$this->dbh = $dbh;
		} 
		
		///////////////////////////////////////////
		
		// CATALOG
		
		///////////////////////////////////////////
		
		//
		
		public function getCatalogItemDetails($id)
		{
			$query = "SELECT * FROM [pre]shop_catalog WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result)
			{
				$result['parents'] = array();
				$result['childs'] = array();
				$result['charsGroup'] = array();
				
				if($result['parent'] > 0)
				{
					$query = "SELECT id,name,alias FROM [pre]shop_catalog WHERE `id`='".$result['parent']."' LIMIT 1";
					$parentMassive = $this->rs($query);
					
					if($parentMassive) $result['parent'] = $parentMassive[0];
				}
				
				$query = "SELECT id,name,alias FROM [pre]shop_catalog WHERE `parent`='$id' LIMIT 10000";
				$childsMassive = $this->rs($query);
				
				if($childsMassive) $result['childs'] = $childsMassive;
				
				$query = "SELECT M.id, M.name, M.alias 
							FROM [pre]shop_chars_groups as M 
							LEFT JOIN [pre]shop_cat_chars_group_ref as R on M.id = R.group_id
							WHERE R.cat_id = $id
							LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['charsGroup'] = $groupMassive[0];
			}
			
			return $result;
		}
		
		//
		
		public function getAllGlobalSettings($params = array())
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			
			$query = "SELECT M.id, M.name, M.alias, M.parent, M.pos, M.block, M.dateCreate, M.dateModify, M.adminMod,
						(SELECT P.name FROM [pre]shop_catalog as P WHERE P.id = M.parent LIMIT 1) as parent_name,
						(SELECT name FROM [pre]users  WHERE id = M.adminMod LIMIT 1) as admin_name,
						(SELECT fname FROM [pre]users  WHERE id = M.adminMod LIMIT 1) as admin_fname 
			 
						FROM [pre]shop_catalog as M
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
			
			//echo "QUERY: ".$query;
			
			return $this->rs($query);
		}
		
		//
		
		public function getCountGlobalSettings($params = array())
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			$query = "SELECT COUNT(*)
			 
						FROM [pre]shop_catalog as M
						
						WHERE 1 $filter_and  
						LIMIT 100000";
			$result = $this->rs($query);
			
			return $result[0]['COUNT(*)'];
		}
		
		//
		
		public function getCatalogParents($catalog=array(), $parent=0, $params=array())
		{
			$query = "SELECT id,parent,name,alias FROM [pre]shop_catalog WHERE `parent`=$parent ORDER BY id LIMIT 10000";
			
			$childs = $this->rs($query);
			
			foreach($childs as $step => $child)
			{
				$childID = $child['id'];
				
				$catalog[$step] = $child; 
				
				$catalog[$step]['childs'] = $this->getCatalogParents(array(),$childID,$params);
			}
			
			return $catalog;
		}
		
		//
		
		public function getCatalogList($params=array())
		{
			$catalogList = array();
			
			$query = "SELECT id,name,alias FROM [pre]shop_catalog WHERE `parent`=0 ORDER BY id LIMIT 10000";
			
			$catalogList = $this->rs($query);
			
			foreach($catalogList as $i => $parent)
			{
				$query = "SELECT id,name,alias FROM [pre]shop_catalog WHERE `parent`='".$parent['id']."' ORDER BY id LIMIT 10000";
				$childs = $this->rs($query);
				
				$catalogList[$i]['childs'] = $childs;
			}
			
			return $catalogList;
		}
		
		//
		
		public function getCharsGroups($params=array())
		{
			$query = "SELECT id,name FROM [pre]shop_chars_groups WHERE 1 ORDER BY id LIMIT 10000";
			
			return $this->rs($query);
		}
		
		//
		
		public function getColors($params=array())
		{
			$query = "SELECT id,name FROM [pre]shop_colors WHERE 1 ORDER BY id LIMIT 10000";
			
			return $this->rs($query);
		}
		//
		
		public function getObjects($params=array())
		{
			$query = "SELECT id,name FROM [pre]shop_objects WHERE 1 ORDER BY id LIMIT 10000";
			
			return $this->rs($query);
		}
		
		public function getCatObjects($cat_id)
		{
			$result = array();
			
			if(!$cat_id) return $result;
			
			$query = "SELECT M.id, M.name FROM [pre]shop_objects as M LEFT JOIN [pre]shop_obj_cat_ref as R on M.id = R.obj_id WHERE R.cat_id = $cat_id LIMIT 100";
			$result = $this->rs($query);
			
			return $result;
		}
		
		public function getObjectGroups($collection_id, $item_id)
		{
			$result = array();
			
			if(!$collection_id) return $result;
			
			$query = "SELECT M.id, M.sku,
			(SELECT name FROM [pre]shop_objects WHERE id = M.obj_id  LIMIT 1) as tname 
			FROM [pre]shop_products as M 
			WHERE M.collection_id = $collection_id AND
			M.id != $item_id AND
			M.obj_id != 0 
			ORDER BY M.sku
			LIMIT 1000";
			
			$resQuery = $this->rs($query);
			
			foreach ($resQuery as &$sub_ob){			
				$sub_ob['name'] = $sub_ob['tname']." (".$sub_ob['sku'].")";			
			}
			
			$result = $resQuery;
			
			return $result;
		}
		
		
		///////////////////////////////////////////
		
		// PRODUCTS
		
		///////////////////////////////////////////
		
		//
		
		public function getProductsGroups($params=array())
		{
			$query = "SELECT id,name FROM [pre]shop_products_groups WHERE 1 ORDER BY id LIMIT 10000";
			
			return $this->rs($query);
		}
		
		//
		
		public function getProductsItemDetails($id)
		{
			$query = "SELECT M.*, 
						  
						  (SELECT name FROM [pre]shop_mf WHERE `id`=M.mf_id LIMIT 1) as mf_name,
						  (SELECT name FROM [pre]shop_objects WHERE `id`=M.obj_id LIMIT 1) as obj_name,
						  (SELECT name FROM [pre]shop_collections WHERE `id`=M.collection_id LIMIT 1) as collection_name

							FROM [pre]shop_products as M 
							WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result)
			{
				$result['prev_prod'] = array();
				$result['next_prod'] = array();
				
				// Вытягиваем данные о категории
				$result['category'] = array();
				
				$query = "SELECT M.id, M.name, M.alias, B.id as brand_id, B.name as brand_name, B.alias as brand_alias, M.specs_group_id
						  FROM [pre]shop_catalog as M 
						  LEFT JOIN [pre]shop_products as P on M.id = P.cat_id
						  LEFT JOIN [pre]shop_catalog as B on B.id = M.parent 
						  WHERE P.id = $id 
						  LIMIT 1
						 ";
				$catMassive = $this->rs($query);
				if($catMassive)
				{
					$result['category'] = $catMassive[0];
					
					$cat_id = $result['category']['id'];
					
					// Предыдущий товар
				
					$query = "SELECT M.id, M.alias, M.name 
								FROM [pre]shop_products as M
								WHERE M.id<$id AND M.cat_id=$cat_id 
								ORDER BY M.id DESC 
								LIMIT 1";
					$prev_prod = $this->rs($query);
					if($prev_prod) $result['prev_prod'] = $prev_prod[0];
								
					// Следующий товар
				
					$query = "SELECT M.id, M.alias, M.name 
								FROM [pre]shop_products as M
								WHERE M.id>$id AND M.cat_id=$cat_id 
								ORDER BY M.id 
								LIMIT 1";
					$next_prod = $this->rs($query);
					if($next_prod) $result['next_prod'] = $next_prod[0];
				}
				
				// Вытягиваем данные о картинках
				$result['images'] = array();
				
				$query = "SELECT * FROM [pre]files_ref WHERE `ref_table`='shop_products' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
				
				// Вытягиваем данные о вариантах отделки
				$result['finishes'] = array();
				
				$query = "SELECT * FROM [pre]finishes_ref WHERE `prod_id`=$id LIMIT 100";
				$finishesMassive = $this->rs($query);
				
				if($finishesMassive)
				{
					$result['finishes'] = $finishesMassive;
				}
				
				// Вытягиваем данные о видео товара
				/*
				$result['video'] = array();
				
				$query = "SELECT id,file,title,crop,path FROM [pre]files_ref WHERE `ref_table`='prod_video' AND `ref_id`=$id LIMIT 1";
				$videoMassive = $this->rs($query);
				
				if($videoMassive)
				{
					$result['video'] = $videoMassive[0]['file'];
				}
				*/
				
				// Вытягиваем данные о documents
				$result['docs'] = array();
				
				$query = "SELECT id,file,crop,path,title FROM [pre]docs_ref WHERE `ref_table`='shop_products' AND `ref_id`=$id LIMIT 1000";
				$docsMassive = $this->rs($query);
				
				if($docsMassive)
				{
					$result['docs'] = $docsMassive;
				}
				
				// Вытягиваем группы товаров
				$result['productGroups'] = array();
				
				$query = "SELECT M.id, M.name, M.block FROM [pre]shop_products_groups as M LEFT JOIN [pre]shop_prod_group_ref as R on M.id = R.group_id WHERE R.prod_id = $id LIMIT 100";
				$groupsMassive = $this->rs($query);
				
				if($groupsMassive) $result['productGroups'] = $groupsMassive;
				
				// Вытягиваем данные о группе свойств
				$result['charsGroup'] = array();
				
				if($result['category'])
				{
					$query = "SELECT M.id, M.name FROM [pre]shop_chars_groups as M LEFT JOIN [pre]shop_cat_chars_group_ref as R on M.id = R.group_id WHERE R.cat_id = ".$result['category']['id']." LIMIT 1";
					$charsGroupMassive = $this->rs($query);
					
					if($charsGroupMassive)
					{
						$result['charsGroup'] = $charsGroupMassive[0];
					}
				}
				
				// Вытягиваем значения свойств
				$result['chars'] = array();
				$result['charsD'] = array();
				
				$result['has_chars'] = 0;
				$result['has_charsD'] = 0;
				$result['charsD_ID'] = 0;
				
				if($result['charsGroup'])
				{
					$cat_chars_group_id = ($result['category'] ? $result['category']['specs_group_id'] : 0);
					
					$query = "SELECT M.id as char_id, M.measure, M.title, M.name, M.pos, V.value as value, V.ua_value as ua_value, V.en_value as en_value, R.id as id,  R.filter as filter
					
							 FROM  [pre]shop_chars as M 
							
							 LEFT JOIN [pre]shop_chars_prod_ref AS R on R.char_id = M.id AND prod_id=$id
							
							 LEFT JOIN [pre]shop_chars_values AS V on V.id = R.val_id 
								  
							 WHERE M.group_id='".$cat_chars_group_id."' AND M.is_dinamic=0
							 ORDER BY M.pos
							 LIMIT 100";
					/*
					$query = "SELECT M.id, M.value, M.char_id, 
							  (SELECT name FROM [pre]shop_chars WHERE id=M.char_id) as name,
							  (SELECT measure FROM [pre]shop_chars WHERE id=M.char_id) as measure,
							  (SELECT title FROM [pre]shop_chars WHERE id=M.char_id) as title
							 FROM  
							 	[pre]shop_chars_prod_ref as M  
							 WHERE M.prod_id='".$id."'
							 ORDER BY M.id
							 LIMIT 100";
					*/
					/*
					$query = "SELECT M.id as id, M.name as name, M.measure as measure, R.value as value
							 FROM [pre]shop_chars_prod_ref as R 
							 LEFT JOIN [pre]shop_chars as M on R.char_id = M.id 
							 WHERE R.prod_id=$id
							 LIMIT 100";
					*/

					$charsList = $this->rs($query);
					
					if($charsList)
					{
						$result['has_chars'] = 1;
					}else
					{
						$query = "SELECT * FROM [pre]shop_chars WHERE `group_id`=$cat_chars_group_id AND `is_dinamic`=0 ORDER BY pos LIMIT 100";
						$charsList = $this->rs($query);
					}
					
					$result['chars'] = $charsList;

					// Dinamical chars


					$query = "SELECT M.id, M.measure, M.title, M.name, M.pos
							 FROM
							 	[pre]shop_chars as M
							 WHERE M.group_id='".$cat_chars_group_id."' AND M.is_dinamic=1
							 ORDER BY M.pos DESC
							 LIMIT 1";

					$dinamicCharArr = $this->rs($query);

					if($dinamicCharArr)
					{
						$dinamicChar = $dinamicCharArr[0];

						$charDID = $dinamicChar['id'];
						
						$result['charsD_ID'] = $charDID;
						
						$result['has_charsD'] = 1;

						//======================================================================================================================
						// Get dinamic chars list

						$query = "SELECT * FROM [pre]shop_chars WHERE `group_id`=$cat_chars_group_id AND is_dinamic=1 ORDER BY pos LIMIT 100";
						$charsListD = $this->rs($query);
					
						//======================================================================================================================
						// Get dinamic chars values 
						
						foreach($charsListD as $i => $d_item)
						{
							$d_id = $d_item['id'];
							
							$query = "SELECT M.id, V.value, V.ua_value, V.en_value, M.filter, M.price_dif,
											  (SELECT id 		FROM [pre]shop_chars WHERE id=$d_id) as char_id,
											  (SELECT measure 	FROM [pre]shop_chars WHERE id=$d_id) as measure,
											  (SELECT title 	FROM [pre]shop_chars WHERE id=$d_id) as title,
											  (SELECT name 		FROM [pre]shop_chars WHERE id=$d_id) as name
								 FROM	[pre]shop_chars_prod_ref as M
								 
								 LEFT JOIN [pre]shop_chars_values AS V on V.id = M.val_id 
								 
								 WHERE M.char_id='".$d_id."' AND M.prod_id=$id
								 ORDER BY M.price_dif
								 LIMIT 1000";
	
							$charsListD[$i]['values'] = $this->rs($query);
						}
						
						//=====================================================================================================================
						// Dinamic chars result
						
						$result['charsD'] = $charsListD;
					}



					// end of Dinamical Char
					
				}
			}
			
			// Вытягиваем группы цветов
			$result['colorGroups'] = array();
			
			$query = "SELECT M.id, M.name, M.value 
			FROM [pre]shop_colors as M 
			LEFT JOIN [pre]shop_color_prod_ref as R on M.id = R.color_id 
			WHERE R.prod_id = $id 
			ORDER BY M.name 
			LIMIT 100";
			$groupsMassive = $this->rs($query);
			
			if($groupsMassive) $result['colorGroups'] = $groupsMassive;			
			
			
			// Вытягиваем группы предметов
			$result['objectGroups'] = array();
			
			$query = "SELECT M.object_id as id
			FROM [pre]shop_object_prod_ref as M
			WHERE M.prod_id = $id
			ORDER BY M.object_id 
			LIMIT 100";
			$groupsMassive = $this->rs($query);
			
			if($groupsMassive) $result['objectGroups'] = $groupsMassive;
			
			
			return $result;
		}
		
		//
		
		public function getAllShopProducts($params = array())
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			
			$query = "SELECT M.id, M.mf_id, M.deliver_id, M.name, M.alias, M.sku, M.cat_id, M.price, M.block, M.dateCreate, M.dateModify,  C.name as cat_name, C.alias as cat_alias, CP.name as parent_name,
			
						(SELECT name FROM [pre]users  WHERE id = M.adminMod LIMIT 1) as admin_name,
						(SELECT fname FROM [pre]users  WHERE id = M.adminMod LIMIT 1) as admin_fname,
						(SELECT name FROM [pre]shop_mf WHERE `id`=M.mf_id LIMIT 1) as mf_name,
						(SELECT name FROM [pre]shop_objects WHERE `id`=M.obj_id LIMIT 1) as obj_name
			 
						FROM [pre]shop_products as M
						
						LEFT JOIN [pre]shop_catalog AS C on C.id = M.cat_id 
						
						LEFT JOIN [pre]shop_catalog AS CP on CP.id = C.parent 
						
						WHERE 1 $filter_and 
						GROUP BY M.id ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
			
			//echo "QUERY: ".$query;
			
			return $this->rs($query);
		}
		
		//
		
		public function getCountShopProducts($params = array())
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			$query = "SELECT COUNT(*)
			 
						FROM [pre]shop_products as M
						
						LEFT JOIN [pre]shop_catalog AS C on C.id = M.cat_id 
						
						LEFT JOIN [pre]shop_catalog AS CP on CP.id = C.parent
						
						WHERE 1 $filter_and  
						
						LIMIT 100000";
			$result = $this->rs($query);
			
			//echo "<pre>"; print_r($result); echo "</pre>";
			
			return $result[0]['COUNT(*)'];
		}
		
		///////////////////////////////////////////
		
		// CHARS
		
		///////////////////////////////////////////
		
		//
		
		public function getCharsGroupsDetails($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.alias, M.block,  
			
						(SELECT COUNT(*) FROM [pre]shop_chars WHERE `group_id`=M.id LIMIT 1000) as chars_quant 
						
						FROM [pre]shop_chars_groups as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_chars_groups as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// 
		
		public function getCharsGroupItem($id)
		{
			$query = "SELECT M.id, M.name, M.alias, M.block, M.details, M.dateCreate, M.dateModify, M.adminMod  
						
						FROM [pre]shop_chars_groups as M 
						
						WHERE `id`=$id LIMIT 1
					 ";
					 
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// get Group chars
			
			$query = "SELECT M.id, M.name, M.measure, M.pos FROM [pre]shop_chars as M WHERE `group_id`=$id ORDER BY M.pos LIMIT 1000";
			
			$result['chars'] = $this->rs($query);
			
			// return result
			
			return $result;
		}
		
		//
		
		public function getShopChars($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.measure, M.is_dinamic,
			
						(SELECT name FROM [pre]shop_chars_groups WHERE `id`=M.group_id LIMIT 1) as group_name 
						
						FROM [pre]shop_chars as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_chars as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get shop manufacturers
		
		public function getShopMf($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.ua_name, M.en_name, M.country, M.ua_country, M.en_country, M.cat_id, M.block, M.dateCreate, M.dateModify,  
			
						(SELECT name FROM [pre]shop_catalog WHERE `id`=M.cat_id LIMIT 1) as cat_name 
						
						FROM [pre]shop_mf as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_mf as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		//
		
		public function getShopMfDetails($id)
		{
			$query = "SELECT M.*, (SELECT name FROM [pre]shop_catalog WHERE id=M.cat_id) as cat_name FROM [pre]shop_mf as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		
		// Get product objects
		
		public function getProdObj($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.ua_name, M.en_name, M.order_id
						
						FROM [pre]shop_objects as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_objects as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		//
		
		public function getProdObjecDetails($id)
		{
			$query = "SELECT M.* FROM [pre]shop_objects as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем группы категорий
			$result['catGroups'] = array();
			
			$query = "SELECT M.id, M.name, M.block FROM [pre]shop_catalog as M LEFT JOIN [pre]shop_obj_cat_ref as R on M.id = R.cat_id WHERE R.obj_id = $id LIMIT 100";
			$groupsMassive = $this->rs($query);
			
			if($groupsMassive) $result['catGroups'] = $groupsMassive;
			
			
			
			return $result;
		}
		
		
		// Get product collections
		
		public function getProdCollect($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.ua_name, M.en_name, M.mf_id,
						(SELECT name FROM [pre]shop_mf WHERE `id`= M.mf_id LIMIT 1) as mf_name
						
						FROM [pre]shop_collections as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_collections as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		//
		
		public function getProdCollectDetails($id)
		{
			$query = "SELECT M.*
			 		FROM [pre]shop_collections as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		
		// Get product colors
		
		public function getProdCol($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.ua_name, M.en_name, M.value, M.order_id
						
						FROM [pre]shop_colors as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_colors as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		//
		
		public function getProdColDetails($id)
		{
			$query = "SELECT M.* FROM [pre]shop_colors as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}

	// Get shop delivers

	public function getShopDelivers($params=array(),$typeCount=false)
	{
		// Filter params

		$filter_and = "";

		if(isset($params['filtr']['massive']))
		{
			foreach($params['filtr']['massive'] as $f_name => $f_value)
			{
				if($f_value < 0) continue;
				$filter_and .= " AND ($f_name='$f_value') ";
			}
		}

		// Filter like

		if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
		{
			$search_field = $params['filtr']['filtr_search_field'];
			$search_key = $params['filtr']['filtr_search_key'];

			$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
		}

		// Filter sort

		$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");

		$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");

		// Order limits

		$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);

		if($limit <= 0) $limit = GLOBAL_ON_PAGE;

		$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);

		if(!$typeCount)
		{

			$query = "SELECT M.id, M.name, M.rus_name, M.cat_id, M.block, M.dateCreate, M.dateModify,

						(SELECT name FROM [pre]shop_catalog WHERE `id`=M.cat_id LIMIT 1) as cat_name

						FROM [pre]shop_deliver as M

						WHERE 1 $filter_and
						ORDER BY $sort_field $sort_vector
						LIMIT $start,$limit";

			return $this->rs($query);

		}else
		{
			$query = "SELECT COUNT(*)

						FROM [pre]shop_deliver as M

						WHERE 1 $filter_and

						LIMIT 100000";

			$result = $this->rs($query);
			return $result[0]['COUNT(*)'];
		}
	}

	// Get deliver item

	public function getShopDeliverDetails($id)
	{
		$query = "SELECT M.*, (SELECT name FROM [pre]shop_catalog WHERE id=M.cat_id) as cat_name FROM [pre]shop_deliver as M WHERE `id`='$id' LIMIT 1";
		$resultMassive = $this->rs($query);

		$result = ($resultMassive ? $resultMassive[0] : array());

		return $result;
	}
	
	
	
	
	
	
		// Get shop delivery methods

	public function getShopDeliveryMeth($params=array(),$typeCount=false)
	{
		// Filter params

		$filter_and = "";

		if(isset($params['filtr']['massive']))
		{
			foreach($params['filtr']['massive'] as $f_name => $f_value)
			{
				if($f_value < 0) continue;
				$filter_and .= " AND ($f_name='$f_value') ";
			}
		}

		// Filter like

		if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
		{
			$search_field = $params['filtr']['filtr_search_field'];
			$search_key = $params['filtr']['filtr_search_key'];

			$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
		}

		// Filter sort

		$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");

		$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");

		// Order limits

		$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);

		if($limit <= 0) $limit = GLOBAL_ON_PAGE;

		$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);

		if(!$typeCount)
		{

			$query = "SELECT M.id, M.name, M.price, M.block, M.dateCreate, M.dateModify

						FROM [pre]shop_delivery_methods as M

						WHERE 1 
						ORDER BY M.id
						LIMIT 20";

			return $this->rs($query);

		}else
		{
			$query = "SELECT COUNT(*)

						FROM [pre]shop_delivery_methods as M

						WHERE 1

						LIMIT 20";

			$result = $this->rs($query);
			return $result[0]['COUNT(*)'];
		}
	}

	// Get delivery methods item

	public function getShopDeliveryMethDetails($id)
	{
		$query = "SELECT M.* FROM [pre]shop_delivery_methods as M WHERE `id`='$id' LIMIT 1";
		$resultMassive = $this->rs($query);

		$result = ($resultMassive ? $resultMassive[0] : array());

		return $result;
	}
	
	
	
	
	
	
	
	
		
		//
		
		public function getCharsItemDetails($id)
		{
			$query = "SELECT * FROM [pre]shop_chars WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result)
			{
				$result['charsGroup'] = array();
				
				$query = "SELECT M.id, M.name, M.alias 
							FROM [pre]shop_chars_groups as M 
							WHERE M.id = ".$result['group_id']."
							LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['charsGroup'] = $groupMassive[0];
			}
			
			return $result;
		}
		
		// Get ORDERS List vs Filter
		
		public function getShopOrders($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : " DESC");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.author_id, M.user_id, M.paid_status, M.pay_method, M.delivery_method, M.products_quant, M.sum, M.dateCreate, M.client_name, M.client_fname,  
			
						(SELECT name FROM [pre]users WHERE `id`=M.author_id LIMIT 1) as author_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.author_id LIMIT 1) as author_fname, 
						
						(SELECT name FROM [pre]users WHERE `id`=M.user_id LIMIT 1) as user_name,
						
						(SELECT fname FROM [pre]users WHERE `id`=M.user_id LIMIT 1) as user_fname, 
						
						(SELECT name FROM [pre]shop_payment_methods WHERE `id`=M.pay_method) as payment_name,
						
						(SELECT name FROM [pre]shop_delivery_methods WHERE `id`=M.delivery_method) as delivery_name,
						
						(SELECT price FROM [pre]shop_delivery_methods WHERE `id`=M.delivery_method) as delivery_price,
						
						(SELECT name FROM [pre]shop_order_statuses WHERE `id`=M.status) as status_name
						
						FROM [pre]shop_orders as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_orders as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get order statuses
		
		public function getOrderStatuses()
		{
			$query = "SELECT * FROM [pre]shop_order_statuses WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get delivery methods
		
		public function getDeliveryMethods()
		{
			$query = "SELECT * FROM [pre]shop_delivery_methods WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get payment methods
		
		public function getPaymentMethods()
		{
			$query = "SELECT * FROM [pre]shop_payment_methods WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get Stocks List
		
		public function getStocksList()
		{
			$query = "SELECT id,name FROM [pre]stocks WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get Char Groups
		
		public function getCharGroups()
		{
			$query = "SELECT id,name FROM [pre]shop_chars_groups WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// 
		
		public function getShopOrderDetails($id)
		{
			$query = "SELECT * FROM [pre]shop_orders WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result)
			{
				// Status info
				$result['delivery'] = array();
				
				$query = "SELECT * FROM [pre]shop_order_statuses WHERE id = ".$result['status']." LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['status_info'] = $groupMassive[0];
				
				// Delivery method
				$result['delivery'] = array();
				
				$query = "SELECT * FROM [pre]shop_delivery_methods WHERE id = ".$result['delivery_method']." LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['delivery'] = $groupMassive[0];
				
				// Payment method
				$result['payment'] = array();
				
				$query = "SELECT * FROM [pre]shop_payment_methods WHERE id = ".$result['pay_method']." LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['payment'] = $groupMassive[0];
				
				// Source user
				$result['source_user'] = array();
				
				$query = "SELECT * FROM [pre]users WHERE id = ".$result['author_id']." LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['source_user'] = $groupMassive[0];
				
				// Order user
				$result['order_user'] = array();
				
				$query = "SELECT * FROM [pre]users WHERE id = ".$result['user_id']." LIMIT 1";
				$groupMassive = $this->rs($query);
				
				if($groupMassive) $result['order_user'] = $groupMassive[0];
			}
			
			return $result;
		}
		
		// return Order VIEW
		
		public function getShopOrderView($card,$params=array())
		{
			$str = "";
			
			// Show products from cart
			
			if(trim($card['products']) != "" && trim($card['products']) != "0")
			{
				$products = unserialize($card['products']);
			}else
			{
				$products = array();
			}
			
			$str .=  "
					<div class='r-z-c-table'>
            			<table class='maintable' id='main-table'>
                    		<div class='head-tr'>
						";
					
					$str .= "<th class='main-t-th'>Название товара</th>";
					$str .= "<th class='main-t-th'>Артикул</th>";
					$str .= "<th class='main-t-th'>Кол-во (шт)</th>";
					$str .= "<th class='main-t-th'>Цена (грн)</th>";
					$str .= "<th class='main-t-th'>Сумма (грн)</th>";
						
			$str .= "
							</div>
                			<tbody>
						";	
						
			$icnt = 0;
			foreach($products as $product)
			{
				$icnt++;
				$iid = $product['prod_id'];
				$iclass = ($icnt%2==1 ? "trcolor" : "");
		
				if(isset($product['prod_id']) && $product['prod_id'])
				{
		
					$prodMassive = $this->rs("SELECT id,name,sku,code,price FROM [pre]shop_products WHERE id=".$product['prod_id']." LIMIT 1");
				}else
				{
					continue;
				}
				
					$prod = ($prodMassive ? $prodMassive[0] : array('id'=>0,'name'=>'','sku'=>'','code'=>'','price'=>0));
						
					$curr_price = ($product['price_dif'] ? $product['price_dif'] : $prod['price']);
					$curr_name = ($product['price_dif'] ? $product['name']." (".$product['char_value'].")" : $prod['name']);
				
					$curr_sum = $curr_price*$product['quant'];
				
				$str .= "
						<tr class='$iclass' id='$iid'>
						";
						
						$str .= "<td>".$curr_name."</td>";
						$str .= "<td>".$prod['sku']."</td>";
						$str .= "<td>".$product['quant']."</td>";
						$str .= "<td>".$curr_price."</td>";
						$str .= "<td>".$curr_sum."</td>";
						
				$str .= "</tr>";
			}
					
			$str .= "
							</tbody>
                		</table>
            		</div>
					";
			
			// Show in total info
			
			$str .= "
					<table class='intotal'>
						<tr>
							<th>Позиций:	<span>".count($products)."</span></th>
							<th>Сумма:		<span>".$card['sum']."</span> грн.</th>
							<th>Доставка:	<span>".$card['delivery']['price']."</span> грн.</th>
							<th>Всего:		<span>".($card['sum']+$card['delivery']['price'])."</span> грн.</th>
						</tr>
					</table>
					";
			
			// Show client info
					
			$str .= $this->hr("Данные клиента");
			
			$str .= "
					<table class='intotal'>
						<tr>
							<td>Имя:</td>
							<td>".$card['client_name']." ".$card['client_fname']."</td>
						</tr>
						<tr>
							<td>Телефон:</td>
							<td>".$card['client_phone']."</td>
						</tr>
						<tr>
							<td>Email:</td>
							<td>".$card['client_email']."</td>
						</tr>
						<tr>
							<td>Комментарий:</td>
							<td>".$card['details']."</td>
						</tr>
						<tr>
							<td>ID:</td>
							<td>".$card['user_id']."</td>
						</tr>
					</table>
					";
			
			// Show delivery info
					
			$str .= $this->hr("Доставка");
			
			$str .= "
					<table class='intotal'>
						<tr>
							<td>Способ доставки:</td>
							<td>".$card['delivery']['name']."</td>
						</tr>
						<tr>
							<td>Адрес:</td>
							<td>".$card['delivery_address']."</td>
						</tr>
						<tr>
							<td>Дата:</td>
							<td>".$this->deformat_date($card['delivery_date'])."</td>
						</tr>
						<tr>
							<td>Время:</td>
							<td>".$card['delivery_time']."</td>
						</tr>
					</table>
					";
					
			// Show payment info
					
			$str .= $this->hr("Оплата");
			
			$str .= "
					<table class='intotal'>
						<tr>
							<td>Способ оплаты:</td>
							<td>".$card['payment']['name']."</td>
						</tr>
						<tr>
							<td>Статус оплаты:</td>
							<td>".$card['paid_status']."</td>
						</tr>
					</table>
					";
			
			// Show Order NOTES
			
			$str .= $this->hr("Сведенья");
			
			$str .= "
					<table class='intotal'>
						<tr>
							<td>Статус заказа:</td>
							<td>".$card['status_info']['name']."</td>
						</tr>
						<tr>
							<td>Создан:</td>
							<td>".$this->deformat_date($card['dateCreate'])."</td>
						</tr>
						<tr>
							<td>Автор:</td>
							<td>ZEN WP</td>
						</tr>
						<tr>
							<td>№ Заказа:</td>
							<td>".($card['id']+5000)."</td>
						</tr>
						<tr>
							<td>ID:</td>
							<td>".$card['id']."</td>
						</tr>
					</table>
					";
			
			return $str;
		}
		
		public function getProductsGroupsAll($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.block,   
			
						(SELECT COUNT(id) FROM [pre]shop_prod_group_ref WHERE `group_id`=M.id LIMIT 1) as products_quant						
						
						FROM [pre]shop_products_groups as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_products_groups as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getProductsGroupItem($id)
		{
			$query = "SELECT M.*, (SELECT COUNT(id) FROM [pre]shop_prod_group_ref WHERE `group_id`=$id) as products_quant FROM [pre]shop_products_groups as M WHERE `id`=$id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		// PRODUCT COMMENTS
		
		public function getProductComments($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id, M.block");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : " DESC");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.*,   
			
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]shop_products WHERE `id`=M.prod_id) as prod_name		
						
						FROM [pre]shop_product_comments as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]shop_product_comments as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getProductCommentItem($id)
		{
			$query = "SELECT M.*, 
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]shop_products WHERE `id`=M.prod_id) as prod_name 
						FROM [pre]shop_product_comments as M 
						WHERE `id`=$id 
						LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		// STOCKS
		
		public function getStocks($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.name, M.alias, M.block 
			
						FROM [pre]stocks as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]stocks as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get Stock Item
		
		public function getStockItem($id)
		{
			$query = "SELECT M.* FROM [pre]stocks as M WHERE `id`=$id LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		// STOCKS CELLS
		
		public function getStocksCells($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT M.id, M.code, M.stock_id, M.zona, M.rack, M.section, M.shelf, M.block, M.fullness, M.dateCreate, M.adminMod, M.ip_add, 
			
						(SELECT name FROM [pre]stocks WHERE `id`=M.stock_id) as stock_name,
						
						(SELECT COUNT(*) FROM [pre]shop_products_shelf_ref WHERE `shelf_id`=M.id) as products_count
			
						FROM [pre]stock_fields as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]stock_fields as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get Stock Item
		
		public function getStockCellItem($id)
		{
			$query = "SELECT M.*, 
					
					(SELECT name FROM [pre]stocks WHERE `id`=M.stock_id) as stock_name,
					
					(SELECT COUNT(*) FROM [pre]shop_products_shelf_ref WHERE `shelf_id`=M.id) as products_count 
					
					FROM [pre]stock_fields as M 
					
					WHERE `id`=$id 
					
					LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
		
		public function getProdAccessuares($id)
		{
			$query = "SELECT M.*,  
					 (SELECT name FROM [pre]shop_products WHERE `id`=M.acc_id LIMIT 1) as acc_name,
					 (SELECT file FROM [pre]files_ref WHERE `ref_table`='shop_products' AND `ref_id`=M.acc_id LIMIT 1) as acc_filename 
						FROM [pre]shop_prod_access_ref as M 
						WHERE M.prod_id=$id 
						LIMIT 1000";
			
			$result = $this->rs($query);
			
			return $result;
		}
		
		public function getProdComplect($id)
		{
			$query = "SELECT M.*,  
					 (SELECT name FROM [pre]shop_products WHERE `id`=M.acc_id LIMIT 1) as acc_name,
					 (SELECT price FROM [pre]shop_products WHERE `id`=M.acc_id LIMIT 1) as acc_price,
					 (SELECT file FROM [pre]files_ref WHERE `ref_table`='shop_products' AND `ref_id`=M.acc_id LIMIT 1) as acc_filename 
						FROM [pre]shop_prod_complect_ref as M 
						WHERE M.prod_id=$id 
						LIMIT 1000";
			
			$result = $this->rs($query);
			
			return $result;
		}
		
		public function getProdSizes($id)
		{
			$query = "SELECT M.*
						FROM [pre]shop_prod_size_ref as M 
						WHERE M.prod_id=$id 
						ORDER BY M.order_id
						LIMIT 20";
			
			$result = $this->rs($query);			
			return $result;
		}
		
		public function getCategoryMf($cat_id)
		{
			$result = array();
			
			if(!$cat_id) return $result;
			
			$query = "SELECT * FROM [pre]shop_mf WHERE `cat_id`=$cat_id LIMIT 100";
			$result = $this->rs($query);
			
			if(!$result)
			{
				$query = "SELECT parent FROM [pre]shop_catalog WHERE `id`=$cat_id LIMIT 1";
				$catInfo = $this->rs($query);
				
				$cat_parent_id = ($catInfo ? $catInfo[0]['parent'] : 0);
				
				$result = $this->getCategoryMf($cat_parent_id);
			}
			
			return $result;
		}
		
		public function getMfCollections($mf_id)
		{
			$result = array();
			
			if(!$mf_id) return $result;
			
			$query = "SELECT id, name FROM [pre]shop_collections WHERE `mf_id`=$mf_id LIMIT 100";
			$result = $this->rs($query);
			
			return $result;
		}
		
		public function getAllMf()
		{
			$result = array();
			
			$query = "SELECT * FROM [pre]shop_mf ORDER BY name LIMIT 1000";
			$result = $this->rs($query);
			
			return $result;
		}

		public function getAllDelivers()
		{
			$result = array();
	
			$query = "SELECT * FROM [pre]shop_deliver ORDER BY name LIMIT 1000";
			$result = $this->rs($query);
	
			return $result;
		}
		
		public function getAllObjects()
		{
			$result = array();
	
			$query = "SELECT * FROM [pre]shop_objects ORDER BY name LIMIT 1000";
			$result = $this->rs($query);
	
			return $result;
		}
		
		// Get Lang item
		
		public function getLangItem($id)
		{
			$query = "SELECT M.block, L.name, L.alias, M.id 
			FROM [pre]site_languages as M
			LEFT JOIN [pre]languages AS L ON L.id = M.lang_id
			WHERE M.id='$id' 
			LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		

		public function getLanguages($params=array(),$typeCount=false)
		{
			// Filter params
			
			$filter_and = "";
			
			if(isset($params['filtr']['massive']))
			{
				foreach($params['filtr']['massive'] as $f_name => $f_value)
				{
					if($f_value < 0) continue;
					$filter_and .= " AND ($f_name='$f_value') ";
				}
			}
			
			// Filter like
			
			if(isset($params['filtr']['filtr_search_key']) && isset($params['filtr']['filtr_search_field']) && trim($params['filtr']['filtr_search_key']) != "")
			{
				$search_field = $params['filtr']['filtr_search_field'];
				$search_key = $params['filtr']['filtr_search_key'];
				
				$filter_and .= " AND ($search_field LIKE '%$search_key%') ";
			}
			
			// Filter sort
			
			$sort_field		= (isset($params['filtr']['sort_filtr']) ? $params['filtr']['sort_filtr'] : "M.id");
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
			// Order limits
			
			$limit = (isset($_COOKIE['global_on_page']) ? (int)$_COOKIE['global_on_page'] : GLOBAL_ON_PAGE);
			
			if($limit <= 0) $limit = GLOBAL_ON_PAGE;
			
			$start = (isset($params['start']) ? ($params['start']-1)*$limit : 0);
			
			if(!$typeCount)
			{
			
				$query = "SELECT L.name, L.alias, M.block, M.id 
			
						FROM [pre]site_languages AS M 
						LEFT JOIN [pre]languages AS L ON L.id = M.lang_id 
						
						WHERE 1 $filter_and AND L.id != 94
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]site_languages as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}

		public function getAllLangs(){
			$q = "
				SELECT * FROM [pre]languages WHERE `used` = 0 LIMIT 1000 
			";
			return $this->rs($q);
		}

		public function getAvailableLangs(){

				$query = "
					SELECT L.name, L.alias, M.block, M.id 
					FROM [pre]site_languages AS M 
					LEFT JOIN [pre]languages AS L ON L.id = M.lang_id 
					WHERE 1 $filter_and AND L.id != 94
					ORDER BY M.id
					LIMIT 1000
				";
						
				return $this->rs($query);
		}
		
    	public function __destruct(){}
}