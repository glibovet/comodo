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

class AjaxController extends AppController
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
		
		$response = ['status'=>'failed', 'message'=>'404 Error'];
		
		if($_POST)
		{
			if(isset($_POST['action']))
			{
				switch($_POST['action'])
				{
					case 'catalogFilter':{
						
						//====================================================================================================
						// POST PARAMS
						
						$cat_id = (int)$_POST['cat_id'];
						
						// $this->request->session()->write('prods_filter',['test']);
						
						if(!isset($_SESSION['prods_filter'])) $_SESSION['prods_filter'] = array();
						if(!isset($_SESSION['prods_filter'][$cat_id])) $_SESSION['prods_filter'][$cat_id] = array( 'price'=>[], 'filter'=>[], 'colors'=>[], 'materials'=>[] );
						
						// $curr_link = strip_tags(trim($_POST['curr_link']));
						
						$price_min  = (int)$_POST['priceMin'];
						$price_max  = (int)$_POST['priceMax'];
						
						//****************************************************************************************
						//
						// SESSION WRITE START
						//
						//****************************************************************************************
						
							// PRICE
							
							$this->request->session()->write('prods_filter.'.$cat_id.'.price', ['min'=>$price_min, 'max'=>$price_max]);
							
							// FILTERS
							
							if(isset($_POST['filter']))
							{
								$this->request->session()->write('prods_filter.'.$cat_id.'.filter', $_POST['filter']);
							}else
							{
								$this->request->session()->write('prods_filter.'.$cat_id.'.filter', []);
							}
							
							// COLORS
						
							if(isset($_POST['colors']))
							{
								$this->request->session()->write('prods_filter.'.$cat_id.'.colors', $_POST['colors']);
							}else
							{
								$this->request->session()->write('prods_filter.'.$cat_id.'.colors', []);
							}
							
							// MATERIALS
						
							if(isset($_POST['materials']))
							{
								$this->request->session()->write('prods_filter.'.$cat_id.'.materials', $_POST['materials']);
							}else
							{
								$this->request->session()->write('prods_filter.'.$cat_id.'.materials', []);
							}
						
						//****************************************************************************************
						//
						// SESSION WRITE END
						//
						//****************************************************************************************
						
						$response['status'] = "success";
						$response['message'] = "Grate request!";
						
						break;
						}
					case 'clearFilter':{
							if(isset($_SESSION['prods_filter'])){
									$_SESSION['prods_filter'] = array();
								}
						
							$response['status'] = "success";
							$response['message'] = "Filter has been cleared!";
							
							break;
						}
					default:{
						$response['message'] = "Current action does not identity!";
						}
				}
			}
		}
		
		echo json_encode($response); 
		exit();
    }
	
	/// ADD TO ViEWED	
	public function viewed()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$p_id 			= (int)$_POST['prod_id'];
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];	
		
		$existingProd = $conn->query(
		"
		SELECT id
				FROM osc_shop_viewed
				WHERE `uid`='$user_id'				
				AND  `session_id`='$session_id'
				AND `prod_id`=$p_id
				ORDER BY id
				LIMIT 1
		"
		)->fetch('assoc');
		
		$existProds = $conn->query(
		"
		SELECT id
				FROM osc_shop_viewed
				WHERE `uid`='$user_id'				
				AND  `session_id`='$session_id'
				ORDER BY id
				LIMIT 20
		"
		)->fetchAll('assoc');
		
		$existId = $existProds[0]['id'];
		
		if(!$existingProd)
		{
			if($existProds && count($existProds) >=16)
			{
				$delProd = $conn->query("
				DELETE FROM osc_shop_viewed
				WHERE id='$existId'
				LIMIT 1
					"
					);	
				
			}
			
			$eddProd = $conn->query("
					INSERT INTO osc_shop_viewed  (uid, session_id, prod_id) 
							 VALUES 
							 ('$user_id', '$session_id', '$p_id')
					"
					);
			
			if(isset($eddProd))
			{
				$data['status'] = "success"; 			
				if (LANG_PREFIX == '') { $data['message'] = "Добавлен в просмотренные";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Додано в переглянуті";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Added to viewed";}
			}
			
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	
	/// ADD TO CART	
	public function toCart()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$p_id 			= (int)$_POST['prod_id'];	
		$chars 			= (isset($_POST['char']) ? $_POST['char'] : 0);
		$qty 			= (isset($_POST['qty']) ? (int)$_POST['qty'] : 1);		
		$date 			= date("Y-m-d H:i:s", time());	
		
		$ref_chars = "a:0:{}";
		if($chars) {$ref_chars = serialize ($chars);}		
		//"<pre>"; print_r($ref_chars); echo "</pre>"; exit();
		
		$data = ['status'=>'failed','message'=>'',];
		
		$cartQty = "0";
		$cartSum = "0";
		$prodSum = "0";
		$open_modal = "#";	
		$open_order = "#";
		
		if ($p_id){
			$existingProd = $conn->query(
			"
			SELECT id, quant
					FROM osc_shop_cart
					WHERE `uid`='$user_id'				
					AND  `session_id`='$session_id'
					AND `prod_id`=$p_id
					ORDER BY id DESC
					LIMIT 1
			"
			)->fetch('assoc');
			
			if($existingProd)
			{	
					$quant=$qty+$existingProd['quant'];
					
			
					$updateProd = $conn->query(
					"
					UPDATE osc_shop_cart
						SET `quant`='$quant'
						WHERE `uid`='$user_id' 
						AND `session_id`='$session_id'
						AND `prod_id`=$p_id
					"
					);
			
			}
			else
			{
				$eddProd = $conn->query("
					INSERT INTO osc_shop_cart  (uid, session_id, prod_id, quant, ref_chars, dateCreate, dateModify) 
							 VALUES 
							 ('$user_id', '$session_id', '$p_id', '$qty', '$ref_chars', '$date', '$date')
					"
					);		
									
			}
			
			if(isset($eddProd) || isset($updateProd))
				{					
				$data['status'] = "success"; 
				
				if (LANG_PREFIX == '') { $data['message'] = "Товар добавлен в корзину";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Product added to cart";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Товар додано в кошик";}
				
				$countQuery = $conn->query(
						"
						SELECT 
								SUM(quant) as cart_quant
								FROM osc_shop_cart
								WHERE uid='$user_id' 
								AND `session_id`='$session_id'
						"
						)->fetch('assoc');
				//echo "<pre>"; print_r($countQuery); echo "</pre>"; exit();
				
				if ($countQuery['cart_quant']) {
					$cartQty = $countQuery['cart_quant'];
					$open_modal = "#modal-4"; 
					$open_order = "/cart/";
					}
				
				$cartList =  $conn->query(
					"
					SELECT C.*, 
					(SELECT ".LANG_PREFIX."name FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_name,
					(SELECT alias FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_alias,
					(SELECT sku FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_sku,
					(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_price,
					(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_crop
					FROM osc_shop_cart as C
					WHERE C.uid = '".UID."' AND
					C.session_id='".SESID."'
					ORDER BY dateModify
					"
					)->fetchAll('assoc');
				$this->set("cartList", $cartList);// Список товаров в корзине
				//echo "<pre>"; print_r($cartList); echo "</pre>"; exit();
				
				foreach ($cartList as $cart){
					$prodSum = $cart['quant']*$cart['prod_price'];
					$cartSum += $prodSum;
					}
					
				$formatCartSum = number_format($cartSum, 0, '.', '.');	
				
			
				$data['total_quant'] = $cartQty;				
				$data['total_sum'] 	 = $formatCartSum;
				$data['open_modal'] = $open_modal;
				$data['open_order'] = $open_order;				
				
				
				ob_start();
				
				foreach ($cartList as $cartItem) { 
						$formatProdPrice = number_format($cartItem['prod_price'], 0, '.', '.');?>
                        
						<div class="header__notebook-baner-item" id="cart-item-<?= $cartItem['id'] ?>">
                            <a class="hcart_img" href="<?= RS.LANG ?>/catalog/product/<?= $cartItem['prod_alias'] ?>/">
                                <img src="<?=IMG?>split/files/shop/products/crop/<?= $cartItem['prod_crop']?>" alt="<?= $cartItem['prod_name'] ?>">
                            </a>
							<div class="header__notebook-baner-text">
                                <p class="header__notebook-baner-caption">
                                    <a class="hcart_img" href="<?= RS.LANG ?>/catalog/product/<?= $cartItem['prod_alias'] ?>/">
                                        <?= $cartItem['prod_name'] ?>
                                    </a>
                                </p>
                                <p class="header__notebook-baner-count"><?= $cartItem['quant'] ?> шт</p>
                            </div>
						</div>
				<?php }
				$data['fastCartHtml'] = ob_get_contents();
				
				ob_end_clean();
				
		}

		}else{
			if (LANG_PREFIX == '') { $data['message'] = "Товар не найден";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Товар не знайдено";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Product not found";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	
	/// CHANGE PROD QTY
	public function prodQty()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'','total_sum'=>'0'];
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$item_id 		= (int)$_POST['item_id'];		
		$prod_id 		= (int)$_POST['prod_id'];
		$qty			= $_POST['qty'];
		
		$prod_sum = 0;
		$total_sum = 0;
		
		$updateProd = $conn->query(
				"
				UPDATE osc_shop_cart
					SET `quant`='$qty'
					WHERE `uid`='$user_id' 
					AND `session_id`='$session_id'
					AND `id`=$item_id
				"
				);
				
		if(isset($updateProd))
		{			
			$countQuery = $conn->query(
					"
					SELECT 
							SUM(quant) as cart_quant,
							(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE id='$prod_id' LIMIT 1) as prod_price
							FROM osc_shop_cart
							WHERE uid='$user_id' 
							AND session_id='$session_id'
									 "
					)->fetch('assoc');
					
					
		
			$data['total_quant'] = $countQuery['cart_quant'];
			
			$prod_sum = $countQuery['prod_price']*$qty;
			$prodSum = number_format($prod_sum, 0, '.', ' ');
			$data['prod_sum'] = $prodSum;
			
			$prodsPrices = $conn->query(
					"
					SELECT 
							C.quant, C.prod_id,
							(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as price
							FROM osc_shop_cart as C
							WHERE C.uid='$user_id' 
							AND C.session_id='$session_id'
									 "
					)->fetchall('assoc');
			
				
			foreach ($prodsPrices as $prods){		
				$p_sum = $prods['price']*$prods['quant'];
				$total_sum += $p_sum;			
			}
			
			$totalSum = number_format($total_sum, 0, '.', '.');
			$data['total_sum'] = $totalSum;
			//echo "<pre>"; print_r($data['total_sum']); echo "</pre>"; exit();	
			
			$data['status'] = "success"; 
			if (LANG_PREFIX == '') { $data['message'] = "Количество изменено";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Quantity changed";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Кількість змінено";}
		}
		else {
			if (LANG_PREFIX == '') { $data['message'] = "Не удалось изменить количество";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to change the quantity";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося змінити кількість";}
			}		
			
	echo json_encode($data);
	exit(); 
	}
	
	
	/// DELETE PROD FROM CART
	public function delCartProd()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'','total_sum'=>'0'];
		
		$open_modal = "#";
		$open_order = "#";
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$item_id 		= (int)$_POST['item_id'];
		
		$prod_sum = 0;
		$total_sum = 0;		
		$total_qty = 0;
		$fastCartHtml = "Ваша корзина пуста";
		$open_modal = "#";
		$open_order = "#";
		
		$delateProd = $conn->query(
				"
				DELETE FROM osc_shop_cart
					WHERE `id`='$item_id' AND
					uid='$user_id' 
					AND `session_id`='$session_id'
				"
				);
				
		if(isset($delateProd))
		{			
			$countQuery = $conn->query(
					"
					SELECT 
							SUM(quant) as cart_quant
							FROM osc_shop_cart
							WHERE uid='$user_id' 
							AND `session_id`='$session_id'
					"
					)->fetch('assoc');
					
			if ($countQuery['cart_quant']) { $total_qty = $countQuery['cart_quant']; $fastCartHtml = ""; $open_modal = "#modal-4"; $open_order = "/cart/";}
		
			$data['total_quant'] = $total_qty;
			$data['fastCartHtml'] = $fastCartHtml;
			$data['open_modal'] = $open_modal;
			$data['open_order'] = $open_order;
			
			$prodsPrices = $conn->query(
					"
					SELECT 
							C.quant, C.prod_id,
							(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as price
							FROM osc_shop_cart as C
							WHERE C.uid='$user_id' 
							AND C.session_id='$session_id'
									 "
					)->fetchall('assoc');
			
				
			foreach ($prodsPrices as $prods){		
				$p_sum = $prods['price']*$prods['quant'];
				$total_sum += $p_sum;			
			}
			
			$totalSum = number_format($total_sum, 0, '.', '.');
			$data['total_sum'] = $totalSum;
			//echo "<pre>"; print_r($data['total_sum']); echo "</pre>"; exit();	
			
			$data['status'] = "success"; 
			if (LANG_PREFIX == '') { $data['message'] = "Товар удален";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Товар видалено";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Product deleted";}
		}
		else {
			if (LANG_PREFIX == '') { $data['message'] = "Не удалось удалить товар";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося знайти товар";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Could not delete item";}
			}		
			
	echo json_encode($data);
	exit(); 
	}
	
	
	/// DELETE PROD FROM CART	
	public function cartProdComment()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'','total_sum'=>'0'];
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$item_id 		= (int)$_POST['item_id'];
		$comment 		= strip_tags(str_replace("'","\'",$_POST['comment']));
		
		
		$updateProd = $conn->query(
				"					
					UPDATE osc_shop_cart
					SET `comment`='$comment'
					WHERE id='$item_id' 
				"
				);
				
		if(isset($updateProd))
		{			
			$data['status'] = "success"; 
			if (LANG_PREFIX == '') { $data['message'] = "Комментарий добавлен";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Коментар додано";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Comment added";}
		}
		else {
			if (LANG_PREFIX == '') { $data['message'] = "Не удалось добавить комментарий";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося додати коментар";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Failed to add a comment";}
			}		
			
	echo json_encode($data);
	exit(); 
	}
	
	/// ADD NEW ORDER
	public function order()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$name			= strip_tags(str_replace("'","\'",$_POST['name']));
		$mail 			= strip_tags(str_replace("'","\'",$_POST['mail']));
		$phone 			= strip_tags(str_replace("_","",$_POST['phone']));
		$comment 		= strip_tags(str_replace("'","\'",$_POST['comment']));
		$pay_meth		=(isset($_POST['pay_meth']) ? (int)$_POST['pay_meth'] : 1);
		$delivery		=(isset($_POST['delivery']) ? (int)$_POST['delivery'] : 1);
		$address		=(isset($_POST['address']) ? strip_tags(str_replace("'","\'",$_POST['address'])) : 0);
		
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];		
		//echo "<pre>"; print_r(strlen($phone)); echo "</pre>"; exit();	
				
		
		$cartProds = $conn->query(
		"
		SELECT 	C.prod_id, C.quant, C.comment as prod_comment, C.ref_chars, P.name as prod_name, P.alias as prod_alias, P.sku as prod_sku, P.".RATE_PREFIX."price as prod_price, P.width as prod_width, P.height as prod_height, P.depth as prod_depth,
				(SELECT crop FROM osc_files_ref WHERE `ref_id` = C.prod_id AND `ref_table` = 'shop_products' ORDER BY `id` LIMIT 1) as img, 
				(SELECT name FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_name, 
				(SELECT name FROM osc_shop_colors WHERE id=P.color_id LIMIT 1) as color,
				(SELECT value FROM osc_shop_colors WHERE id=P.color_id LIMIT 1) as color_val, 
				(SELECT country FROM osc_shop_mf WHERE id=P.mf_id LIMIT 1) as mf_country,
				(SELECT name FROM osc_shop_objects WHERE id=P.obj_id LIMIT 1) as obj_name				
								
				FROM osc_shop_cart as C
				LEFT JOIN `osc_shop_products` as P ON P.id=C.prod_id
				
				WHERE C.uid='$user_id' 
				AND C.session_id='$session_id'
				ORDER BY C.id DESC
		"
		)->fetchAll('assoc');
		
		foreach ($cartProds as &$cartRefChar){
			
		$cartChars = unserialize($cartRefChar['ref_chars']);
		$cartRefChar['chars'] = [];
			foreach ($cartChars as $char){
				$refChar = $conn->query("
				SELECT M.char_id, C.name as char_name, V.value as char_value
							FROM osc_shop_chars_prod_ref as M 
							LEFT JOIN `osc_shop_chars` as C ON C.id=M.char_id
							LEFT JOIN `osc_shop_chars_values` as V ON V.id=M.val_id
							WHERE M.id=".$char."
							LIMIT 1
				")->fetch('assoc');
				array_push($cartRefChar['chars'], $refChar);
			}
		}		
		//echo "<pre>"; print_r($cartProds); echo "</pre>"; exit();	
				
		
		if($cartProds)
		{				
			if($name)
			{
			if(filter_var($mail,FILTER_VALIDATE_EMAIL))
			{	
			if(strlen($phone) ==17)
			{	
				$orderProds = serialize($cartProds);
				
		
				$insertProd = $conn->query(
				"
				INSERT INTO osc_shop_orders  (client_email, client_phone, client_name, type, author_id, user_id, status, paid_status, pay_method, delivery_method, delivery_address, details, products, dateCreate, dateModify) 
						 VALUES 
											('$mail', '$phone', '$name', 'internet-shop', '$user_id', '$user_id', '1', 'Не оплачен', '$pay_meth', '$delivery', '$address', '$comment', '$orderProds', '$date', '$date')
				"
				);
				
				
				$newOrderId = $insertProd->lastInsertId();
				
				//echo "<pre>"; print_r($orderProds); echo "</pre>"; exit();	
				
				if($insertProd)
				{	
					$delateFromCart = $conn->query(
					"
					DELETE FROM osc_shop_cart
						WHERE uid='$user_id'
						AND session_id='$session_id'
					"
					);
					
					$orderInfo = $conn->query(
					"
					SELECT *											
							FROM osc_shop_orders
							WHERE `id`='$newOrderId'
							LIMIT 1
					"
					)->fetch('assoc');
					
					$orderNum = 5000+$orderInfo['id'];
					$orderProducts = unserialize($orderInfo['products']);	
					//echo "<pre>"; print_r($orderProducts); echo "</pre>"; exit();	
					
					$orderSum = 0;
					
					$data['status'] = "success";
					
					if (LANG_PREFIX == '') { 
					$data['message'] .= "Номер заказа <strong>".$orderNum."</strong><br>";
					$data['message'] .= "Детали отправлены на Ваш e-mail</p>";
					}
					elseif (LANG_PREFIX == 'ua_') { 
					$data['message'] .= "Номер замовлення <strong>".$orderNum."</strong><br>";
					$data['message'] .= "Деталі надіслано на Ваш e-mail";
					}
					elseif (LANG_PREFIX == 'en_') { 
					$data['message'] .= "Order number <strong>".$orderNum."</strong><br>";
					$data['message'] .= "Details sent to your e-mail";
					}
						
					
					//Email посетителю
					$message = "";
					
					$to  = $mail; 
						$subject = "Заказ на COMODO № ".$orderNum."";
						$message .= ' 
						<html> 
						<head> 
						<title>Новый заказ на comodo.kiev.ua</title> 
						</head> 
						<body> 
						<p>Уважаемый пользователь</p>
						<p>Вы оформили заказ на нашем сайте <a href="http://comodo.kiev.ua/">comodo.kiev.ua</a></p>
						<h2 style="color: #686b60;">Номер заказа '.$orderNum.' </h2>
						
						<p style="font-size: 20px;line-height: 32px;text-indent: 20px;background: #cecece;">Данные по заказу:</p>
						<table width="100%" style="max-width:500px;">
						<tbody>';
						foreach ($orderProducts as $product)
						{
						$prodSum = $product['prod_price']*$product['quant'];
						$orderSum += $prodSum;
						$message .= '<tr>
										<td style="border-bottom: 1px solid #aaaaaa; vertical-align: top;">
											<img style="max-width: 210px; margin: 15px 10px 10px 0;" src="http://comodo.kiev.ua/img/split/files/shop/products/crop/'.$product['img'].'" alt="'.$product['prod_name'].'">
										</td>
										<td style="border-bottom: 1px solid #aaaaaa;; vertical-align: top;">
											<h3  style="color: #ef692a;"><a target="_blank" href="http://comodo.kiev.ua/catalog/product/'.$product['prod_alias'].'/">'.$product['obj_name'].' '.$product['prod_name'].'<a></h3> 
											<div style="line-height: 26px;"><strong  style="color: #ef692a;">'.$product['mf_name'].' - '.$product['mf_country'].'</strong></div>   
											<div></div>
											<div style="line-height: 26px;">Размер: <strong  style="color: #ef692a;">'.$product['prod_height'].' x '.$product['prod_width'].' x '.$product['prod_depth'].'</strong></div>
											<div style="line-height: 26px;">Цвет: <strong  style="color: #ef692a;">'.$product['color'].'</strong></div>';
											if ($product['chars']){
												foreach ($product['chars'] as $char){
									$message .= '<div style="line-height: 26px;">'.$char['char_name'].':  <strong  style="color: #ef692a;">'.$char['char_value'].'</strong></div>';	
												}
											}
											
											
								//$message .= '<div style="line-height: 26px;">Цена:  <strong  style="color: #ef692a;">'.$product['prod_price'].' UAH</strong></div>';
								$message .= '<div style="line-height: 26px;">Количество:  <strong  style="color: #ef692a;">'.$product['quant'].'</strong></div>    
											<div></div>';
								//$message .= '<div style="line-height: 46px;"><strong>СТОИМОСТЬ: <span style="color: #ef692a;">'.$prodSum.' UAH</span></strong></div>  <div></div>';
								$message .= '<div style="line-height: 46px;"><strong>Примечание: <span style="color: #ef692a;">'.$product['prod_comment'].'</span></strong></div>											
										</td>
									</tr>';									
						}
						$message .= '
						</tbody>
						</table>';
						//$message .= '<p style="font-size: 20px;line-height: 40px;text-indent: 20px;background: #cecece;"><strong>СУММА ЗАКАЗА: <span style="color: #ef692a;">'.$orderSum.' UAH</span></strong></p>	';					
						$message .= '<hr />							
						<p>Комментарий:  '.$comment.'</p>					
						<hr />
						<p><strong>В ближайшее время с Вами свяжется наш менеджер.</strong></p>
						<p><strong>Спасибо, что выбрали нас.</strong></p>
						<hr />
						</body> 
						</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".SHOPMAIL." <".SHOPMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
						
						//Email администратору
						$message = "";						
						$orderSum = 0;						
						
						$to  = SHOPMAIL; 
							$subject = "Новый заказ на COMODO № ".$orderNum."";
							$message .= ' 
							<html> 
							<head> 
							<title>Новый заказ на comodo.kiev.ua</title> 
							</head> 
							<body> 
							<p>Оформлен заказ на сайте <a href="http://comodo.kiev.ua/">comodo.kiev.ua</a></p>						
							<hr />
							<p>На имя:<strong> '.$name.'</strong></p>
							<p>Email: <strong> '.$mail.'</strong></p>
							<p>Тел.: <strong> '.$phone.'</strong></p>
							<h2 style="color: #686b60;">Номер заказа '.$orderNum.' </h2>
							
							<p style="font-size: 20px;line-height: 32px;text-indent: 20px;background: #cecece;">Данные по заказу:</p>
							<table width="100%" style="max-width:500px;">
							<tbody>';
							foreach ($orderProducts as $product)
							{
							$prodSum = $product['prod_price']*$product['quant'];
							$orderSum += $prodSum;
							$message .= '<tr>
											<td style="border-bottom: 1px solid #aaaaaa; vertical-align: top;">
												<img style="max-width: 210px; margin: 15px 10px 10px 0;" src="http://comodo.kiev.ua/img/split/files/shop/products/crop/'.$product['img'].'" alt="'.$product['prod_name'].'">
											</td>
											<td style="border-bottom: 1px solid #aaaaaa; vertical-align: top;">
												<h3  style="color: #ef692a;"><a target="_blank" href="http://comodo.kiev.ua/catalog/product/'.$product['prod_alias'].'/">'.$product['obj_name'].' '.$product['prod_name'].'<a></h3> 
												<div style="line-height: 26px;"><strong  style="color: #ef692a;">'.$product['mf_name'].' - '.$product['mf_country'].'</strong></div>   
												<div></div>
												<div style="line-height: 26px;">Размер: <strong  style="color: #ef692a;">'.$product['prod_height'].' x '.$product['prod_width'].' x '.$product['prod_depth'].'</strong></div>
												<div style="line-height: 26px;">Цвет: <strong  style="color: #ef692a;">'.$product['color'].'</strong></div>';
												if ($product['chars']){
													foreach ($product['chars'] as $char){
										$message .= '<div style="line-height: 26px;">'.$char['char_name'].':  <strong  style="color: #ef692a;">'.$char['char_value'].'</strong></div>';	
													}
												}
												
												
										//$message .= '<div style="line-height: 26px;">Цена:  <strong  style="color: #ef692a;">'.$product['prod_price'].' UAH</strong></div>';
										$message .= '<div style="line-height: 26px;">Количество:  <strong  style="color: #ef692a;">'.$product['quant'].'</strong></div>    
													<div></div>';
										//$message .= '<div style="line-height: 46px;"><strong>СТОИМОСТЬ: <span style="color: #ef692a;">'.$prodSum.' UAH</span></strong></div>  <div></div>';
										$message .= '<div style="line-height: 46px;"><strong>Примечание: <span style="color: #ef692a;">'.$product['prod_comment'].'</span></strong></div>		
											</td>
										</tr>';									
							}
							$message .= '
							</tbody>
							</table>';
							//$message .= '<p style="font-size: 20px;line-height: 40px;text-indent: 20px;background: #cecece;"><strong>СУММА ЗАКАЗА: <span style="color: #ef692a;">'.$orderSum.' UAH</span></strong></p>	';					
							$message .= '<hr />							
							<p>Комментарий пользователя:  '.$comment.'</p>
							</body> 
							</html>';
		
							$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
							$headers .= "From: ".SHOPMAIL." <".SHOPMAIL.">\r\n"; 
		
							mail($to, $subject, $message, $headers);
								
					
				}
				else
				{	
					if (LANG_PREFIX == '') { $data['message'] = "Не удалось создать заказ";}
					elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося створити замовлення";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to create order";}
				}			
			}
			else
			{	
				if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Телефон*</span>";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Телефон*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Phone*</span> is not filled";}
			}			
			}
			else
			{	
				if (LANG_PREFIX == '') { $data['message'] = "Введите действующий <span>Email*</span>";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Введіть дійсний <span>Email*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter a valid <span>Email*</span>";}
			}			
			}
			else
			{	
				if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Имя*</span>";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Ім'я*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Name*</span> is not filled.";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "Не удалось найти выбранные товары";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося знайти обрані товари";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Could not find selected products";}
		}
			
	echo json_encode($data);
	exit();
		
	}	
	
	/// CHANGE MF LIST	
	public function cahangeMfList()
    {
		$conn = ConnectionManager::get('default');
		
		
		$letter = strip_tags(str_replace("'","\'",$_POST['letter']));
		//"<pre>"; print_r($letter); echo "</pre>"; exit();
		
		$data = ['status'=>'failed','message'=>''];
		
		if ($letter){
			
			$letterMf = $conn->query("
						SELECT M.id, M.".LANG_PREFIX."name as name, M.alias, M.filename, M.crop as logo
						FROM osc_shop_mf as M
						WHERE M.block=0	 AND
						SUBSTRING(M.".LANG_PREFIX."name, 1, 1) = '$letter'
						ORDER BY M.".LANG_PREFIX."name	
						LIMIT 1000
					")->fetchAll('assoc');
					
			foreach ($letterMf as &$mf_let){			
				$mf_let['objects'] = $conn->query("
				SELECT O.".LANG_PREFIX."name as name
							FROM osc_shop_products as P 
							LEFT JOIN osc_shop_objects as O ON O.id=P.obj_id
							WHERE P.mf_id='".$mf_let['id']."'
							AND  P.block=0
							GROUP BY P.obj_id
							ORDER BY O.".LANG_PREFIX."name
							LIMIT 300
				")->fetchAll('assoc');			
			}
					
			$this->set("letterMf", $letterMf);
			//"<pre>"; print_r($letterMf); echo "</pre>"; exit();
			
			if($letterMf)
			{				
				$mfQty = count($letterMf);
				
				$data['status'] = "success"; 			
				$data['mf_qty'] = $mfQty;				
				
				
				ob_start();?>
                <div class="container">
                     <div class="factories__list four-column">
				
				<?php foreach ($letterMf as $mf) {?>
                        <a href="<?=RS.LANG?>/fabriki/<?=$mf['alias']?>/" class="factories__item">
                            <?php if ($mf['filename']){?>
                            	<img src="<?=RS?>img/split/files/content/crop/<?= $mf['logo']?>" alt="<?= $mf['name']?>_logo" class="factories__logo">
                            <?php }
							else {?>
                            	<img src="<?=RS?>img/noimage.png" alt="<?= $mf['name']?>_logo" class="factories__logo">
							<?php }?>
                            <p class="factories__item-caption"><?= $mf['name']?></p>
                            <hr>
                            
                            <?php if($mf['objects']){?>
                            <ul>
                                <?php foreach ($mf['objects'] as $obj) {?>
                                	<li><?= $obj['name']?></li>
                                <?php }?>
                            </ul>
                            <?php }?>
                        </a>
				<?php }?>
				
                    </div>
                </div>
				
				<?php  
				$data['fastMfHtml'] = ob_get_contents();
				
				ob_end_clean();
				
			}
			else{
				if (LANG_PREFIX == '') { $data['message'] = "Фабрики не найдены";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Фабрики не знайдені";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Factories not found";}
			}

		}else{
			if (LANG_PREFIX == '') { $data['message'] = "Укажите букву алфавита";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Вкажіть букву алфавіту";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "Click on the letter";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function callback()
    {
		$conn = ConnectionManager::get('default');
		
		$name			= strip_tags(str_replace("'","\'",$_POST['name']));
		$phone 			= strip_tags(str_replace("_","",$_POST['phone']));
		
		
		if($name)
		{	
			if(strlen($phone) ==17)
			{	
					
				$message = "";
				
				$to  = TECHMAIL; 
					$subject = "Обратный звонок на comodo.kiev.ua";
					$message .= ' 
					<html> 
					<head> 
					<title>Запрос на обратный звонок из сайта comodo.kiev.ua</title> 
					</head> 
					<body> 
					<h2 style="color: #686b60;">Поступил новый запрос на обратный звонок из сайта <a href="http://comodo.kiev.ua/">comodo.kiev.ua</a> </h2>
										
					<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>	
					<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Телефон отправителя: <span style="color: #ef692a;">'.$phone.'</span></p>				
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					if (LANG_PREFIX == '') { $data['message'] = "Сообщение успешно отправлено";}
					elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Повідомлення успішно відправлено";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Message sent successfully";}							
				
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Телефон*</span>";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Телефон*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Phone*</span> is not filled";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Имя*</span>";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Ім'я*</span>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Name*</span> is not filled.";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	
	
	public function subscribe()
    {
		$conn = ConnectionManager::get('default');
		
		$name			= strip_tags(str_replace("'","\'",$_POST['name']));
		$mail 			= strip_tags(str_replace("'","\'",$_POST['mail']));		
		$date 			= date("Y-m-d H:i:s", time());	
		
		
		
		
		if($name)
		{	
			if(filter_var($mail,FILTER_VALIDATE_EMAIL))
			{
				$successMail = $conn->query("
						SELECT login
						FROM osc_subscribers
						WHERE login='$mail'
						LIMIT 1
				")->fetch('assoc');	
				
				if(!$successMail)
				{
					$insertUser = $conn->query(
					"
					INSERT INTO osc_subscribers  (login, name, dateCreate, dateModify) 
							 VALUES 
												('$mail', '$name', '$date', '$date')
					"
					);
					
					if($insertUser)
					{
						$message = "";
						
						$to  = TECHMAIL; 
							$subject = "Новый запрос на рассылку comodo.kiev.ua";
							$message .= ' 
							<html> 
							<head> 
							<title>Подписка на рассылку из сайта comodo.kiev.ua</title> 
							</head> 
							<body> 
							<h2 style="color: #686b60;">Поступил новый запрос на рассылку из сайта <a href="http://comodo.kiev.ua/">comodo.kiev.ua</a> </h2>
												
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>	
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Email отправителя: <span style="color: #ef692a;">'.$mail.'</span></p>				
							<hr />
							</body> 
							</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
						
						$message = "";
						
						$to  = $mail; 
							$subject = "Подписка на рассылку от comodo.kiev.ua";
							$message .= ' 
							<html> 
							<head> 
							<title>Оформление подписки на рассылку из сайта comodo.kiev.ua</title> 
							</head> 
							<body> 
							<h2 style="color: #686b60;">Уважаемый пользователь, Вы оформили подписку на рассылку из сайта <a href="http://comodo.kiev.ua/">comodo.kiev.ua</a> </h2>
												
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">На имя: <span style="color: #0000;">'.$name.'</span></p>	
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Email: <span style="color: #ef692a;">'.$mail.'</span></p>				
							<hr />
							<p><strong>Спасибо, что выбрали нас.</strong></p>
							<hr />
							</body> 
							</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
					
						$data['status'] = "success";
						if (LANG_PREFIX == '') { $data['message'] = "Запрос успешно отправлен";}
						elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Запит успішно відправлено";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Request successfully otpravlen";}
						
					}
					else
					{	
						if (LANG_PREFIX == '') { $data['message'] = "Не удалось добавить подписчика";}
						elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося додати підписувача";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to add a subscriber";}
					}	
				
				}
				else
				{
					if (LANG_PREFIX == '') { $data['message'] = "Пользователь с таким e-mail уже зарегистрирован";}
					elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Користувач з таким e-mail вже зареєстрований";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "This email is already registered";}
				}							
				
			}
			else
			{
				if (LANG_PREFIX == '') { $data['message'] = "Введите действующий <span>Email*</span>";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Введіть дійсний <span>Email*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter a valid <span>Email*</span>";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Имя*</span>";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Ім'я*</span>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Name*</span> is not filled.";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function meeting()
    {
		$conn = ConnectionManager::get('default');
		
		$name			= strip_tags(str_replace("'","\'",$_POST['name']));
		$mail 			= strip_tags(str_replace("'","\'",$_POST['mail']));	
		$phone 			= strip_tags(str_replace("_","",$_POST['phone']));
		$comment 		= strip_tags(str_replace("'","\'",$_POST['comment']));
		$uid 			= (int)$_POST['uid'];	
				
		
		if($name)
		{				
			if(strlen($phone) ==17)
			{	
				if(filter_var($mail,FILTER_VALIDATE_EMAIL))
				{
					$successWorker = $conn->query("
							SELECT login, name, fname
							FROM osc_users
							WHERE id='$uid' AND
							worker = 0
							LIMIT 1
					")->fetch('assoc');	
					
					if($successWorker)
					{						
						$wMail = $successWorker['login'];
						$wName = $successWorker['name'];
						$wFname = $successWorker['fname'];
						
						$message = "";
						
						$to  = $wMail; 
							$subject = "Запись на встречу comodo.kiev.ua";
							$message .= ' 
							<html> 
							<head> 
							<title>Запись на встречу из сайта comodo.kiev.ua</title> 
							</head> 
							<body> 
							
							<h2 style="color: #686b60;">
								<a href="http://comodo.kiev.ua/">comodo.kiev.ua</a><br>
								Поступил новый запрос записи на встречу с архитектором <span style="color: #00916b;">'.$wName.' '.$wFname.'</span>
							</h2>
												
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>	
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Тел.: <span style="color: #ef692a;">'.$phone.'</span></p>
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Email: <span style="color: #ef692a;">'.$mail.'</span></p>
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #ef692a;">'.$comment.'</span></p>				
							<hr />
							</body> 
							</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
						
						$message = "";
						
						$to  = $mail; 
							$subject = "Запись на встречу с дизайнером comodo.kiev.ua";
							$message .= ' 
							<html> 
							<head> 
							<title>Запись на встречу с дизайнером comodo.kiev.ua</title> 
							</head> 
							<body> 
							<h2 style="color: #686b60;">Уважаемый пользователь, Вы отправили запрос записи на встречу через форму сайта <a href="http://comodo.kiev.ua/">comodo.kiev.ua</a> </h2>
												
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">На имя: <span style="color: #0000;">'.$name.'</span></p>
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Тел.: <span style="color: #ef692a;">'.$phone.'</span></p>
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Email: <span style="color: #ef692a;">'.$mail.'</span></p>
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #ef692a;">'.$comment.'</span></p>				
							<hr />
							<p><strong>В ближайшее время с Вами свяжется наш менеджер.</strong></p>
							<p><strong>Спасибо, что выбрали нас.</strong></p>
							<hr />
							</body> 
							</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
					
						$data['status'] = "success";
						if (LANG_PREFIX == '') { $data['message'] = "Запрос успешно отправлен";}
						elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Запит успішно відправлено";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Request successfully otpravlen";}
					
					}
					else
					{
						if (LANG_PREFIX == '') { $data['message'] = "Не удалось найти дизайнера";}
						elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не вдалося знайти дизайнера";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "Unable to find a designer";}
					}							
					
				}
				else
				{
					if (LANG_PREFIX == '') { $data['message'] = "Введите действующий <span>Email*</span>";}
					elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Введіть дійсний <span>Email*</span>";}
					elseif (LANG_PREFIX == 'en_') { $data['message'] = "Enter a valid <span>Email*</span>";}
				}
			}
			else
			{	
				if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Телефон*</span>";}
				elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Телефон*</span>";}
				elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Phone*</span> is not filled";}
			}
		}
		else
		{
			if (LANG_PREFIX == '') { $data['message'] = "Не заполнено поле <span>Имя*</span>";}
			elseif (LANG_PREFIX == 'ua_') { $data['message'] = "Не заповнено поле <span>Ім'я*</span>";}
			elseif (LANG_PREFIX == 'en_') { $data['message'] = "<span>Name*</span> is not filled.";}
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	/*public function sitemapdb()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("Y-m-d", time());
		
		$smList = $conn->query("
						SELECT M.new_urls
						FROM osc_redirect as M
						WHERE M.id!=31380 OR M.id!=31381
						GROUP BY M.new_urls
						ORDER BY M.id
						LIMIT 50000
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($mfList); echo "</pre>"; exit();
		
				
		
		if ($smList){	
			
			echo "<div>";
			foreach ($smList as $sm){
								
				$url = explode("/ru/", $sm['new_urls']);
				$sitemap = "

						  <url>
						
							<loc>http://www.comodo.kiev.ua/en/".$url['1']."</loc>
						
							<lastmod>".$date."</lastmod>
						
							<priority>0.7</priority>
						
							<changefreq>weekly</changefreq>
						
						  </url>";
				
				print_r($sitemap);
					
				
			}
			echo "</div>";
			
		}			
	}	*/
	
}
