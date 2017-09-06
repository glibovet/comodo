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
 
class NewsController extends AppController
{

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
		
		$newsWhere = "";
		$catWhere = "";
		$newsRelation = "";
		
		$newsRel =  $conn->query("SELECT relation 
					FROM osc_menu
					WHERE `alias`= '".LA."'
					LIMIT 1
					")->fetch('assoc');
		$this->set("newsRel", $newsRel);
		
		$newsRelation = unserialize($newsRel['relation']);// Список привязанных к новостям категорий
		//echo "<pre>"; print_r($newsRelation); echo "</pre>"; exit();
		
		if ($newsRelation){
			$i=0;
			$or = "";
			foreach ($newsRelation as $relation){
				$i++;
				if ($i>=2){$or = " OR ";}				
				$newsWhere .= $or."M.cat_id = ".$relation.""; 			
				$catWhere .= $or."M.id = ".$relation.""; 
				}
			}
			
		$newsCat =  $conn->query("SELECT M.".LANG_PREFIX."name as name, M.alias,
					(SELECT COUNT(id) FROM osc_articles WHERE `block`=0 AND `cat_id`=M.id) as art_count
					FROM osc_categories as M
					WHERE M.block =0 AND (".$catWhere.")
					ORDER BY M.".LANG_PREFIX."name
					LIMIT 100
		")->fetchAll('assoc');
		$this->set("newsCat", $newsCat);// Список категорий новостей
		//echo "<pre>"; print_r($newsCat); echo "</pre>"; exit();
		
		$f_pag_lim = 5; // Количество новостей на странице
		$this->set("f_pag_lim", $f_pag_lim);

		$f_page_size = 5; // Максимальное количество отображаемых страниц в пагинации
		$this->set("f_page_size", $f_page_size);
		
		$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
		$this->set("f_page_num", $f_page_num);
		
		$newsList = $conn->query("SELECT SQL_CALC_FOUND_ROWS M.*,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					".LANG_PREFIX."name as name, 
					".LANG_PREFIX."content as content,
					(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias
					FROM osc_articles as M
					WHERE M.block =0 AND (".$newsWhere.")
					ORDER BY M.dateCreate DESC
					LIMIT ".(($f_page_num-1)*$f_pag_lim).",$f_pag_lim")->fetchAll('assoc');
		$this->set("newsList", $newsList);// Список новостей на странице
		//echo "<pre>"; print_r($newsList); echo "</pre>"; exit();
	
		$rows =  $conn->query("SELECT FOUND_ROWS() AS rows")->fetchAll('assoc'); // Запрос на глобальное количество новостей в категории // Запрос на глобальное количество новостей в категории
		$this->set("rows", $rows);
		  
		$f_total_rows = $rows['0']['rows']; // сохраняем общее количество новостей в категории
		$this->set("f_total_rows", $f_total_rows);
	
		$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
		$this->set("f_pages_count", $f_pages_count);
		
		
			
		if (NEWSQNT){
			$lastNewsQty = NEWSQNT;
			}else{
				$lastNewsQty = 8;
				}	
				//echo "<pre>"; print_r($lastNewsQty); echo "</pre>"; exit();	
				
		$lastNewsList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content, alias, filename,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy
					FROM osc_articles as M
					WHERE M.block=0 AND (".$newsWhere.")
					ORDER BY M.dateCreate DESC
					LIMIT $lastNewsQty")->fetchAll('assoc');
		$this->set("lastNewsList", $lastNewsList);// Список последних новостей
		//echo "<pre>"; print_r($lastNewsList); echo "</pre>"; exit();


    }
	
	 public function category()
    {						
		$conn = ConnectionManager::get('default');	
		
		
		$newsWhere = "";
		$catWhere = "";
		$newsRelation = "";
		
		$newsRel =  $conn->query("SELECT relation 
					FROM osc_menu
					WHERE `alias`= 'news'
					LIMIT 1
					")->fetch('assoc');
		$this->set("newsRel", $newsRel);
		
		$newsRelation = unserialize($newsRel['relation']);// Список привязанных к новостям категорий
		//echo "<pre>"; print_r($newsRelation); echo "</pre>"; exit();
		
		$trueCat =  $conn->query("SELECT id, ".LANG_PREFIX."name as name, alias, ".LANG_PREFIX."meta_title as meta_title, ".LANG_PREFIX."meta_keys as meta_keys, ".LANG_PREFIX."meta_desc as meta_desc
					FROM osc_categories
					WHERE `alias`= '".LA."'
					LIMIT 1
					")->fetch('assoc');
		$this->set("trueCat", $trueCat);
		
		$catId = $trueCat['id'];// ID текущей категории
		$catName = $trueCat['name'];
		$this->set("catName", $catName);// Название текущей категории
		
		if ($trueCat['meta_title']) {
		$metaTitle = $trueCat['meta_title'];
		$this->set("metaTitle", $metaTitle);//title страницы
		}
		
		if ($trueCat['meta_keys']) {
		$metaKeys = $trueCat['meta_keys'];
		$this->set("metaKeys", $metaKeys);//keywords страницы
		}
		
		if ($trueCat['meta_desc']) {
		$metaDesc = $trueCat['meta_desc'];
		$this->set("metaDesc", $metaDesc);//description страницы
		}
		
		if ($newsRelation){
			$i=0;
			$or = "";
			foreach ($newsRelation as $relation){
				$i++;
				if ($i>=2){$or = " OR ";}
				$newsWhere .= $or."M.cat_id = ".$relation.""; 			 			
				$catWhere .= $or."M.id = ".$relation.""; 
				}
			}
			
		$newsCat =  $conn->query("SELECT M.".LANG_PREFIX."name as name, M.alias,
					(SELECT COUNT(id) FROM osc_articles WHERE `block`=0 AND `cat_id`=M.id) as art_count
					FROM osc_categories as M
					WHERE M.block =0 AND (".$catWhere.")
					ORDER BY M.".LANG_PREFIX."name
					LIMIT 100
		")->fetchAll('assoc');
		$this->set("newsCat", $newsCat);// Список категорий новостей
		//echo "<pre>"; print_r($newsCat); echo "</pre>"; exit();
		
		
		$f_pag_lim = 5; // Количество новостей на странице
		$this->set("f_pag_lim", $f_pag_lim);

		$f_page_size = 5; // Максимальное количество отображаемых страниц в пагинации
		$this->set("f_page_size", $f_page_size);
		
		$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
		$this->set("f_page_num", $f_page_num);
		
		$newsList = $conn->query("SELECT SQL_CALC_FOUND_ROWS M.*,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					".LANG_PREFIX."name as name, 
					".LANG_PREFIX."content as content,
					(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count
					FROM osc_articles as M
					WHERE M.block =0 AND M.cat_id = ".$catId."
					ORDER BY M.dateCreate DESC
					LIMIT ".(($f_page_num-1)*$f_pag_lim).",$f_pag_lim")->fetchAll('assoc');
		$this->set("newsList", $newsList);// Список новостей на странице
		//echo "<pre>"; print_r($newsList); echo "</pre>"; exit();
	
		$rows =  $conn->query("SELECT FOUND_ROWS() AS rows")->fetchAll('assoc'); // Запрос на глобальное количество новостей в категории // Запрос на глобальное количество новостей в категории
		$this->set("rows", $rows);
		  
		$f_total_rows = $rows['0']['rows']; // сохраняем общее количество новостей в категории
		$this->set("f_total_rows", $f_total_rows);
	
		$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
		$this->set("f_pages_count", $f_pages_count);
		
		
		$lastNewsQty = 8;	
				
		$lastNewsList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content, alias, filename,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy
					FROM osc_articles as M
					WHERE M.block=0 AND (".$newsWhere.")
					ORDER BY M.dateCreate DESC
					LIMIT $lastNewsQty")->fetchAll('assoc');
		$this->set("lastNewsList", $lastNewsList);// Список последних новостей
		//echo "<pre>"; print_r($lastNewsList); echo "</pre>"; exit();

    }
	
	
	public function article()
    {					
		$conn = ConnectionManager::get('default');
		
		$la_key = $this->Help->xss_clean(LA); // Must move to App Controller
		
		$q = "
		SELECT M.*, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."content as content, M.".LANG_PREFIX."meta_title as meta_title, M.".LANG_PREFIX."meta_keys as meta_keys, M.".LANG_PREFIX."meta_desc as meta_desc,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy,
					(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias,
					(SELECT ".LANG_PREFIX."name FROM osc_categories WHERE `id`=M.cat_id) as cat_name,
					(SELECT alias FROM osc_articles WHERE `block`=0 AND `cat_id`=M.cat_id AND `dateCreate`>M.dateCreate ORDER BY `dateCreate` LIMIT 1) as next_news,
					(SELECT alias FROM osc_articles WHERE `block`=0 AND `cat_id`=M.cat_id AND `dateCreate`<M.dateCreate ORDER BY `dateCreate` DESC LIMIT 1) as prev_news
					FROM osc_articles as M
					WHERE M.alias='".$la_key."'  
					LIMIT 1";
		
		$newsArticle = $conn->query($q)->fetch('assoc');// Статья по алиасу	
		
		if(!$newsArticle)
		{
			$q2 = "SELECT `new` FROM `osc_help_alias` WHERE `type`='article_post' AND `old`='".$la_key."' ORDER BY id DESC LIMIT 1";
			$help_alias = $conn->query($q2)->fetch('assoc');
			
			if($help_alias)
			{
				$la_key = $help_alias['new'];
		
				$q = "
				SELECT M.*, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."content as content, M.".LANG_PREFIX."meta_title as meta_title, M.".LANG_PREFIX."meta_keys as meta_keys, M.".LANG_PREFIX."meta_desc as meta_desc,
							Extract(MONTH from M.dateCreate ) AS mm,
							Extract(day from M.dateCreate ) AS dd,
							Extract(year from M.dateCreate ) AS yy,
							(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count,
							(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias,
							(SELECT alias FROM osc_articles WHERE `block`=0 AND `cat_id`=M.cat_id AND `dateCreate`>M.dateCreate ORDER BY `dateCreate` LIMIT 1) as next_news,
							(SELECT alias FROM osc_articles WHERE `block`=0 AND `cat_id`=M.cat_id AND `dateCreate`<M.dateCreate ORDER BY `dateCreate` DESC LIMIT 1) as prev_news
							FROM osc_articles as M
							WHERE M.alias='".$la_key."' 
							LIMIT 1";
							
				$newsArticle = $conn->query($q)->fetch('assoc'); // Статья по СТАРОМУ алиасу
			}
		} // !!! OLD ALIAS HACK STEP 1
					
		$this->set("newsArticle", $newsArticle);	
		//echo "<pre>"; print_r($newsArticle); echo "</pre>"; exit();			
		
		
		if ( !$newsArticle )
		{
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: ".RS."404/"); 
			exit();
		}
		
		/*if ($newsArticle['meta_title']) {
		$metaTitle = $newsArticle['meta_title'];
		$this->set("metaTitle", $metaTitle);//title страницы
		}*/
				
		$artName 	= (isset($newsArticle['name']) ? $newsArticle['name'] : "");	
		
		$metaTitle = $artName." - Comodo";
		$this->set("metaTitle", $metaTitle);//сгенерированный title статьи
		
		if ($newsArticle['meta_keys']) {
		$metaKeys = $newsArticle['meta_keys'];
		$this->set("metaKeys", $metaKeys);//keywords страницы
		}
		
		if ($newsArticle['meta_desc']) {
			$metaDesc = $newsArticle['meta_desc'];
		}else{
			$metaDesc = "";
		}
		$this->set("metaDesc", $metaDesc);//description страницы
		
		$newsGalId = $newsArticle['gallery_id'];
		
		$trueGalleryId = $conn->query("
            SELECT  id
			FROM osc_galleries
 			WHERE `id` = '$newsGalId' AND
			`block` = 0
			ORDER BY `id` 
			LIMIT 1
        	")->fetch('assoc');
			
		$galId = $trueGalleryId['id'];
		
		$ArtGallery = $conn->query("SELECT *
					FROM osc_files_ref
					WHERE ref_table='galleries'
					AND ref_id='".$galId."'
					ORDER BY id 
					LIMIT 40")->fetchAll('assoc');
		$this->set("ArtGallery", $ArtGallery);// Галлерея в статье
		
		$newsWhere = "";
		$catWhere = "";
		$newsRelation = "";
		
		$newsRel =  $conn->query("SELECT relation 
					FROM osc_menu
					WHERE `alias`= 'news'
					LIMIT 1
					")->fetch('assoc');
		$this->set("newsRel", $newsRel);
		
		$newsRelation = unserialize($newsRel['relation']);// Список привязанных к новостям категорий
		//echo "<pre>"; print_r($newsRelation); echo "</pre>"; exit();
		
		$trueCat =  $conn->query("SELECT id 
					FROM osc_categories
					WHERE `alias`= '".LA."'
					LIMIT 1
					")->fetch('assoc');
		$this->set("trueCat", $trueCat);
		
		$catId = $trueCat['id'];// ID текущей категории
		
		if ($newsRelation){
			$i=0;
			$or = "";
			foreach ($newsRelation as $relation){
				$i++;
				if ($i>=2){$or = " OR ";}
				$newsWhere .= $or."M.cat_id = ".$relation.""; 			 			
				$catWhere .= $or."M.id = ".$relation.""; 
				}
			}
			
		$newsCat =  $conn->query("SELECT M.".LANG_PREFIX."name as name, M.alias,
					(SELECT COUNT(id) FROM osc_articles WHERE `block`=0 AND `cat_id`=M.id) as art_count
					FROM osc_categories as M
					WHERE M.block =0 AND (".$catWhere.")
					ORDER BY M.".LANG_PREFIX."name
					LIMIT 100
		")->fetchAll('assoc');
		$this->set("newsCat", $newsCat);// Список категорий новостей
		//echo "<pre>"; print_r($newsCat); echo "</pre>"; exit();
		
		$lastNewsQty = 8;	
				
		$lastNewsList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content, alias, filename,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(year from M.dateCreate ) AS yy
					FROM osc_articles as M
					WHERE M.block=0 AND (".$newsWhere.")
					ORDER BY M.dateCreate DESC
					LIMIT $lastNewsQty")->fetchAll('assoc');
		$this->set("lastNewsList", $lastNewsList);// Список последних новостей
		//echo "<pre>"; print_r($lastNewsList); echo "</pre>"; exit();
    }
}
