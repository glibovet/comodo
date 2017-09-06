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
 
class AboutUsController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
	 
	public function initialize()
	{		
		parent::initialize();
	}
	 
    public function index()
    {						
		$conn = ConnectionManager::get('default');
		
		if ( LA == "company" )
		{
			//header("HTTP/1.1 301 Moved Permanently"); 
			//header("Location: ".RS.LANG."/company/about-us/"); 
			//exit();
			$this->set("companyWorkers", []);
		}else
		{
			$companyWorkers = $conn->query("
            SELECT  id, login, ".LANG_PREFIX."name as name, ".LANG_PREFIX."fname as fname, ".LANG_PREFIX."position as position, ".LANG_PREFIX."credo as credo, avatar, alias 
			FROM osc_users
 			WHERE `block` = 0
			AND  `worker` = 0
			ORDER BY order_id, ".LANG_PREFIX."name 
			LIMIT 200
        	")->fetchAll('assoc');
			$this->set("companyWorkers", $companyWorkers);
			//echo "<pre>"; print_r($companyWorkers); echo "</pre>"; exit();
		}	
    }
	
	public function designer()
    {						
		$conn = ConnectionManager::get('default');
		
		$worker = $conn->query("
            SELECT  id, login, ".LANG_PREFIX."name as name, ".LANG_PREFIX."fname as fname, ".LANG_PREFIX."position as position, ".LANG_PREFIX."credo as credo, avatar, alias, phone, ".LANG_PREFIX."delivery_address as address, ".LANG_PREFIX."details as details, ".LANG_PREFIX."skills as skills, ".LANG_PREFIX."meta_title as meta_title, ".LANG_PREFIX."meta_keys as meta_keys, ".LANG_PREFIX."meta_desc as meta_desc
			FROM osc_users
 			WHERE `block` = 0
			AND  `worker` = 0
			AND  `alias` = '".LA."'
			LIMIT 1
        	")->fetch('assoc');
			$this->set("worker", $worker);
			//echo "<pre>"; print_r($worker); echo "</pre>"; exit();			
		
			if ( !$worker )
			{
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: ".RS."404/"); 
				exit();
			}
			
			$wId = $worker['id'];
			$this->set("wId", $wId);
			
			/*if ($worker['meta_title']) {
			$metaTitle = $worker['meta_title'];
			$this->set("metaTitle", $metaTitle);//title страницы
			}*/
			
			$workerName 	= (isset($worker['name']) ? $worker['name'] : "");	
			$workerFname	= (isset($worker['fname']) ? $worker['fname'] : "");			
			$workerPos 		= (isset($worker['position']) ? $worker['position'] : "");			
		
			$metaTitle = $workerName." ".$workerFname." - ".$workerPos;
			$this->set("metaTitle", $metaTitle);//сгенерированный title страницы
			
			if ($worker['meta_keys']) {
			$metaKeys = $worker['meta_keys'];
			$this->set("metaKeys", $metaKeys);//keywords страницы
			}
			
			if ($worker['meta_desc']) {
			$metaDesc = $worker['meta_desc'];
			}else{
				$metaDesc = "";
			}
			$this->set("metaDesc", $metaDesc);//description страницы
			
			// PROROJECT LIST	
		
			$f_pag_lim = 6; // Количество проектов на странице
			$this->set("f_pag_lim", $f_pag_lim);
	
			$f_page_size = 5; // Максимальное количество отображаемых страниц в пагинации
			$this->set("f_page_size", $f_page_size);
			
			$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
			$this->set("f_page_num", $f_page_num);
			
			$projectsList = $conn->query("
            SELECT SQL_CALC_FOUND_ROWS P.id, P.".LANG_PREFIX."name as name, P.alias,
			(SELECT crop FROM osc_project_files_ref WHERE `ref_id` = P.id ORDER BY `id` LIMIT 1) as img,
			(SELECT title FROM osc_project_files_ref WHERE `ref_id` = P.id ORDER BY `id` LIMIT 1) as title			
			FROM osc_projects as P
 			WHERE P.block = 0
			AND  P.user_id = '".$wId."'
			ORDER BY P.dateCreate
			LIMIT ".(($f_page_num-1)*$f_pag_lim).",$f_pag_lim
        	")->fetchAll('assoc');
			$this->set("projectsList", $projectsList);
			//echo "<pre>"; print_r($projectsList); echo "</pre>"; exit();
		
			$rows =  $conn->query("SELECT FOUND_ROWS() AS rows")->fetchAll('assoc'); // Запрос на глобальное проектов
			$this->set("rows", $rows);
			//echo "<pre>"; print_r($rows); echo "</pre>"; exit();
			  
			$f_total_rows = $rows['0']['rows']; // сохраняем общее количество проектов
			$this->set("f_total_rows", $f_total_rows);
		
			$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
			$this->set("f_pages_count", $f_pages_count);
    }
	
	public function article()
    {						
		$conn = ConnectionManager::get('default');		
		
			$companyInfo = $conn->query("
            SELECT  id, ".LANG_PREFIX."name as name, ".LANG_PREFIX."details as details,  alias, filename, script_name, gallery_id 
			FROM osc_menu
 			WHERE `alias` = '".LA."' 
			ORDER BY `id` 
			LIMIT 1
        	")->fetch('assoc');
			$this->set("companyInfo", $companyInfo);
			//echo "<pre>"; print_r($companyInfo); echo "</pre>"; exit();	
		
			if ( !$companyInfo )
			{
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: ".RS."404/"); 
				exit();
			}
			
			$pageGalId = $companyInfo['gallery_id'];
			
			$trueGalleryId = $conn->query("
            SELECT  id
			FROM osc_galleries
 			WHERE `id` = '$pageGalId' AND
			`block` = 0
			ORDER BY `id` 
			LIMIT 1
        	")->fetch('assoc');
			
			$galId = $trueGalleryId['id'];
			
			$pageGallery = $conn->query("
            SELECT  crop, file, title 
			FROM osc_files_ref
 			WHERE `ref_id` = '$galId' AND
			`ref_table` = 'galleries'
			ORDER BY `id` 
			LIMIT 100
        	")->fetchAll('assoc');
			$this->set("pageGallery", $pageGallery);
			//echo "<pre>"; print_r($pageGallery); echo "</pre>"; exit();
    }
	
	public function reviews()
    {						
		$conn = ConnectionManager::get('default');
		
		$siteComments = $conn->query("
						SELECT M.*, M.name as table_name,
							(SELECT name FROM osc_users WHERE id = M.user_id LIMIT 1) as name
							FROM osc_site_comments as M
							WHERE M.block = 0
							ORDER BY M.dateCreate DESC
							LIMIT 1000
					")->fetchAll('assoc');
					$this->set("siteComments", $siteComments);
    }
}
