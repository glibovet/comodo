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
class CartController extends AppController
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
		
		$payments =  $conn->query(
					"
					SELECT id, ".LANG_PREFIX."name as name
						FROM osc_shop_payment_methods
						ORDER BY id
					"
					)->fetchAll('assoc');
		$this->set("payments", $payments);// Список способов оплаты
		
		$deliveries =  $conn->query(
					"
					SELECT id, ".LANG_PREFIX."name as name, ".RATE_PREFIX."price as price
						FROM osc_shop_delivery_methods
						ORDER BY id
					"
					)->fetchAll('assoc');
		$this->set("deliveries", $deliveries);// Список способов доставки
		
		
		$userInfo =  $conn->query(
					"
					SELECT login, phone, name, lname, delivery_address
						FROM osc_users
						WHERE block = '0' AND
							id = '".UID."'
						LIMIT 1
					"
					)->fetch('assoc');
		$this->set("userInfo", $userInfo);// Данные по заказчику	
		//echo "<pre>"; print_r($userInfo); echo "</pre>"; exit();
		
		$cartList =  $conn->query(
			"
			SELECT C.*, P.".LANG_PREFIX."name as prod_name, P.alias as prod_alias, P.sku as prod_sku, P.".RATE_PREFIX."price as prod_price, P.width as prod_width, P.height as prod_height, P.depth as prod_depth,
				(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_crop, 
				(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_name, 
				(SELECT ".LANG_PREFIX."name FROM osc_shop_colors WHERE id=P.color_id AND id!=0 LIMIT 1) as color,
				(SELECT value FROM osc_shop_colors WHERE id=P.color_id LIMIT 1) as color_val, 
				(SELECT ".LANG_PREFIX."country FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_country,
				(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=P.obj_id AND id!=0 LIMIT 1) as obj_name
				FROM osc_shop_cart as C
				LEFT JOIN `osc_shop_products` as P ON P.id=C.prod_id
				WHERE C.uid = '".UID."' AND
				C.session_id='".SESID."'
				ORDER BY dateModify
			"
			)->fetchAll('assoc');
			
		foreach ($cartList as &$cartRefChar){
			
		$cartChars = unserialize($cartRefChar['ref_chars']);
		$cartRefChar['chars'] = [];
			foreach ($cartChars as $char){
				$refChar = $conn->query("
				SELECT M.char_id, C.".LANG_PREFIX."name as char_name, V.".LANG_PREFIX."value as char_value
							FROM osc_shop_chars_prod_ref as M 
							LEFT JOIN `osc_shop_chars` as C ON C.id=M.char_id
							LEFT JOIN `osc_shop_chars_values` as V ON V.id=M.val_id
							WHERE M.id=".$char."
							LIMIT 1
				")->fetch('assoc');
				array_push($cartRefChar['chars'], $refChar);
			}
		}
		$this->set("cartList", $cartList);// Список товаров в корзине
				
		//echo "<pre>"; print_r($cartList); echo "</pre>"; exit();


		
    }
}
