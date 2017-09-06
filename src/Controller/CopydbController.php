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

class CopydbController extends AppController
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
		
		$helo = "HELO!";
		echo "<pre>"; print_r($helo); echo "</pre>"; exit();
		
	}	
	
	/// COPY SHOP CATAGORY	
	/*public function copycat()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("Y-m-d H:i:s", time());
		
		$oldCats = $conn->query("
						SELECT M.id, M.n_rus, M.title_rus, M.metad_rus, M.h1_rus, M.art_rus, M.img_rus
						FROM com_shop_cat as M
						WHERE M.types_cat='use'
						LIMIT 1000
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($oldCats); echo "</pre>"; exit();
		
				
		
		if ($oldCats){	
			$i = 0;	
			foreach ($oldCats as $cat){
				$i++;
				$insertCats = $conn->query(
				"
				INSERT INTO osc_shop_catalog_new  (
				id, 
				name, 
				ua_name, 
				en_name, 
				alias,
				filename,
				details,
				ua_details,
				en_details,
				meta_title,
				ua_meta_title,
				en_meta_title,
				meta_desc,
				ua_meta_desc,
				en_meta_desc,
				meta_keys,
				ua_meta_keys,
				en_meta_keys,
				dateCreate, 
				dateModify) 
						 VALUES 
											('".$cat['id']."', 
											'".$cat['n_rus']."', 
											'".$cat['n_rus']."', 
											'".$cat['n_rus']."', 
											'cat-".$i."', 
											'".$cat['img_rus']."',
											'".$cat['art_rus']."',
											'".$cat['art_rus']."',
											'".$cat['art_rus']."',
											'".$cat['title_rus']."',
											'".$cat['title_rus']."',
											'".$cat['title_rus']."', 
											'".$cat['metad_rus']."',
											'".$cat['metad_rus']."',
											'".$cat['metad_rus']."', 
											'".$cat['h1_rus']."',
											'".$cat['h1_rus']."',
											'".$cat['h1_rus']."', 											
											'$date', 
											'$date')
				"
				);
				
				$insertCats = $conn->query(
				"
				INSERT INTO osc_shop_cat_chars_group_ref  (
				cat_id, 
				group_id) 
						 VALUES 
											('".$cat['id']."',  
											'1')
				"
				);
			}
			
				
				if ($insertCats){				
					echo "it`s DONE! ))";
				}
		
		}
		
	}*/
	
	
		
	
	/// COPY SHOP CATAGORY	
	/*public function copyprod ()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("Y-m-d H:i:s", time());
		
		$oldProd = $conn->query("
						SELECT M.id, M.kod, M.n_rus, M.d_rus, M.id_cat_use as cat_id, M.id_firm as mf_id, M.id_cat_money as class, M.style_rus as style, M.img_rus as img, M.img1_rus as img1, M.img2_rus as img2, M.img3_rus as img3, M.is_vn as qty, M.status_rus as block, M.price_eur, M.size_rus
						FROM com_shop as M
						WHERE M.id >=30493
						ORDER BY M.id
						LIMIT 1000
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($oldProd); echo "</pre>"; exit();
		
				
		
		if ($oldProd){	
			$i = 0;	
			foreach ($oldProd as $pd){
				$i++;
				$name = str_replace("'","\'",$pd['n_rus']);				
				$data = str_replace("'","\'",$pd['d_rus']);
				$block = 0;
				if ($pd['block']==0){$block = 1;}
				
				$insertProd = $conn->query(
				"
				INSERT INTO osc_shop_products_new  (
				id, 
				name, 
				ua_name, 
				en_name, 
				alias,
				sku,
				eur_price,
				details,
				ua_details,
				en_details,
				cat_id,
				mf_id,
				quant,
				block,
				proportions,				
				dateCreate, 
				dateModify) 
						 VALUES 
											('".$pd['id']."', 
											'".$name."', 
											'".$name."', 
											'".$name."', 
											'product-".$pd['id']."', 
											'".$pd['kod']."', 
											'".$pd['price_eur']."',
											'".$data."',
											'".$data."',
											'".$data."',
											'".$pd['cat_id']."',
											'".$pd['mf_id']."',
											'".$pd['qty']."', 
											'".$block."', 
											'".$pd['size_rus']."', 											
											'$date', 
											'$date')
				"
				);
				
				if ($pd['img']){				
					$insertImg = $conn->query("
					INSERT INTO osc_files_ref  (
					ref_table, 
					ref_id,  
					file,
					crop,
					path) 
							 VALUES 
												('shop_products',
												'".$pd['id']."',
												'".$pd['img']."', 												
												'".$pd['img']."', 
												'webroot/img/split/files/shop/products/')
					");
				}
				
				if ($pd['img1']){				
					$insertImg1 = $conn->query("
					INSERT INTO osc_files_ref  (
					ref_table, 
					ref_id,  
					file,
					crop,
					path) 
							 VALUES 
												('shop_products',
												'".$pd['id']."',
												'".$pd['img1']."', 												
												'".$pd['img1']."', 
												'webroot/img/split/files/shop/products/')
					");
				}
				
				if ($pd['img2']){				
					$insertImg2 = $conn->query("
					INSERT INTO osc_files_ref  (
					ref_table, 
					ref_id,  
					file,
					crop,
					path) 
							 VALUES 
												('shop_products',
												'".$pd['id']."',
												'".$pd['img2']."', 												
												'".$pd['img2']."', 
												'webroot/img/split/files/shop/products/')
					");
				}
				
				if ($pd['img3']){				
					$insertImg3 = $conn->query("
					INSERT INTO osc_files_ref  (
					ref_table, 
					ref_id,  
					file,
					crop,
					path) 
							 VALUES 
												('shop_products',
												'".$pd['id']."',
												'".$pd['img3']."', 												
												'".$pd['img3']."', 
												'webroot/img/split/files/shop/products/')
					");
				}
				
								
				if ($pd['class']){				
					$insertImg = $conn->query("
					INSERT INTO osc_shop_chars_prod_ref  (
					char_id, 
					prod_id,  
					val_id) 
							 VALUES 
												('2',
												'".$pd['id']."',
												'".$pd['class']."')
					");
				}
				
				if ($pd['style']){				
					$insertImg = $conn->query("
					INSERT INTO osc_shop_chars_prod_ref  (
					char_id, 
					prod_id,  
					val_id) 
							 VALUES 
												('1',
												'".$pd['id']."',
												'".$pd['style']."')
					");
				}
				
				
				
			
			if ($insertProd){				
					echo "it`s DONE! ))";
				}
		
		}
		
	}*/
	
	/// COPY CATEGORIES
	public function copycats ()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("Y-m-d H:i:s", time());
		
		$categories = $conn->query("
						SELECT M.id, M.alias,
						(SELECT COUNT(id) FROM osc_shop_products WHERE cat_id = M.id AND block =0) as prods_count
						FROM osc_shop_catalog as M
						WHERE 1
						ORDER BY M.id
						LIMIT 100
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($categories); echo "</pre>"; exit();
		
				
		
		if ($categories){		
			
			foreach ($categories as $cat){
				
				echo "<h5>".$cat['alias']." / ".$cat['prods_count']."</h5>";
				
				$old_urls = "/";
				$new_urls = "/";
				
				$pagesNum = 1;
				$onPage = 0;
				$stepPage = 28;
				
				$pagesQty = ceil( $cat['prods_count']/$stepPage );
				
				for($i = 1; $i <= $pagesQty; $i++)
				{
					$old_urls = "/rus/shop/catu_".$cat['id']."-sp_".$onPage.".html";
					$new_urls = "/ru/catalog/".$cat['alias']."/";				
					//$new_urls = "/ru/catalog/".$cat['alias']."/?page=".$i."";
					
					$onPage+=$stepPage;	
				
					echo "<pre>"; print_r($old_urls." => ".$new_urls); echo "</pre>";
					
					/*$insertCats = $conn->query(
					"
					INSERT INTO osc_redirect  (
					old_urls, 
					new_urls, 
					type ) 
							 VALUES 
												(
												'".$old_urls."',
												'".$new_urls."',
												'catalog')
					"
					);	*/
				}
			
			}
		
		}
		
	}
	
	/// COPY PRODUCTS
	/*public function copyprods()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("Y-m-d H:i:s", time());
		
		$products = $conn->query("
						SELECT M.id, M.alias
						FROM osc_shop_products as M
						WHERE 1
						ORDER BY M.id
						LIMIT 40000
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($products); echo "</pre>"; exit();
		
				
		
		if ($products){				
			
			$old_urls = "/";
			$new_urls = "/";	
			
			foreach ($products as $prod){
				
				echo "<h5>".$prod['alias']." / ".$prod['id']."</h5>";
				
				$old_urls = "/rus/shop/items_".$prod['id']."-mode_full.html";
				$new_urls = "/ru/catalog/product/".$prod['alias']."/";
				
				echo "<pre>"; print_r($old_urls." => ".$new_urls); echo "</pre>";
					
					$insertCats = $conn->query(
					"
					INSERT INTO osc_redirect  (
					old_urls, 
					new_urls, 
					type ) 
							 VALUES 
												(
												'".$old_urls."',
												'".$new_urls."',
												'prods')
					"
					);
			}
			
		}		
	}	*/
	
	/// COPY PRODUCTS
	public function copymfs()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("Y-m-d", time());
		
		$mfList = $conn->query("
						SELECT M.id, M.alias
						FROM osc_shop_mf as M
						WHERE 1
						ORDER BY M.id
						LIMIT 1000
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($mfList); echo "</pre>"; exit();
		
				
		
		if ($mfList){				
			
			$old_urls = "/";
			$new_urls = "/";	
			$i=0;
			
			foreach ($mfList as $mf){
				
				
				echo "<h5>".$mf['alias']." / ".$mf['id']."</h5>";
				
				$old_urls = "/rus/shop/catu_0-catm_0-catt_0-ff_".$mf['id']."-sp_0.html";
				$new_urls = "/ru/fabriki/".$mf['alias']."/";
				
				echo "<pre>"; print_r($old_urls." => ".$new_urls); echo "</pre>";
					
				/*$insertCats = $conn->query(
					"
					INSERT INTO osc_redirect  (
					old_urls, 
					new_urls, 
					type ) 
							 VALUES 
												(
												'".$old_urls."',
												'".$new_urls."',
												'mf')
					"
					);*/
			}
			
		}		
	}	
	
	/// COPY PRODUCTS
	public function sitemapdb()
    {
		
		$conn = ConnectionManager::get('default');
		
		$date 			= date("YYYY-MM-DDThh:mmTZD");
		
		$smList = $conn->query("
						SELECT M.new_urls
						FROM osc_redirect as M
						WHERE 1
						ORDER BY M.id
						LIMIT 50000
					")->fetchAll('assoc');
		//echo "<pre>"; print_r($mfList); echo "</pre>"; exit();
		
				
		
		if ($smList){	
			
			foreach ($smList as $sm){
								
				$sitemap = "

						  <url>
						
							<loc>http://www.comodo.kiev.ua/".$sm['new_urls']."</loc>
						
							<lastmod>".$date."</lastmod>
						
							<priority>1.0</priority>
						
							<changefreq>weekly</changefreq>
						
						  </url>";
				
				echo "<pre>"; print_r($sitemap); echo "</pre>";
					
				
			}
			
		}			
	}	
	
	
	
}
