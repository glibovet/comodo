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
			
			
			$query = "SELECT M.id, M.name, M.alias, M.parent, M.block, M.dateCreate, M.dateModify, 
						(SELECT P.name FROM [pre]shop_catalog as P WHERE P.id = M.parent LIMIT 1) as parent_name 
			 
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
		
		public function getCatalogParents($params=array())
		{
			$query = "SELECT id,name,alias FROM [pre]shop_catalog WHERE `parent`=0 ORDER BY id LIMIT 10000";
			
			return $this->rs($query);
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
			$query = "SELECT * FROM [pre]shop_products WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			if($result)
			{
				// Вытягиваем данные о категории
				$result['category'] = array();
				
				$query = "SELECT M.id, M.name, M.alias, B.id as brand_id, B.name as brand_name, B.alias as brand_alias
						  FROM [pre]shop_catalog as M 
						  LEFT JOIN [pre]shop_cat_prod_ref as R on M.id = R.cat_id
						  LEFT JOIN [pre]shop_catalog as B on B.id = M.parent 
						  WHERE R.prod_id = $id 
						  LIMIT 1
						 ";
				$catMassive = $this->rs($query);
				if($catMassive)
				{
					$result['category'] = $catMassive[0];
				}
				
				// Вытягиваем данные о картинках
				$result['images'] = array();
				
				$query = "SELECT id,file,crop,path FROM [pre]files_ref WHERE `ref_table`='shop_products' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
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
				
				if($result['charsGroup'])
				{
					$query = "SELECT M.id as id, M.name as name, M.measure as measure, R.value as value
							 FROM [pre]shop_chars_prod_ref as R 
							 LEFT JOIN [pre]shop_chars as M on R.char_id = M.id 
							 WHERE R.prod_id=$id 
							 LIMIT 100";
					$charsList = $this->rs($query);
					
					if($charsList)
					{
						$result['chars'] = $charsList;
					}
				}
			}
			
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
			
			
			$query = "SELECT M.id, M.name, M.alias, M.block, M.dateCreate, M.dateModify,  C.name as cat_name, C.alias as cat_alias, C.id as cat_id
			 
						FROM [pre]shop_products as M
						
						LEFT JOIN [pre]shop_cat_prod_ref AS R on R.prod_id = M.id 
						
						LEFT JOIN [pre]shop_catalog AS C on C.id = R.cat_id 
						
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
						
						LEFT JOIN [pre]shop_cat_prod_ref AS R on R.prod_id = M.id 
						
						LEFT JOIN [pre]shop_catalog AS C on C.id = R.cat_id 
						
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
			
			$query = "SELECT M.id, M.name, M.measure FROM [pre]shop_chars as M WHERE `group_id`=$id LIMIT 1000";
			
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.measure,  
			
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
			
			$sort_vector	= (isset($params['filtr']['order_filtr']) ? $params['filtr']['order_filtr'] : "");
			
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
						
					$curr_sum = $prod['price']*$product['quant'];
				
				$str .= "
						<tr class='$iclass' id='$iid'>
						";
						
						$str .= "<td>".$prod['name']."</td>";
						$str .= "<td>".$prod['sku']."</td>";
						$str .= "<td>".$product['quant']."</td>";
						$str .= "<td>".$prod['price']."</td>";
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
							<th>Доставка:	<span>".(40)."</span> грн.</th>
							<th>Всего:		<span>".($card['sum']+40)."</span> грн.</th>
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
							<td>".$card['delivery_date']."</td>
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
							<td>".$card['dateCreate']."</td>
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
		
    	public function __destruct(){}
}