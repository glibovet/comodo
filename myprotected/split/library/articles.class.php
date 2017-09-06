<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Settings class
	
require("BasicHelp.php");

class articlesHelp extends BasicHelp
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
		
		// CATEGORIES
		
		///////////////////////////////////////////
		
		// Get category item
		
		public function getArtCategoriesItem($id)
		{
			$query = "SELECT M.*, (SELECT COUNT(*) FROM [pre]articles WHERE `cat_id`=M.id LIMIT 1000) as arts_quant  FROM [pre]categories as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all categories
		
		public function getArtCategories($params=array(),$typeCount=false)
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
			
						(SELECT COUNT(*) FROM [pre]articles WHERE `cat_id`=M.id LIMIT 1000) as arts_quant 
						
						FROM [pre]categories as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]categories as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// ARTICLES
		
		///////////////////////////////////////////
		
		// Get article item
		
		public function getArticleItem($id, $pref="")
		{
			$query = "SELECT M.*, (SELECT ".$pref."name FROM [pre]categories WHERE `id`=M.cat_id LIMIT 1) as cat_name  FROM [pre]articles as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о documents
				$result['docs'] = array();
				
				$query = "SELECT id,file,crop,path,title FROM [pre]docs_ref WHERE `ref_table`='articles' AND `ref_id`=$id LIMIT 1000";
				$docsMassive = $this->rs($query);
				
				if($docsMassive)
				{
					$result['docs'] = $docsMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getArticles($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.cat_id, 
			
						(SELECT name FROM [pre]categories WHERE `id`=M.cat_id LIMIT 1) as cat_name 
						
						FROM [pre]articles as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]articles as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get cats List
		
		public function getCatsList()
		{
			$query = "SELECT id,name FROM [pre]categories WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
				
		
		///////////////////////////////////////////
		
		// PROJECTS
		
		///////////////////////////////////////////
		
		// Get article item
		
		public function getProjectItem($id)
		{
			$query = "SELECT M.*, (SELECT fname FROM [pre]users WHERE `id`=M.user_id LIMIT 1) as user_name  FROM [pre]projects as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());			
					
			// Вытягиваем данные о картинках
			$result['images'] = array();
			
			$query = "SELECT id,file,crop,title FROM [pre]project_files_ref WHERE `ref_id`=$id LIMIT 100";
			$imagesMassive = $this->rs($query);
			
			if($imagesMassive)
			{
				$result['images'] = $imagesMassive;
			}
			
			// Вытягиваем значения свойств
			$result['chars'] = array();
			$result['charsD'] = array();
			
			$result['charsD_ID'] = 0;
			
			$query = "SELECT M.id as char_id, M.name, V.value as value, V.ua_value as ua_value, V.en_value as en_value, R.id as id,  R.filter as filter
			
					 FROM  [pre]project_chars as M 
					
					 LEFT JOIN [pre]project_chars_ref AS R on R.char_id = M.id AND R.project_id=$id
					
					 LEFT JOIN [pre]project_chars_values AS V on V.id = R.val_id 
						  
					 WHERE M.is_dinamic=0
					 ORDER BY M.name
					 LIMIT 100";
					 
			$charsList = $this->rs($query);
			
			if(!$charsList)
			{
				$query = "SELECT * FROM [pre]project_chars WHERE `is_dinamic`=0 ORDER BY pos LIMIT 100";
				$charsList = $this->rs($query);
			}
			
			$result['chars'] = $charsList;

			// Dinamical chars

			$query = "SELECT M.id, M.name
					 FROM [pre]project_chars as M
					 WHERE M.is_dinamic=1
					 ORDER BY M.name
					 LIMIT 1";

			$dinamicCharArr = $this->rs($query);

			if($dinamicCharArr)
			{
				$dinamicChar = $dinamicCharArr[0];

				$charDID = $dinamicChar['id'];
				
				$result['charsD_ID'] = $charDID;

				//======================================================================================================================
				// Get dinamic chars list

				$query = "SELECT * FROM [pre]project_chars WHERE is_dinamic=1 ORDER BY name LIMIT 100";
				$charsListD = $this->rs($query);
			
				//======================================================================================================================
				// Get dinamic chars values 
				
				foreach($charsListD as $i => $d_item)
				{
					$d_id = $d_item['id'];
					
					$query = "SELECT M.id, V.value, V.ua_value, V.en_value, M.filter,
									  (SELECT id 		FROM [pre]project_chars WHERE id=$d_id) as char_id,
									  (SELECT name 		FROM [pre]project_chars WHERE id=$d_id) as name
						 FROM	[pre]project_chars_ref as M
						 
						 LEFT JOIN [pre]project_chars_values AS V on V.id = M.val_id 
						 
						 WHERE M.char_id='".$d_id."' AND M.project_id=$id
						 ORDER BY M.id
						 LIMIT 1000";

					$charsListD[$i]['values'] = $this->rs($query);
				}
				
				//=====================================================================================================================
				// Dinamic chars result
				
				$result['charsD'] = $charsListD;
			}
			
			// end of Dinamical Char
			
			
			return $result;
		}
		
		
	
		// Get all projects
		
		public function getProjects($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.user_id, 
							
						(SELECT fname FROM [pre]users WHERE `id`=M.user_id LIMIT 1) as user_name 
						
						FROM [pre]projects as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]projects as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get user List
		
		public function getUserList()
		{
			$query = "SELECT id, fname FROM [pre]users WHERE block = 0 AND worker = 0 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		///////////////////////////////////////////
		
		// CHARS
		
		///////////////////////////////////////////
		
		// 
		
		public function getProjectChars($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.ua_name, M.en_name, M.alias, M.block, M.is_dinamic
						
						FROM [pre]project_chars as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]project_chars as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		//
		
		public function getCharsItemDetails($id)
		{
			$query = "SELECT * FROM [pre]project_chars WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
						
			return $result;
		}
		
		
		///////////////////////////////////////////
		
		// BANNERS
		
		///////////////////////////////////////////
		
		// Get banner item
		
		public function getBannerItem($id)
		{
			$query = "SELECT M.*, (SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name  FROM [pre]banners as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getBanners($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.pos_id, M.startPublish, M.finishPublish, 
			
						(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name 
						
						FROM [pre]banners as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]banners as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// Galleries
		
		///////////////////////////////////////////
		
		// Get gallery item
		
		public function getGalleryItem($id)
		{
			$query = "SELECT M.*  FROM [pre]galleries as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
				$result['images'] = array();
				
				$query = "SELECT id,file,title,crop,path FROM [pre]files_ref WHERE `ref_table`='galleries' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getGalleries($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.caption, M.block, M.dateCreate, M.dateModify
				
						FROM [pre]galleries as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]galleries as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		
		///////////////////////////////////////////
		
		// CONTENT BLOCKS
		
		///////////////////////////////////////////
		
		// Get content block item
		
		public function getContentBlockItem($id)
		{
			$query = "SELECT M.*, (SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name  FROM [pre]content_blocks as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getContentBlocks($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.pos_id, M.startPublish, M.finishPublish, 
			
						(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name 
						
						FROM [pre]content_blocks as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]content_blocks as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// Get site Positions
		
		public function getPositions()
		{
			$query = "SELECT id,name FROM [pre]site_positions WHERE 1 ORDER BY id LIMIT 1000";
			return $this->rs($query);
		}
		
		// Get menuFormats
		
		public function getMenuFormats()
		{
			$query = "SELECT id,name FROM [pre]menu_formats WHERE 1 ORDER BY id LIMIT 100";
			return $this->rs($query);
		}
		
		// Get galleries list
		
		public function getGalleriesList()
		{
			$query = "SELECT id,name FROM [pre]galleries WHERE 1 ORDER BY id LIMIT 10000";
			return $this->rs($query);
		}
		
		///////////////////////////////////////////
		
		// FAQ
		
		///////////////////////////////////////////
		
		// Get FAQ item
		
		public function getFaqItem($id)
		{
			$query = "SELECT M.* FROM [pre]faq as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			return $result;
		}
	
		// Get all articles
		
		public function getFAQ($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.question, M.answer, M.block, M.order_id, M.dateCreate 
			
						FROM [pre]faq as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]faq as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		///////////////////////////////////////////
		
		// CONTENT BLOCKS
		
		///////////////////////////////////////////
		
		// Get content block item
		
		public function getMenuItem($id)
		{
			$query = "SELECT M.*, (SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name  FROM [pre]menu as M WHERE `id`='$id' LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			// Вытягиваем данные о картинках
				$result['docs'] = array();
				
				$query = "SELECT id,file,crop,path FROM [pre]docs_ref WHERE `ref_table`='menu' AND `ref_id`=$id LIMIT 1000";
				$docsMassive = $this->rs($query);
				
				if($docsMassive)
				{
					$result['docs'] = $docsMassive;
				}
			
			return $result;
		}
	
		// Get all articles
		
		public function getMenu($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.id, M.name, M.alias, M.block, M.pos_id, 
			
						(SELECT name FROM [pre]site_positions WHERE `id`=M.pos_id LIMIT 1) as pos_name 
						
						FROM [pre]menu as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]menu as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		// SITE MESSAGES
		
		public function getSiteMessages($params=array(),$typeCount=false)
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
			
				$query = "SELECT M.*	
						
						FROM [pre]site_messages as M  
						
						WHERE 1 
						ORDER BY M.dateCreate DESC 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]site_messages as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getSiteMessageItem($id)
		{
			$query = "SELECT M.*
						FROM [pre]site_messages as M 
						WHERE `id`=$id 
						LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			$result['images'] = array();
				
				$query = "SELECT id,file,title,crop,path FROM [pre]files_ref WHERE `ref_table`='site_messages' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
			
			return $result;
		}
		
		// ARTICLE COMMENTS
		
		public function getArticleComments($params=array(),$typeCount=false)
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
						(SELECT name FROM [pre]articles WHERE `id`=M.art_id) as prod_name		
						
						FROM [pre]article_comments as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]article_comments as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getArticleCommentItem($id)
		{
			$query = "SELECT M.*, 
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email,
						(SELECT name FROM [pre]articles WHERE `id`=M.art_id) as prod_name 
						FROM [pre]article_comments as M 
						WHERE `id`=$id 
						LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			$result['images'] = array();
				
				$query = "SELECT id,file,title,crop,path FROM [pre]files_ref WHERE `ref_table`='article_comments' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
			
			return $result;
		}
		
		// SITE COMMENTS
		
		public function getSiteComments($params=array(),$typeCount=false)
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
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email		
						
						FROM [pre]site_comments as M  
						
						WHERE 1 $filter_and 
						ORDER BY $sort_field $sort_vector 
						LIMIT $start,$limit";
						
				return $this->rs($query);
				
			}else
			{
				$query = "SELECT COUNT(*)  
			
						FROM [pre]site_comments as M  
						
						WHERE 1 $filter_and 
						
						LIMIT 100000";
						
				$result = $this->rs($query);
				return $result[0]['COUNT(*)'];
			}
		}
		
		public function getSiteCommentItem($id)
		{
			$query = "SELECT M.*, 
						(SELECT name FROM [pre]users WHERE `id`=M.user_id) as user_name,
						(SELECT login FROM [pre]users WHERE `id`=M.user_id) as user_email
						FROM [pre]site_comments as M 
						WHERE `id`=$id 
						LIMIT 1";
			$resultMassive = $this->rs($query);
			
			$result = ($resultMassive ? $resultMassive[0] : array());
			
			$result['images'] = array();
				
				$query = "SELECT id,file,title,crop,path FROM [pre]files_ref WHERE `ref_table`='site_comments' AND `ref_id`=$id LIMIT 100";
				$imagesMassive = $this->rs($query);
				
				if($imagesMassive)
				{
					$result['images'] = $imagesMassive;
				}
			
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