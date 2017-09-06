<?php // Users class

	/*	***************************	*/
	/*	Author: Sivkovych Maksym	*/
	/*	Developed: 01.09.2015		*/
	/*	***************************	*/

// exec_query ( query , once , update )

class Shop
{
	protected $db;
	function __construct($db_obj)
	{
		$this->db = $db_obj;
	}

	public function getCategoryById($_id)
	{
		try{
			$query = "SELECT * 
						FROM [pre]shop_catalog 
						WHERE `block`=0 
						AND `id`='$_id' 
						LIMIT 1";
			return $this->db->exec_query($query,1);
		}
		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		}
	}

	public function getCategoryByAlias($_alias)
	{
		try{
			$query = "SELECT * 
						FROM [pre]shop_catalog 
						WHERE `block`=0 
						AND `alias`='$_alias' 
						LIMIT 1";
			return $this->db->exec_query($query,1);
		}
		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		}
	}


	public function getCategoryProductsById($cat_id, $page_num, $page_lim, $filters="", $filter_joins="")
	{
		try{
		$result = array('rows'=>0,'tems'=>array());
			
		// REMOVED COLUMNS: , M.currency, M.block, M.quant, R.cat_id
			
		// REMOVED: INNER JOIN [pre]shop_chars_prod_ref as CPR ON CPR.prod_id=M.id 
			
		$query= "SELECT SQL_CALC_FOUND_ROWS M.id, M.name, M.alias, M.price, M.sale_price, M.usd_price, M.eur_price, M.sku, M.free_delivery, F.file, 
					
					(SELECT id FROM [pre]shop_wishlist WHERE `uid`=".UID." AND `prod_id`=M.id LIMIT 1) as wish_id  ,
                    (SELECT id FROM [pre]shop_compare WHERE `uid`=".UID." AND `prod_id`=M.id LIMIT 1) as comp_id  , 
					(SELECT id FROM [pre]shop_banner_prod_ref WHERE `prod_id`=M.id LIMIT 1) as sert_id , 
					(SELECT id FROM [pre]shop_banner_prod_access_ref WHERE`prod_id`=M.id LIMIT 1) as pres_id 
					
					FROM [pre]shop_products as M
					INNER JOIN [pre]shop_cat_prod_ref as R ON R.prod_id=M.id 
					
					
					$filter_joins

					INNER JOIN [pre]shop_catalog as C ON C.id=R.cat_id 
					INNER JOIN [pre]files_ref as F ON F.ref_id=M.id 
					WHERE C.id=$cat_id 
					AND F.file!='fail' 
					AND F.ref_table='shop_products' 
					AND M.block=0 

					$filters

					GROUP BY M.id
					LIMIT ".(($page_num-1)*$page_lim).",$page_lim
				";

// echo "<pre>" . str_replace("[pre]","next_",$query) . "</pre>"; // exit();
		
		//if($filters!="") echo "<pre>" . str_replace("[pre]","next_",$query) . "</pre>";

		$result['items'] = $this->db->exec_query($query);
		
		$result['rows'] = $this->db->exec_query('SELECT FOUND_ROWS() AS rows',1);

		foreach($result['items'] as &$item)
		{
			$product_id = $item['id'];
			
			$query = "SELECT M.*, R.name 
							FROM [pre]shop_chars_prod_ref_v2 as M 
							JOIN [pre]shop_chars as R ON R.id = M.char_id
							WHERE M.prod_id=$product_id AND M.value2 != '' AND R.show_admin=1 
							ORDER BY R.pos 
							LIMIT 5";
							
			$item['product_chars'] = $this->db->exec_query($query);
			
			$query = "SELECT M.group_id, (SELECT title FROM [pre]shop_products_groups WHERE `id`=M.group_id LIMIT 1) as title FROM [pre]shop_prod_group_ref as M WHERE M.prod_id='$product_id' ORDER BY M.id LIMIT 5";

			$item['product_groups'] = $this->db->exec_query($query);
		}

		return $result;
		}
		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		}

	}
    
    public function getCategoryMf($_id, $count=false, $filters="", $filter_joins="")
	{
		try{
            $count_select = "";
            
            if($count)
            {
                $count_select = ",
                    (SELECT 
                        COUNT(M.id) 
                        FROM [pre]shop_products as M  
                        JOIN [pre]shop_cat_prod_ref as R2 ON R2.prod_id=M.id 
                        $filter_joins
                        WHERE 
                        M.mf_id=MF.id AND M.block=0 AND R2.cat_id=$_id
                        $filters 
                        
                    ) as count 
                ";
            }
            
			$query = "SELECT MF.id, MF.name $count_select 
						FROM [pre]shop_products as P 
                        JOIN [pre]shop_cat_prod_ref as R ON R.prod_id=P.id 
                        JOIN [pre]shop_mf as MF ON MF.id=P.mf_id 
                        
						WHERE 
                            R.cat_id=$_id AND 
                            P.block=0 
                       
						GROUP BY P.mf_id
                        ORDER BY MF.name
                        ";
			return $this->db->exec_query($query);
		}
		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		}
	}
    
	public function getProductByAlias($_alias)
	{
		try{
			$query = "SELECT M.* , R.cat_id, C.parent
						FROM [pre]shop_products as M 
						LEFT JOIN [pre]shop_cat_prod_ref as R ON R.prod_id=M.id 
						LEFT JOIn [pre]shop_catalog as C ON C.id=R.cat_id
						WHERE M.block=0 
						AND M.alias='$_alias'
						LIMIT 1";
			return $this->db->exec_query($query,1);
		}

		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		}
	}

	public function getProductImages($_prod_id)
	{
		try{
			$query = "SELECT R.file 
						FROM [pre]files_ref as R 
						WHERE R.ref_table='shop_products'
						AND R.ref_table='shop_products' AND R.ref_id=$_prod_id AND R.file!='fail'
						LIMIT 20";
			return $this->db->exec_query($query);

		}
		catch (Exception $e) {
			echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
		}
	}	

	public function getParentByAlias($_alias)
	{
		try
			{
			$query = "SELECT *
						FROM [pre]shop_catalog
						WHERE `block`=0
						AND `alias`='$_alias'
						LIMIT 1";
			return $this->db->exec_query($query,1);
			}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}

	public function getChildsByID($parent)
	{
		try{
			$query = "SELECT *
						FROM [pre]shop_catalog
						WHERE `parent`='$parent'
						AND `block`=0
						ORDER BY id
						LIMIT 20";
			return $this->db->exec_query($query);

			}
		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function getCategoryFilterChars($_group_id)
	{
		try{
			$query = "SELECT M.id, M.name, M.measure
						FROM [pre]shop_chars as M
						WHERE M.group_id = $_group_id AND M.show_site = 1 AND M.block = 0 AND M.show_admin = 1
						ORDER BY M.pos
						LIMIT 100
					";
			return $this->db->exec_query($query);

			}
		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}
	}

	public function getCategoryFilterCharValues($_cat_id, $_char_id)
	{
		try{
			$query = "SELECT M.value, M.id as ref_id,
						(
							SELECT COUNT(SREF.id) 
							FROM [pre]shop_chars_prod_ref as SREF 
							LEFT JOIN [pre]shop_cat_prod_ref as CPR on CPR.prod_id=SREF.prod_id 
							LEFT JOIN [pre]shop_products as RP on RP.id=SREF.prod_id 
							WHERE SREF.char_id=M.char_id AND SREF.value=M.value AND CPR.cat_id=$_cat_id AND RP.block=0 
						) 
							as values_count
						FROM [pre]shop_chars_prod_ref as M 
						LEFT JOIN [pre]shop_cat_prod_ref as R ON R.prod_id=M.prod_id
						LEFT JOIN [pre]shop_products as P ON P.id=R.prod_id
						WHERE M.value != '' AND M.char_id=$_char_id AND P.block=0 AND R.cat_id=$_cat_id 
						GROUP BY M.value 
						ORDER BY M.value 
						LIMIT 200
					";
			
			//if($_char_id==32) { echo "<pre>" . str_replace("[pre]","next_",$query) . "</pre>"; }

			return $this->db->exec_query($query);

			}
		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function countFilterValues($_cat_id, $_char_id, $filters, $filter_joins)
	{
		try{
			$query = "SELECT SREF.value, COUNT(SREF.id) as count, SREF.id as ref_id 
						FROM [pre]shop_chars_prod_ref as SREF 
						LEFT JOIN [pre]shop_cat_prod_ref as CPR on CPR.prod_id=SREF.prod_id 
						LEFT JOIN [pre]shop_products as M on M.id=SREF.prod_id 
						
							$filter_joins
						
						WHERE SREF.char_id=$_char_id AND CPR.cat_id=$_cat_id AND M.block=0 AND SREF.value!=''
						
							$filters
						
						GROUP BY SREF.value 
						ORDER BY SREF.id
						";
			
			//if($_char_id==32) echo "<pre>" . str_replace("[pre]","next_",$query) . "</pre>";

			return $this->db->exec_query($query);

			}
		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function getCategoryMaxMinPrice($_cat_id)
	{
		try{
			$query = "SELECT MAX(M.price), MIN(M.price)
						FROM [pre]shop_products as M
						LEFT JOIN [pre]shop_cat_prod_ref as R ON R.cat_id=$_cat_id
						WHERE M.id = R.prod_id
						LIMIT 1
					";
			return $this->db->exec_query($query,1);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function getNewProducts()
	{
		try{
			$query = "SELECT M.id, M.alias, M.name, M.price, M.currency, R.file, 
						(SELECT quant FROM [pre]shop_cart WHERE prod_id=M.id AND uid='".ACCOUNT_ID."' LIMIT 1) as quant_in_cart
						FROM [pre]shop_products as M
						LEFT JOIN [pre]files_ref as R ON R.ref_id=M.id
						LEFT JOIN [pre]shop_prod_group_ref as G ON G.prod_id=M.id
						WHERE G.group_id=1 AND R.file!='fail' AND R.file!='' AND R.file!=''
						AND M.block=0
						GROUP BY M.id DESC
						LIMIT 10
					";
			return $this->db->exec_query($query);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

		public function getPopularProducts()
	{
		try{
			$query = "SELECT M.id, M.alias, M.quant, M.name, M.price, M.currency, R.file,
						(SELECT quant FROM [pre]shop_cart WHERE prod_id=M.id AND uid='".ACCOUNT_ID."' LIMIT 1) as quant_in_cart
						FROM [pre]shop_products as M
						LEFT JOIN [pre]files_ref as R ON R.ref_id=M.id
						LEFT JOIN [pre]shop_prod_group_ref as G ON G.prod_id=M.id
						WHERE G.group_id=4
						AND M.block=0 AND R.file!='fail' AND R.file!='' AND R.file!=''
						GROUP BY M.id DESC
						LIMIT 10
					";
			return $this->db->exec_query($query);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}
		

		public function getInCartProducts($userId)
	{
		try{
		$query = "SELECT C.*,
					(SELECT name FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_name,
					(SELECT square FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_square,
					(SELECT depth FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_depth,
					(SELECT alias FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_alias,
					(SELECT model FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_model,
					(SELECT price FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_price,
					(SELECT currency FROM [pre]shop_products WHERE `id`=C.prod_id LIMIT 1) as product_currency,
					(SELECT file FROM [pre]files_ref WHERE `ref_id`=C.prod_id ORDER BY id DESC LIMIT 1) as product_image,
					(SELECT parent FROM [pre]shop_catalog WHERE `id`=R.cat_id ORDER BY id DESC LIMIT 1) as parent
					FROM [pre]shop_cart as C
					LEFT JOIN [pre]shop_cat_prod_ref as R ON R.prod_id=C.prod_id
					WHERE C.uid='$userId'
					ORDER BY C.id DESC
					";
			return $this->db->exec_query($query);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}


	public function countCartSumm($uid)
	{
		try{
			$countQuery = "SELECT SUM(P.price*C.quant) as cart_price, SUM(C.quant) as cart_quant
							FROM [pre]shop_products as P 
							LEFT JOIN [pre]shop_cart as C ON C.prod_id=P.id
							WHERE C.uid='$uid'
							  ";

			return $this->db->exec_query($countQuery,1);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function getInCartItem($uid, $prod_id)
	{
		try{
			$query = "SELECT id, quant
					FROM [pre]shop_cart
					WHERE `uid`='$uid'
					AND `prod_id`=$prod_id
					ORDER BY id DESC
					LIMIT 1
					";
			return $this->db->exec_query($query,1);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}


	public function getMyOrdersById($account_id)
	{
		try{
			$query = "SELECT O.*, S.name
					FROM [pre]shop_orders as O
					LEFT JOIN [pre]shop_order_statuses as S ON S.id = O.status
					WHERE O.user_id='$account_id'
					ORDER BY O.id
					LIMIT 100
					";
			return $this->db->exec_query($query);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function getCitiesList()
	{
		try{
			$query = "SELECT *
					FROM next_np_cities
					ORDER BY id
					";
			return $this->db->exec_query($query);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}

	public function getPartsListByCity($city_id)
	{
		try{
			$query = "SELECT *
					FROM next_np_parts as P
					LEFT JOIN next_np_cities as C ON C.Ref=P.CityRef
					WHERE C.id='$city_id'
					ORDER BY id
					";
			return $this->db->exec_query($query);

		}

		catch (Exception $e) {
				echo "Error (File: ".$e->getFile().", line ".$e->getLine()."): ".$e->getMessage();
			}

	}


	function __destruct(){}
}