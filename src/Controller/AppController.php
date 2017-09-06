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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
	 
	public $ri = array();
	 
    public function initialize()
    {
		$conn = ConnectionManager::get('default');

		// start of redirect script

			$uri_pre = "";
			$sru = str_replace($uri_pre,"",$_SERVER['REQUEST_URI']);
			
			if (is_string($sru)) {
				$sru = trim($sru);
				$sru=htmlentities($sru, ENT_QUOTES, 'utf-8');
			}    
			
			$redirectData = $conn->query("SELECT `new_urls` FROM `osc_redirect` WHERE `old_urls`='$sru' LIMIT 1")->fetch('assoc');
			
			if($redirectData){
				$to = $uri_pre.$redirectData['new_urls'];
				
				//echo "<pre>"; print_r($redirectData); echo "</pre>"; exit();
				
				header("HTTP/1.1 301 Moved Permanently");
				header("location: $to"); 
				exit();
			}else
			{
				$cat_searchKey = "/rus/shop/catu_";
				
				$catFilterSubStr = str_replace($cat_searchKey,"",$sru);
				
				if( $sru != $catFilterSubStr )
				{
					$catFilterSubStrSplit = mb_split("-",$catFilterSubStr);
					$filterCatID = ($catFilterSubStrSplit ? (int)$catFilterSubStrSplit[0] : 0);
					
					$to = $uri_pre."/ru/catalog/";
					
					if($filterCatID)
					{
						$catInfo = $conn->query("SELECT `alias` FROM `osc_shop_catalog` WHERE `id`='$filterCatID' LIMIT 1")->fetch('assoc');
						
						if($catInfo)
						{
							$catAlias = $catInfo['alias'];
							$to = $uri_pre."/ru/catalog/".$catAlias."/";
						}
					}

					//die($to);

					header("HTTP/1.1 301 Moved Permanently");
					header("location: $to"); 
					exit();

				}
				elseif($sru!="" && $sru != "/"){
					
					//die("2: ");
					
					$sruExplode = mb_split("/",$sru);
					
					// if(isset($_GET['utm']) && $_GET['utm']=='mmm'){ echo "<pre>"; print_r($sruExplode); echo "</pre>"; exit(); }
				
					if(count($sruExplode) > 1){
						if($sruExplode[count($sruExplode)-1][0]=='?'){
								array_pop($sruExplode);
								//if(isset($_GET['utm']) && $_GET['utm']=='mmm'){ echo "<pre>EX1: "; print_r($sruExplode); echo "</pre>"; exit(); }
								//echo "<pre>EX 2: "; print_r($sruExplode); echo "</pre>"; exit();
							}
					}
					
					if(count($sruExplode) > 1){
						if($sruExplode[1]!="" && $sruExplode[1]!="ru" && $sruExplode[1]!="en" &&  $sruExplode[1]!="ua" && 
							$sruExplode[1]!="404" && $sruExplode[1]!="ajax" && $sruExplode[1]!="home" && $sruExplode[1]!="Projects" && $sruExplode[1]!="Catalog"){
						
							$to = $uri_pre."/404/";
						
							//echo "<pre>!!!! "; print_r($to); echo "</pre>"; exit();
							
							header("HTTP/1.1 301 Moved Permanently");
							header("location: $to"); 
							exit();
						}
					}
				}else{
					//die("3: ");
					}
			}
			
		// end of redirect script
		
		// echo "<pre>SERVER: "; print_r($_SERVER); echo "</pre>"; exit();
		
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		
		session_start();
		define('SESID', session_id());
		if (isset($_SESSION['online'])) {
            define('ONLINE', true);
			define('UID', $_SESSION['online']);
        }else{
            define('ONLINE', false);
			define('UID', "0");
        }
		
		
		
		$userLogin = $conn->query("
            SELECT login FROM osc_users WHERE `id` = '".UID."' LIMIT 1
        ")->fetch('assoc');
		
		if ($userLogin){
			define("ULOG",$userLogin['login']);
		}
		
		define("RS", "/");
		define("IMG", "/img/");
		define("PIMG", "split/files/shop/products/");	
		define("FINIMG", "split/files/shop/finishes/");	
		define("CFINIMG", "split/files/shop/finishes/crop/");	
		define("PVID", "/img/split/files/shop/products/video/");
		define("CIMG", "split/files/shop/products/crop/");
		define("PJIMG", "split/files/projects/");	
		define("PJCIMG", "split/files/projects/crop/");
		define("BIMG", "split/files/projects/");
		define("GIMG", "split/files/content/");
		define("GCIMG", "split/files/content/crop/");
		define("UIMG", "split/files/users/");
		define("CATIMG", "split/files/shop/categories/");
		
		
		
		if(isset($_COOKIE['rete_prefix']))
		{
			switch($_COOKIE['rete_prefix'])
			{
				case 'uah':{
					define("RATE_PREFIX", "");
					define("CURNAME", "грн");
					break;
					}
				case 'rub':{
					define("RATE_PREFIX", "rub_");
					define("CURNAME", "RUB");
					break;
					}
				case 'eur':{
					define("RATE_PREFIX", "eur_");
					define("CURNAME", "EUR");
					break;
					}
					
				case 'usd':{
					define("RATE_PREFIX", "usd_");
					define("CURNAME", "USD");
					break;
					}
				default:{
					define("RATE_PREFIX", "eur_");
					define("CURNAME", "EUR");
					break;
					}
			}	
		}else
		{
			define("RATE_PREFIX", "eur_");
			define("CURNAME", "EUR");
		}
		
		
		if(isset($_COOKIE['lang_prefix']))
		{	
			$lang = $_COOKIE['lang_prefix'];		
			$this->set("lang", $lang);
			define("LANG", $lang);
			
			if ($_COOKIE['lang_prefix'] == "ru"){
				define("LANG_PREFIX", "");
			}else{
				define("LANG_PREFIX", $lang."_");
				}
				
		}else
		{
			define("LANG_PREFIX", "");
			$lang = "ru";
			$this->set("lang", $lang);
			define("LANG", $lang);
		}
		
		if(isset($_COOKIE['pr_column']))
		{	
			if ($_COOKIE['pr_column'] == 2){
				define("PR_COLUMN", "two");
			}else{
				define("PR_COLUMN", "three");
				}
		}else
		{
			define("PR_COLUMN", "three");
		}
		
		
		if(isset($_COOKIE['pr_qty']))
		{
			define("PR_QTY", $_COOKIE['pr_qty']);
		}else
		{
			define("PR_QTY", "12");
		}
		
		
		if(isset($_COOKIE['price_line']))
		{
			if ($_COOKIE['price_line'] == "desc"){
				define("PRICE_LINE", "DESC");
			}else{
				define("PRICE_LINE", "");
				}
		}else
		{
			define("PRICE_LINE", "");
		}
		
		if(isset($_COOKIE['project_line']))
		{
			if ($_COOKIE['project_line'] == "name"){
				define("PROJECT_LINE", "name");
			}elseif($_COOKIE['project_line'] == "new"){
				define("PROJECT_LINE", "new");
				}
		}else
		{
			define("PROJECT_LINE", "new");
		}
		
		
		if(isset($_COOKIE['site_search']))
		{
			define("SEARCH", $_COOKIE['site_search']);
		}else
		{
			define("SEARCH", "");
		}
		
		if(isset($_GET['mmm']))
		{		
			echo "<pre>"; print_r($_COOKIE); echo "</pre>"; 
		}		
		
		if(isset($_COOKIE['mf_list_type']))
		{	
			if ($_COOKIE['mf_list_type'] == "tree"){
				define("MFVIEW", $_COOKIE['mf_list_type']);
			}else{
				define("MFVIEW", "");
				}
		}else
		{
			define("MFVIEW", "three");
		}		
		
		if(isset($_COOKIE['mf_abc']))
		{	
			define("MFABC", $_COOKIE['mf_abc']);
		}else
		{
			define("MFABC", "");
		}
		
		
		
		// GET FA AND LA
        $ri_trim = trim($_SERVER['REQUEST_URI'],'/\\');
        $ri = explode("/",$ri_trim);
		
		/*
		//  $ri = [ 0=>'catalog',..., 3=>'?page=2' ];
		
		//	count($ri) = 4;
		*/
		
        if(!$ri){
            // header("Location: ".RS."404/");
            debug($ri);
			exit();
        }else{ 
            
			// Проверяем, если мы на локалке - удаляем первый алиас - название папки на локалхост
			
			if(count($ri) > 1){
                if($ri[0]=="lf-cake") array_shift($ri);
            }
            if(strpos($ri[0], "index.php") !== false || trim($ri[0]) == "" || $ri[0] =="lf-cake"){ 
                $ri[0] = "home";
            }
			//echo "<pre>"; print_r($ri); echo "</pre>";  exit();
			// Проверяем, если последний алиас - список GET параметров - удаляем последний алиас
			
            $lastAlias = $ri[count($ri)-1];
            if($lastAlias[0]=='?' && count($ri) > 1){
                $lastAlias = $ri[count($ri)-2];
            }
			
			$currUrl = "/";
			
			foreach($ri as $url_item)
			{
				if($url_item[0]=='?') break;
				$currUrl .= $url_item."/";
			}
			
			$langUrl = "";
			$urlI = "";
			
			foreach($ri as $url_item)
			{
				$urlI++;
				if($url_item[0]=='?') break;
				if($urlI>=2) {
					$langUrl .= $url_item."/";
				}
			}
			//echo "<pre>"; print_r($currUrl); echo "</pre>";  exit();
			
			$prevUrl = RS;
			$i = 0;
			foreach($ri as $url_item)
			{
				$i++;
				if($i >= count($ri)) break;
				$prevUrl .= $url_item."/";
			}
			
			define("CURR_URL", $currUrl);			
			define("LANG_URL", $langUrl);
			define("PREV_URL", $prevUrl);
			
            define("FA",$ri[0]);   
            define("LA",$lastAlias);
        }	
		
		$_SESSION['ri'] = $ri;
		$this->ri = $ri;	
		
		define('UTP', "rt");
        define('UTP_PREFIX', "");
		
		define("PROJECTS_QTY", 10);
		
		/*
		
		LOAD COMPONENT HELPER
		
		*/
		
		// GET TOTAL CONFIG
        //$site_config = $this->Help->getGlobalConfig();
        //$shop_config = $this->Help->getShopConfig();

        define('PRODS_BY_PAGE', 9); // $shop_config['prods_by_page']
        define('WS_LIMIT', 100);
		
		$this->loadComponent('Help');
		
		$site_langs = $conn->query("
            SELECT M.*,
			(SELECT alias FROM osc_languages WHERE id = M.lang_id LIMIT 1) as alias
			FROM osc_site_languages as M
			WHERE M.block = 0 
			ORDER BY M.order_id
			LIMIT 20
        ")->fetchAll('assoc');
		$this->set("site_langs", $site_langs);
		//echo "<pre>"; print_r($site_langs); echo "</pre>";  exit();
		
		
		$site_translate = $conn->query("
            SELECT text as ru_text, ".LANG_PREFIX."text as text
			FROM osc_static_translations
			LIMIT 1000
        ")->fetchAll('assoc');
		$this->set("site_translate", $site_translate);
		//echo "<pre>"; print_r($site_translate); echo "</pre>";  exit();
		
		$mn=0; foreach ($site_translate as $translate){					
			if ($translate['ru_text'] == "Итальянская мебель") {
				$mn++;
				if ($mn==1 ) {
					$mName = $translate['text'];
					define("MNAME",$translate['text']);
				}
			}
		}
		
		
		
		
		$menu = $conn->query("
            SELECT M.".LANG_PREFIX."name as name, M.id, M.alias, M.type,
			(SELECT parent FROM osc_menu WHERE parent = M.id LIMIT 1) as 'drop'
			FROM osc_menu as M
			WHERE M.block = 0 AND 
			M.parent = 0 
			ORDER BY M.pos_id
        ")->fetchAll('assoc');
		
		foreach ($menu as &$sub_menu){
			
			$sub_menu['submenu'] = $conn->query("
			SELECT M.".LANG_PREFIX."name as name, M.id, M.parent, M.alias, M.type
						FROM osc_menu as M 
						WHERE M.parent=".$sub_menu['id']."
						AND  M.block=0
						ORDER BY M.pos_id, M.id
						LIMIT 1000
			")->fetchAll('assoc');
			
			}
		$this->set("menu", $menu);
		//echo "<pre>"; print_r($menu); echo "</pre>";  exit();
		
		$subMenu = $conn->query("
            SELECT ".LANG_PREFIX."name as name, id, parent, alias FROM osc_menu WHERE `block` = 0 AND `parent` != 0 ORDER BY `pos_id`
        ")->fetchAll('assoc');
		$this->set("subMenu", $subMenu);
		
		
		$catalog = $conn->query("
            SELECT ".LANG_PREFIX."name as name, alias, id FROM osc_shop_catalog WHERE `block` = 0 AND `parent` = 0 ORDER BY `pos` LIMIT 100
        ")->fetchAll('assoc');
		$this->set("catalog", $catalog);
		
		$parent_catalog = $conn->query("
            SELECT ".LANG_PREFIX."name as name, ".LANG_PREFIX."details as details, alias, id, parent, filename FROM osc_shop_catalog WHERE `block` = 0 AND parent != 0 ORDER BY `pos`
        ")->fetchAll('assoc');
		$this->set("parent_catalog", $parent_catalog);	
		
		// STAT PAGES INFO
		$pageInfo = $conn->query("
            SELECT id, ".LANG_PREFIX."name as name, ".LANG_PREFIX."details as details
			FROM osc_menu WHERE `alias` = '".LA."' LIMIT 1
        ")->fetch('assoc');		
		if ($pageInfo){
			define("PNAME",$pageInfo['name']);
			define("PID",$pageInfo['id']);
		}
		else{
			define("PNAME","");
			define("PID","");
			}	
		if ($pageInfo['details']){
			define("PDET",$pageInfo['details']);
		}
		else{
			define("PDET","");
			}	
		
		$breadCrumbs = [];
					
		$bcMenu = $conn->query("
			SELECT id, parent, ".LANG_PREFIX."name as name, alias
						FROM osc_menu
						WHERE id = '".PID."'
						LIMIT 1
		")->fetch('assoc');
		
		array_push ($breadCrumbs, $bcMenu);
		
		while ($bcMenu['parent']>0){
			$bcMenu = $conn->query("
			SELECT id, parent, ".LANG_PREFIX."name as name, alias
						FROM osc_menu
						WHERE id = '".$bcMenu['parent']."'
						LIMIT 1
			")->fetch('assoc');
			array_push ($breadCrumbs, $bcMenu);
			}
		
		$breadCr = array_reverse ($breadCrumbs);
		$this->set("breadCr", $breadCr);
		// AND STAT PAGES INFO

		//CART
		$cartQty = "0";
		$cartSum = "0";
		$prodSum = "0";
		$user_id 		= UID;
		$session_id 	= SESID;
			
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
		
		$cartQty = $countQuery['cart_quant'];
		$this->set("cartQty", $cartQty);// К-во товаров в корзине
		//"<pre>"; print_r($cartQty); echo "</pre>"; exit();		
		
		$mainCartList =  $conn->query(
			"
			SELECT C.*,  P.".LANG_PREFIX."name as prod_name, P.alias as prod_alias, P.sku as prod_sku, P.".RATE_PREFIX."price as prod_price,
				(SELECT crop FROM osc_files_ref WHERE ref_table='shop_products' AND ref_id=C.prod_id ORDER BY id LIMIT 1) as prod_crop, 
				(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=P.obj_id LIMIT 1) as obj_name
				FROM osc_shop_cart as C
				LEFT JOIN `osc_shop_products` as P ON P.id=C.prod_id
				WHERE C.uid = '".UID."' AND
				C.session_id='".SESID."'
				ORDER BY dateModify
			"
			)->fetchAll('assoc');
		$this->set("mainCartList", $mainCartList);// Список товаров в корзине
		//echo "<pre>"; print_r($mainCartList); echo "</pre>"; exit();
		
		if ($mainCartList){
		foreach ($mainCartList as $cart){
			$prodSum = $cart['quant']*$cart['prod_price'];
			$cartSum += $prodSum;
			}
		}
		$formatCartSum = number_format($cartSum, 0, '.', '.');	
		$this->set("formatCartSum", $formatCartSum);// Сума товаров в корзине		
		// AND CART	
		
		$likeQuant = $conn->query("
				SELECT COUNT(id) as like_quant
						FROM osc_shop_like
						WHERE uid='".UID."' AND
						session_id='".SESID."'
		")->fetch('assoc');
		$this->set("likeQuant", $likeQuant['like_quant']);	
		
		$shopSettings = $conn->query("
		SELECT  terms, order_email
					FROM  osc_shop_settings
					WHERE 1
					LIMIT 1")->fetch('assoc');// Настройки магазина
		if ($shopSettings){
			define("SHOPTHERMS",$shopSettings['terms']);// Правила пользования 
			define("SHOPMAIL",$shopSettings['order_email']); //Email заказов
		}
		
		$siteSettings = $conn->query("
		SELECT  support_email, phone_number, ".LANG_PREFIX."meta_title as meta_title, ".LANG_PREFIX."meta_keys as meta_keys, ".LANG_PREFIX."meta_desc as meta_desc, fb_url, vk_url, gp_url, yt_url, in_url, ".LANG_PREFIX."shop_adress as shop_adress, copyright, map_frame, blog_qnt
					FROM  osc_total_config
					WHERE 1
					LIMIT 1")->fetch('assoc');// Настройки сайта
		if ($siteSettings){
			define("TECHMAIL", $siteSettings['support_email']);//Email техподдержки
			define("TECHPHONE", $siteSettings['phone_number']);//Телефон техподдержки
			define("MAPFRAME", $siteSettings['map_frame']);//фрейм карты
			define("COPIRIGHT", $siteSettings['copyright']);//COPIRIGHT сайта
			define("MAINADRESS", $siteSettings['shop_adress']);//Адрес компании 
			define("NEWSQNT", $siteSettings['blog_qnt']);//Недавние статьи (к-во)
			
			$metaTitle = $siteSettings['meta_title'];
			$this->set("metaTitle", $metaTitle);//title страницы
						
			$metaKeys = $siteSettings['meta_keys'];
			$this->set("metaKeys", $metaKeys);//keywords страницы
			
			$metaDesc = $siteSettings['meta_desc'];
			$this->set("metaDesc", $metaDesc);//description страницы
			
			$fb_url = $siteSettings['fb_url'];
			$this->set("fb_url", $fb_url);// страница fb
			
			$vk_url = $siteSettings['vk_url'];
			$this->set("vk_url", $vk_url);// страница vk
			
			$gp_url = $siteSettings['gp_url'];
			$this->set("gp_url", $gp_url);// страница ok
			
			$yt_url = $siteSettings['yt_url'];
			$this->set("yt_url", $yt_url);// страница yt
			
			$in_url = $siteSettings['in_url'];
			$this->set("in_url", $in_url);// страница in
		}
		
		$contactsMain = $conn->query(
					"
					SELECT ".LANG_PREFIX."city as city, ".LANG_PREFIX."adress as adress, phone_number
						FROM osc_contacts
						WHERE block = '0'
						ORDER BY order_id
						LIMIT 20
					"
					)->fetchAll('assoc');
		$this->set("contactsMain", $contactsMain);// Данные контактов в шапке/футере
		//echo "<pre>"; print_r($contactsMain); echo "</pre>";  exit();
		
		$pageMeta = $conn->query("
            SELECT meta_title, meta_keys, meta_desc 
			FROM osc_menu WHERE `alias` = '".LA."' LIMIT 1
        ")->fetch('assoc');		
		if ($pageMeta){
									
			if ($pageMeta['meta_title']) {
			$metaTitle = $pageMeta['meta_title'];
			$this->set("metaTitle", $metaTitle);//title страницы
			}
			
			if ($pageMeta['meta_keys']) {
			$metaKeys = $pageMeta['meta_keys'];
			$this->set("metaKeys", $metaKeys);//keywords страницы
			}
			
			if ($pageMeta['meta_desc']) {
			$metaDesc = $pageMeta['meta_desc'];
			$this->set("metaDesc", $metaDesc);//description страницы
				}
		}
		
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
