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

class HelpfulController extends AppController
{
	
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
	public function faq()
    {					
		$conn = ConnectionManager::get('default');
		
		$faqInfo = $conn->query("
            SELECT ".LANG_PREFIX."question as question, 
					".LANG_PREFIX."answer as answer
			FROM osc_faq
			WHERE `block` = 0
			ORDER BY `order_id` 
			LIMIT 1000
        	")->fetchAll('assoc');
			$this->set("faqInfo", $faqInfo);
			
		
		$faqName = $conn->query("
			SELECT  ".LANG_PREFIX."name as name FROM osc_menu WHERE `alias` = '".LA."' LIMIT 1
		")->fetch('assoc');
		$pName = $faqName['name'];
		$this->set("pName", $pName);
	}
	 
    public function index()
    {					
		$conn = ConnectionManager::get('default');		
		
		if ( LA == "helpful-info" )
		{
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: ".RS."helpful-info/faq/"); 
			exit();
		}
		else
		{
			$helpfulInfo = $conn->query("
            SELECT  id, ".LANG_PREFIX."name as name, ".LANG_PREFIX."details as details,  alias, filename, script_name, gallery_id 
			FROM osc_menu
 			WHERE `alias` = '".LA."' 
			ORDER BY `id` 
			LIMIT 1
        	")->fetch('assoc');
			$this->set("helpfulInfo", $helpfulInfo);
			
			$pageGalId = $helpfulInfo['gallery_id'];
			
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
            SELECT  crop, file 
			FROM osc_files_ref
 			WHERE `ref_id` = '$galId' AND
			`ref_table` = 'galleries'
			ORDER BY `id` 
			LIMIT 100
        	")->fetchAll('assoc');
			$this->set("pageGallery", $pageGallery);
			
			
		}
		
	}
}
