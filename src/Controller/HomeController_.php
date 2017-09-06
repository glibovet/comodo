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
class HomeController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function home()
    {
		$conn = ConnectionManager::get('default');
		
		/*echo "<pre>"; print_r(SHOPTHERMS); echo "</pre>"; 
		echo "<pre>"; print_r(SHOPMAIL); echo "</pre>";
		echo "<pre>"; print_r(TECHPHONE); echo "</pre>";
		echo "<pre>"; print_r(TECHMAIL); echo "</pre>";
		echo "<pre>"; print_r($metaTitle); echo "</pre>";
		echo "<pre>"; print_r($metaKeys); echo "</pre>";
		echo "<pre>"; print_r($metaDesc); echo "</pre>";exit();*/
		
		$mainBanList = $conn->query("SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."data as data, file, target, link
					FROM osc_banners
					WHERE `block`=0 AND `pos_id`=1
					ORDER BY `order_id`
					LIMIT 40")->fetchAll('assoc');
		$this->set("mainBanList", $mainBanList);// Список баннеров на глввной странице
		
    }
	
	public function register()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$_email 		= strip_tags(str_replace("'","\'",$_POST['reg_login']));
		$_pass  		= strip_tags(str_replace("'","\'",$_POST['reg_password']));
		$_pass_con 		= strip_tags(str_replace("'","\'",$_POST['reg_password_confirm']));
		
		$_true_pass = $_pass;
		
		if(filter_var($_email,FILTER_VALIDATE_EMAIL))
		{
			if(strlen($_pass) >=5)
			{
				if($_pass_con === $_pass)
				{
					$user_exist = $conn->query(
					"
					SELECT id FROM osc_users WHERE login='$_email' LIMIT 1
					"
					)->fetch('assoc');
					
					if (!$user_exist)
					{
					$_pass = md5($_pass);	
					$success = $conn->query("
					INSERT INTO osc_users (login, pass) VALUES ('$_email',  '$_pass')
					"
					);
						if($success){ 
						$data['status'] = "success"; $data['message'] = "<?php if (LANG_PREFIX == '') { echo 'Успешная регистрация';}elseif (LANG_PREFIX == 'en_') { echo 'Successful registration';}?>";
						
						$_user = $conn->query("
						SELECT * FROM osc_users WHERE login='$_email' LIMIT 1
						")->fetch('assoc');						
						$user_id = $_user['id'];
						
						if($_user){	$_SESSION['online']=$_user['id'];}
						
						$updateCart = $conn->query("
						UPDATE osc_shop_cart
							SET `uid`='$user_id'
							WHERE  `session_id`='".SESID."'
						");
						
						$updateLike = $conn->query("
						UPDATE osc_shop_like
							SET `uid`='$user_id'
							WHERE  `session_id`='".SESID."'
						");
						
						$to  = $_email; 
						$subject = "Регистрация на It Fur Line";
						$message = ' 
						<html> 
						<head> 
						<title>Регистрация на It Fur Line</title> 
						</head> 
						<body> 
						<p style="color: green;">Уважаемый пользователь</p>
						<p>Вы прошли регистрацию на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
						
						<p>Данные для авторизации:</p>
						<p>ЛОГИН: '.$_email.'</p>
						<p>ПАРОЛЬ: '.$_true_pass.'</p>
						
						<hr />
						<p><strong>Спасибо, что выбрали нас.</strong></p>
						<hr />
						</body> 
						</html>';
	
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
						mail($to, $subject, $message, $headers);
						}
						
					}
					else{
						if (LANG_PREFIX == '') { $data['message'] = "Пользователь с таким e-mail уже зарегистрирован";}
						elseif (LANG_PREFIX == 'en_') { $data['message'] = "This email is already registered";}
					}				
				}else{
						$data['message'] = "Повторный пароль не совпадает";
				}
			}else{
					$data['message'] = "Пароль сликом короткий<br>(минимум 5 символов)";
			}
		}else{
				$data['message'] = "<small>Введите действующий email адресс";
			}
	echo json_encode($data);
	exit();
	}
	
	
	
	public function login()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$_email 		= strip_tags(str_replace("'","\'",$_POST['login']));
		$_pass  		= strip_tags(str_replace("'","\'",$_POST['password']));		
		$_pass = md5($_pass);
		
		$_user = $conn->query("
		SELECT * FROM osc_users WHERE login='$_email' LIMIT 1
		")->fetch('assoc');					
		$user_id = $_user['id'];
		
		if($_user){
			if($_user['pass'] == $_pass){
				
				$_SESSION['online']=$_user['id'];
				$data['status'] = "success";
				$data['message'] = "Успешная аторизация";
				
				$updateCart = $conn->query("
				UPDATE osc_shop_cart
					SET `uid`='$user_id'
					WHERE  `session_id`='".SESID."'
				");
				
				$updateLike = $conn->query("
				UPDATE osc_shop_like
					SET `uid`='$user_id'
					WHERE  `session_id`='".SESID."'
				");
				
				}
				else {$data['message'] = "Неверный пароль";}
			}
			else{$data['message'] = "Пользователь не найден";}
			
			echo json_encode($data);
	exit();
		
	}
	
	public function logout()
    {
		$_SESSION['online'] = null;
		unset($_SESSION['online']);
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".RS."catalog/"); 
		exit();
	}
	
	public function sendNewPass()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$_email 		= strip_tags(str_replace("'","\'",$_POST['np_login']));
		
		if(filter_var($_email,FILTER_VALIDATE_EMAIL))
		{
				$user_exist = $conn->query(
				"
				SELECT id FROM osc_users WHERE login='$_email' LIMIT 1
				"
				)->fetch('assoc');
				
				if (!$user_exist)
				{
					$data['message'] = "Пользователь с таким e-mail не зарегистрирован";
				}
				else{
				function generatePassword($length = 8){
				  $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
				  $numChars = strlen($chars);
				  $string = '';
				  for ($i = 0; $i < $length; $i++) {
					$string .= substr($chars, rand(1, $numChars) - 1, 1);
				  }
				  return $string;
				}
				
				$pass = generatePassword(8);
				$_true_pass = $pass;	
					
				$_pass = md5($pass);
					
				$success = $conn->query("
				UPDATE osc_users
						SET `pass`='$_pass'
						WHERE  `login`='$_email'
				"
				);
					if($success){ 
					$data['status'] = "success"; $data['message'] = "Новый пароль отправлен на Ваш e-mail";
					
					$_user = $conn->query("
					SELECT * FROM osc_users WHERE login='$_email' LIMIT 1
					")->fetch('assoc');						
					$user_name = $_user['name'];
										
					$to  = $_email; 
					$subject = "Новый пароль на It Fur Line";
					$message = ' 
					<html> 
					<head> 
					<title>Создан новый пароль на It Fur Line</title> 
					</head> 
					<body> 
					<p style="color: green;">Уважаемый пользователь</p>
					<p>Вы изменили свой пароль для авторизации на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
					
					<p>Данные для авторизации:</p>
					<p>ЛОГИН: '.$_email.'</p>
					<p>ПАРОЛЬ: '.$_true_pass.'</p>
					
					<hr />
					<p><strong>Спасибо, что выбрали нас.</strong></p>
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
					}						
				}
			
		}else{
				$data['message'] = "<small>Введите действующий email адресс";
			}
	echo json_encode($data);
	exit();
	}
	
	public function changePersInfo()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$user_id 		= UID;
		$_name 			= strip_tags(str_replace("'","\'",$_POST['name']));
		$_lname 		= strip_tags(str_replace("'","\'",$_POST['lname']));
		$_email 		= strip_tags(str_replace("'","\'",$_POST['email']));
		$_phone 		= $_POST['phone'];
		$_adress		= strip_tags(str_replace("'","\'",$_POST['adress']));
		$_confirm		= (int)$_POST['confirm'];
		
		if(filter_var($_email,FILTER_VALIDATE_EMAIL))
		{
				
			if(strlen($_phone) >=10)
			{
				$user_exist = $conn->query(
				"
				SELECT id FROM osc_users WHERE login='$_email' AND id !='$user_id' LIMIT 1
				"
				)->fetch('assoc');
				
				if (!$user_exist)
				{
					$success = $conn->query("
						UPDATE osc_users
								SET `name`='$_name',`lname`='$_lname', `login`='$_email', `phone`='$_phone', `delivery_address`='$_adress', `newsletter`='$_confirm'
								WHERE  `id`='$user_id'
						");
						
					if($success){ 
					$data['status'] = "success"; $data['message'] = "Изменения внесены в базу";
									
					$to  = $_email; 
					$subject = "Личные данные на It Fur Line";
					$message = ' 
					<html> 
					<head> 
					<title>Изменения в личном кабинете на It Fur Line</title> 
					</head> 
					<body> 
					<p style="color: green;">Уважаемый пользователь</p>
					<p>Вы изменили персональную информацию на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
					
					<p>Новые данные:</p>
					<p>Логин: '.$_email.'</p>
					<p>Имя: '.$_name.'</p>
					<p>Фамилия: '.$_lname.'</p>
					<p>Телефон: '.$_phone.'</p>
					<p>Адрес: '.$_adress.'</p>
					
					<hr />
					<p><strong>Спасибо, что выбрали нас.</strong></p>
					<hr />
					</body> 
					</html>';
	
					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
	
					mail($to, $subject, $message, $headers);
					}
					
				}
				else{
					$data['message'] = "Пользователь с таким e-mail уже зарегистрирован";
				}
			}
			else{
				$data['message'] = "Введите корректный номер тел.";
			}
		}else{
				$data['message'] = "<small>Введите действующий email адресс";
			}
	echo json_encode($data);
	exit();
	}	
	
	public function userChangePass()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$user_id 		= UID;
		$old_password 			= $_POST['old_password'];
		$new_password 			= strip_tags(str_replace("'","\'",$_POST['new_password']));
		$new_password_repeat 	= strip_tags(str_replace("'","\'",$_POST['new_password_repeat']));
		
		$old_pass = md5($old_password);
		$_true_pass = $new_password;
		
		$user_exist = $conn->query("
				SELECT login, name FROM osc_users WHERE `id`='$user_id' AND `pass`='$old_pass' LIMIT 1
				")->fetch('assoc');
		//"<pre>"; print_r($user_exist); echo "</pre>"; exit();
		
		$_email = $user_exist['login'];
		$user_name = $user_exist['name'];
		
		
		if($user_exist)
		{
			if(strlen($new_password) >=5)
			{
				if($new_password === $new_password_repeat)
				{				
					
				$_pass = md5($new_password);
				
				$success = $conn->query("
						UPDATE osc_users
						SET `pass`='$_pass'
						WHERE  `id`='$user_id'
				");
				
					if($success){ 
					$data['status'] = "success"; $data['message'] = "Новый пароль отправлен на Ваш e-mail";
															
					$to  = $_email; 
					$subject = "Новый пароль на It Fur Line";
					$message = ' 
					<html> 
					<head> 
					<title>Создан новый пароль на It Fur Line</title> 
					</head> 
					<body> 
					<p style="color: green;">Уважаемый пользователь</p>
					<p>Вы изменили свой пароль для авторизации на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
					
					<p>Данные для авторизации:</p>
					<p>ЛОГИН: '.$_email.'</p>
					<p>НОВЫЙ ПАРОЛЬ: '.$_true_pass.'</p>
					
					<hr />
					<p><strong>Спасибо, что выбрали нас.</strong></p>
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
					}
					else{
							$data['message'] = "Не удалось изменить пароль (";
					}
				}
				else{
						$data['message'] = "Повторный пароль не совпадает";
				}
			}
			else{
					$data['message'] = "Новый пароль сликом короткий<br>(минимум 5 символов)";
			}
		}
		else{
				$data['message'] = "<small>Старый пароль не верный";
			}
	echo json_encode($data);
	exit();
	}
	
		
	
	public function callOffOrder()
    {
		$conn = ConnectionManager::get('default');
		$data = ['status'=>'failed','message'=>'',];		
		
		$user_id 		= UID;
		$order_id 		= $_POST['order_id'];
		
		$status_exist = $conn->query("
				SELECT status FROM osc_shop_orders WHERE `status`<=1 AND `id`='$order_id' LIMIT 1
				")->fetch('assoc');
		//"<pre>"; print_r($status_exist); echo "</pre>"; exit();
		
		if($status_exist)
		{				
			
			$success = $conn->query("
					UPDATE osc_shop_orders
					SET `status`=5
					WHERE  `id`='$order_id'
			");
			
			if($success){ 
			$data['status'] = "success"; $data['message'] = "Заказ отменен!";
			
			}
			else{
					$data['message'] = "Не удалось изменить статус заказа! Свяжитесь с администратором.";
			}
		}
		else{
				$data['message'] = "<small>Не отменен! Свяжитесь с администратором.";
			}
	echo json_encode($data);
	exit();
	}
	
	public function cart()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$p_id 			= (int)$_POST['prod_id'];		
		$p_url 			= $_POST['prod_url'];
		$qty 			= (isset($_POST['qty']) ? (int)$_POST['qty'] : 1);
		$size			= (isset($_POST['size']) ? (int)$_POST['size'] : 0);
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];
		
		$cartQty = "0";
		$cartSum = "0";
		$prodSum = "0";
		$open_modal = "#";	
		$open_order = "#";
		
		if ($size){
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
				//echo "<pre>"; print_r($date); echo "</pre>"; exit();
				
				$cartSizes = $conn->query("
							SELECT M.value
										FROM osc_shop_chars_prod_ref as M 
										JOIN osc_shop_chars as C ON M.char_id=C.id 
										WHERE 
											M.value 	!= '' AND	
											C.alias 	= 'size'  	AND 
											M.prod_id 	= '$p_id'	AND 
											C.block 	= 0
										ORDER BY M.id
										LIMIT 10
						")->fetchAll('assoc');
				$this->set("cartSizes", $cartSizes);// Список размеров товара
				
				$oll_sizes = serialize($cartSizes);
				
				$cartSizeValues = $conn->query("
								SELECT M.size, M.breast_val, M.waist_val, M.hip_val, M.sleeve_val
									FROM osc_shop_prod_size_ref as M 
									WHERE M.prod_id = '$p_id' AND
									M.breast_val != ''
									ORDER BY M.order_id
									LIMIT 20
								")->fetchAll('assoc');
				$this->set("cartSizeValues", $cartSizeValues);// Список значений размеров товара
				
				$sizeValues = serialize($cartSizeValues);
				
				$eddProd = $conn->query("
					INSERT INTO osc_shop_cart  (uid, session_id, prod_id, prod_url, quant, size, oll_sizes, size_val, dateCreate, dateModify) 
							 VALUES 
							 ('$user_id', '$session_id', '$p_id', '$p_url', '$qty', '$size', '$oll_sizes', '$sizeValues', '$date', '$date')
					"
					);		
									
			}
			
			if(isset($eddProd) || isset($updateProd))
				{					
				$data['status'] = "success"; $data['message'] = "Товар добавлен в корзину";
				
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
					SELECT C.*, R.cat_id, 
					(SELECT ".LANG_PREFIX."name FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_name,
					(SELECT sku FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_sku,
					(SELECT ".RATE_PREFIX."price FROM osc_shop_products WHERE `block`=0 AND `id`=C.prod_id) as prod_price,
					(SELECT file FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_file,
					(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_crop,
					(SELECT ".LANG_PREFIX."name FROM osc_shop_catalog WHERE id=R.cat_id ORDER BY id LIMIT 1) as cat_name
					FROM osc_shop_cart as C
					LEFT JOIN `osc_shop_cat_prod_ref` as R ON R.prod_id=C.prod_id
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
						$formatProdPrice = number_format($cartItem['prod_price'], 0, '.', '.');
						$oll_sizes  = unserialize($cartItem['oll_sizes']);		// Список размеров товара?>
                        <div class="buy-item" id="cart-item-<?= $cartItem['id'] ?>">
                            <a href="<?= $cartItem['prod_url'] ?>">
                                <img src="/img/split/files/shop/products/crop/<?= $cartItem['prod_crop']?>" alt="<?= $cartItem['prod_name'] ?>">
                            </a>
                            <div class="model">
                                <h5><?= $cartItem['cat_name'] ?></h5>
                                <h6><?= $cartItem['prod_name'] ?></h6>
                                
                                <div class="prod_cart_sizes">
                                    <button type="button" class="prod_cart_size_btn product-size<?= $cartItem['id'] ?>-dd" onclick=" $('#product-size<?= $cartItem['id'] ?>-dd').slideDown(900);">
                                        <i><span id="product-selected-size<?= $cartItem['id'] ?>">
                                        <?php if ($cartItem['size']){ echo $cartItem['size']; }
                                        else { echo $oll_sizes['0']['value'];}?>
                                        </span></i>
                                    </button>
            
                                    <ul id="product-size<?= $cartItem['id'] ?>-dd" class="prod_cart_size_ul">
                                        <?php foreach ($oll_sizes as $prodSize)
                                        { 
                                        $dop_class = "";
                                        if ($prodSize['value'] == $cartItem['size']) {$dop_class = "active";}
                                        ?>
                                            <li id="size-val-<?= $prodSize['value'] ?>" class="<?= $dop_class ?>"><a data-val="<?= $prodSize['value'] ?>" href="javascript:void(0);" onclick="mainScript.changeProdSize(<?= $cartItem['id'] ?>,'<?= $prodSize['value'] ?>');"><?= $prodSize['value'] ?></a></li>
                                        <?php
                                        }?>
                                    </ul>
                                </div>
                                
                                <p class="code">код:  <?= $cartItem['prod_sku'] ?></p>
                            </div>
                            <p class="price"><?= $formatProdPrice ?> <?= CURNAME ?></p>
                            <div class="sum" id="sum_<?= $cartItem['prod_id'] ?>">
                                <button class="minus change" onClick="mainScript.minusProdQty(<?= $cartItem['prod_id'] ?>);"></button>
                                <input type="number" value="<?= $cartItem['quant'] ?>" size="5" class="count" onChange="mainScript.changeProdQty(<?= $cartItem['id'] ?>, this.value, <?= $cartItem['prod_id'] ?>, '<?= RATE_PREFIX ?>');">
                                <button class="plus change" onClick="mainScript.plusProdQty(<?= $cartItem['prod_id'] ?>);"></button>
                            </div>
                            <i class="trash" onClick="mainScript.delCartProd(<?= $cartItem['id'] ?>, '<?= RATE_PREFIX ?>');"></i>
                        </div>
				<?php }
				$data['fastCartHtml'] = ob_get_contents();
				
				ob_end_clean();
				
		}
		}else{
			 $data['message'] = "Укажите размер";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function prodSize()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'',];
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$item_id 		= (int)$_POST['item_id'];
		$size			= $_POST['size'];
		
		$updateProd = $conn->query(
				"
				UPDATE osc_shop_cart
					SET `size`='$size'
					WHERE `uid`='$user_id' 
					AND `session_id`='$session_id'
					AND `id`=$item_id
				"
				);
				
		if(isset($updateProd))
		{
			$data['status'] = "success"; $data['message'] = "Размер изменен";
		}
		else {$data['message'] = "Не удалось изменить размер";}		
			
	echo json_encode($data);
	exit(); 
	}
	
	public function prodQty()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'','total_sum'=>'0'];
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$rate_prefix    = $_POST['rate'];
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
							(SELECT ".$rate_prefix."price FROM osc_shop_products WHERE id='$prod_id' LIMIT 1) as prod_price
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
							(SELECT ".$rate_prefix."price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as price
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
			
			$data['status'] = "success"; $data['message'] = "Количество изменено";
		}
		else {$data['message'] = "Не удалось изменить количество";}		
			
	echo json_encode($data);
	exit(); 
	}
	
	public function delCartProd()
    {
		$conn = ConnectionManager::get('default');
		
		$data = ['status'=>'failed','message'=>'','total_sum'=>'0'];
		
		$open_modal = "#";
		$open_order = "#";
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$rate_prefix    = $_POST['rate'];
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
							(SELECT ".$rate_prefix."price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as price
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
			
			$data['status'] = "success"; $data['message'] = "Товар удален";
		}
		else {$data['message'] = "Не удалось удалить товар";}		
			
	echo json_encode($data);
	exit(); 
	}
	
	public function order()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$name			= $_POST['name'];
		$mail 			= strip_tags(str_replace("'","\'",$_POST['mail']));
		$phone 			= strip_tags(str_replace("'","\'",$_POST['phone']));
		$delivery 		= strip_tags(str_replace("'","\'",$_POST['delivery']));
		$pay_meth 		= strip_tags(str_replace("'","\'",$_POST['pay_meth']));
		$address 		= strip_tags(str_replace("'","\'",$_POST['address']));
		$comment 		= strip_tags(str_replace("'","\'",$_POST['comment']));		
		$rate			= $_POST['rate'];		
		
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];	
		
		$cartProds = $conn->query(
		"
		SELECT 
				(SELECT id FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as id,
				(SELECT sku FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as sku,
				(SELECT name FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as name,
				(SELECT ua_name FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as ua_name,
				(SELECT en_name FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as en_name,
				(SELECT alias FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as alias,
				(SELECT price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as price,
				(SELECT usd_price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as usd_price,
				(SELECT rub_price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as rub_price,
				(SELECT eur_price FROM osc_shop_products WHERE id=C.prod_id LIMIT 1) as eur_price,
				(SELECT crop FROM osc_files_ref WHERE `ref_id` = C.prod_id AND `ref_table` = 'shop_products' ORDER BY `id` LIMIT 1) as img,
				C.quant,
				C.size
								
				FROM osc_shop_cart as C
				WHERE C.uid='$user_id' 
				AND C.session_id='$session_id'
				ORDER BY id DESC
		"
		)->fetchAll('assoc');
		
		//echo "<pre>"; print_r($cartProds); echo "</pre>"; exit();		
		
		if($cartProds)
		{	
			if($user_id)
			{
				if($name)
				{
				if(filter_var($mail,FILTER_VALIDATE_EMAIL))
				{	
				if(strlen($phone) >=10)
				{	
					$orderProds = serialize($cartProds);
			
					$insertProd = $conn->query(
					"
					INSERT INTO osc_shop_orders  (client_email, client_phone, client_name, type, author_id, user_id, status, paid_status, pay_method, delivery_method, delivery_address, details, products, dateCreate, dateModify) 
							 VALUES 
												('$mail', '$phone', '$name', 'internet-shop', '$user_id', '$user_id', '1', 'Не оплачен', '$pay_meth', '$delivery', '$address', '$comment', '$orderProds', '$date', '$date')
					"
					);
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
								WHERE `user_id`='$user_id'
								ORDER BY id DESC
								LIMIT 1
						"
						)->fetch('assoc');
						
						$orderNum = 5000+$orderInfo['id'];
						$orderProducts = unserialize($orderInfo['products']);
						$orderSum = 0;
						
						$data['status'] = "success";
						$data['message'] .= "<p>Ваш заказ успешно создан. Номер заказа <span>".$orderNum."</span></p>";	
						$data['message'] .= "<p>Детали отправлены на Ваш e-mail</p>";	
						
						//Email посетителю
						$message = "";
						
						$to  = $mail; 
							$subject = "Заказ на It Fur Line № ".$orderNum."";
							$message .= ' 
							<html> 
							<head> 
							<title>Новый заказ на itfurline.com</title> 
							</head> 
							<body> 
							<p>Уважаемый пользователь</p>
							<p>Вы оформили заказ на нашем сайте <a href="http://itfurline.com/">itfurline.com</a></p>
							<h2 style="color: #686b60;">Номер заказа '.$orderNum.' </h2>
							
							<p style="font-size: 20px;line-height: 32px;text-indent: 20px;background: #cecece;">Данные по заказу:</p>
							<table width="100%" style="max-width:500px;">
							<tbody>';
							foreach ($orderProducts as $product)
							{
							$prodSum = $product['price']*$product['quant'];
							$orderSum += $prodSum;
							$message .= '<tr>
											<td style="border-bottom: 1px solid #aaaaaa; text-align: center;">
												<img style="max-height: 210px;" src="http://itfurline.com/img/split/files/shop/products/crop/'.$product['img'].'" alt="'.$product['name'].'">
											</td>
											<td style="border-bottom: 1px solid #aaaaaa;; vertical-align: top;">
												<h3  style="color: #ef692a;"><a target="_blank" href="http://itfurline.com/catalog/product/'.$product['alias'].'/">'.$product['name'].'<a></h3>    
												<div></div>
												<div style="line-height: 26px;">Размер: <strong  style="color: #ef692a;">'.$product['size'].'</strong></div>
												<div style="line-height: 26px;">Цена:  <strong  style="color: #ef692a;">'.$product['price'].' UAH</strong></div>
												<div style="line-height: 26px;">Количество:  <strong  style="color: #ef692a;">'.$product['quant'].'</strong></div>    
												<div></div>
												<div style="line-height: 46px;"><strong>СТОИМОСТЬ: <span style="color: #ef692a;">'.$prodSum.' UAH</span></strong></div>
											</td>
										</tr>';									
							}
							$message .= '
							</tbody>
							</table>
							<p style="font-size: 20px;line-height: 40px;text-indent: 20px;background: #cecece;"><strong>СУММА ЗАКАЗА: <span style="color: #ef692a;">'.$orderSum.' UAH</span></strong></p>						
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
								$subject = "Новый заказ на It Fur Line № ".$orderNum."";
								$message .= ' 
								<html> 
								<head> 
								<title>Новый заказ на itfurline.com</title> 
								</head> 
								<body> 
								<p>Оформлен заказ на сайте <a href="http://itfurline.com/">itfurline.com</a></p>
								<h2 style="color: #686b60;">Номер заказа '.$orderNum.' </h2>
								
								<p style="font-size: 20px;line-height: 32px;text-indent: 20px;background: #cecece;">Данные по заказу:</p>
								<table width="100%" style="max-width:500px;">
								<tbody>';
								foreach ($orderProducts as $product)
								{
								$prodSum = $product['price']*$product['quant'];
								$orderSum += $prodSum;
								$message .= '<tr>
												<td style="border-bottom: 1px solid #aaaaaa; text-align: center;">
													<img style="max-height: 210px;" src="http://itfurline.com/img/split/files/shop/products/crop/'.$product['img'].'" alt="'.$product['name'].'">
												</td>
												<td style="border-bottom: 1px solid #aaaaaa;; vertical-align: top;">
													<h3  style="color: #ef692a;"><a target="_blank" href="http://itfurline.com/catalog/product/'.$product['alias'].'/">'.$product['name'].'<a></h3>    
													<div></div>
													<div style="line-height: 26px;">Размер: <strong  style="color: #ef692a;">'.$product['size'].'</strong></div>
													<div style="line-height: 26px;">Цена:  <strong  style="color: #ef692a;">'.$product['price'].' UAH</strong></div>
													<div style="line-height: 26px;">Количество:  <strong  style="color: #ef692a;">'.$product['quant'].'</strong></div>    
													<div></div>
													<div style="line-height: 46px;"><strong>СТОИМОСТЬ: <span style="color: #ef692a;">'.$prodSum.' UAH</span></strong></div>
												</td>
											</tr>';									
								}
								$message .= '
								</tbody>
								</table>
								<p style="font-size: 20px;line-height: 40px;text-indent: 20px;background: #cecece;"><strong>СУММА ЗАКАЗА: <span style="color: #ef692a;">'.$orderSum.' UAH</span></strong></p>						
								<hr />
								
								<p>Комментарий пользователя:  '.$comment.'</p>
								</body> 
								</html>';
			
								$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
								$headers .= "From: ".SHOPMAIL." <".SHOPMAIL.">\r\n"; 
			
								mail($to, $subject, $message, $headers);
									
						
					}
					else
					{	
						$data['message'] = "Не удалось создать заказ";
					}			
				}
				else
				{	
					$data['message'] = "Не заполнено поле <span>Телефон*</span>";
				}			
				}
				else
				{	
					$data['message'] = "Введите действующий <span>Email*</span>";
				}			
				}
				else
				{	
					$data['message'] = "Не заполнено поле <span>Ф.И.О.*</span>";
				}
			}
			else
			{
				$data['message'] = "<a href='#' data-toggle='modal' data-target='.auth-modal-sm'>Авторизируйтесь</a> для оформления заказа";
			}
		}
		else
		{
			$data['message'] = "Не удалось найти выбранные товары";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function like()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;
		$p_id 			= (int)$_POST['prod_id'];		
		$p_url 			= $_POST['prod_url'];
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>'',];	
		
		$existingProd = $conn->query(
		"
		SELECT id
				FROM osc_shop_like
				WHERE `uid`='$user_id'				
				AND  `session_id`='$session_id'
				AND `prod_id`=$p_id
				ORDER BY id DESC
				LIMIT 1
		"
		)->fetch('assoc');
		
		if($existingProd)
		{	
				$data['status'] = "success"; $data['message'] = "Добавлен в избранное";		
		}
		else
		{			
			$eddProd = $conn->query("
				INSERT INTO osc_shop_like  (uid, session_id, prod_id, prod_url, dateCreate) 
						 VALUES 
						 ('$user_id', '$session_id', '$p_id', '$p_url', '$date')
				"
				);		
								
		}
		
		if(isset($eddProd))
		{
			$data['status'] = "success"; $data['message'] = "Добавлен в избранное";
			
			$countQuery = $conn->query(
					"
					SELECT 
							COUNT(id) as like_quant
							FROM osc_shop_like
							WHERE uid='$user_id' 
							AND `session_id`='$session_id'
					"
					)->fetch('assoc');
		
		
			$data['total_quant'] = $countQuery['like_quant'];
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function delLike()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;
		$session_id 	= SESID;	
		$item_id 		= $_POST['item_id'];
		
		$data = ['status'=>'failed','message'=>'',];
		
		$delateProd = $conn->query(
				"
				DELETE FROM osc_shop_like
					WHERE `id`='$item_id' AND
					`uid`='$user_id' AND 
					`session_id`='$session_id'
				"
				);
				
		if(isset($delateProd))
		{			
			$data['status'] = "success"; $data['message'] = "Успешное удаление";
			
			$countQuery = $conn->query("
					SELECT 
							COUNT(id) as like_quant
							FROM osc_shop_like
							WHERE uid='$user_id' AND 
							`session_id`='$session_id'
					"
					)->fetch('assoc');
		
		
			$data['total_quant'] = $countQuery['like_quant'];
		}
			
	echo json_encode($data);
	exit();
		
	}
	public function review()
    {
		$conn = ConnectionManager::get('default');
		
		
		$user_id 		= UID;	
		$rating 		= (int)$_POST['size'];
		$comment 		= strip_tags(str_replace("'","\'",$_POST['review']));
		$date 			= date("Y-m-d H:i:s", time());
		
		$data = ['status'=>'failed','message'=>''];
		
		if($user_id){
			if(strlen($comment) >=5){
			$eddReview = $conn->query("
				INSERT INTO osc_article_comments (user_id, comment, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$user_id', '$comment', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$selectReview = $conn->query("
						SELECT id
								FROM osc_article_comments
								WHERE user_id='$user_id'
								ORDER BY id DESC
								LIMIT 1
						"
						)->fetch('assoc');
					
					$item_id = $selectReview['id'];
					
					$filename = "files";
					
					// Upload files
					
					
					if(isset($_FILES[$filename]) && $_FILES[$filename]['size'] > 0)
					{
						$file_path = "../webroot/img/split/files/users/";
						
						$files_upload = $this->Helper->mtvc_add_files_file_miltiple(array(
								'path'			=>$file_path,
								'name'			=>5,
								'pre'			=>"comm_",
								'size'			=>10,
								'rule'			=>0,
								'max_w'			=>3333,
								'max_h'			=>3333,
								'files'			=>$filename,
								'resize_path'	=>$file_path."crop/",
								'resize_w'		=>386,
								'resize_h'		=>585,
								'resize_path_2'	=>"0",
								'resize_w_2'	=>0,
								'resize_h_2'	=>0
							  ));
						if($files_upload)
						{
							foreach($files_upload as $file_upload)
							{
								$query = "INSERT INTO osc_files_ref (`ref_table`, `ref_id`, `file`, `crop`, `path`) VALUES ('article_comments', '$item_id', '$file_upload', '0', 'webroot/img/split/files/users/')";
								
								$conn->query($query);
							}
						}
					}	else{
						
						$data['message'] = count($_FILES);
						
						
						echo json_encode($data);
						exit();
						}
					$data['status'] = "success"; $data['message'] = "Отзыв добавлен и вскоре будет размещен.";
				}else{
					$data['message'] = "Не удалось добавить отзыв";
				}
			}else{
				$data['message'] = "Поле <span>Ваш отзыв</span> не заполнено";
			}
		}else{
			$data['message'] = "<a href='#' data-toggle='modal' data-target='.auth-modal-sm'>Авторизируйтесь</a> для добавления отзыва";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function footerForm()
    {
		$conn = ConnectionManager::get('default');
		
		$name			= $_POST['footer_name'];
		$mail 			= strip_tags(str_replace("'","\'",$_POST['footer_email']));
		$comment 		= strip_tags(str_replace("'","\'",$_POST['footer_comment']));
		
		
		if($name)
		{
			if(filter_var($mail,FILTER_VALIDATE_EMAIL))
			{	
				if(strlen($comment) >=5)
				{	
					
						$message = "";
						
						$to  = TECHMAIL; 
							$subject = "Новое сообщение из сайта itfurline.com";
							$message .= ' 
							<html> 
							<head> 
							<title>Новое сообщение из сайта itfurline.com</title> 
							</head> 
							<body> 
							<h2 style="color: #686b60;">Поступило новое сообщение из сайта <a href="http://itfurline.com/">itfurline.com</a> </h2>
							
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Email отправителя: <span style="color: #ef692a;">'.$mail.'</span></p>
							
							<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>					
							<hr />
							<p><strong>Сообщение:</strong></p>
							<p>'.$comment.'</p>
							<hr />
							</body> 
							</html>';
		
							$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
							$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
							mail($to, $subject, $message, $headers);
						
							$data['status'] = "success";							
							$data['message'] = "Сообщение успешно отправлено";
							
				}
				else
				{	
					$data['message'] = "Не заполнено поле <span>Сообщение*</span>";
				}
			}
			else
			{
				$data['message'] = "Введите корректный <span>Email*</span>";
			}
		}
		else
		{
			$data['message'] = "Не заполнено поле <span>Имя*</span>";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	
	
	public function addSiteComm()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$title  		= strip_tags(str_replace("'","\'",$_POST['title']));
		$coment 		= strip_tags(str_replace("'","\'",$_POST['coment']));
		$rating			= (isset($_POST['rating']) ? (int)$_POST['rating'] : 5);
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($user_id)
		{	
			if(strlen($coment) >=5)
			{	
				
				$selectUser = $conn->query("
					SELECT name
							FROM osc_users
							WHERE id='$user_id'
							LIMIT 1
					"
					)->fetch('assoc');
				
				$user_name = $selectUser['name'];
				
				$eddReview = $conn->query("
				INSERT INTO osc_site_comments (user_id, comment, name, caption, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$user_id', '$coment', '$user_name', '$title', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$message = "";
					
					$to  = TECHMAIL; 
						$subject = "Новый отзыв на itfurline.com";
						$message .= ' 
						<html> 
						<head> 
						<title>Прокомментирован сайт itfurline.com</title> 
						</head> 
						<body> 
						<h2 style="color: #686b60;">Новый отзыв на сайте <a href="http://itfurline.com/">itfurline.com</a> </h2>
											
						<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$user_name.'</span></p>			
						<hr />
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Тама: <span style="color: #0000;">'.$title.'</span></p>	
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #0000;">'.$coment.'</span></p>	
						</body> 
						</html>';
		
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
						mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					$data['message'] = "Сообщение успешно отправлено";
				}
				else
				{
					$data['message'] = "*Не удалось добавить запись!";
				}							
				
			}
			else
			{
				$data['message'] = "*Комментарий слишком короткий!";
			}
		}
		else
		{
			$data['message'] = "<a href='#modal-1' class='sign-in'>*Авторизируйтесь!</a>";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
		
	
	public function addProdComm()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$title  		= strip_tags(str_replace("'","\'",$_POST['title']));
		$coment 		= strip_tags(str_replace("'","\'",$_POST['coment']));
		$rating			= (isset($_POST['rating']) ? (int)$_POST['rating'] : 5);
		$prod_id 		= $_POST['com_pid'];
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($user_id)
		{	
			if(strlen($coment) >=5)
			{	
				
				$selectUser = $conn->query("
					SELECT name
							FROM osc_users
							WHERE id='$user_id'
							LIMIT 1
					"
					)->fetch('assoc');
				
				$user_name = $selectUser['name'];
				
				$eddReview = $conn->query("
				INSERT INTO osc_shop_product_comments (prod_id, user_id, comment, name, caption, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$prod_id', '$user_id', '$coment', '$user_name', '$title', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$selectProd = $conn->query("
						SELECT alias, name
								FROM osc_shop_products
								WHERE id='$prod_id'
								LIMIT 1
						"
						)->fetch('assoc');
					
					$item_name = $selectProd['name'];
					$item_alias = $selectProd['alias'];
				
					$message = "";
					
					$to  = TECHMAIL; 
						$subject = "Новый отзыв на itfurline.com";
						$message .= ' 
						<html> 
						<head> 
						<title>Прокомментирован товар на itfurline.com</title> 
						</head> 
						<body> 
						<h2 style="color: #686b60;">Новый отзыв на товар <a href="http://itfurline.com/catalog/product/'.$item_alias.'">'.$item_name.'</a> на <a href="http://itfurline.com/">itfurline.com</a> </h2>
											
						<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$user_name.'</span></p>			
						<hr />
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Тама: <span style="color: #0000;">'.$title.'</span></p>	
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #0000;">'.$coment.'</span></p>	
						</body> 
						</html>';
		
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
						mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					$data['message'] = "Сообщение успешно отправлено";
				}
				else
				{
					$data['message'] = "*Не удалось добавить запись!";
				}							
				
			}
			else
			{
				$data['message'] = "*Комментарий слишком короткий!";
			}
		}
		else
		{
			$data['message'] = "<a href='#modal-1' class='sign-in'>*Авторизируйтесь!</a>";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function addArtComm()
    {
		$conn = ConnectionManager::get('default');
		
		$user_id 		= UID;
		$coment 		= strip_tags(str_replace("'","\'",$_POST['coment']));
		$art_id 		= $_POST['art_id'];
		$rating			= "5";
		$date 			= date("Y-m-d H:i:s", time());
		
		
		if($user_id)
		{	
			if(strlen($coment) >=5)
			{	
				
				$selectUser = $conn->query("
					SELECT name
							FROM osc_users
							WHERE id='$user_id'
							LIMIT 1
					"
					)->fetch('assoc');
				
				$user_name = $selectUser['name'];
				
				$eddReview = $conn->query("
				INSERT INTO osc_article_comments (art_id, user_id, comment, name, rating, block, dateCreate, dateModify) 
						 VALUES 
						 ('$art_id', '$user_id', '$coment', '$user_name', '$rating', '1', '$date', '$date')
				"
				);
				
				if($eddReview)
				{	
					$selectArt = $conn->query("
						SELECT alias, name
								FROM osc_articles
								WHERE id='$art_id'
								LIMIT 1
						"
						)->fetch('assoc');
					
					$item_name = $selectArt['name'];
					$item_alias = $selectArt['alias'];
				
					$message = "";
					
					$to  = TECHMAIL; 
						$subject = "Новый отзыв на itfurline.com";
						$message .= ' 
						<html> 
						<head> 
						<title>Прокомментированна статья на itfurline.com</title> 
						</head> 
						<body> 
						<h2 style="color: #686b60;">Новый отзыв на статью <a href="http://itfurline.com/blog/'.$item_alias.'">'.$item_name.'</a> на <a href="http://itfurline.com/">itfurline.com</a> </h2>
											
						<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$user_name.'</span></p>			
						<hr />	
						<p style="font-size: 16px;line-height: 22px; text-indent: 20px;">Комментарий: <span style="color: #0000;">'.$coment.'</span></p>	
						</body> 
						</html>';
		
						$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
						$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 
		
						mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					$data['message'] = "Сообщение успешно отправлено";
				}
				else
				{
					$data['message'] = "*Не удалось добавить запись!";
				}							
				
			}
			else
			{
				$data['message'] = "*Комментарий слишком короткий!";
			}
		}
		else
		{
			$data['message'] = "<a href='#modal-1' class='sign-in'>*Авторизируйтесь!</a>";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
	public function callback()
    {
		$conn = ConnectionManager::get('default');
		
		$name			= $_POST['name'];
		$phone 			= $_POST['phone'];
		
		
		if($name)
		{	
			if(strlen($phone) >=17)
			{	
					
				$message = "";
				
				$to  = TECHMAIL; 
					$subject = "Обратный звонок на itfurline.com";
					$message .= ' 
					<html> 
					<head> 
					<title>Запрос на обратный звонок из сайта itfurline.com</title> 
					</head> 
					<body> 
					<h2 style="color: #686b60;">Поступил новый запрос на обратный звонок из сайта <a href="http://itfurline.com/">itfurline.com</a> </h2>
										
					<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Имя отправителя: <span style="color: #0000;">'.$name.'</span></p>	
					<p style="font-size: 18px;line-height: 22px; text-indent: 20px;">Телефон отправителя: <span style="color: #ef692a;">'.$phone.'</span></p>				
					<hr />
					</body> 
					</html>';

					$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
					$headers .= "From: ".TECHMAIL." <".TECHMAIL.">\r\n"; 

					mail($to, $subject, $message, $headers);
				
					$data['status'] = "success";
					$data['message'] = "Сообщение успешно отправлено";							
				
			}
			else
			{
				$data['message'] = "Введите корректный <span>немер телефона*</span>";
			}
		}
		else
		{
			$data['message'] = "Не заполнено поле <span>Имя*</span>";
		}
			
	echo json_encode($data);
	exit();
		
	}
	
}
