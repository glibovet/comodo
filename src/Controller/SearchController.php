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
 
class SearchController extends AppController
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
		
		$search_val = SEARCH;
		$search_query = (isset($search_val) ? strip_tags(trim($search_val)) : "");
		
		
		if (!$search_query){$searchProds = array(); $this->set("searchProds", $searchProds);}
		else {
		$searchProds = $conn->query("
			SELECT M.id, M.".LANG_PREFIX."name as name, M.".RATE_PREFIX."price as price, M.".RATE_PREFIX."sale_price as sale_price, M.alias, MF.".LANG_PREFIX."name as mf_name,
						(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=M.obj_id AND id!=0 LIMIT 1) as obj_name,
						(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '6' LIMIT 1) as sale_id,
						(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '1' LIMIT 1) as new_id,
						(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '7' LIMIT 1) as delivery,
						(SELECT id FROM osc_shop_like WHERE `session_id` = '".SESID."' AND `uid` = '".UID."' AND `prod_id` = M.id ORDER BY `id` LIMIT 1) as prod_like,
						(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=M.id ORDER BY id LIMIT 1 ) as img
						FROM osc_shop_products as M 
						LEFT JOIN osc_shop_mf AS MF on MF.id = M.mf_id							
						WHERE M.block=0  AND 
						( ( M.".LANG_PREFIX."name LIKE'%$search_query%') OR (M.id='$search_query') OR (M.sku='$search_query') ) OR ( MF.".LANG_PREFIX."name LIKE'%$search_query%')
						ORDER BY M.".RATE_PREFIX."price
						LIMIT 100
		")->fetchAll('assoc');
		$this->set("searchProds", $searchProds);
		}
		
		if (!$search_query){$searchArticles = array(); $this->set("searchArticles", $searchArticles);}
		else {
		$searchArticles = $conn->query("
			SELECT SQL_CALC_FOUND_ROWS M.*,
					Extract(MONTH from M.dateCreate ) AS mm,
					Extract(day from M.dateCreate ) AS dd,
					Extract(YEAR from M.dateCreate ) AS yy,					
					".LANG_PREFIX."name as name, 
					".LANG_PREFIX."content as content,
					(SELECT COUNT(id) FROM osc_article_comments WHERE `block`=0 AND `art_id`=M.id) as comm_count,
					(SELECT alias FROM osc_categories WHERE `id`=M.cat_id) as cat_alias
					FROM osc_articles as M
					WHERE `block`=0 AND 
					( ( M.".LANG_PREFIX."name LIKE'%$search_query%') OR (M.".LANG_PREFIX."content LIKE'%$search_query%') )
					ORDER BY M.dateCreate
					LIMIT 100
		")->fetchAll('assoc');
		$this->set("searchArticles",  $searchArticles);
		}
		
		/*echo "<pre>"; print_r($searchProds); echo "</pre>";
		echo "<pre>"; print_r($searchArticles); echo "</pre>";  exit();*/
		

    }
}
