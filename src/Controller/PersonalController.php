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
 
class PersonalController extends AppController
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
				
		$userInfo =  $conn->query("
					SELECT login, phone, name, lname, delivery_address, newsletter
						FROM osc_users
						WHERE block = '0' AND
							id = '".UID."'
						LIMIT 1
					"
					)->fetch('assoc');
		$this->set("userInfo", $userInfo);// Данные по заказчику		
		
		//echo "<pre>"; print_r($userInfo); echo "</pre>"; exit();
		
		$userOrders =  $conn->query("
						SELECT M.id, M.products, M.dateCreate, M.status, M.paid_status,
						(SELECT name FROM osc_shop_order_statuses WHERE id=M.status LIMIT 1) as order_status
						FROM osc_shop_orders as M
						WHERE M.user_id='".UID."'
						GROUP BY id DESC
						LIMIT 500"
					)->fetchAll('assoc');
		$this->set("userOrders", $userOrders);// Данные по заказам
		
		//echo "<pre>"; print_r($userOrders); echo "</pre>"; exit();

    }
	
	 public function order()
    {						
		$conn = ConnectionManager::get('default');	
		
		$order_id = (LA - 5000);
		
		$order =  $conn->query("
						SELECT M.*,
						(SELECT name FROM osc_shop_order_statuses WHERE id=M.status LIMIT 1) as order_status
						FROM osc_shop_orders as M
						WHERE M.id='$order_id'
						LIMIT 1"
					)->fetch('assoc');
		$this->set("order", $order);// Данные по заказу
		
		//echo "<pre>"; print_r($order); echo "</pre>"; exit();
		

    }
}
