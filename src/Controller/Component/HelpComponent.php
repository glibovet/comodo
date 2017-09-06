<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Email\Email;

class HelpComponent extends Component
{
    public $conn;
    
    public $devCompany = "POSITIVE BUSINESS";
    
    public function __construct(){
        $this->conn = ConnectionManager::get('default');
    }
    
    public function safedata($value){

        if(!isset($value)) {
            return '';	
        }

        if (is_string($value)) {
            $value = trim($value);
            $value=htmlentities($value, ENT_QUOTES, 'utf-8');
        }    

        return $value;
    }

    public function xss_clean($data){

            if (is_array($data)) {
                    $cleaned_array = array();

                    foreach($data as $name => $value) {
                            $cleaned_array[$name] = $this->safedata($value);
                    }
                    return $cleaned_array;		
            }
            return $cleaned_data = $this->safedata($data);
    }

    public function _post($param,$defvalue = '') {
        if(!isset($_POST[$param])) 	{
            return $defvalue;
        }
        else {
            return $this->safedata($_POST[$param]);
        }
    }

    public function _get($param,$defvalue = '')
    {
        if(!isset($_GET[$param])) {
            return $defvalue;
        }
        else {
            return $this->safedata($_GET[$param]);
        }
    }

    public function _action() {
        if(!isset($_POST['action'])) 	{
            return false;
        }
        else {
            return $this->safedata($_POST['action']);
        }
    }

    public function _pre( $arr, $ext=false ) {
        echo "<pre>";
            print_r($arr);
            echo "</pre>";

            if($ext) exit();
    }
    
    public function r2($to,$ntype='e',$msg=''){
        if($msg==''){
            header("HTTP/1.1 301 Moved Permanently");
            header("location: $to"); exit;
        }
        $_SESSION['ntype']=$ntype ; $_SESSION['notify']=$msg ;
        header("HTTP/1.1 301 Moved Permanently");
        header("location: $to"); exit;
    }

    public function q($query, $fetch = 0){
        if (isset($fetch) && $fetch == 0) {
            return $this->conn->query($query)->fetchAll('assoc');
        }elseif(isset($fetch) && $fetch == 1){
            return $this->conn->query($query)->fetch('assoc');
        }elseif(isset($fetch) && $fetch == 2){
            return $this->conn->query($query);
        }else{
            exit('query expect params');
        }
    }

    static function now(){
        return $now = date("Y-m-d H:i:s");
    }

    public function cutStr($str, $len){
        return (implode(array_slice(explode('<br>',wordwrap(strip_tags($str),$len,'<br>',false)),0,1)))."...";
    }
   
    /* HELPER START <3 */

    public function getMenu(){
        return $this->conn->query("
            SELECT M.alias, M.".LANG_PREFIX."details as details, M.target, M.".LANG_PREFIX."name as name, M.caption
            FROM `osc_menu` AS M
            WHERE M.block = 0
            ORDER BY M.order_id
            LIMIT 1000
        ")->fetchAll('assoc');
    }

    public function getPageContent($alias){
        $q = "
            SELECT M.".LANG_PREFIX."details as details
            FROM `osc_menu` AS M
            WHERE M.block = 0 AND M.alias = '$alias'
            LIMIT 1
        ";
        return $this->conn->query($q)->fetch('assoc');;
    }

    public function questionForm(){
        $data = ['status'=>'failed', 'message'=>'Tech error', 'reason'=>'default'];

        $name = $this->_post('name');
        $email = $_POST['email'];
        $message = $this->_post('message');
        $now = date("Y-m-d H:i:s");


        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (mb_strlen($name) >= 2) {
                if (mb_strlen($message) >= 10) {
                    $q = "
                        INSERT INTO `osc_income_questions` (`email`, `name`, `message`, `dateCreate`, `dateModify`, `viewed`)
                        VALUES ('$email', '$name', '$message', '$now', '$now', 0)
                    ";
                    $action = $this->conn->query($q);
                    if ($action) {
                        $data['status'] = "success";
                        $data['message'] = (LANG == 'ru' ? 'Ваше сообщение отправлено' : 'Your message has been sent');
                        $data['reason'] = "success";
                        return $data;
                    }
                }else{
                    $data['status'] = "failed";
                    $data['message'] = (LANG == 'ru' ? 'Вопрос должен содержать 10 или больше символов' : 'Question must consist of 10 or more symbols');
                    $data['reason'] = "message";
                    return $data;
                }
            }else{
                $data['status'] = "failed";
                $data['message'] = (LANG == 'ru' ? 'Имя должно содержать 2 или больше символов' : 'Name must consist of 2 or more symbols');
                $data['reason'] = "name";
                return $data;
            }
        }else{
            $data['status'] = "failed";
            $data['message'] = (LANG == 'ru' ? 'Введите корректный email' : 'Enter correct email');
            $data['reason'] = "email";
            return $data; 
        }
    }

    public function getGlobalConfig(){
        $q = "
            SELECT M.*
            FROM `osc_total_config` AS M
            LIMIT 1
        ";
        return $this->q($q, 1);
    }

    public function getShopConfig(){
        $q = "
            SELECT M.*
            FROM `osc_shop_settings` AS M
            LIMIT 1
        ";
        return $this->conn->query($q)->fetch('assoc');
    }

    public function getMenuMeta($FA){
        $q = "
            SELECT M.meta_title, M.meta_desc, M.meta_keys
            FROM `osc_menu` AS M
            WHERE M.alias = '$FA'
            LIMIT 1
        ";
        return $this->conn->query($q)->fetch('assoc');
    }

    public function getCategoryMeta($id){
        $q = "
            SELECT M.meta_title, M.meta_keys, M.meta_desc, M.index 
            FROM `osc_shop_catalog` AS M WHERE M.id = '$id' LIMIT 1
        ";
        return $this->q($q, 1);
    }

    public function getArticlesList($cat_id, $start, $per_page){
        $q = "
            SELECT M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."content as content, M.filename, M.dateCreate, M.target, M.alias, M.".LANG_PREFIX."style as style, M.".LANG_PREFIX."magazine as magazine, M.part_link
            FROM `osc_articles` AS M
            WHERE M.block = 0 AND M.cat_id = $cat_id
            ORDER BY M.order_id
            LIMIT $start, $per_page
        ";
        return $this->conn->query($q)->fetchAll('assoc');
    }

    public function getArticle($LA, $cat_id){
        // ARTICLE
        $q = "
            SELECT M.id, M.".LANG_PREFIX."name as name, M.".LANG_PREFIX."content as content, M.meta_title, M.meta_desc, M.meta_keys, M.alias, M.filename, M.plan_image, M.target, M.dateCreate, M.".LANG_PREFIX."style as style, M.".LANG_PREFIX."magazine as magazine
            FROM `osc_articles` AS M
            WHERE M.alias = '$LA' AND M.cat_id = $cat_id AND M.block = 0
        ";
        $article =  $this->conn->query($q)->fetch('assoc');

        // GALLERY
        $q = "
            SELECT F.file
            FROM `osc_articles` AS M
            LEFT JOIN `osc_galleries` AS G ON G.id = M.gallery_id
            LEFT JOIN `osc_files_ref` AS F ON F.ref_id = G.id
            WHERE M.block = 0 AND M.alias = '$LA' AND G.block = 0
        ";
        $art_gallery = $this->conn->query($q)->fetchAll('assoc');

        // NEXT ARTICLE
        $curr_id = $article['id'];
        $q = "
            SELECT M.alias 
            FROM `osc_articles` AS M
            WHERE M.id > $curr_id AND M.cat_id = $cat_id
            LIMIT 1
        ";

        if (!$curr_id) {
            $this->r2(RS.'404/');
        }
        $next_article = $this->conn->query($q)->fetch('assoc');


        return array('article'=>$article, 'gallery'=>$art_gallery, 'next_article'=>$next_article);
    }

    public function getPagination($cat_id, $per_pag){
        $per_page = $per_pag;
        $cur_page = 1;

        if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = $_GET['page'];
        $start = ($cur_page - 1) * $per_page;

        $q = "SELECT COUNT(`id`) as count FROM `osc_articles` WHERE `block` = 0 AND `cat_id` = $cat_id";
        $count_posts = $this->conn->query($q)->fetch('assoc');
        $num_pages = ceil($count_posts['count'] / $per_page);

        return array('num_pages'=>$num_pages, 'cur_page'=>$cur_page, 'start'=>$start, 'per_page'=>$per_page);
    }

    public function buildSitemap(){
        $menu_links = array();
        $projects_links = array();
        $media_links = array();


        //MENU
        $map_query = $this->conn->query("
            SELECT `name`, `alias` FROM `osc_menu` WHERE `block` = 0 ORDER BY `id` LIMIT 1000;
        ")->fetchAll('assoc');

        foreach ($map_query as $key) {
            $menu_links[$key['name']] = $key['alias'];
        }
        $manu_alias = array_flip($menu_links);

        //CATALOG PARENT CAT
        if (isset($manu_alias['catalog'])) {
            $map_query = $this->conn->query("
                SELECT M.id, M.name, M.alias
                FROM `osc_shop_catalog` AS M
                WHERE M.block = 0 AND M.parent = 0
            ")->fetchAll('assoc');
            foreach ($map_query as $key) {
                $catalog_links[$key['name']] = array('id'=>$key['id'], 'alias' => $key['alias']);
            }

            //CATALOG CHILD CAT
            $q = "SELECT M.name, M.alias, M.id, M.parent FROM `osc_shop_catalog` AS M WHERE M.parent != 0 ORDER BY M.id LIMIT 1000";
            $map_query = $this->q($q);
            foreach ($map_query as $i => $key) {
                $child_cats[$i] = array('parent'=>$key['parent'], 'alias'=>$key['alias'], 'name'=>$key['name'], 'id'=>$key['id']);
            }


        }else{
            $catalog_links = array();
            $child_cats = array();
        }



        $products = array();

        $q = "
            SELECT M.id, M.name, C.id as cat_id 
            FROM `osc_shop_products` AS M
            LEFT JOIN `osc_shop_catalog` AS C ON C.id = M.cat_id
            WHERE M.block = 0
            GROUP BY M.id
            ORDER BY M.id
            LIMIT 10000 
        ";
        //$products = $this->q($q);
        //debug($products);

        //CATALOG PARENT CAT
        if (isset($manu_alias['gallery'])) {
            $map_query = $this->conn->query("
                SELECT M.id, M.name, M.gal_type
                FROM `osc_galleries` AS M
                WHERE M.block = 0
            ")->fetchAll('assoc');
            foreach ($map_query as $key) {
                $gal_links[$key['name']] = array('id'=>$key['id'], 'name' => $key['name'], 'gal_type' => $key['gal_type']);
            }
        }else{
            $gal_links = array();
        }

        //MEDIA
        if (isset($manu_alias['media'])) {
            $map_query = $this->conn->query("
                SELECT M.name, M.alias
                FROM `osc_articles` AS M
                WHERE M.block = 0 AND M.id = '$cat_id'
            ")->fetchAll('assoc');
            foreach ($map_query as $key) {
                $media_links[$key['name']] = $key['alias'];
            }
        }else{
            $media_links = [];
        }


        return [
            'menu_links'=> $menu_links,
            'catalog_links'=> $catalog_links,
            'media_links'=> $media_links,
            'child_cats'=> $child_cats,
            'products'=> $products,
            'gal_links'=>$gal_links
        ];
        
    }

    public function send_mail($receiver, $subject, $message, $from, $from_title, $type=""){

        $email = new Email('default');
        $email->from([$from => $from_title])->emailFormat('html')->to($receiver)->subject($subject)->send($message);       
        
    }

    public function getShopParentCategories(){
        $q = "
            SELECT 
                M.name, 
                M.alias,
                M.id
            FROM `osc_shop_catalog` as M
            WHERE M.block = 0 AND M.parent = 0
            ORDER BY M.order_id
            LIMIT 1000
        ";

        return $this->q($q);
    }

    public function getShopChildCategories(){
        $q = "
            SELECT 
                M.name, 
                M.alias,
                M.id,
                M.parent
            FROM `osc_shop_catalog` as M
            WHERE M.block = 0 AND M.parent != 0
            ORDER BY M.order_id
            LIMIT 1000
        ";

        return $this->q($q);
    }


    public function register(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>''];

        $name = $this->_post('name');
        $phone = $this->_post('phone');
        $email = strip_tags(str_replace("'", "", trim($_POST['email'])));
        $u_type = $this->_post('u_type');
        $password = $this->_post('password');
        $password_confirm = $this->_post('password_confirm');

        $action = false;
        // VALIDATION
        if (mb_strlen($name) >= 2) {
            $valid_phone = $this->check_phone($phone);
            if (mb_strlen($phone) == 15 && $valid_phone) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // TEST USER
                    $q = "
                        SELECT M.id
                        FROM `osc_users` AS M
                        WHERE M.login = '$email'
                        LIMIT 1
                    ";
                    $test_user = $this->q($q, 1);
                    if (!$test_user['id']) {
                        if ($u_type == 1 || $u_type == 2) {
                            if (mb_strlen($password) > 5) {
                                if ($password == $password_confirm) {
                                    $action = true;
                                }else{
                                    $data['reason'] = "password_confirm";
                                    $data['message'] = "Пароли не совпадают";
                                }
                            }else{
                                $data['reason'] = "password";
                                $data['message'] = "Длинна пароля должна быть миниум 6 символов";
                            }
                        }else{
                            $data['reason'] = "u_type";
                            $data['message'] = "Выберите тип учетной записи.";
                        }
                    }else{
                        $data['reason'] = "user_exist";
                        $data['message'] = "Такой email уже существует.";
                    }
                }else{
                    $data['reason'] = "email";
                    $data['message'] = "Укажите корректный email.";
                }
            }else{
                $data['reason'] = "phone";
                $data['message'] = "Укажите корректный телефон.";
            }
        }else{
            $data['reason'] = "name";
            $data['message'] = "Минимальная длинна имени - 2 символа.";
        }

        if ($action === true) {
            $password_md = md5($password);
            $user_type = ($u_type == 1 ? '20' : '30');

            $sitename = $this->getGlobalConfig()['sitename'];
            $from = $this->getGlobalConfig()['support_email'];

            $now = HelpComponent::now();
            $q = "
                INSERT INTO `osc_users`
                (`type`, `login`, `pass`, `phone`, `name`, `dateCreate`, `dateModify`)
                VALUES
                ('$user_type', '$email', '$password_md', '$phone', '$name', '$now', '$now')
            ";
            $insert = $this->q($q, 2);
            if ($insert) {
                $data['reason'] = "";
                $data['message'] = "Успешная регистрация";
                $data['status'] = "success";
                $data['ref'] = "";

                $uid = $insert->lastinsertId();

                $_SESSION['login'] = array();
                array_push($_SESSION['login'], $uid);
                array_push($_SESSION['login'], $user_type);

                $receiver = $email;
                $subject = "Успешная регистрация на ".$sitename.".";
                $message = ' 
                <html> 
                <head> 
                <title>Успешная регистрация на <b>'.$sitename.'</b>.</title> 
                </head> 
                <body> 
                    <p>Вы прошли успешную регистрацию на сайте.</p>
                    <hr />
                    <p>Ваши регистрационные данные:</p>
                    <p>Логин: <b>'.$email.'</b></p>
                    <p>Пароль: <b>'.$password.'</b></p>
                    <hr />
                    <p>Спасибо за регистрацию.</p>
                </body> 
                </html>';

                $from_title = "OnePolar";
                
                $email_obj = new Email('default');
                $email_obj->from(['onepolar.ukraine@gmail.com' => 'OnePolar Ukraine'])
                    ->emailFormat('html')
                    ->to($receiver)
                    ->subject($subject)
                    ->send($message);
            }
            return $data;
        }else{
            return $data;
        }
    }

    public function login(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>''];
        $email = $this->_post('email');
        $password = $this->_post('password');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $q = "
                SELECT M.id, M.pass, M.type
                FROM `osc_users` AS M
                WHERE M.login = '$email' AND M.block = 0
                LIMIT 1
            ";
            $user = $this->q($q, 1);
            if ($user) {
                if ($user['pass'] == md5($password)) {
                    $_SESSION['login'] = array();
                    array_push($_SESSION['login'], $user['id']);
                    array_push($_SESSION['login'], $user['type']);
                    $data['status'] = "success";
                    $data['reason'] = "";
                    $data['message'] = "Вход...";
                    $data['ref'] = "profile/";

                    //$this->updateUser($user['id'], session_id());
                }else{
                    $data['reason'] = "password";
                    $data['message'] = "Неправильный пароль.";
                }
            }else{
                $data['reason'] = "email";
                $data['message'] = "Такого пользователя не существует.";
            }
        }else{
            $data['reason'] = "email";
            $data['message'] = "Введите корректный email.";
        }
        
