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
 
class ContactsController extends AppController
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
		
		$contactsData = $conn->query(
					"
					SELECT ".LANG_PREFIX."city as city, ".LANG_PREFIX."adress as adress, ".LANG_PREFIX."work_time as work_time, ".LANG_PREFIX."sat_time as sat_time, ".LANG_PREFIX."sun_time as sun_time, email, phone_number, map_frame
						FROM osc_contacts
						WHERE block = '0'
						ORDER BY order_id
						LIMIT 20
					"
					)->fetchAll('assoc');
		$this->set("contactsData", $contactsData);// Данные контактов сайта
		//echo "<pre>"; print_r($contactsData); echo "</pre>";  exit();
		
		$metaTitle = "Контакты";	
		if (LANG_PREFIX == "ua_") {$metaTitle 	= "Контакти";}	
		if (LANG_PREFIX == "en_") {$metaTitle 	= "Contacts";}	
		$this->set("metaTitle", $metaTitle);// title страницы		
		
		$metaKeys = "";
		$this->set("metaKeys", $metaKeys);//keywords страницы
		
		$metaDesc = "";
		$this->set("metaDesc", $metaDesc);//description страницы	
		

    }
}
