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
 
class BlogController extends AppController
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
		
		$f_pag_lim = 7; // Количество новостей на странице
		$this->set("f_pag_lim", $f_pag_lim);

		$f_page_size = 40; // Максимальное количество отображаемых страниц в пагинации
		$this->set("f_page_size", $f_page_size);
		
		$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
		$this->set("f_page_num", $f_page_num);
		
		$blogList = $conn->query("SELECT SQL_CALC_FOUND_ROWS M.*,
					Extract(MONTH from M.dateModify ) AS mm,
					Extract(day from M.dateModify ) AS dd,
					Extract(YEAR from M.dateModify ) AS yy,					
					".LANG_PREFIX."name as name, 
					".LANG_PREFIX."content as content,
					(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count
					FROM osc_articles as M
					WHERE `cat_id`=1 AND `block`=0
					ORDER BY M.dateModify DESC
					LIMIT ".(($f_page_num-1)*$f_pag_lim).",$f_pag_lim")->fetchAll('assoc');
		$this->set("blogList", $blogList);// Список новостей на странице
		
		//echo "<pre>"; print_r($blogList); echo "</pre>";  exit();
	
		$rows =  $conn->query("SELECT FOUND_ROWS() AS rows")->fetchAll('assoc'); // Запрос на глобальное количество новостей в категории // Запрос на глобальное количество новостей в категории
		$this->set("rows", $rows);
		  
		$f_total_rows = $rows['0']['rows']; // сохраняем общее количество новостей в категории
		$this->set("f_total_rows", $f_total_rows);
	
		$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
		$this->set("f_pages_count", $f_pages_count);

    }
	
	public function article()
    {		
		$conn = ConnectionManager::get('default');
		
		$blogArticle = $conn->query("SELECT M.*, ".LANG_PREFIX."name as name, ".LANG_PREFIX."content as content,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(YEAR from M.dateCreate ) AS yy,	
					(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count
					FROM osc_articles as M
					WHERE M.alias='".LA."' 
					LIMIT 1")->fetch('assoc');
		$this->set("blogArticle", $blogArticle);// Статья по алиасу	
		
		if ($blogArticle['meta_title']) {
		$metaTitle = $blogArticle['meta_title'];
		$this->set("metaTitle", $metaTitle);//title страницы
		}
		
		if ($blogArticle['meta_keys']) {
		$metaKeys = $blogArticle['meta_keys'];
		$this->set("metaKeys", $metaKeys);//keywords страницы
		}
		
		if ($blogArticle['meta_desc']) {
		$metaDesc = $blogArticle['meta_desc'];
		$this->set("metaDesc", $metaDesc);//description страницы
		}
				
		$artId = $blogArticle['id'];
		$blogGalId = $blogArticle['gallery_id'];
		
		$trueGalleryId = $conn->query("
            SELECT  id
			FROM osc_galleries
 			WHERE `id` = '$blogGalId' AND
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
					LIMIT 100")->fetchAll('assoc');
		$this->set("ArtGallery", $ArtGallery);// Галлерея в статье
		
		$artComments = $conn->query("
						SELECT M.*, M.name as table_name,
							(SELECT name FROM osc_users WHERE id = M.user_id LIMIT 1) as name,
							Extract(MONTH from M.dateCreate ) AS mm,
							Extract(day from M.dateCreate ) AS dd,
							Extract(YEAR from M.dateCreate ) AS yy
							FROM osc_article_comments as M
							WHERE M.art_id = '$artId' AND
							M.block = 0
							ORDER BY M.dateCreate DESC
							LIMIT 100
		")->fetchAll('assoc');
		$this->set("artComments", $artComments);// Комментарии к статье
		
		//echo "<pre>"; print_r($ArtGallery); echo "</pre>";  exit();
    }
}