        return $data;
    }

    public function forgot(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>''];
        $email = $this->_post('email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $q = "
                SELECT M.id, M.pass, M.type, M.login
                FROM `osc_users` AS M
                WHERE M.login = '$email'
                LIMIT 1
            ";
            $user = $this->q($q, 1);
            if ($user) {
                $uid = $user['id'];
                // NEW PASSWORD GENERATION
                $new_pass = $this->getRandPass();
                $new_pass_md = md5($new_pass);
                $q = "
                    UPDATE `osc_users` 
                    SET 
                        `pass` = '$new_pass_md'
                    WHERE `id` = '$uid'
                    LIMIT 1
                ";
                $update = $this->q($q, 2);

                if ($update) {
                    $sitename = $this->getGlobalConfig()['sitename'];
                    $from = $this->getGlobalConfig()['support_email'];

                    $receiver = $user['login'];
                    $subject = "Восстановление пароля на ".$sitename.".";
                    $message = ' 
                    <html> 
                    <head> 
                    <title>Восстановление пароля на '.$sitename.'.</title> 
                    </head> 
                    <body> 
                        <p>Ваш новый пароль: '.$new_pass.'</p>
                        <hr />
                        <p>Изменить пароль Вы можете перейдя по ссылке ниже.</p>
                        <p>http://www.one_polar/profile/</p>
                    </body> 
                    </html>';
                    
                    $from_title = "OnePolar";

                    $email_obj = new Email('default');
                    $email_obj->from(['onepolar.ukraine@gmail.com' => 'OnePolar Ukraine'])
                    ->emailFormat('html')
                    ->to($receiver)
                    ->subject($subject)
                    ->send($message);
                }
            }else{
                $data['reason'] = "email";
                $data['message'] = "Такого пользователя не существует.";
            }
        }else{
            $data['reason'] = "email";
            $data['message'] = "Введите корректный email.";
        }
        return $data;
    }

    public function recall(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>''];

        $phone = $this->_post('phone');
        $time = $this->_post('time');
        $now = HelpComponent::now();

        $valid_phone = $this->check_phone($phone);
        if (mb_strlen($phone) == 15 && $valid_phone) {
            $q = "
                INSERT INTO `osc_recall`
                (`phone`, `time`, `viewed`, `dateCreate`)
                VALUES
                ('$phone', '$time', 0, '$now')
            ";
            $insert = $this->q($q, 2);

            if ($insert) {
                $data['status'] = "success";
                $data['reason'] = "";
                $data['message'] = "Мы перезвоним Вам в ближайшее время";
            }
        }else{
            $data['reason'] = "phone";
            $data['message'] = "Укажите корректный телефон.";
        }

        return $data;
    }

    public function getWishedGoods(){
        if (ONLINE) {
            $uid = UID;
            $sess_id = session_id();
            $filter = "((M.uid = '$uid') OR (M.session_id = '$sess_id'))";
        }else{
            $sess_id = session_id();
            $filter = "M.session_id = '$sess_id'";
        }
        $q = "
            SELECT M.prod_id,
                (SELECT name FROM `osc_shop_products` WHERE id = M.prod_id LIMIT 1) as prod_name,
                (SELECT preview FROM `osc_shop_products` WHERE id = M.prod_id LIMIT 1) as prod_preview,
                (SELECT ".UTP_PREFIX."price as price FROM `osc_shop_products` WHERE id = M.prod_id LIMIT 1) as prod_price,
                (SELECT ".UTP_PREFIX."sale_price FROM `osc_shop_products` WHERE id = M.prod_id LIMIT 1) as prod_sale_price,
                (SELECT sale FROM `osc_shop_products` WHERE id = M.prod_id LIMIT 1) as prod_sale,
                (SELECT quant FROM `osc_shop_products` WHERE id = M.prod_id LIMIT 1) as prod_quant
            FROM `osc_shop_like` AS M 
            INNER JOIN `osc_shop_products` as P ON P.id=M.prod_id 
            WHERE ".$filter." AND P.block=0 
            LIMIT 1000
        ";

        $wished_prods = $this->q($q);
        return $wished_prods;
    }

    public function getUniUsersForProjects(){
        // GET UNIQUE USERS FROM ALL PROJECTS
            $q = "
                SELECT 
                    DISTINCT M.user_id as id,
                    (SELECT ".LANG_PREFIX."name FROM `osc_users` WHERE id=M.user_id LIMIT 1) as name,
                    (SELECT ".LANG_PREFIX."fname FROM `osc_users` WHERE id=M.user_id LIMIT 1) as fname  
                FROM `osc_projects` AS M  
                WHERE 
                    M.block = 0 AND 
                    M.user_id != 'NULL' AND 
					M.user_id != '0'
                GROUP BY M.id, M.user_id 
                ORDER BY name  
                LIMIT 100 
            ";
            return $this->q($q);
    }
   
    public function getUniColorsFromOneCategory($cat_id){
        // GET UNIQUE COLORS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.color_id as id,
                    (SELECT value FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as value,
                    (SELECT ".LANG_PREFIX."name FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M  
                WHERE 
                    M.block = 0 AND 
                    M.cat_id = '$cat_id' AND 
					M.color_id != 'NULL' AND 
					M.color_id != '0'
                GROUP BY M.id, M.color_id 
                ORDER BY M.color_id  
                LIMIT 100 
            ";
            return $this->q($q);
    }
	
	public function getUniObjectsFromOneCategory($cat_id){
        // GET UNIQUE OBJECTS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.obj_id as id,
                    (SELECT ".LANG_PREFIX."name FROM `osc_shop_objects` WHERE id=M.obj_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M  
                WHERE 
                    M.block = 0 AND 
                    M.cat_id = '$cat_id' AND 
					M.obj_id != 'NULL' AND 
					M.obj_id != '0'
                GROUP BY M.id, M.obj_id 
                ORDER BY M.obj_id  
                LIMIT 100 
            ";
            return $this->q($q);
    }
	
	public function getUniCollectionsFromOneCategory($cat_id){
        // GET UNIQUE COLLECTIONS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.collection_id as id,
                    (SELECT ".LANG_PREFIX."name FROM `osc_shop_collections` WHERE id=M.collection_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M  
                WHERE 
                    M.block = 0 AND 
                    M.cat_id = '$cat_id' AND 
					M.collection_id != 'NULL' AND 
					M.collection_id != '0'
                GROUP BY M.id, M.collection_id 
                ORDER BY M.collection_id  
                LIMIT 100 
            ";
            return $this->q($q);
    }
	
	public function getUniMfsFromOneCategory($cat_id){
        // GET UNIQUE MFS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.mf_id as id,
                    (SELECT ".LANG_PREFIX."name FROM `osc_shop_mf` WHERE id=M.mf_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M  
                WHERE 
                    M.block = 0 AND 
                    M.cat_id = '$cat_id' AND 
					M.mf_id != 'NULL' AND 
					M.mf_id != '0'
                GROUP BY M.id, M.mf_id 
                ORDER BY M.mf_id  
                LIMIT 100 
            ";
            return $this->q($q);
    }

    public function getUniColorsFromMultCategories($parent_cat_id){
        // GET CHILD CATS
            $q = "
                SELECT M.id
                FROM `osc_shop_catalog` AS M
                WHERE
                    M.parent = '$parent_cat_id' AND
                    M.block = 0
                LIMIT 100
            ";
            $child_cats = $this->q($q);

            // CATS REF-PROD FILTER QUERY
            $cat_filter = " ( M.cat_id=$parent_cat_id ";
            foreach ($child_cats as $key => $value) {
                $cat_id = $value['id'];
                $cat_filter .= " OR M.cat_id = ".$cat_id;

                // GET SUB CHILD CATS
                $sub_q = "
                    SELECT M.id
                    FROM `osc_shop_catalog` AS M
                    WHERE
                        M.parent = '$cat_id' AND
                        M.block = 0
                    LIMIT 100
                ";
                $sub_child_cats = $this->q($sub_q);

                foreach ($child_cats as $key => $value) {
                    $cat_filter .= " OR M.cat_id = ".$value['id'];
                }

            }
            $cat_filter .= " ) ";

            // GET UNIQUE COLORS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.color_id as id,
                    (SELECT value FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as value,
                    (SELECT name FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M  
                WHERE 
                    M.block = 0 AND
                    ".$cat_filter." 
                GROUP BY R.prod_id, M.color_id 
                ORDER BY M.color_id  
                LIMIT 100 
            ";
            return $this->q($q);
    }

    public function getProdsByCat($cat_alias, $main_cat = ""){
        if ($main_cat != "") {
            // GET PARENT CAT
            $q = "
                SELECT M.id
                FROM `osc_shop_catalog` AS M
                WHERE 
                    M.parent = 0 AND
                    M.alias = '$main_cat' AND
                    M.block = 0
                LIMIT 1
            ";
            $parent_cat = $this->q($q, 1);
            $parent_cat_id = $parent_cat['id'];

            // GET CHILD CAT
            $q = "
                SELECT M.id, M.meta_title, M.meta_desc, M.meta_keys
                FROM `osc_shop_catalog` AS M
                WHERE
                    M.alias = '$cat_alias' AND
                    M.parent = '$parent_cat_id' AND
                    M.block = 0
                LIMIT 1
            ";
            $child_cat = $this->q($q, 1);
            $cat_id = $child_cat['id'];

            // GET PAG
            $per_page = PRODS_BY_PAGE;
            $cur_page = 1;
            if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = $_GET['page'];
            $start = ($cur_page - 1) * $per_page;

            // GET PRODS BY CAT
            $q = "
                SELECT 
                    SQL_CALC_FOUND_ROWS M.id,
                    M.name, 
                    M.quant, 
                    M.alias, 
                    M.".UTP_PREFIX."price as price, 
                    M.sale, 
                    M.".UTP_PREFIX."sale_price as sale_price, 
                    M.preview,
                    M.color_id 
                FROM `osc_shop_products` AS M
                WHERE 
                    M.cat_id = '$cat_id' AND
                    M.block = 0
                GROUP BY M.id  
                ORDER BY M.price 
                LIMIT $start, $per_page
            ";
            $prods = $this->q($q);

            $total_rows = $this->conn->query("SELECT FOUND_ROWS() as count")->fetch('assoc');

            // GET UNIQUE COLORS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.color_id as id,
                    (SELECT value FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as value,
                    (SELECT name FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M
                WHERE 
                    M.block = 0 AND 
                    M.cat_id = '$cat_id'  
                GROUP BY M.id, M.color_id 
                ORDER BY M.color_id  
                LIMIT 100 
            ";
            $uni_colors = $this->q($q);

            foreach ($prods as &$pc_value) {
                $q = "
                    SELECT M.id, M.value, M.name 
                    FROM `osc_shop_colors` AS M 
                    LEFT JOIN `osc_shop_products` as P ON P.color_id=M.id 
                    WHERE 
                        P.id = ".$pc_value['id']."
                    GROUP BY P.color_id 
                    LIMIT 100
                ";
                $pc_value['colors'] = $this->q($q);
            }

            return array('prods' => $prods, 'uni_colors' => $uni_colors, 'count_rows' => $total_rows['count']);
        }else{
            // GET PARENT CAT
            $q = "
                SELECT M.id, M.meta_title, M.meta_desc, M.meta_keys
                FROM `osc_shop_catalog` AS M
                WHERE 
                    M.parent = 0 AND
                    M.alias = '$cat_alias' AND
                    M.block = 0
                LIMIT 1
            ";
            $parent_cat = $this->q($q, 1);
            $parent_cat_id = $parent_cat['id'];

            // GET CHILD CATS
            $q = "
                SELECT M.id
                FROM `osc_shop_catalog` AS M
                WHERE
                    M.parent = '$parent_cat_id' AND
                    M.block = 0
                LIMIT 100
            ";
            $child_cats = $this->q($q);

            // CATS REF-PROD FILTER QUERY
            $cat_filter = " ( R.cat_id=$parent_cat_id ";
            foreach ($child_cats as $key => $value) {
                $cat_id = $value['id'];
                $cat_filter .= " OR R.cat_id = ".$cat_id;

                // GET SUB CHILD CATS
                $sub_q = "
                    SELECT M.id
                    FROM `osc_shop_catalog` AS M
                    WHERE
                        M.parent = '$cat_id' AND
                        M.block = 0
                    LIMIT 100
                ";
                $sub_child_cats = $this->q($sub_q);

                foreach ($child_cats as $key => $value) {
                    $cat_filter .= " OR R.cat_id = ".$value['id'];
                }

            }
            $cat_filter .= " ) ";

            // GET PAG
            $per_page = PRODS_BY_PAGE;
            $cur_page = 1;
            if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = $_GET['page'];
            $start = ($cur_page - 1) * $per_page;
            
            // GET PRODUCTS BY MAIN CAT
            $q = "
                SELECT 
                    SQL_CALC_FOUND_ROWS M.id,
                    M.name, 
                    M.quant, 
                    M.alias, 
                    M.".UTP_PREFIX."price as price, 
                    M.sale, 
                    M.".UTP_PREFIX."sale_price as sale_price, 
                    M.preview,
                    M.colors
                FROM `osc_shop_products` AS M
                WHERE 
                    M.block = 0 AND
                    ".$cat_filter." 
                GROUP BY M.id 
                ORDER BY M.order_id
                LIMIT $start, $per_page
            ";
            $prods = $this->q($q);
            $total_rows = $this->conn->query("SELECT FOUND_ROWS() as count")->fetch('assoc');

            // GET UNIQUE COLORS FROM ALL PRODUCTS IN CATEGORY LIST
            $q = "
                SELECT 
                    DISTINCT M.color_id as id,
                    (SELECT value FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as value,
                    (SELECT name FROM `osc_shop_colors` WHERE id=M.color_id LIMIT 1) as name 
                FROM `osc_shop_products` AS M
                WHERE 
                    M.block = 0 AND
                    ".$cat_filter." 
                GROUP BY M.id, M.color_id 
                ORDER BY M.color_id  
                LIMIT 100 
            ";
            $uni_colors = $this->q($q);

            foreach ($prods as &$pc_value) {
                $q = "
                    SELECT M.id, M.value, M.name 
                    FROM `osc_shop_colors` AS M 
                    LEFT JOIN `osc_shop_products` as P ON P.color_id=M.id 
                    WHERE 
                        P.id = ".$pc_value['id']."
                    GROUP BY P.color_id 
                    LIMIT 100
                ";
                $pc_value['colors'] = $this->q($q);
            }

            return array('prods' => $prods, 'uni_colors' => $uni_colors, 'count_rows'=>$total_rows['count']);
        }
    }

    public function getSaleProds(){

        // GET PAG
        $per_page = PRODS_BY_PAGE;
        $cur_page = 1;
        if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = $_GET['page'];
        $start = ($cur_page - 1) * $per_page;

        // GET ALL SALE PRODUCTS
        $q = "
            SELECT
                SQL_CALC_FOUND_ROWS M.id,
                M.name, 
                M.quant, 
                M.alias, 
                M.".UTP_PREFIX."price as price, 
                M.sale, 
                M.".UTP_PREFIX."sale_price as sale_price, 
                M.preview,
                M.colors
            FROM `osc_shop_products` AS M
            WHERE 
                M.block = 0 AND
                M.sale_price != 0 AND
                M.quant > 0
            ORDER BY M.order_id
            LIMIT $start, $per_page
        ";
        $prods = $this->q($q);
        $total_rows = $this->conn->query("SELECT FOUND_ROWS() as count")->fetch('assoc');

        foreach ($prods as $key => &$value) {
            $colors = explode(',', $value['colors']);
            foreach ($colors as $c_key => $c_value) {
                $q = "
                    SELECT M.value FROM `osc_shop_colors` AS M WHERE M.id = '$c_value' LIMIT 1
                ";
                $hex = $this->q($q, 1);
                $value['colors'] .= trim($hex['value']);
            }
        }
        return array('prods' => $prods, 'count_rows' => $total_rows['count']);
    }

    public function check_cat($cat_alias, $main_alias=false){
        if($main_alias){
            $q = "
                SELECT M.id
                FROM `osc_shop_catalog` AS M 
                LEFT JOIN `osc_shop_catalog` as MP on MP.id=M.parent 
                WHERE M.alias = '$cat_alias' AND MP.alias='$main_alias'
                LIMIT 1
            ";
        }else{
            $q = "
                SELECT M.id
                FROM `osc_shop_catalog` AS M
                WHERE M.alias = '$cat_alias'
                LIMIT 1
            ";
        }
        return $this->q($q, 1);
    }

    public function check_prod($prod_id){
        $q = "
            SELECT M.id
            FROM `osc_shop_products` AS M
            WHERE 
                M.id = '$prod_id' AND
                M.block = 0
            LIMIT 1
        ";
        return $this->q($q, 1)['id'];
    }

    public function getProductById($prod_id){
        // GET PRODUCT
        $q = "
            SELECT
                M.id,
                M.name,
                M.alias,
                M.quant,
                M.colors,
                M.preview,
                M.sku,
                M.".UTP_PREFIX."price as price,
                M.".UTP_PREFIX."sale_price as sale_price,
                M.sale,
                M.details,
                M.video,
                M.title,
                M.desc,
                M.keys,
                M.index,
                M.cat_id 
            FROM `osc_shop_products` AS M
            LEFT JOIN `osc_shop_cat_chars_group_ref` AS CHAR_R ON CHAR_R.cat_id = cat_id
            LEFT JOIN `osc_shop_chars` AS C ON C.group_id = CHAR_R.group_id
            WHERE
                M.id = '$prod_id' AND
                M.block = 0
            GROUP BY CHAR_R.cat_id
            LIMIT 1
        ";
        $product = $this->q($q, 1);

        $q = "
            SELECT M.id, M.value, M.name 
            FROM `osc_shop_colors` AS M 
            LEFT JOIN `osc_shop_products` as P ON P.color_id=M.id 
            WHERE 
                P.prod_id = $prod_id 
            GROUP BY P.color_id 
            LIMIT 100
        ";
        $product_colors = $this->q($q);

        // GET CHARS
        $product_chars = array();
        $prod_id = $product['id'];
        $q = "
            SELECT 
                R.*,
                (
                    SELECT name FROM `osc_shop_chars` WHERE id = R.char_id LIMIT 1
                ) as char_name,
                (
                    SELECT measure FROM `osc_shop_chars` WHERE id = R.char_id LIMIT 1
                ) as char_measure
            FROM `osc_shop_chars_prod_ref` AS R
            WHERE 
                R.prod_id = '$prod_id' AND
                R.value != ''
            GROUP BY R.char_id
            LIMIT 30
        ";
        $product_chars = $this->q($q);

        // GET PRODUCT IMAGES
        $q = "
            SELECT 
                F.file,
                F.crop,
                F.title
            FROM `osc_files_ref` AS F
            WHERE 
                F.ref_id = '$prod_id' AND
                F.ref_table = 'shop_products'
            ORDER BY F.id
            LIMIT 100
        ";
        $product_images = $this->q($q);

        // GET CAT INFO
        $q = "
            SELECT 
                M.id,
                M.name,
                M.alias,
                M.parent
            FROM `osc_shop_catalog` AS M
            LEFT JOIN `osc_shop_products` AS P ON P.id = '$prod_id' 
            WHERE M.id = P.cat_id 
            GROUP BY P.cat_id
            LIMIT 1
        ";
        $product_cat = $this->q($q, 1);
        $parent = $product_cat['parent'];
        $parent_cat_id = $product_cat['id'];

        $parent_cat = $this->get_parent_cat($parent, $parent_cat_id);
        $parent_cat = array_merge($parent_cat, ['curr_cat_name'=>$product_cat['name'], 'curr_cat_alias'=>$product_cat['alias']]);

        // GET SIMILAR PRODUCTS

        if ($parent_cat['child_cat_alias'] === 0) {
            $main_cat = $parent_cat['parent_cat_alias']['alias'];
            $child_cat = false;
            $cat_id = $parent_cat['parent_cat_alias']['main_cat_id'];
            $q = "
                SELECT 
                    M.id, 
                    M.preview, 
                    M.name
                FROM `osc_shop_products` AS M
                WHERE
                    M.block = 0 AND 
                    M.cat_id = '$cat_id' 
                GROUP BY M.id                
                ORDER BY M.order_id
                LIMIT 20
            ";
        }else{
            $main_cat = $parent_cat['parent_cat']['parent_al'];
            $child_cat = $parent_cat['child_cat_alias'];
            $parnet_cat_id = $parent_cat['parent_cat']['parent_cat_id'];
            $child_cat_id = $parent_cat['parent_cat']['child_cat_id'];
            $q = "
                SELECT 
                    M.id, 
                    M.preview, 
                    M.name
                FROM `osc_shop_products` AS M
                LEFT JOIN `osc_shop_catalog` AS C ON C.id = M.cat_id 
                WHERE
                    M.block = 0 AND 
                    M.cat_id = '$child_cat_id' AND
                    C.parent = '$parnet_cat_id '  
                GROUP BY M.id             
                ORDER BY M.order_id
                LIMIT 20
            ";
        }

        $similar_products = $this->q($q);

        foreach ($similar_products as $key => $value) {
            if ($value['id'] == $prod_id) {
                unset($similar_products[$key]);
            }
        }

        $prod_data = array(
            'product' => $product,
            'product_colors' => $product_colors,
            'product_chars' => $product_chars,
            'product_images' => $product_images,
            'product_category' => $parent_cat,
            'similar_products' => $similar_products
        );
        return $prod_data;
    }

    public function getCatByAlias($cat_alias){

        $cat_alias = strip_tags(str_replace("'", "\'", trim($cat_alias)));

        $ri = $_SESSION['ri'];
        if (count($ri) > 2) {
            
            $main_cat_alias = $ri[1];
            
            $q = "SELECT M.* FROM `osc_shop_catalog` AS M WHERE M.parent = 0 AND M.alias = '$main_cat_alias' LIMIT 1";
            $main_cat = $this->q($q, 1);
            $main_cat_id = $main_cat['id'];

            $q = "
                SELECT M.* FROM `osc_shop_catalog` AS M WHERE M.alias = '$cat_alias' AND M.parent = '$main_cat_id' LIMIT 1
            ";
            $child_cat = $this->q($q, 1);
        }else{
            $q = "SELECT M.* FROM `osc_shop_catalog` AS M WHERE M.parent = 0 AND M.alias = '$cat_alias' LIMIT 1";
            $main_cat = $this->q($q, 1);
            $child_cat = false;
        }

        if (!$child_cat) {
            return array(
                'main_cat' => $main_cat,
                'child_cat' => false
            );
        }else{
            return array(
                'main_cat' => $main_cat,
                'child_cat' => $child_cat
            );
        }
    }

    public function get_parent_cat($parent, $cat_id){

        // DETECT PARENT AND CHILD CAT
        if ($parent == 0) {
            $q = "
                SELECT M.alias, M.name, M.id as main_cat_id
                FROM `osc_shop_catalog` as M
                WHERE M.id = '$cat_id'
                LIMIT 1 
            ";
            $parent_cat = $this->q($q, 1);
            $child_cat = 0;
            return array('parent_cat_alias' => $parent_cat, 'child_cat_alias' => $child_cat);
        }else{
            $q = "
                SELECT M.alias as parent_al, M.name as parent_cat, M.id as parent_cat_id,
                    (SELECT C.alias FROM `osc_shop_catalog` AS C WHERE C.id = '$cat_id' LIMIT 1) as child_cat,
                    (SELECT C.id FROM `osc_shop_catalog` AS C WHERE C.id = '$cat_id' LIMIT 1) as child_cat_id,
                    (SELECT C.name FROM `osc_shop_catalog` AS C WHERE C.id = '$cat_id' LIMIT 1) as child_cat_name
                FROM `osc_shop_catalog` as M
                WHERE 
                    M.id = '$parent'
                LIMIT 1 
            ";
            $parent_cat = $this->q($q, 1);
            $child_cat = $this->q($q, 1)['child_cat'];
            return array('parent_cat' => $parent_cat, 'child_cat_alias' => $child_cat);
        }
    }

    public function addProductIntoCart(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>''];
        
        $prod_form_id = $this->_post('prod_id');
        $prod_id = $this->check_prod($prod_form_id);
        $uid = UID;
        $session_id = session_id();
        $prod_url = $this->_post('prod_url');
        $now = HelpComponent::now();

        if ($prod_id) {
            // CHECK PRODUCT IN CART
            $q = "
                SELECT M.id 
                FROM `osc_shop_cart` AS M
                WHERE 
                    M.prod_id = '$prod_id' AND
                    M.session_id = '$session_id'
                LIMIT 1
            ";
            $prod_already_in_cart = $this->q($q, 1);
            if (!$prod_already_in_cart) {            
                $prod_post_quant = $this->_post('quant');
                $q = "
                    SELECT M.quant, M.".UTP_PREFIX."price as price, colors
                    FROM `osc_shop_products` AS M
                    WHERE M.id = '$prod_id'
                    LIMIT 1
                ";
                $prod_data = $this->q($q, 1);
                $quant_diff = $prod_data['quant'] - $prod_post_quant;
                if ($quant_diff >= 0) {
                    $prod_color = $this->_post('color');

                    if ($prod_color) {
                        // ADD PROD INTO CART
                        $q = "
                            INSERT INTO `osc_shop_cart`
                            (`uid`, `session_id`, `prod_id`, `prod_url`,  `quant`, `color_id`, `dateCreate`, `dateModify`)
                            VALUES 
                            ('$uid', '$session_id', '$prod_id', '$prod_url', '$prod_post_quant', '$prod_color', '$now', '$now')
                        ";
                        $insert = $this->q($q, 2);
                        if ($insert) {
                            $data['status'] = "success";
                            $data['message'] = "Товар добавлен в корзину.";
                        }
                    }else{
                        $data['message'] = "Выберите цвет товара.";
                    }
                }else{
                    $data['message'] = "Недопустимое количество товаров.";
                }
            }else{
                $data['message'] = "Товар уже добавлен Вами в корзину.";
            }
        }
        return $data;
    }

    public function addWishedProduct(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>'', 'value' => ''];

        $prod_post_id = $this->_post('prod_id');
        $prod_id = $this->check_prod($prod_post_id);

        $action = ($prod_id ? true : false);

        if ($action === true) {
            $now = HelpComponent::now();
            if (ONLINE) {
                $uid = UID;
                $session_id = session_id();
                $q = "
                    SELECT M.id
                    FROM `osc_shop_like` AS M
                    WHERE
                        ((M.uid = '$uid') OR
                        (M.session_id = '$session_id')) AND
                        M.prod_id = '$prod_id'
                    LIMIT 1
                ";
                $check = $this->q($q, 1);
                $prod_in_wished = ($check ? true : false);
            }else{
                $uid = 0;
                $session_id = session_id();
                $q = "
                    SELECT M.id
                    FROM `osc_shop_like` AS M
                    WHERE
                        M.session_id = '$session_id' AND
                        M.prod_id = '$prod_id'
                    LIMIT 1
                ";
                $check = $this->q($q, 1);
                $prod_in_wished = ($check ? true : false);
            }

            if ($prod_in_wished === false) {           
                $q = "
                    INSERT INTO `osc_shop_like`
                        (`uid`, `session_id`, `prod_id`, `dateCreate`)
                    VALUES
                        ('$uid', '$session_id', '$prod_id', '$now')
                ";
                $insert = $this->q($q, 2);
                if ($insert) {
                    $count_left = count($this->getWishedGoods());
                    $data['status'] = "success";
                    $data['message'] = "Товар добавлен в список желаемых товаров.";
                    $data['value'] = $count_left;
                }
            }else{
                $count_left = count($this->getWishedGoods());
                $data['message'] = "Товар уже добавлен Вами в список желаемых.";
                $data['value'] = $count_left;
            }

        }

        return $data;
    }

    public function deleteWishedProduct(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>'', 'value' => ''];

        $prod_post_id = $this->_post('prod_id');
        $prod_id = $this->check_prod($prod_post_id);
        $session_id = session_id();
        $uid = UID;
        if (ONLINE) {
            $filter = "((M.session_id = '$session_id') OR (M.uid = '$uid'))";
        }else{
            $filter = "M.session_id = '$session_id'";
        }
        if ($prod_id) {
            // CHECK OWNER
            $q = "
                SELECT M.id
                FROM `osc_shop_like` AS M
                WHERE
                    M.prod_id = '$prod_id' AND 
                    ".$filter."
                LIMIT 1
            ";
            $row_id = $this->q($q, 1)['id'];

            if ($row_id) {
                $q = "
                    DELETE FROM `osc_shop_like` WHERE `id` = '$row_id' LIMIT 1
                ";
                $delete = $this->q($q, 2);
                if ($delete) {
                    $count_left = count($this->getWishedGoods());
                    $data['status'] = "success";
                    $data['value'] = $count_left;
                }
            }
        }

        return $data;
    }

    public function getCart(){
        $uid = UID;
        $session_id = session_id();
        if (ONLINE) {
            $filter = "(C.uid = '$uid' OR C.session_id = '$session_id')";
        }else{
            $filter = "C.session_id = '$session_id'";
        }

        $q = "
            SELECT
                M.id,
                M.name,
                M.preview,
                M.sale,
                M.".UTP_PREFIX."price as price,
                M.".UTP_PREFIX."sale_price as sale_price,
                C.quant,
                C.color_id
            FROM `osc_shop_products` AS M
            LEFT JOIN `osc_shop_cart` AS C ON C.prod_id = M.id
            WHERE
                M.block = 0 AND
                ".$filter."
            GROUP BY M.id
            ORDER BY C.id DESC 
            LIMIT 100
        ";
        $cart = $this->q($q);
        return $cart;
    }

    public function changeProdQuant(){
        $data = ['status'=>'failed', 'message'=>'', 'count'=>'', 'prod' => ''];

        $action = $this->_post('action');
        $prod_post_id = $this->_post('prod_id');
        $curr_post_quant = $this->_post('count');
        $update_cart = false;
        $uid = UID;
        $session_id = session_id();

        $prod_id = $this->check_prod($prod_post_id);

        if ($prod_id) {
            // GET PRODUCT
            $product = $this->getProductById($prod_id)['product'];
                
            if ($action == "increase") {
                $new_quant = $curr_post_quant + 1;
                if ($new_quant > 0 && $new_quant <= $product['quant']) {
                    $update_cart = true;
                }
            }elseif($action == "decrease"){
                $new_quant = $curr_post_quant - 1;
                if ($new_quant > 0) {
                    $update_cart = true;
                }
            }
            
        }

        if ($update_cart == true) {
            if (ONLINE) {
                $filter = "`uid` = '$uid' OR `session_id` = '$session_id' ";
            }else{
                $filter = "`session_id` = '$session_id' ";
            }
            $q = "
                UPDATE `osc_shop_cart` SET 
                `quant` = '$new_quant'
                WHERE $filter AND `prod_id` = '$prod_id'
                LIMIT 1
            ";
            $update = $this->q($q, 2);

            $total_sum = $this->getCartCountInfo('sum');

            $prod_price = $product['price'];

            $prod_total_sum = $new_quant * $prod_price;

            if ($update) {
                $data['status'] = "success";
                $data['count'] = $new_quant;
                $data['prod'] = $prod_id;
                $data['cart_sum'] = $total_sum;
                $data['prod_total_sum'] = $prod_total_sum;
            }
        }

        return $data;
    }

    public function getDeliveryTmp(){
        $q = "SELECT M.store_address FROM `osc_shop_settings` AS M WHERE M.id = 1 LIMIT 1";
        $store_address = $this->q($q, 1);

        $q = "SELECT M.id, M.Description, M.Ref FROM `next_np_cities` AS M LIMIT 10000";
        $np_cities = $this->q($q);

        return ['store_address' => $store_address, 'np_cities' => $np_cities];
    }

    public function getNPdep(){
        $data = ['status' => 'failed', 'reason' => '', 'tmp' => ''];

        $post_ref = $this->_post('ref');
        
        $q = "SELECT M.Ref FROM `next_np_cities` AS M WHERE M.Ref = '$post_ref' LIMIT 1";
        $ref = $this->q($q, 1)['Ref'];

        if ($ref) {
            $q = "
                SELECT M.Description, M.id 
                FROM `next_np_parts` AS M 
                WHERE M.CityRef = '$ref'
                LIMIT 1000
            ";
            $departments = $this->q($q);

            if ($departments) {
                ob_start();
                ?>
                    <select name="np_dep">
                        <option value="0">Выберите отделение</option>
                        <?php 
                            foreach ($departments as $key => $value) {
                                ?>
                                    <option value="<?= $value['id']; ?>"><?= $value['Description']; ?></option>
                                <?php
                            } 
                        ?> 
                    </select>
                <?php       
                $tmp = ob_get_contents();
                ob_clean();
                $data['status'] = "success";
                $data['tmp'] = $tmp;
            }
        }

        return $data;
    }

    public function getAjaxCartTmp(){
        $data = ['status'=>'failed', 'message'=>'', 'count'=>'', 'sum'=>'', 'tmp' => ''];
        $cart = $this->getCart();
        if ($cart) {
            ob_start();
            foreach ($cart as $key => $value) {
                ?>
                    <div class="bucket_product" id="modal_bucket_product_<?php echo $value['id']; ?>">
                        <div class="delete_product" onclick="core.delFromModalCart('<?php echo $value['id']; ?>');"><img src="<?php echo RS; ?>img/bucket_products/delete.png"></div>
                        <a href="<?php echo RS.'catalog/product/'.$value['id'].'/'; ?>" class="prod_buck_link">
                            <img src="<?php echo PROD_PATH.$value['preview']; ?>" alt="preview" class="cart_item_prev" />
                            <div class="bucket_product_info">
                                <p class="prod_name"><?php echo $value['name']; ?></p>
                                <p class="prod_count"><b><?php echo $value['quant']; ?> ШТ.</b></p>
                                <p class="prod_price"><b><?php echo $value['price'] * $value['quant']; ?> ГРН</b></p>
                            </div>
                        </a>
                    </div>
                <?php
            }
            $cartTmp = ob_get_contents();
            ob_clean();

            $total_count = $this->getCartCountInfo('count');
            $total_sum = $this->getCartCountInfo('sum');
        }else{
            $cartTmp = '<p class="no_items">Ваша корзина пуста.</p>';
            $total_sum = 0;
            $total_count = 0;
        }

        $data['status'] = "success";
        $data['tmp'] = $cartTmp;
        $data['count'] = $total_count;
        $data['sum'] = $total_sum;

        return $data;
    }

    public function deleteItemFromBucket(){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>'', 'value' => ''];

        $prod_post_id = $this->_post('prod_id');
        $prod_id = $this->check_prod($prod_post_id);
        $session_id = session_id();
        $uid = UID;
        if ($prod_id) {
            // CHECK OWNER
            $q = "
                SELECT M.id
                FROM `osc_shop_cart` AS M
                WHERE
                    ((M.session_id = '$session_id') OR (M.uid = '$uid')) AND
                    M.prod_id = '$prod_id'
                LIMIT 1
            ";
            $row_id = $this->q($q, 1)['id'];

            

            if ($row_id) {
                $q = "
                    DELETE FROM `osc_shop_cart` WHERE `id` = '$row_id' LIMIT 1
                ";

                $delete = $this->q($q, 2);
                if ($delete) {
                    $count_left = count($this->getCart());
                    $data['status'] = "success";
                    $data['value'] = $count_left;

                }
            }
        }

        return $data;

    }

    public function getCartCountInfo($expect){
        $cart = $this->getCart();
        $total_count = 0;
        $total_sum = 0;
        foreach ($cart as $key => $value) {
            $total_count += (int)$value['quant'];
            $total_sum += (int)$value['price']*(int)$value['quant'];
        }
        switch ($expect) {
            case 'count':
                $val = $total_count;
                break;
            case 'sum':
                $val = $total_sum;
                break;
            default:
                $val =  "Expecting correct parametr";
                break;
        }
        return $val;
    }

    public function search($key, $aj_sh = false){
        $key = strip_tags(str_replace("'", "\'", trim($key)));

        // GET PAG
        $per_page = PRODS_BY_PAGE;
        $cur_page = 1;
        if (isset($_GET['page']) && $_GET['page'] > 0) $cur_page = $_GET['page'];
        $start = ($cur_page - 1) * $per_page;

        $filter = "$start, $per_page";

        if ($aj_sh == true) {
           $filter = "100";
        }

        $q = "
            SELECT
                SQL_CALC_FOUND_ROWS M.id,
                M.id,
                M.name,
                M.alias,
                M.quant,
                M.colors,
                M.preview,
                M.".UTP_PREFIX."price as price,
                M.".UTP_PREFIX."sale_price as sale_price,
                M.sale  
            FROM `osc_shop_products` AS M
            WHERE
                M.block = 0 AND
                ( M.name LIKE '%".$key."%' OR M.sku LIKE '%".$key."%' )
            ORDER BY M.order_id                
            LIMIT ".$filter."
        ";
        $products = $this->q($q);
        $total_rows = $this->conn->query("SELECT FOUND_ROWS() as count")->fetch('assoc');

        foreach ($products as $key => &$value) {
            $colors = explode(',', $value['colors']);
            foreach ($colors as $c_key => $c_value) {
                if ($c_key == 0) {
                    $value['colors'] = "";
                }
                $q = "
                    SELECT M.value FROM `osc_shop_colors` AS M WHERE M.id = '$c_value' LIMIT 1
                ";
                $hex = $this->q($q, 1);
                $value['colors'] .= trim($hex['value']);
            }
        }
        return array('prods' => $products, 'count_rows' => $total_rows['count']);
    }

    public function ajaxSearch(){
        $search_key = $this->_post('search_key');
        $prd = [];
        if ($search_key) {
            $aj_sh = true;
            $prods = $this->search($search_key, $aj_sh);
            $prd = $prods['prods'];
        }
        ob_start();
            foreach ($prd as $key => $value) {
                ?>
                <a href="<?= RS.'catalog/product/'.$value['id'].'/'; ?>">
                    <div class="search_product">
                        <?php if ($value['preview']): ?>
                            <img src="<?= PROD_PATH.'crop/250x300_'.$value['preview']; ?>" alt="image" class="ajaxSearchImage"/>
                        <?php endif ?>
                        <div class="prod_info">
                            <?php if ($value['name']): ?>
                                <p><?= $value['name']; ?></p>
                            <?php endif ?>
                            <span>
                                <?php if ($value['sale_price']): ?>
                                    <span class="ajax_old_price"><b><?= $value['sale_price']; ?> грн</b></span>
                                <?php endif ?>
                                <span><b><?= $value['price']; ?> грн</b></span>
                            </span>                        
                        </div>
                    </div>
                </a>
                <?php
            }
        $tmp = ob_get_contents();
        ob_clean(); 
        if (!$tmp) {
            $tmp = "Нет результатов поиска.";
        }
        return array('result' => $tmp);
    }

    public function getProdPriceInfo($cat){
        $main_cat = $cat['main_cat'];
        $child_cat = $cat['child_cat'];
        $child_cat_id = $child_cat['id'];
        $main_cat_id = $main_cat['id'];

        if ($child_cat) {
            $filter = " M.cat_id = '$child_cat_id'";
            $filter2 = "";
        }else{
            $q = "
                SELECT M.id FROM `osc_shop_catalog` AS M WHERE M.parent = $main_cat_id LIMIT 100;
            ";
            $children = $this->q($q);
            $filter = "M.cat_id = '$main_cat_id'";
            $filter2 = "";
            foreach ($children as $key => $value) {
                $filter2 .= " OR M.cat_id = ".$value['id']." ";
            }
        }
        $q = "
            SELECT 
                MAX(M.".UTP_PREFIX."price) as max_price,
                MIN(M.".UTP_PREFIX."price) as min_price
            FROM `osc_shop_products` AS M
            WHERE 
                M.block = 0 AND 
				".$filter.$filter2."
            LIMIT 1
        ";
        $prices = $this->q($q, 1);
        return array('prices' => $prices);
    }

    public function getProfile($uid){
        // GET USER BY ID
        $q = "
            SELECT
                M.type,
                M.login,
                M.phone,
                M.name,
                M.is_address
            FROM `osc_users` AS M
            WHERE 
                M.block = 0 AND
                M.id = '$uid'
            LIMIT 1
        ";
        $user = $this->q($q, 1);
        return $user;
    }

    public function getUserAddress(){
        $uid = UID;
        $q = "
            SELECT M.city, M.street, M.building, M.flat
            FROM `osc_user_address` AS M
            WHERE M.uid = '$uid'
            LIMIT 1
        ";

        if (UID) {
            return $this->q($q, 1);
        }
    }

    public function check_phone($phone){
        $reg_exp = '/\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}/';
        $action = preg_match($reg_exp, $phone);
        return $action;
    }

    public function editProfile($uid){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>'', 'value' => '', 'value_name' => '', 'value_email' => '', 'value_phone' => ''];

        $name = $this->_post('name');
        $email = $this->_post('email');
        $phone = $this->_post('phone');

        $city = $this->_post('city');
        $street = $this->_post('street');
        $building = $this->_post('building');
        $flat = $this->_post('flat');

        $collumns = array();
        $adr_collumns = array();
        $adr_values = array();
        $update_addr = array();
        $is_address = false;

        $update_user = false;
        $update_user_addr = false;
        $insert_user_addr = false;

        if ($name) {
            if (mb_strlen($name) >= 2) {
                $collumns['name'] = $name;
                $data['ref'] = "name";
                $data['value_name'] = $name;
            }else{
                $data['reason'] = "name";
                $data['message'] = "Минимальная длинна имени - 2 символа.";
            }
        }
        if ($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $collumns['login'] = $email;
                $data['value_email'] = $email;
            }else{
                $data['reason'] = "email";
                $data['message'] = "Укажите корректный email.";
            }
        }
        if ($phone) {
            $valid_phone = $this->check_phone($phone);
            if (mb_strlen($phone) == 15 && $valid_phone) {
                $collumns['phone'] = $phone;
                $data['value_phone'] = $phone;
            }else{
                $data['message'] = "Укажите корректный телефон.";
            }
        }
        if ($city) {
            if (mb_strlen($city) >= 3) {
                $is_address = true;
                $update_addr['city'] = $city;
                array_push($adr_collumns, 'city');
                array_push($adr_values, $city);
            }else{
                $data['reason'] = "city";
                $data['message'] = "Минимальная длинна города - 3 символа.";
            }
        }
        if ($street) {
            if (mb_strlen($street) >= 2) {
                $is_address = true;
                $update_addr['street'] = $street;
                array_push($adr_collumns, 'street');
                array_push($adr_values, $street);
            }else{
                $data['reason'] = "street";
                $data['message'] = "Минимальная длинна улицы - 2 символа.";
            }
        }
        if ($building) {
            $update_addr['building'] = $building;
            $is_address = true;
            array_push($adr_collumns, 'building');
            array_push($adr_values, $building);
        }
        if ($flat) {
            $update_addr['flat'] = $flat;
            $is_address = true;
            array_push($adr_collumns, 'flat');
            array_push($adr_values, $flat);
        }

        if (count($collumns) > 0) {
            $q = "
                UPDATE `osc_users`
                SET 
            ";
            $i = 0;
            foreach ($collumns as $col => $value) {
                $i++;
                $comma = ($i == (count($collumns)) ? "" : " , ");
                
                $q .= " `".$col."` = '$value' ".$comma;
            }
            $q .= "
                WHERE `id` = '$uid'
                LIMIT 1
            ";
        }
        if (isset($q) && $q) {
            $update_user = $this->q($q, 2);
        }

        // UPDATE OR INSERT ADDRESS
        if ($is_address == true) {
            // CHECK ADDRESS EXIST
            $q = "SELECT M.id FROM `osc_user_address` AS M WHERE M.uid = '$uid' LIMIT 1";
            $address_exist =$this->q($q, 1);
            if ($address_exist) {
                $adr_id = $address_exist['id'];
                $q = "
                    UPDATE `osc_user_address`
                    SET 
                ";
                $i = 0;
                foreach ($update_addr as $col => $value) {
                    $i++;
                    $comma = ($i == (count($update_addr)) ? "" : " , ");
                    
                    $q .= " `".$col."` = '$value' ".$comma;
                }
                $q .= "
                    WHERE `id` = '$adr_id'
                    LIMIT 1
                ";
                $update_user_addr = $this->q($q, 2);
            }else{
                $q = "
                    INSERT INTO `osc_user_address` (`uid`, 
                ";
                foreach ($adr_collumns as $key => $col) {
                    $comma = ($key == (count($adr_collumns) - 1) ? '' : ' , ');
                    $q .= " `".$col."` ".$comma;
                }
                $q .= " ) VALUES ('$uid', ";
                foreach ($adr_values as $key => $cell) {
                    $comma = ($key == (count($adr_values) - 1) ? '' : ' , ');

                    $q .= " '".$cell."' ".$comma;
                }
                $q .= " ) ";
                $insert_user_addr = $this->q($q, 2);
            }
        }

        if ($update_user || $update_user_addr || $insert_user_addr) {
            $data['status'] = "success";
            $data['message'] = "Ваш профиль обновлен.";

            if ($is_address == true) {
                $q = "
                    UPDATE `osc_users` SET `is_address` = 1 WHERE `id` = '$uid' LIMIT 1
                ";
                $this->q($q, 2);
            }
        }
        return $data;
    }

    public function changePassword($uid){
        $data = ['status'=>'failed', 'message'=>'', 'reason'=>'', 'ref'=>'', 'value' => ''];

        $old_password = $this->_post('old_password');
        $new_password = $this->_post('new_password');
        $confirm_new_password = $this->_post('confirm_new_password');

        $md5_old_password = md5($old_password);
        $action = false;

        // CHECK OLD USER PASSWORD
        $q = "SELECT M.pass, M.login FROM `osc_users` AS M WHERE M.id = '$uid' LIMIT 1";
        $user_data = $this->q($q, 1);
        $query_password = $user_data['pass'];
        if ($query_password == $md5_old_password) {
            if (mb_strlen($new_password) > 5) {
                if ($new_password == $confirm_new_password) {
                    $action = true;                    
                }else{
                    $data['reason'] = "confirm_new_password";
                    $data['message'] = "Пароли не совпадают.";
                }
            }else{
                $data['reason'] = "new_password";
                $data['message'] = "Длинна пароля должна быть миниум 6 символов.";
            }
        }else{
            $data['reason'] = "old_password";
            $data['message'] = "Вы ввели неправильный старый пароль.";
        }
        if ($action == true) {
            // UPDATE PASSWORD
            $md5_new_password = md5($new_password);
            $q = "
                UPDATE `osc_users`
                SET 
                    `pass` = '$md5_new_password'
                WHERE `id` = '$uid'
                LIMIT 1
            ";
            $update = $this->q($q, 2);
            if ($update) {
                $data['reason'] = "";
                $data['message'] = "Пароль успешно изменен.";
                $data['status'] = "success";
                $data['ref'] = "";
                $sitename = $this->getGlobalConfig()['sitename'];
                $from = $this->getGlobalConfig()['support_email'];
                $receiver = $user_data['login'];
                $subject = "Изменение пароля на ".$sitename.".";
                $message = ' 
                <html> 
                <head> 
                <title>Изменение пароля на '.$sitename.'.</title> 
                </head> 
                <body> 
                    <p>Вы успешно изменили пароль.</p>
                    <hr />
                    <p>Ваш новый пароль: '.$new_password.'</p>
                </body> 
                </html>';
                

                $from_title = "OnePolar";

                $email_obj = new Email('default');
                $email_obj->from(['onepolar.ukraine@gmail.com' => 'OnePolar Ukraine'])
                    ->emailFormat('html')
                    ->to($receiver)
                    ->subject($subject)
                    ->send($message);
            }
        }
        return $data;
    }

    public function getCatChars($cat){

        $main_cat = $cat['main_cat'];
        $child_cat = $cat['child_cat'];
		
		// GET CHAR CROUP
        if ($child_cat) {
            
            $child_cat_id = $child_cat['id'];
            $char_group_id = $child_cat['specs_group_id'];

            // GET PRODS BY CAT
            $q = "
                SELECT M.id  
                FROM `osc_shop_products` AS M 
                WHERE
                    M.block = 0 AND
                    M.cat_id = '$child_cat_id'
                GROUP BY M.id 
                LIMIT 1000
            ";
            $product_ids = $this->q($q);

            $q = "
                SELECT M.*, M.".LANG_PREFIX."name as name 
                FROM `osc_shop_chars` as M 
                WHERE 
                    M.group_id = $char_group_id 
				ORDER BY M.pos
                LIMIT 100
            ";
			
            $chars_arr = $this->q($q);
            if ($product_ids) {
                $prods_or_query = " ( ";
                $prods_or_query_count = " ( ";
                foreach($product_ids as $i => $p_id){
                    $prods_or_query .= ($i ? " OR M.prod_id=".$p_id['id'] : " M.prod_id=".$p_id['id']);
                    $prods_or_query_count .= ($i ? " OR prod_id=".$p_id['id'] : " prod_id=".$p_id['id']);
                }
                $prods_or_query .= " ) AND";
                $prods_or_query_count .= " ) ";
            }else{
                $prods_or_query = " ";
                return []; exit();
            }
            

            foreach($chars_arr as &$chars_item){
                $curr_char_id = $chars_item['id'];
                $q = "
                    SELECT DISTINCT M.val_id, 
					(SELECT ".LANG_PREFIX."value FROM osc_shop_chars_values WHERE id=M.val_id) as value 
                    FROM `osc_shop_chars_prod_ref` as M 
                    WHERE 
                        M.char_id = $curr_char_id AND 
                        $prods_or_query 
                        M.val_id != '' AND M.val_id != '0'
                    LIMIT 1000
                ";

                $chars_item['values'] = $this->q($q);

            }   
        }else{

            $main_cat_id = $main_cat['id'];

            $child_cats = $this->q("SELECT * FROM `osc_shop_catalog` WHERE parent=$main_cat_id LIMIT 100");


            $chars_arr = [];
            $sem_specs_group_id = 0;

            $cats_or_query = " ( M.cat_id=".$main_cat_id;
            foreach($child_cats as $i => $child_cat){
                if(!$child_cat['specs_group_id']) continue;

                // Страховка от ситуации, когда в одном разделе лежат категории с разным набором фильтров
                if($sem_specs_group_id){
                    if($child_cat['specs_group_id']!=$sem_specs_group_id) {  
                        return $chars_arr; 
                    }
                }
                
                if($child_cat['specs_group_id']){
                    $sem_specs_group_id = $child_cat['specs_group_id'];
                }

                $cats_or_query .= " OR M.cat_id=".$child_cat['id'];
            }
            $cats_or_query .= " ) ";

            $char_group_id = $sem_specs_group_id;
            // GET PRODS BY CAT
            $q = "
                SELECT R.prod_id 
                FROM `osc_shop_products` AS M 
                WHERE
                    M.block = 0 AND
                    $cats_or_query 
                GROUP BY M.id 
                LIMIT 1000
            ";
            $product_ids = $this->q($q);



            $q = "
                SELECT M.*  
                FROM `osc_shop_chars` as M 
                WHERE 
                    M.group_id = $char_group_id 
                LIMIT 100
            ";
            $chars_arr = $this->q($q);

            if ($product_ids) {
               $prods_or_query = " ( ";
                $prods_or_query_count = " ( ";
                foreach($product_ids as $i => $p_id){
                    $prods_or_query .= ($i ? " OR M.prod_id=".$p_id['prod_id'] : " M.prod_id=".$p_id['prod_id']);
                    $prods_or_query_count .= ($i ? " OR prod_id=".$p_id['prod_id'] : " prod_id=".$p_id['prod_id']);
                }
                $prods_or_query .= " ) ";
                $prods_or_query_count .= " ) ";
            }else{
                $prods_or_query = " ";
                return []; exit();
            }

            foreach($chars_arr as &$chars_item){
                $curr_char_id = $chars_item['id'];
                $q = "
                    SELECT DISTINCT M.value 
                    FROM `osc_shop_chars_prod_ref` as M 
                    WHERE 
                        M.char_id = $curr_char_id AND 
                        $prods_or_query AND 
                        M.val_id != '' AND M.val_id != '0'
                    LIMIT 1000
                ";
                $chars_item['values'] = $this->q($q);
            }   
        }
        return $chars_arr;
        
    }
	
	// GET PROJECTS FILTERS
	
	public function getProjectsChars(){
            
            $q = "
                SELECT M.*, M.".LANG_PREFIX."name as name 
                FROM `osc_project_chars` as M 
                WHERE 
                    M.block = 0 
                LIMIT 100
            ";
			
            $chars_arr = $this->q($q);

            foreach($chars_arr as &$chars_item){
                $curr_char_id = $chars_item['id'];
                $q = "
                    SELECT DISTINCT M.val_id, 
					(SELECT ".LANG_PREFIX."value FROM osc_project_chars_values WHERE id=M.val_id) as value 
                    FROM `osc_project_chars_ref` as M 
                    WHERE 
                        M.char_id = $curr_char_id AND 
                        M.val_id != '' AND 
						M.val_id != '0'
                    LIMIT 1000
                ";

                $chars_item['values'] = $this->q($q);

            }   
        
        return $chars_arr;
        
    }

    // Filter methods

    public function getProjects($page_num, $page_lim, $filters="", $filter_joins="", $order_vector=" M.id "){
        
		$page_lim = PROJECTS_QTY;
		
		$order_vector = PROJECT_LINE;
		
		$order_vector = ($order_vector=='new' ? 'dateCreate' : $order_vector);
		
		$result = array('rows'=>0,'items'=>array());
			
		$query= "SELECT SQL_CALC_FOUND_ROWS 
                    M.id, 
					M.dateCreate as dateCreate, 
					M.".LANG_PREFIX."name as name, 
					M.alias,
					'no_img' as img,
					'no_title' as title,	
					(SELECT ".LANG_PREFIX."name FROM osc_users WHERE id=M.user_id LIMIT 1) as user_name
					
					FROM osc_projects as M 
                    	$filter_joins  
                    
					WHERE 
						M.block=0 
                    	$filters
                    GROUP BY M.id 
                    ORDER BY $order_vector 
                    LIMIT ".(($page_num-1)*$page_lim).",$page_lim
                ";

        $result['items'] = $this->q($query);
        $result['rows'] = $this->q('SELECT FOUND_ROWS() AS rows',1);
		
		// debug($result); exit();

        foreach($result['items'] as &$prod_tmp_item){
            $project_id = $prod_tmp_item['id'];
            
            $q = "
               SELECT crop as img, title 
			   FROM osc_project_files_ref 
			   WHERE 
			   	`ref_id` = '$project_id'
				ORDER BY `id` 
				LIMIT 1 
            ";
            $prod_tmp_item['img'] = $this->q($q,1)['img'];
			$prod_tmp_item['title'] = $this->q($q,1)['title'];
        }

        return $result;
    }
	
	public function getCategoryProductsById($cat_id, $page_num, $page_lim, $filters="", $filter_joins="", $order_vector=" M.id "){
        
		$page_lim = PR_QTY;
		
		$result = array('rows'=>0,'items'=>array());
        $session_id = session_id();
        $like_q = (ONLINE ? "`uid`=".UID : "`session_id`='$session_id'");

        $cats_filter = " ( C.id=$cat_id ";
        $cat_childs = $this->q("SELECT M.id 
                                FROM osc_shop_catalog as M 
                                WHERE M.parent='$cat_id' AND M.block=0  
                                LIMIT 100
                                ");
        foreach($cat_childs as $item){
            $cats_filter .= " OR C.id=".$item['id']." ";
        }
        $cats_filter .= " ) ";
            
		/*
		(SELECT crop FROM osc_files_ref WHERE `ref_id` = M.id AND `ref_table` = 'shop_products' ORDER BY `id` LIMIT 1) as img, 
		(SELECT title FROM osc_files_ref WHERE `ref_id` = M.id AND `ref_table` = 'shop_products' ORDER BY `id` LIMIT 1) as title,
		*/
			
		$query= "SELECT SQL_CALC_FOUND_ROWS 
                    M.id, M.name, M.quant, M.alias,
                    M.".UTP_PREFIX."price as price, 
                    M.".UTP_PREFIX."sale_price as sale_price, 
                    M.sku, M.preview,                    
					'crop_img' as img,
					'img_title' as title,
					(SELECT id FROM osc_shop_like WHERE `session_id` = '".SESID."' AND `uid` = '".UID."' AND `prod_id` = M.id ORDER BY `id` LIMIT 1) as prod_like,
					(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '6' LIMIT 1) as sale_id,
					(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '1' LIMIT 1) as new_id,
					(SELECT group_id FROM osc_shop_prod_group_ref WHERE `prod_id` = M.id AND  group_id = '7' LIMIT 1) as delivery,
					(SELECT ".LANG_PREFIX."name FROM osc_shop_mf WHERE id=M.mf_id LIMIT 1) as mf_name,
					(SELECT ".LANG_PREFIX."name FROM osc_shop_objects WHERE id=M.obj_id AND id!=0 LIMIT 1) as obj_name
					
                    FROM osc_shop_products as M 
                    $filter_joins 
                    LEFT JOIN osc_shop_catalog as C ON C.id=M.cat_id 
                    WHERE $cats_filter  
                    AND M.block=0 
                    $filters
                    GROUP BY M.id 
                    ORDER BY $order_vector 
                    LIMIT ".(($page_num-1)*$page_lim).",$page_lim
                ";

        $result['items'] = $this->q($query);
        $result['rows'] = $this->q('SELECT FOUND_ROWS() AS rows',1);
		
		// debug($result); exit();

        foreach($result['items'] as &$prod_tmp_item){
            $product_id = $prod_tmp_item['id'];
            
            $query = "
                SELECT M.*, R.name 
                FROM osc_shop_chars_prod_ref as M 
                JOIN osc_shop_chars as R ON R.id = M.char_id
                WHERE M.prod_id=$product_id AND M.val_id != '' AND M.val_id != '0' AND R.show_admin=1 
                ORDER BY R.pos 
                LIMIT 5
            ";
                            
            $prod_tmp_item['product_chars'] = $this->q($query);
            
            $query = "
                SELECT M.group_id, 
                (SELECT title FROM osc_shop_products_groups WHERE `id`=M.group_id LIMIT 1) as title 
                FROM osc_shop_prod_group_ref as M 
                WHERE 
                    M.prod_id='$product_id' 
                ORDER BY M.id 
                LIMIT 5
            ";

            $prod_tmp_item['product_groups'] = $this->q($query);

            $q = "
                SELECT M.id, M.value, M.name 
                FROM `osc_shop_colors` AS M 
                LEFT JOIN `osc_shop_products` as P ON P.color_id=M.id 
                WHERE 
                    P.id = ".$prod_tmp_item['id']."
                GROUP BY P.color_id 
                LIMIT 100
            ";
            $prod_tmp_item['colors'] = $this->q($q);

            $q = "
               SELECT crop as img, title 
			   FROM osc_files_ref 
			   WHERE 
			   	`ref_id` = ".$prod_tmp_item['id']." AND 
				`ref_table` = 'shop_products' 
				ORDER BY `id` 
				LIMIT 1 
            ";
            $prod_tmp_item['img'] = $this->q($q,1)['img'];
			$prod_tmp_item['title'] = $this->q($q,1)['title'];
        }

        return $result;
    }

    public function getCategoryFilterChars($_group_id){
        $query = "
            SELECT M.id, M.".LANG_PREFIX."name as name, M.measure
            FROM osc_shop_chars as M
            WHERE M.group_id = $_group_id AND M.show_site = 1 AND M.block = 0 AND M.show_admin = 1
            ORDER BY M.pos
            LIMIT 100
        ";
        return $this->q($query);
    }
	
	public function getProjectsFilterChars(){
        $query = "
            SELECT M.id, M.".LANG_PREFIX."name as name 
            FROM osc_project_chars as M
            WHERE M.block = 0
            ORDER BY M.pos
            LIMIT 100
        ";
        return $this->q($query);
    }

    public function countProjectsFilterValues($_char_id, $filters, $filter_joins){
        
        $charFilter = " SREF.char_id=$_char_id ";

		// COUNT( DISTINCT ...

        $query = "
            SELECT SREF.val_id, COUNT(SREF.val_id) as count, SREF.id as ref_id ,
			(SELECT ".LANG_PREFIX."value FROM osc_project_chars_values WHERE id=SREF.val_id LIMIT 1) as value 
            FROM osc_project_chars_ref as SREF 
            LEFT JOIN osc_projects as M on M.id=SREF.project_id  
                $filter_joins
            WHERE $charFilter AND M.block=0 AND SREF.val_id!='' AND SREF.val_id!='0'
                $filters
				
        	GROUP BY SREF.val_id      
        ";
        return $this->q($query);
    }
	
	public function countProjectsXFilterValues($params=[], $filters, $filter_joins){
        
        $charFilter = " 1 ";
		
		if($params)
		{
			$charFilter = " M.".$params['name']."='".$params['id']."' ";
			
			// COUNT( DISTINCT ...
			
			$query = "
				SELECT COUNT(M.".$params['name'].") as count 
				FROM osc_projects as M   
					$filter_joins
				WHERE $charFilter AND M.block=0 
					$filters
					
				GROUP BY M.".$params['name']." 
			";
	
			return $this->q($query,1);
		}

        return [];
    }
	
	public function countFilterValues($_cat_id, $_char_id, $filters, $filter_joins){
        
        $cats_filter = " ( M.cat_id=$_cat_id ";
        $cat_childs = $this->q("SELECT M.id 
                                FROM osc_shop_catalog as M 
                                WHERE M.parent='$_cat_id' AND M.block=0  
                                LIMIT 100
                                ");
        foreach($cat_childs as $item){
            $cats_filter .= " OR M.cat_id=".$item['id']." ";
        }
        $cats_filter .= " ) ";
		
		$charFilter = " SREF.char_id=$_char_id ";

		// COUNT( DISTINCT ...

        $query = "
            SELECT SREF.val_id, COUNT(SREF.val_id) as count, SREF.id as ref_id ,
			(SELECT ".LANG_PREFIX."value FROM osc_shop_chars_values WHERE id=SREF.val_id LIMIT 1) as value 
            FROM osc_shop_chars_prod_ref as SREF 
            LEFT JOIN osc_shop_products as M on M.id=SREF.prod_id  
                $filter_joins
            WHERE $charFilter AND $cats_filter AND M.block=0 AND SREF.val_id!='' AND SREF.val_id!='0'
                $filters
				
        	GROUP BY SREF.val_id      
        ";
		/*
		
            GROUP BY SREF.val_id  
            ORDER BY SREF.id
		*/

        return $this->q($query);
    }
	
	public function countXFilterValues($_cat_id, $params=[], $filters, $filter_joins){
        
        $cats_filter = " ( M.cat_id=$_cat_id ";
        $cat_childs = $this->q("SELECT M.id 
                                FROM osc_shop_catalog as M 
                                WHERE M.parent='$_cat_id' AND M.block=0  
                                LIMIT 100
                                ");
        foreach($cat_childs as $item){
            $cats_filter .= " OR M.cat_id=".$item['id']." ";
        }
        $cats_filter .= " ) ";
		
		$charFilter = " 1 ";
		
		if($params)
		{
			$charFilter = " M.".$params['name']."='".$params['id']."' ";
			
			// COUNT( DISTINCT ...
			
			$query = "
				SELECT COUNT(M.".$params['name'].") as count 
				FROM osc_shop_products as M   
					$filter_joins
				WHERE $charFilter AND $cats_filter AND M.block=0 
					$filters
					
				GROUP BY M.".$params['name']." 
			";
	
			return $this->q($query,1);
		}

        return [];
    }

    public function getCategoryColors($_id, $count=false, $filters="", $filter_joins=""){
        $count_select = "";
        
        if($count){
            $count_select = ",
                (SELECT 
                    COUNT(M.id) 
                    FROM osc_shop_products as M  
                    $filter_joins
                    WHERE 
                    M.block=0 AND M.cat_id=$_id
                    $filters 
                    
                ) as count 
            ";
        }
        
        $query = "
            SELECT CL.id, CL.name, CL.value $count_select 
            FROM osc_shop_products as P 
            JOIN osc_shop_colors as CL ON CL.id=P.color_id 
            WHERE 
                P.cat_id=$_id AND 
                P.block=0 
            GROUP BY P.color_id
            ORDER BY CL.name
        ";
        return $this->q($query);
    }

	public $count = 0;

    public function filters_calc_query($post_filter, $group_char_id=0, $cat_id=0){
        $r = array('filter_joins'=>"",'filters'=>"");

		$this->count++;
		
		// echo "<pre>$group_char_id : ".$this->count." - "; print_r($post_filter); echo "</pre>";
		
		$i = 1;

        foreach($post_filter as $char_id => $char_values){
            if($char_id == $group_char_id) continue;
			
			$i++;
			
            if($char_values){
                if(!$group_char_id) $_SESSION['prods_filter'][$cat_id][$char_id] = $char_values;
                $r['filter_joins'] .= " INNER JOIN osc_shop_chars_prod_ref as CPR".$i." ON CPR".$i.".prod_id=M.id ";
                $r['filters'] .= " AND CPR".$i.".char_id=$char_id AND (";
                $v_cnt = 0;

                foreach($char_values as $value){
                    $v_cnt++;
                    if($v_cnt > 1){
                        $r['filters'] .= " OR ";
                    }
                    $_v = str_replace("'","\'",$value);
                    $r['filters'] .= " CPR".$i.".val_id='$_v' ";
                } 
                $r['filters'] .= ") ";
            }
        }
        return $r;
    }
	
	public function projects_filters_calc_query($post_filter, $group_char_id=0){
        $r = array('filter_joins'=>"",'filters'=>"");

		$this->count++;		
		$i = 1;

        foreach($post_filter as $char_id => $char_values){
            if($char_id == $group_char_id) continue;
			
			$i++;
			
            if($char_values){
                if(!$group_char_id) $_SESSION['projects_filter'][$char_id] = $char_values;
                
				$r['filter_joins'] .= " INNER JOIN osc_project_chars_ref as CPR".$i." ON CPR".$i.".project_id=M.id ";
                $r['filters'] .= " AND (";
                $v_cnt = 0;

                foreach($char_values as $value){
                    $v_cnt++;
                    if($v_cnt > 1){
                        $r['filters'] .= " OR ";
                    }
                    $_v = str_replace("'","\'",$value);
                    $r['filters'] .= " CPR".$i.".val_id='$_v' ";
                } 
                $r['filters'] .= ") ";
            }
        }
        return $r;
    }

    public function filterPrepare($cat_id,$filter_group_id,$min_price=0,$max_price=100000){

        $filter_group_id    = $filter_group_id;
        $filter_prods_by_page        
                            =   (
                                isset($_SESSION['filter_prods_by_page']) ? 
                                    isset($_SESSION['filter_prods_by_page'][$cat_id]) ?  
                                            $_SESSION['filter_prods_by_page'][$cat_id]
                                    : PRODS_BY_PAGE
                                : PRODS_BY_PAGE
                                );
        $sort_vector        =   (
                                isset($_SESSION['sort_vector_filter']) ? 
                                    isset($_SESSION['sort_vector_filter'][$cat_id]) ?  
                                            $_SESSION['sort_vector_filter'][$cat_id]
                                    : 2
                                : 2
                                );
        $min_price          =   (
                                isset($_SESSION['price_filter']) ? 
                                    isset($_SESSION['price_filter'][$cat_id]) ? 
                                        isset($_SESSION['price_filter'][$cat_id]['min']) ? 
                                            $_SESSION['price_filter'][$cat_id]['min']
                                        : $min_price
                                    : $min_price
                                : $min_price
                                );
        $max_price          = (
                                isset($_SESSION['price_filter']) ? 
                                    isset($_SESSION['price_filter'][$cat_id]) ? 
                                        isset($_SESSION['price_filter'][$cat_id]['max']) ? 
                                            $_SESSION['price_filter'][$cat_id]['max']
                                        : $max_price
                                    : $max_price
                                : $max_price
                                );
        $colors             = (
                                isset($_SESSION['colors_filter']) ? 
                                    isset($_SESSION['colors_filter'][$cat_id]) ?  
                                            $_SESSION['colors_filter'][$cat_id]
                                    : []
                                : []
                                );
		$objects             = (
                                isset($_SESSION['objects_filter']) ? 
                                    isset($_SESSION['objects_filter'][$cat_id]) ?  
                                            $_SESSION['objects_filter'][$cat_id]
                                    : []
                                : []
                                );
		$collections             = (
                                isset($_SESSION['collections_filter']) ? 
                                    isset($_SESSION['collections_filter'][$cat_id]) ?  
                                            $_SESSION['collections_filter'][$cat_id]
                                    : []
                                : []
                                );
		$mfs             = (
                                isset($_SESSION['mfs_filter']) ? 
                                    isset($_SESSION['mfs_filter'][$cat_id]) ?  
                                            $_SESSION['mfs_filter'][$cat_id]
                                    : []
                                : []
                                );
        //=========================================
        // SESSION PARAMS

        $sql_order_vector = ($sort_vector==1 ? " M.".UTP_PREFIX."price DESC " : " M.".UTP_PREFIX."price ASC ");

        $filters = ""; // Фильтры к запросу в БД

        $price_min  = $min_price;
        $price_max  = $max_price;

        if($price_max > $price_min){
            $filters .= " AND (M.".UTP_PREFIX."price >= $price_min AND M.".UTP_PREFIX."price <= $price_max) ";
        }

        // FILTER PARAMS
  
        $f_pag_lim = $filter_prods_by_page; // Количество товаров на странице

        $f_pag_size = 2; // Максимальное количество отображаемых страниц в пагинации (not used)

        $f_page_num = 1; // Текущая страница пагинации

        $f_sort = UTP_PREFIX."price"; // Колонка, по которой делаем сортировку (not used)

        $f_sort .= ($sort_vector ? " DESC " : " "); // Направление сортировки (not used)
        
        $and_colors_filter = "";
        
        if($colors)
        {
            $and_colors_filter = " AND ( ";
            foreach($colors as $color_i => $color_id)
            {
                $and_colors_filter .= ($color_i ? " OR " : "") . " M.color_id=$color_id ";
            }
            $and_colors_filter .= " ) ";
        }
		
		if($objects)
        {
            $and_colors_filter = " AND ( ";
            foreach($objects as $obj_id_i => $obj_id)
            {
                $and_colors_filter .= ($obj_id_i ? " OR " : "") . " M.obj_id=$obj_id ";
            }
            $and_colors_filter .= " ) ";
        }
		
		if($collections)
        {
            $and_colors_filter = " AND ( ";
            foreach($collections as $coll_id_i => $coll_id)
            {
                $and_colors_filter .= ($coll_id_i ? " OR " : "") . " M.collection_id=$coll_id ";
            }
            $and_colors_filter .= " ) ";
        }
		
		if($mfs)
        {
            $and_colors_filter = " AND ( ";
            foreach($mfs as $mf_id_i => $mf_id)
            {
                $and_colors_filter .= ($mf_id_i ? " OR " : "") . " M.mf_id=$mf_id ";
            }
            $and_colors_filter .= " ) ";
        }
        
        $post_filter = (
                        isset($_SESSION['prods_filter']) ? 
                            isset($_SESSION['prods_filter'][$cat_id]) ?  
                                    $_SESSION['prods_filter'][$cat_id]
                            : []
                        : []
                        );

        $filter_joins = "";

        $filter_result = $this->filters_calc_query($post_filter, 0, $cat_id);
        $filter_joins_1 = $filter_joins . $filter_result['filter_joins'];
        $filters_1      = $filters      . $filter_result['filters'];

        //==============
        // COUNT CHARS !

        $charsList = $this->getCategoryFilterChars($filter_group_id);
        $charsListConvert = [];

        foreach($charsList as $item){
            $charsListConvert[$item['id']] = $item;
        }

        foreach($charsListConvert as &$overFilterChar)
        {
            $char_id = $overFilterChar['id'];

            $filter_result = $this->filters_calc_query($post_filter, $char_id, $cat_id);

            $filters_2      = $filters          . $filter_result['filters'];
            $filter_joins_2 = $filter_joins     . $filter_result['filter_joins'];

            $overFilterChar['values_count'] = $this->countFilterValues($cat_id, $char_id, $filters_2.$and_colors_filter, $filter_joins_2);  // Количество товаров в фильтрах

            foreach($overFilterChar['values_count'] as &$j_item)
            {
                $j_item['ref_md5'] = md5( $char_id . trim(mb_strtolower($j_item['value'])) );
            }
        }

        return [
                'filters_1'         => $filters_1, 
                'and_colors_filter' => $and_colors_filter, 
                'filter_joins_1'    => $filter_joins_1, 
                'sql_order_vector'  => $sql_order_vector,
                'min_price'         => $min_price,
                'max_price'         => $max_price,
                'colors'            => $colors,
				'objects'           => $objects,
				'collections'       => $collections,
				'mfs'            	=> $mfs,
                'checked_chars'     => $post_filter, 
                'charsList'         => $charsListConvert,
                'sort_vector'       => $sort_vector,
                'filter_prods_by_page' => $filter_prods_by_page      
                ];

    }
	
	 public function filterProjectsPrepare(){

        $filter_projects_by_page	= (isset($_SESSION['filter_projects_by_page']) ? $_SESSION['filter_projects_by_page'] : PRODS_BY_PAGE );
		
        $sort_vector       			= ( isset($_SESSION['projects_sort_vector_filter']) ? $_SESSION['projects_sort_vector_filter'] : 2 );
        
		$users             			= ( isset($_SESSION['projects_users_filter']) ? $_SESSION['projects_users_filter'] : [] );

        //=========================================
        // SESSION PARAMS

        $sql_order_vector = ($sort_vector==1 ? " M.dateCreate DESC " : " M.dateCreate ASC ");

        $filters = ""; // Фильтры к запросу в БД
		
        // FILTER PARAMS
  
        $f_pag_lim = $filter_projects_by_page; // Количество товаров на странице

        $f_page_num = 1; // Текущая страница пагинации
        
        $and_colors_filter = "";
        
        if($users)
        {
            $and_colors_filter = " AND ( ";
            foreach($users as $uid_i => $uid)
            {
                $and_colors_filter .= ($uid_i ? " OR " : "") . " M.user_id=$uid ";
            }
            $and_colors_filter .= " ) ";
        }
        
        $post_filter = ( isset($_SESSION['projects_filter']) ? $_SESSION['projects_filter'] : [] );

        $filter_joins = "";
		$filters = "";
		
		// return []; // !!!! STOP 

        $filter_result = $this->projects_filters_calc_query($post_filter, 0);
        $filter_joins_1 = $filter_joins . $filter_result['filter_joins'];
        $filters_1      = $filters      . $filter_result['filters'];

        //==============
        // COUNT CHARS !

        $charsList = $this->getProjectsFilterChars();
        $charsListConvert = [];

        foreach($charsList as $item){
            $charsListConvert[$item['id']] = $item;
        }

        foreach($charsListConvert as &$overFilterChar)
        {
            $char_id = $overFilterChar['id'];

            $filter_result = $this->projects_filters_calc_query($post_filter, $char_id);

            $filters_2      = $filters          . $filter_result['filters'];
            $filter_joins_2 = $filter_joins     . $filter_result['filter_joins'];

            $overFilterChar['values_count'] = $this->countProjectsFilterValues($char_id, $filters_2.$and_colors_filter, $filter_joins_2);  // Количество товаров в фильтрах

            foreach($overFilterChar['values_count'] as &$j_item)
            {
                $j_item['ref_md5'] = md5( $char_id . trim(mb_strtolower($j_item['value'])) );
            }
        }

        return [
                'filters_1'         => $filters_1, 
                'and_colors_filter' => $and_colors_filter, 
                'filter_joins_1'    => $filter_joins_1, 
                'sql_order_vector'  => $sql_order_vector,
                'users'            	=> $users,
                'checked_chars'     => $post_filter, 
                'charsList'         => $charsListConvert,
                'sort_vector'       => $sort_vector,
                'filter_prods_by_page' => $filter_projects_by_page      
                ];

    }

    public function filter(){
        // Prepare Response Array
        $data = array('status'=>'failed', 'mf_list'=>array(), 'resultHtml'=>'<div class="alert alert-info">По Вашему запросу товаров не найдено. Пожалуйста, скорректируйте свой фильтр.</div>', 'filter_chars'=>array(), 'productsNavi'=>"");

        $filter_prods_by_page = PR_QTY; //(int)$this->_post('filter_prods_by_page');
        $main_cat = $this->_post('main_cat');
        $child_cat = $this->_post('child_cat');
        $filter_group_id = $this->_post('filter_group_id');
        $curr_link = $this->_post('curr_link');
        $sort_vector = $this->_post('sort_vector');
        $min_price = $this->_post('min_price');
        $max_price = $this->_post('max_price');
        $price_range = $this->_post('price_range');
		
        $colors 		= $this->_post('colors');
		$objects 		= $this->_post('objects');
		$collections 	= $this->_post('collections');
		$mfs 			= $this->_post('mfs');

        //=========================================
        // POST PARAMS

        $sql_order_vector = ($sort_vector==1 ? " M.price DESC " : " M.price ASC ");

        $filters = ""; // Фильтры к запросу в БД

        $cat_id = (int)($child_cat ? $child_cat : $main_cat);


        $_SESSION['colors_filter'] = array();
		
		$_SESSION['objects_filter'] = array();
		$_SESSION['mfs_filter'] = array();
		$_SESSION['collections_filter'] = array();
		
        $_SESSION['price_filter'] = array();
        $_SESSION['prods_filter'] = array();
        $_SESSION['sort_vector_filter'] = array();
        $_SESSION['filter_prods_by_page'] = array();
        $_SESSION['price_filter'][$cat_id] = array();
        $_SESSION['prods_filter'][$cat_id] = array();
        
		$_SESSION['colors_filter'][$cat_id] = array();
		$_SESSION['objects_filter'][$cat_id] = array();
		$_SESSION['mfs_filter'][$cat_id] = array();
		$_SESSION['collections_filter'][$cat_id] = array();
		
        $_SESSION['sort_vector_filter'][$cat_id] = $sort_vector;
        $_SESSION['filter_prods_by_page'][$cat_id] = $filter_prods_by_page;

        $curr_link = strip_tags(trim($_POST['curr_link']));

        $price_min  = $min_price;
        $price_max  = $max_price;

        if($price_max > $price_min){
            $filters .= " AND (M.".UTP_PREFIX."price >= $price_min AND M.".UTP_PREFIX."price <= $price_max) ";
            $_SESSION['price_filter'][$cat_id] = array('min'=>$price_min, 'max'=>$price_max);
        }

        // FILTER PARAMS
  
        $f_pag_lim = $filter_prods_by_page; // Количество товаров на странице

        $f_pag_size = 2; // Максимальное количество отображаемых страниц в пагинации (not used)

        $f_page_num = 1; // Текущая страница пагинации

        $f_sort = (isset($_POST['sort']) ? strip_tags($_POST['sort']) : UTP_PREFIX."price"); // Колонка, по которой делаем сортировку

        $f_sort .= ($sort_vector ? " DESC " : " "); // Направление сортировки: убывающая/возрастающая
        
        $and_colors_filter = "";
        
		// COLORS
		
        if($colors)
        {
            $_SESSION['colors_filter'][$cat_id] = $colors;
            
            $and_colors_filter = " AND ( ";
            foreach($colors as $color_i => $color_id)
            {
                $and_colors_filter .= ($color_i ? " OR " : "") . " M.color_id=$color_id ";
            }
            $and_colors_filter .= " ) ";
        }
		
		//OBJECTS
		
		if($objects)
        {
            $_SESSION['objects_filter'][$cat_id] = $objects;
            
            $and_colors_filter .= " AND ( ";
            foreach($objects as $object_i => $object_id)
            {
                $and_colors_filter .= ($object_i ? " OR " : "") . " M.obj_id=$object_id ";
            }
            $and_colors_filter .= " ) ";
        }
		
		//COLLECTIONS
		
		if($collections)
        {
            $_SESSION['collections_filter'][$cat_id] = $collections;
            
            $and_colors_filter .= " AND ( ";
            foreach($collections as $collection_i => $collection_id)
            {
                $and_colors_filter .= ($collection_i ? " OR " : "") . " M.collection_id=$collection_id ";
            }
            $and_colors_filter .= " ) ";
        }
		
		//MFS
		
		if($mfs)
        {
            $_SESSION['mfs_filter'][$cat_id] = $mfs;
            
            $and_colors_filter .= " AND ( ";
            foreach($mfs as $mf_i => $mf_id)
            {
                $and_colors_filter .= ($mf_i ? " OR " : "") . " M.mf_id=$mf_id ";
            }
            $and_colors_filter .= " ) ";
        }
        
		// end of aditional filters for PRODUCTS table
		
        $post_filter = (isset($_POST['filter']) ? $_POST['filter'] :  array());

        $filter_joins = "";

        $filter_result = $this->filters_calc_query($post_filter, 0, $cat_id);
        $filter_joins_1 = $filter_joins . $filter_result['filter_joins'];
        $filters_1      = $filters      . $filter_result['filters'];

        ob_start();

		// ['items'=>[],'rows'=>0]; //
		
        $prodListResult = $this->getCategoryProductsById($cat_id, $f_page_num, $f_pag_lim, $filters_1.$and_colors_filter, $filter_joins_1, $sql_order_vector); // Список товаров на странице

        $prodList = $prodListResult['items'];
        $data['prodList'] = $prodList;

        $rows = $prodListResult['rows']; // глобальное количество товаров в категории
        $data['rows'] = $rows;
          
        $f_total_rows = $rows['rows'];
        $data['f_total_rows'] = $f_total_rows;

        $f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
        $data['f_pages_count'] = $f_pages_count;

        //==============
        // COUNT CHARS !

        $charsList = $this->getCategoryFilterChars($filter_group_id);

        foreach($charsList as &$overFilterChar)
        {
            $char_id = $overFilterChar['id'];

            $filter_result = $this->filters_calc_query($post_filter, $char_id, $cat_id);
			
            $filters_2      = $filters          . $filter_result['filters'];
            $filter_joins_2 = $filter_joins     . $filter_result['filter_joins'];

            $overFilterChar['values_count'] = $this->countFilterValues($cat_id, $char_id, $filters_2.$and_colors_filter, $filter_joins_2);  // Количество товаров в фильтрах
			
			// echo "<pre style='width:100%;'>"; print_r($overFilterChar); echo "</pre><div class='clear'><hr></div>";

            foreach($overFilterChar['values_count'] as &$j_item)
            {
                $j_item['ref_md5'] = md5( $char_id . trim(mb_strtolower($j_item['value'])) );
            }
        }

        $data['filter_chars'] = $charsList;
		
		// Calculate count for products table filters
		
		$productsTableFilters = [
			'color_id' 		=> $this->getUniColorsFromOneCategory($cat_id),
			'obj_id' 		=> $this->getUniObjectsFromOneCategory($cat_id),        
			'collection_id' => $this->getUniCollectionsFromOneCategory($cat_id),        
			'mf_id' 		=> $this->getUniMfsFromOneCategory($cat_id)
		];                 
		
		$filtersPrepeared = $this->filters_calc_query($post_filter, 0, $cat_id);
		
		$filters_xf      = $filters          . $filtersPrepeared['filters'];
        $filter_joins_xf = $filter_joins     . $filtersPrepeared['filter_joins'];
		
		foreach($productsTableFilters as $xf_name => &$xf_list_item)
		{
			foreach($xf_list_item as $xfi => $x_item)
			{
				$xf_list_item[$xfi]['ref_md5'] = md5( $xf_name.$x_item['id'] . trim(mb_strtolower($x_item['name'])) );
				
				$xf_list_item[$xfi]['count'] = 0;
				
				$currXfCountResult = $this->countXFilterValues($cat_id, ['name'=>$xf_name, 'id'=>$x_item['id']], $filters_xf, $filter_joins_xf);  
				// Количество товаров учитывая все фильтры по заданному field_id в таблице Products
			
				if($currXfCountResult) $xf_list_item[$xfi]['count'] = $currXfCountResult['count'];
			}
		}
		
		//echo "<pre style='width:100%;'>"; 
			// print_r($productsTableFilters); 
			//print_r($currColorCountResult); 
		//echo "</pre><div class='clear'><hr></div>";
		
		$data['filters_xf'] = $productsTableFilters;
        
        // COLORS
        
        $data['colors_list'] = $this->getCategoryColors($cat_id, true, $filters_1, $filter_joins_1);
        
        $data['resultHtml'] = ob_get_contents();

        ob_end_clean();

        ob_start();
		
		?>
            <?php if ($prodList): ?>
                        <?php foreach ($prodList as $prodItem): 
							
							$formatProdPrice = number_format($prodItem['price'], 0, '.', '.');								
							$formatProdPriceSale = number_format($prodItem['sale_price'], 0, '.', '.');								
							$prodUrl = RS.LANG."/catalog/product/".$prodItem['alias']."/";
							$prodIcon = "";
							$prodIconTxt = "";
							if ($prodItem['sale_id']){ $prodIcon = "discount"; $prodIconTxt = "%";}
							elseif ($prodItem['new_id']){ $prodIcon = "new"; $prodIconTxt = "new";}
							elseif ($prodItem['delivery']){ $prodIcon = "delivery"; $prodIconTxt = "";}
							
						?>
                            
                            <!-- PROD ITEM -->
                            <div class="catalog__item" id="list_prod_<?=$prodItem['id']?>">
                                <a href="<?= $prodUrl ?>" onclick="mainScript.addToView(<?=$prodItem['id']?>);">
                                    <img src="<?= IMG.CIMG.$prodItem['img'] ?>" alt="COMODO IMG" />
                                    <div class="catalog__descr">
                                        <div class="catalog__see-more">
                                            <p>
                                            	<?php if (LANG_PREFIX == '') { echo "Смотреть подробнее";}
													elseif (LANG_PREFIX == 'ua_') { echo "Дивитися докладніше";}
													else { echo "Whatch more";} ?>
                                            </p>
                                        </div>
                                        <div class="catalog__descr-param">
                                            <p class="catalog__descr-name"><?= $prodItem['obj_name'] ?></p>
                                            <p class="catalog__descr-value"><?= $prodItem['name'] ?></p>
                                        </div>
                                        <div class="catalog__descr-param">
                                            <p class="catalog__descr-name">
												<?php if (LANG_PREFIX == '') { echo "Фабрика";}
                                                elseif (LANG_PREFIX == 'ua_') { echo "Фабрика";}
                                                else { echo "Factory";} ?>
											</p>
                                            <p class="catalog__descr-value"><?= $prodItem['mf_name'] ?></p>
                                        </div>
                                        <?php if($prodItem['price']){?>
                                            <div class="catalog__descr-param hidden">
                                                <p class="catalog__descr-name">
													<?php if (LANG_PREFIX == '') { echo "Цена";}
                                                    elseif (LANG_PREFIX == 'ua_') { echo "Ціна";}
                                                    else { echo "Price";} ?>
                                                </p>
                                                <p class="catalog__descr-value"><?= $formatProdPrice ." ". CURNAME ?></p>
                                            </div>
                                        <?php }?>
                                    </div>
                                </a>
                            </div>
                            <!-- /PROD ITEM -->
                            
                        <?php endforeach ?>
                    <?php else: ?>
                        <p class="no_items">                        
							<?php if (LANG_PREFIX == '') { echo "По Вашему запросу товаров не найдено, пожалуйста скорректируйте условия фильтров.";}
                            elseif (LANG_PREFIX == 'ua_') { echo "За Вашим запитом товарів не знайдено, будь ласка скоректуйте умови фільтрів.";}
                            else { echo "Your search for items not found, please adjust the filter conditions.";} ?>
                        </p>
                    <?php endif ?>
        <?php
        //include("../templates/".TEMPLATE_NAME."/view/shop/shopCatProdList.php");

        //include("../templates/".TEMPLATE_NAME."/view/shop/shopCatProdPagination.php");

        $data['resultHtml'] .= ob_get_contents();

        ob_end_clean();

        ob_start();
			
			$f_page_size = 5;
			$f_page_num = 1;
			$site_translate = [['ru_text'=>'Далее','text'=> (LANG=='ru' ? 'Далее' : (LANG=='ua' ? 'Далі' : 'Next')) ]];
			
			// PAGINATION INCLUDE __FILE__
			$path = dirname(__FILE__) ;
			include(str_replace("Controller/Component","",$path)."Template/Catalog/pagination.php");
       
        $data['productsNavi'] = ob_get_contents();

        ob_end_clean();

        // Return Json Array

        if($prodList) $data['status'] = 'success';

        $data['url'] = "http://".$_SERVER['HTTP_HOST'].$curr_link;

        // debug($data);

        return $data;
    }
	
	public function filterProjects(){
        // Prepare Response Array
        $data = array('status'=>'failed', 'mf_list'=>array(), 'resultHtml'=>'<div class="alert alert-info">По Вашему запросу проектов не найдено. Пожалуйста, скорректируйте свой фильтр.</div>', 'filter_chars'=>array(), 'productsNavi'=>"");

        $filter_prods_by_page = PROJECTS_QTY; //(int)$this->_post('filter_prods_by_page');
        $main_cat = 0; //$this->_post('main_cat');
        $child_cat = 0; //$this->_post('child_cat');
        $filter_group_id = 0; //$this->_post('filter_group_id');
        $curr_link = $this->_post('curr_link');
        $sort_vector = $this->_post('sort_vector');
		
        $users 		= $this->_post('users');

        //=========================================
        // POST PARAMS

        $sql_order_vector = ($sort_vector==1 ? " M.dateCreate DESC " : " M.dateCreate ASC ");

        $filters = ""; // Фильтры к запросу в БД

        $cat_id = 0;

        $_SESSION['projects_users_filter'] = array();
		$_SESSION['projects_filter'] = array();
        $_SESSION['sort_vector_filter'] = array();
        $_SESSION['filter_prods_by_page'] = array();
        
        $curr_link = $this->_post('curr_link');

        // FILTER PARAMS
  
        $f_pag_lim = $filter_prods_by_page; // Количество товаров на странице

        $f_page_num = 1; // Текущая страница пагинации

        $f_sort = " M.dateCreate "; // Колонка, по которой делаем сортировку

        $f_sort .= ($sort_vector ? " DESC " : " "); // Направление сортировки: убывающая/возрастающая
        
        $and_colors_filter = "";
        
		// USERS
		
		if($users)
        {
            $_SESSION['projects_users_filter'] = $users;
            
            $and_colors_filter .= " AND ( ";
            foreach($users as $uid_i => $uid)
            {
                $and_colors_filter .= ($uid_i ? " OR " : "") . " M.user_id=$uid ";
            }
            $and_colors_filter .= " ) ";
        }
        
		// end of aditional filters for PROJECTS table
		
        $post_filter = (isset($_POST['filter']) ? $_POST['filter'] :  array());

        $filter_joins = "";

        $filter_result = $this->projects_filters_calc_query($post_filter, 0);
        $filter_joins_1 = $filter_joins . $filter_result['filter_joins'];
        $filters_1      = $filters      . $filter_result['filters'];

        ob_start();

		// ['items'=>[],'rows'=>0]; //
		
        $prodListResult = $this->getProjects($f_page_num, $f_pag_lim, $filters_1.$and_colors_filter, $filter_joins_1, $sql_order_vector); // Список projects на странице

        $prodList = $prodListResult['items'];
        $data['prodList'] = $prodList;

        $rows = $prodListResult['rows']; // глобальное количество товаров в категории
        $data['rows'] = $rows;
          
        $f_total_rows = $rows['rows'];
        $data['f_total_rows'] = $f_total_rows;

        $f_pages_count = ceil($f_total_rows/$f_pag_lim); // определяем количество страниц в пагинации
        $data['f_pages_count'] = $f_pages_count;

        //==============
        // COUNT CHARS !

        $charsList = $this->getProjectsFilterChars($filter_group_id);

        foreach($charsList as &$overFilterChar)
        {
            $char_id = $overFilterChar['id'];

            $filter_result = $this->projects_filters_calc_query($post_filter, $char_id);
			
            $filters_2      = $filters          . $filter_result['filters'];
            $filter_joins_2 = $filter_joins     . $filter_result['filter_joins'];

            $overFilterChar['values_count'] = $this->countProjectsFilterValues($char_id, $filters_2.$and_colors_filter, $filter_joins_2);  // Количество товаров в фильтрах
			
			// echo "<pre style='width:100%;'>"; print_r($overFilterChar); echo "</pre><div class='clear'><hr></div>";

            foreach($overFilterChar['values_count'] as &$j_item)
            {
                $j_item['ref_md5'] = md5( $char_id . trim(mb_strtolower($j_item['value'])) );
            }
        }

        $data['filter_chars'] = $charsList;
		
		// Calculate count for products table filters
		
		$productsTableFilters = [
			'user_id' 	=> $this->getUniUsersForProjects()
		];                 
		
		// $filtersPrepeared = $this->filters_calc_query($post_filter, 0, $cat_id);
		
		$filters_xf      = $filters_1; //          . $filtersPrepeared['filters'];
        $filter_joins_xf = $filter_joins_1; //     . $filtersPrepeared['filter_joins'];
		
		foreach($productsTableFilters as $xf_name => &$xf_list_item)
		{
			foreach($xf_list_item as $xfi => $x_item)
			{
				$xf_list_item[$xfi]['ref_md5'] = md5( $xf_name.$x_item['id'] . trim(mb_strtolower($x_item['name'])) );
				
				$xf_list_item[$xfi]['count'] = 0;
				
				$currXfCountResult = $this->countProjectsXFilterValues(['name'=>$xf_name, 'id'=>$x_item['id']], $filters_xf, $filter_joins_xf);  
				// Количество товаров учитывая все фильтры по заданному field_id в таблице Products
			
				if($currXfCountResult) $xf_list_item[$xfi]['count'] = $currXfCountResult['count'];
			}
		}
		
		//echo "<pre style='width:100%;'>"; 
			// print_r($productsTableFilters); 
			//print_r($currColorCountResult); 
		//echo "</pre><div class='clear'><hr></div>";
		
		$data['filters_xf'] = $productsTableFilters;
        
        // USERS
        // $data['users_list'] = $this->getCategoryColors($cat_id, true, $filters_1, $filter_joins_1);
        
        $data['resultHtml'] = ob_get_contents();

        ob_end_clean();

        ob_start();
		
		
		$site_translate = [
			['ru_text'=>'Далее','text'=> (LANG=='ru' ? 'Далее' : (LANG=='ua' ? 'Далі' : 'Next')) ],
			['ru_text'=>'Смотреть подробнее','text'=> (LANG=='ru' ? 'Смотреть подробнее' : (LANG=='ua' ? 'Дивитись детальніше' : 'WATCH MORE')) ]
		];
		
		$tt = [];
		
		foreach($site_translate as $t_item){
			$tt[$t_item['ru_text']] = $t_item['text'];
			}
		
		?>
            <?php if ($prodList): ?>
                        <?php foreach ($prodList as $proj): ?>
                            
                            <!-- PROD ITEM -->
                            <div class="catalog__item">
                                <a href="<?=$proj['alias']?>/">
                                    <div class="proj_list_img">
                                        <img src="<?= IMG.PJCIMG.$proj['img'] ?>" alt="<?= $proj['title'] ?>" />
                                    </div>
                                    <div class="catalog__descr">
                                        <div class="catalog__see-more">
                                            <p><?= $tt['Смотреть подробнее']; ?></p>
                                        </div>
                                        <p class="projects__name"><?=$proj['name']?></p>
                                    </div>
                                </a>
                            </div>
                            <!-- /PROD ITEM -->
                            
                        <?php endforeach ?>
                    <?php else: ?>
                        <p class="no_items">                        
							<?php if (LANG_PREFIX == '') { echo "По Вашему запросу projects не найдено, пожалуйста скорректируйте условия фильтров.";}
                            elseif (LANG_PREFIX == 'ua_') { echo "За Вашим запитом projects не знайдено, будь ласка скоректуйте умови фільтрів.";}
                            else { echo "Your search for items not found, please adjust the filter conditions.";} ?>
                        </p>
                    <?php endif ?>
        <?php
        //include("../templates/".TEMPLATE_NAME."/view/shop/shopCatProdList.php");

        //include("../templates/".TEMPLATE_NAME."/view/shop/shopCatProdPagination.php");

        $data['resultHtml'] .= ob_get_contents();

        ob_end_clean();

        ob_start();
			
			$f_page_size = 5;
			$f_page_num = 1;
			
			// PAGINATION INCLUDE
			include(str_replace("Controller/Component","",dirname(__FILE__))."Template/Projects/pagination.php");
       
        $data['productsNavi'] = ob_get_contents();

        ob_end_clean();

        // Return Json Array

        if($prodList) $data['status'] = 'success';

        $data['url'] = "http://".$_SERVER['HTTP_HOST'].$curr_link;

        // debug($data);

        return $data;
    }

    public function submitOrder(){
        $data = ['status' => 'failed', 'message' => '', 'reason'=>'', 'ref'=>''];

        $oc = $this->_post('oc');
        if ($oc == 1) {
            $name = $this->_post('oc_name');
            $phone = $this->_post('oc_phone');
            $email = $this->_post('oc_email');

            $pay_type = 1;
            $del_type = 1;
            $city_adr = false;
            $street_adr = false;
            $building_adr = false;
            $flat_adr = false;
            $comment = false;

            $quick = true;
        }else{
            $name = $this->_post('name');
            $phone = $this->_post('phone');
            $email = $this->_post('email');
            
            $pay_type = (int)$_POST['pay_type'];
            $del_type = (int)$_POST['del_type'];
            $city_adr = $this->_post('city_adr');
            $street_adr = $this->_post('street_adr');
            $building_adr = (int)$_POST['building_adr'];
            $flat_adr = (int)$_POST['flat_adr'];
            $comment = $this->_post('comment');

            $quick = false;
        }

        $main_validation = false;
        $insert = false;
        $new_user = false;
        

        $place_order = "";

        if (mb_strlen($name) >= 2 ) {
            if ($this->check_phone($phone)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($pay_type == 1 || $pay_type == 2) {
                        if ($del_type == 1 || $del_type == 2 || $del_type == 3) {
                            $main_validation = true;
                        }else{
                            $data['reason'] = "del_type";
                            $data['message'] = "Выберите способ доставки";
                            return $data;
                            exit();
                        }
                    }else{
                        $data['reason'] = "pay_type";
                        $data['message'] = "Выберите способ оплаты";
                        return $data;
                        exit();
                    }
                }else{
                    $data['reason'] = "email";
                    $data['message'] = "Укажите корректный email";
                    return $data;
                    exit();
                }
            }else{
                $data['reason'] = "phone";
                $data['message'] = "Укажите корректный телефон";
                return $data;
                exit();
            }
        }else{
            $data['reason'] = "name";
            $data['message'] = "Укажите свое имя";
            return $data;
            exit();
        }

        if ($main_validation === true) {
            // DETECT DELIVERY METHOD
            switch ($del_type) {
                case 1:
                    $place_order = 'self';
                    break;
                case 2:
                    $np_city = $this->_post('np_city');
                    if ($np_city && $np_city != '0') {
                        $np_dep = $this->_post('np_dep');
                        if ($np_dep && $np_dep != '0') {
                            $place_order = 'np';
                        }else{
                            $data['reason'] = "np_dep";
                            $data['message'] = "Выберите отделение из списка";
                        }
                    }else{
                        $data['reason'] = "np_city";
                        $data['message'] = "Выберите город из списка";
                    }
                    break;
                case 3:
                    if ($city_adr && mb_strlen($city_adr) >= 1) {
                        if ($street_adr && mb_strlen($street_adr) >= 1) {
                            if ($building_adr) {
                                if ($flat_adr) {
                                    $place_order = 'courier';
                                }else{
                                    $data['reason'] = "flat_adr";
                                    $data['message'] = "Укажите ваш номер квартиры";
                                }
                            }else{
                                $data['reason'] = "building_adr";
                                $data['message'] = "Укажите ваш номер дома";
                            }
                        }else{
                            $data['reason'] = "street_adr";
                            $data['message'] = "Укажите вашу улицу";
                        }
                    }else{
                        $data['reason'] = "city_adr";
                        $data['message'] = "Укажите ваш город";
                    }
                    break;
                
                default:
                    break;
            }
        }

        $cart = $this->getCart();



        // HACK PREVENT
        if (UTP == "ws") {
            $cart_items_count = 0;
            foreach ($cart as $key => $value) {
               $cart_items_count += $value['quant'];
            }
            $ws_limit = WS_LIMIT;
            $ws_limit_text = "";
            if ($ws_limit == 1) {
                $ws_limit_text = "товар.";
            }else{
                $ws_limit_text = "товаров.";
            }
            if ($cart_items_count < WS_LIMIT) {
                $data['message'] = "Оптовый покупатель не может оформить заказ при количестве менее ".$ws_limit." ".$ws_limit_text;
                return $data;
                exit();
            }
        }

        $selected_products = addslashes(json_encode($cart));
        $del_meth_id = $del_type;
        $pay_meth_id = $pay_type;
        $prods_count = $this->getCartCountInfo('count');
        $prods_sum = $this->getCartCountInfo('sum');
        $uid = UID;
        $session_id = session_id();

        if(UTP == "rt") {
            $client_type = 30;
        }elseif(UTP == "ws"){
            $client_type = 20;
        }else{
            $client_type = 0;
        }

        if (!$comment) {
            $comment = "";
        }

        // CREATE USER IF NOT ONLINE
        if (!ONLINE) {
            if ($this->check_user($email)) {
                $data['message'] = "Пользователь с таким email уже существует";
                return $data; exit();
            }else{
                // NEW PASSWORD GENERATION

                $new_pass = $this->getRandPass();
                $new_pass_md = md5($new_pass);
                $user_type = 30;
                $now = HelpComponent::now();

                $q = "
                    INSERT INTO `osc_users`
                    (`type`, `login`, `pass`, `phone`, `name`, `dateCreate`, `dateModify`)
                    VALUES
                    ('$user_type', '$email', '$new_pass_md', '$phone', '$name', '$now', '$now')
                ";
                $new_user = $this->q($q, 2);

                if ($new_user) {
                    $uid = $new_user->lastInsertId();

                    $_SESSION['login'] = array();
                    array_push($_SESSION['login'], $uid);
                    array_push($_SESSION['login'], $user_type);

                }
            }
        }

        $now = HelpComponent::now();

        if ($place_order == 'self') {
            // QUUCK FILTER

            $quick_filter = "";
            $quick_filter2 = "";
            if ($quick == true) {
                $quick_filter = " , `is_quick` ";
                $quick_filter2 = " , 1 ";
            }
            $q = "
                INSERT INTO `osc_shop_orders` 
                (`client_email`, `client_phone`, `client_name`, `client_type`, `user_id`, `session_id`, `status`, `paid_status`, `pay_method`, `delivery_method`, `products_quant`, `sum`, `products`, `details`, `dateCreate`, `dateModify` ".$quick_filter." )
                VALUES ('$email', '$phone', '$name', '$client_type', '$uid', '$session_id', 1, 'Не оплачен', '$pay_meth_id', '$del_meth_id', '$prods_count', '$prods_sum', '$selected_products', '$comment', '$now', '$now' ".$quick_filter2.")
            ";

            $insert = $this->q($q, 2);
        }

        if ($place_order == 'np') {
            $q = "SELECT M.Description FROM `next_np_cities` AS M WHERE M.Ref = '$np_city' LIMIT 1";
            $np_city = $this->q($q, 1)['Description'];
            $q = "SELECT M.DescriptionRu FROM `next_np_parts` AS M WHERE M.id = '$np_dep' LIMIT 1";
            $np_dep = $this->q($q, 1)['DescriptionRu'];
            $np_del_addr = $np_city.", ".$np_dep;

            $q = "
                INSERT INTO `osc_shop_orders` 
                (`client_email`, `client_phone`, `client_name`, `client_type`, `user_id`, `session_id`, `status`, `paid_status`, `pay_method`, `delivery_method`, `products_quant`, `sum`, `products`, `details`, `dateCreate`, `dateModify`, `np_delivery_address`)
                VALUES ('$email', '$phone', '$name', '$client_type', '$uid', '$session_id', 1, 'Не оплачен', '$pay_meth_id', '$del_meth_id', '$prods_count', '$prods_sum', '$selected_products', '$comment', '$now', '$now', '$np_del_addr')
            ";
            $insert = $this->q($q, 2);
        }

        if ($place_order == 'courier') {

            $del_addr = $city_adr.", ".$street_adr.", ".$building_adr.", ".$flat_adr;
            
            $q = "
                INSERT INTO `osc_shop_orders` 
                (`client_email`, `client_phone`, `client_name`, `client_type`, `user_id`, `session_id`, `status`, `paid_status`, `pay_method`, `delivery_method`, `products_quant`, `sum`, `products`, `details`, `dateCreate`, `dateModify`, `delivery_address`)
                VALUES ('$email', '$phone', '$name', '$client_type', '$uid', '$session_id', 1, 'Не оплачен', '$pay_meth_id', '$del_meth_id', '$prods_count', '$prods_sum', '$selected_products', '$comment', '$now', '$now', '$del_addr')
            ";
            $insert = $this->q($q, 2);
        }

   


        if ($insert) {

            $order_id = $insert->lastInsertId();
            if ($pay_type == 2) {
                $data['message'] = "Ваш заказ успешно оформлен. На указанный email было отправлено письмо с реквизитами для опталы заказа";

                // GET REQUISITES
                $q = "SELECT M.card_requisites FROM `osc_shop_settings` AS M WHERE M.id = 1 LIMIT 1";
                $requisites = $this->q($q, 1)['card_requisites'];
            }else{
                $data['message'] = "Ваш заказ успешно оформлен.";
                $requisites = false;               
            }

            // SEND MAIL IF SUCCESS
            $from = "shop@onepolar.com";
            $from_title = "OnePolar";
            $subject = "Оформление заказа на OnePolar";

            $message = '
                <html> 
                <head> 
                <title>Оформление заказа на OnePolar</title> 
                </head> 
                <body> 
                <style>
                 p {margin: 0}
                </style>
                <p style="margin: 0">Вы успешно оформили заказ в магазине OnePolar</p>
            ';
            
            if ($new_user) {
                $message .= '
                    <hr/>
                    <p style="margin: 0">Ваши регистрационные данные:</p>
                    <hr/>
                    <p style="margin: 0">Логин: '.$email.'</p>
                    <p style="margin: 0">Пароль: '.$new_pass.'</p>
                ';
            }
            if ($requisites) {
                $message .= '
                    <hr/>
                    <p style="margin: 0">Реквизиты для оплаты:</p>
                    <hr/>
                    <div>'.$requisites.'</div>
                ';
            }
            $message .= '<p>Ваш заказ:</p>';
                                   
            foreach ($cart as $key => $value) {
                $message .= "<hr/>";
                $message .= "<h4>".$value['name']."</h4>";
                $message .= "<p style='margin: 0'>Количество: <b>".$value['quant']."</b></p>";
                $price = $value['price'];
                $message .= "<p style='margin: 0'>Цена: <b>".$price * $value['quant']." грн.</b></p>";
            }

            $message .= '
                <p style="margin: 0">Спасибо за покупку</p>
                </body> 
                </html>
            ';

            $email_obj = new Email('default');
            $email_obj->from(['onepolar.ukraine@gmail.com' => 'OnePolar Ukraine'])
                ->emailFormat('html')
                ->to($email)
                ->subject($subject)
                ->send($message);
            //$this->send_mail($email, $subject, $message, $from, $from_title);

            // CHANGE PRODUCTS QUANT
            foreach ($cart as $key) {
                $cart_prod_id = $key['id'];
                $q = "SELECT M.* FROM `osc_shop_products` AS M WHERE M.id = '$cart_prod_id' LIMIT 1";
                $product = $this->q($q, 1);
                $product_id = $product['id'];
                $product_quant = $product['quant'];
                $f_quant = $product_quant - $key['quant'];

                if ($f_quant > 0) {
                    $q = "UPDATE `osc_shop_products` SET `quant` = '$f_quant' WHERE `id` = '$product_id' LIMIT 1";
                }else{
                    $q = "UPDATE `osc_shop_products` SET `quant` = 0 WHERE `id` = '$product_id' LIMIT 1";
                }
                $this->q($q, 2);
            }

            // CLEAR CART
            $sess_id = session_id();
            if (ONLINE) {
                $uid = UID;
                $q = "DELETE FROM `osc_shop_cart` WHERE `uid` = '$uid' OR `session_id` = '$sess_id'";
            }else{
                $q = "DELETE FROM `osc_shop_cart` WHERE `session_id` = '$sess_id'";
            }
            $this->q($q, 2);

            $data['status'] = "success";
            $data['order_id'] = base64_encode($order_id);

        }else{
            return $data;
        }


        return $data;
    }

    public function getOrderById($order_post_id){
        $q = "SELECT M.id FROM `osc_shop_orders` AS M WHERE M.id = '$order_post_id' LIMIT 1";
        $order_id = $this->q($q, 1);
        if ($order_id) {
            $order_id = $order_id['id'];
            $session_id = session_id();
            $filter = "";
            if (ONLINE) {
                $uid = UID;
                $filter = " AND M.user_id = '$uid' AND M.session_id = '$session_id' ";
            }else{
                $filter = " AND M.session_id = '$session_id' ";
            }
            $q = "
                SELECT M.* FROM `osc_shop_orders` AS M WHERE M.id = '$order_id' $filter LIMIT 1
            ";
            return $this->q($q, 1);
        }else{
            return false;
        }
    }

    public function getProfileOrders($uid){
        $q = "
            SELECT M.*,
                (SELECT `name` FROM `osc_shop_order_statuses` WHERE `id` = M.status LIMIT 1) as order_status 
            FROM `osc_shop_orders` AS M 
            WHERE M.user_id = '$uid' AND M.is_quick = 0
            ORDER BY M.id DESC 
            LIMIT 100
        ";
        $orders = $this->q($q);
        return $orders;
    }

    public function clearCart(){
        $filter = "";
        if (ONLINE) {
            $uid = UID;
            $session_id = session_id();
            $filter = " `uid` = '$uid' AND `session_id` = '$session_id' ";
        }else{
            $session_id = session_id();
            $filter = " `session_id` = '$session_id' ";
        }
        $q = "DELETE FROM `osc_shop_cart` WHERE $filter";
            $this->q($q, 2);
    }

    public function getPayMethods(){
        $q = "
            SELECT M.id, M.name FROM `osc_shop_payment_methods` AS M
            LIMIT 30
        ";
        return $this->q($q);
    }

    public function getDelMethods(){
        $q = "
            SELECT M.id, M.name, M.price FROM `osc_shop_delivery_methods` AS M
            WHERE M.block = 0
            LIMIT 30
        ";
        return $this->q($q);
    }

    public function check_user($email){
        $q = "SELECT M.* FROM `osc_users` AS M WHERE M.login = '$email' LIMIT 1";
        return $this->q($q, 1);
    }

    public function getRandPass(){
        // NEW PASSWORD GENERATION
        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $new_pass = "";
        for($i = 0; $i < 10; $i++){
            $module = mt_rand(0, 25);
            $new_pass .= $letters[$module];
        }

        return $new_pass;
    }

    public function getPageByAlias($alias){
        $q = "
            SELECT 
                M.name, 
                M.caption, 
                M.id, 
                M.filename, 
                M.details, 
                M.target, 
                M.gallery_id
            FROM `osc_menu` AS M
            WHERE 
                M.alias = '$alias' AND
                M.block = 0
            ORDER BY M.order_id
            LIMIT 1
        ";
        return $this->q($q, 1);
    }

    public function getGalList($gal_type){
        if ($gal_type == 'photo') {
            $filter = "AND M.gal_type = 'photo' ";
        }elseif($gal_type == 'video'){
            $filter = "AND M.gal_type = 'video' ";
        }elseif($gal_type == 'all'){
            $filter = "";
        }else{
            exit();
        }

        $q = "
            SELECT 
                M.id, 
                M.name, 
                M.caption,
                M.data,
                M.gal_type,
                (
                    SELECT `crop` 
                    FROM `osc_files_ref` 
                    WHERE `ref_table` = 'galleries' AND
                    `ref_id` = M.id
                    ORDER BY `id` 
                    LIMIT 1 
                ) as prev
            FROM `osc_galleries` AS M 
            WHERE 
                M.block = 0 
                ".$filter."
            ORDER BY M.id  
            LIMIT 100
        ";

        
        return $this->q($q);
    }

    public function getGalleryById($id){
        $q = "SELECT M.id, M.gal_type, M.name, M.caption, M.data FROM `osc_galleries` AS M WHERE M.id = '$id' LIMIT 1";
        $gallery = $this->q($q, 1);
        $gal_id = $gallery['id'];
        $gal_type = $gallery['gal_type'];

        if ($gallery && $gal_type == 'photo'){
            $q = "
                SELECT 
                    M.file,
                    M.crop,
                    M.title
                FROM `osc_files_ref` AS M
                WHERE 
                    M.ref_table = 'galleries' AND
                    M.ref_id = '$gal_id'
                ORDER BY M.id
                LIMIT 200
            ";
            $gal_photos = $this->q($q);

            return array('gallery' => $gallery, 'photos' => $gal_photos);
        }elseif($gallery && $gal_type == 'video'){
            return array('gallery' => $gallery, 'photos' => false);
        }else{
            return false;
        }
    }

    public function getBanner($type){
        $q = "
            SELECT M.id, M.name, M.data, M.link, M.target, M.file
            FROM `osc_banners` AS M
            WHERE M.block = 0 AND M.type = '$type'
            ORDER BY M.order_id
            LIMIT 50
        ";
        return $this->q($q);
    }

    public function getShopsInfo(){
        $q = "SELECT M.* FROM `osc_shop_addresses` AS M WHERE M.block = 0 LIMIT 20";
        return $this->q($q);
    }

    public function getFAQ(){
        $q = "SELECT M.question, M.answer FROM `osc_faq` AS M WHERE M.block = 0 ORDER BY M.order_id LIMIT 500";
        return $this->q($q);
    }
}