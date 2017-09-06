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
class LikedController extends AppController
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
		
		$likeList =  $conn->query("
					SELECT C.* , 
						(SELECT ".LANG_PREFIX."name FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as name,
						(SELECT alias FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as alias,
						(SELECT sale FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as sale,
						(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as price,
						(SELECT ".RATE_PREFIX."sale_price FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as sale_price,
						(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_img1,
						(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id DESC LIMIT 1) as prod_img2,
						(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = C.prod_id AND  group_id = '6' LIMIT 1) as sale_id,
						(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = C.prod_id AND  group_id = '1' LIMIT 1) as new_id,
						(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = C.prod_id AND  group_id = '7' LIMIT 1) as delivery
						FROM osc_shop_like as C
						WHERE C.uid = '".UID."' AND
						C.session_id='".SESID."'
						ORDER BY id DESC
					")->fetchAll('assoc');
		$this->set("likeList", $likeList);// Список товаров в избранном
		
		//echo "<pre>"; print_r($likeList); echo "</pre>"; exit();


		
    }
}
