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
 
class ProjectsController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
	 
	protected function init(){
		return array();
    }
	 
    public function index()
    {						
		$conn = ConnectionManager::get('default');
		
		
		
		// FILTERS
		
		// DECLARING VARIABLES
        $num_pages = false;
        $projects = false;
        $init_arr = false;
        
		$filter_users = false;
		
		$filter_countries = false;
        $filter_chars = false;

        $ri = $_SESSION['ri'];
		
		$cur_page = 1;
		
		if (isset($_GET['page']) && $_GET['page'] > 0){
            $cur_page = $_GET['page'];
        }
		
		$filter_chars = array();
		$filterPrepare = array();
		
		$filterPrepare['sort_vector'] = "";
		$filterPrepare['filter_prods_by_page'] = 3;
		$filterPrepare['filters_1'] = ""; 
		$filterPrepare['filter_joins_1'] = "";
		$filterPrepare['sql_order_vector'] = " M.dateCreate ";
		$filterPrepare['and_colors_filter'] = "";
		
		$filterPrepare['checked_chars'] = array();
		$filterPrepare['charsList'] = array();
		
		$filterPrepare = $this->Help->filterProjectsPrepare();
 
		$projectsResult = $this->Help->getProjects(
			$cur_page,
			$filterPrepare['filter_prods_by_page'],
			$filterPrepare['filters_1'].
			$filterPrepare['and_colors_filter'], 
			$filterPrepare['filter_joins_1'], 
			$filterPrepare['sql_order_vector']
		);

		// debug($products_by_cat); exit();

		$projects = $projectsResult['items'];
		$num_pages = $projectsResult['rows']['rows'] / PROJECTS_QTY;
		
		// PAGINATION
		
		$f_pag_lim = PROJECTS_QTY; // Количество проектов на странице
		$this->set("f_pag_lim", $f_pag_lim);

		$f_page_size = 5; // Максимальное количество отображаемых страниц в пагинации
		$this->set("f_page_size", $f_page_size);
		
		$f_page_num = (isset($_GET['page']) ? (int)$_GET['page'] : 1); // Текущая страница пагинации
		$this->set("f_page_num", $f_page_num);
		
		$f_total_rows = $projectsResult['rows']['rows']; // сохраняем общее количество товаров в категории
		$this->set("f_total_rows", $f_total_rows);
	
		$f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
		$this->set("f_pages_count", $f_pages_count);
		
		// CHARS
		
		$filter_chars = $this->Help->getProjectsChars();
		
		// debug($filter_chars);
		
		// Calculate count for products table filters
				
		$projectsTableFilters = [
			'user_id' 	=> $this->Help->getUniUsersForProjects()
		]; 
		
		 
		// Get filters from SESSION
		 
		$post_filter = ( isset($_SESSION['projects_filter']) ? $_SESSION['projects_filter'] : [] );
				
		$filters_xf      = $filterPrepare['filters_1'];
		$filter_joins_xf = $filterPrepare['filter_joins_1']; 
		
		foreach($projectsTableFilters as $xf_name => &$xf_list_item)
		{
			foreach($xf_list_item as $xfi => $x_item)
			{
				$xf_list_item[$xfi]['ref_md5'] = md5( $xf_name.$x_item['id'] . trim(mb_strtolower($x_item['name'])) );
				
				$xf_list_item[$xfi]['count'] = 0;
				
				$currXfCountResult = $this->Help->countProjectsXFilterValues(['name'=>$xf_name, 'id'=>$x_item['id']], $filters_xf, $filter_joins_xf);  
				// Количество товаров учитывая все фильтры по заданному field_id в таблице Products
			
				if($currXfCountResult) $xf_list_item[$xfi]['count'] = $currXfCountResult['count'];
			}
		}          

		// echo "<pre>"; print_r($projectsTableFilters); echo "</pre>"; exit();
		
		 $this->set(array(
                    	'projectsList'			=> $projects,
						'filter_chars' 			=> $filter_chars,
						
						'filter_users' 			=> $projectsTableFilters['user_id'],
						'checked_users' 		=> $filterPrepare['users'],
						
						'ri_url' 				=> RS.LANG."/projects/",
						
						'checked_chars' 		=> $filterPrepare['checked_chars'],
                    	'charsList' 			=> $filterPrepare['charsList'],
						'sort_vector' 			=> $filterPrepare['sort_vector'],
                    	'filter_prods_by_page' 	=> $filterPrepare['filter_prods_by_page']
					)
				);
    }
	
	public function filter(){
        if ($this->request->is('ajax')) {
            $response = $this->Help->filterProjects();
            echo json_encode($response); exit();
        }
    }  
	
	public function project()
    {						
		$conn = ConnectionManager::get('default');
		
		$project = $conn->query("
            SELECT  P.id, P.user_id, P.".LANG_PREFIX."name as name, P.alias, P.".LANG_PREFIX."content as content, P.".LANG_PREFIX."meta_title as meta_title, P.".LANG_PREFIX."meta_keys as meta_keys, P.".LANG_PREFIX."meta_desc as meta_desc,
			(SELECT crop FROM osc_project_files_ref WHERE `ref_id` = P.id ORDER BY `id` LIMIT 1) as crop,
			(SELECT file FROM osc_project_files_ref WHERE `ref_id` = P.id ORDER BY `id` LIMIT 1) as img,
			(SELECT title FROM osc_project_files_ref WHERE `ref_id` = P.id ORDER BY `id` LIMIT 1) as title,
			(SELECT id FROM osc_users WHERE `id` = P.user_id LIMIT 1) as worker_id,
			(SELECT alias FROM osc_users WHERE `id` = P.user_id LIMIT 1) as worker_alias,
			(SELECT ".LANG_PREFIX."name FROM osc_users WHERE `id` = P.user_id LIMIT 1) as worker_name,
			(SELECT ".LANG_PREFIX."fname FROM osc_users WHERE `id` = P.user_id LIMIT 1) as worker_fname,
			(SELECT ".LANG_PREFIX."position FROM osc_users WHERE `id` = P.user_id LIMIT 1) as worker_position
			FROM osc_projects as P
			WHERE P.block = 0
			AND  P.alias = '".LA."'
			LIMIT 1
        	")->fetch('assoc');
		$this->set("project", $project);
		//echo "<pre>"; print_r($project); echo "</pre>"; exit();
		
		$wId = $project['worker_id'];
		$this->set("wId", $wId);
			
		$prjId = $project['id'];
			
			
		$projectGal = $conn->query("
			SELECT R.file, R.crop, R.title
						FROM osc_project_files_ref as R 
						WHERE R.ref_id = $prjId
						LIMIT 100
		")->fetchAll('assoc');
		$this->set("projectGal", $projectGal);
		//echo "<pre>"; print_r($projectGal); echo "</pre>";  exit();
		
		$projectName 	= (isset($project['name']) ? $project['name'] : "");	
		
		$metaTitle = $projectName." - Comodo";
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
    }
}
