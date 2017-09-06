<?php
	/*	MIRACLE WEB TECHNOLOGIES	*/
	/*	***************************	*/
	/*	Author: Sivkovich Maxim		*/
	/*	***************************	*/
	/*	Developed: from 2013		*/
	/*	***************************	*/
	
	// Core system
	
require_once("BasicPrinter.php");
	
class BasicHelp extends BasicPrinter
{
   		public $dbh;
		
		public $table;
		public $id;
		public $item;
		
		public function __construct($dbh)
		{
			$this->dbh = $dbh;
		} 
		
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		// Headers
		
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		
		// Return Landing page header
		
		public function getLandingHeader($params=array())
		{
			$parent		= $params['parent'];
			$alias		= $params['alias'];
			$id			= $params['id'];
			$appTable	= $params['appTable'];
			
			$nonactiveMsg = "Опция не активна, для активации необходимо отметить элементы из списка.";
			
			$result = "
			<div class='head-app' id='head-app-1'>
		
            	<div class='r-z-h-filter'> 
            		<button class='r-z-h-f-search but-sort' id='but-sort-1' type='button' onclick='open_filtr(1);'></button>
            	    <button class='r-z-h-f-filling but-sort' id='but-sort-2' type='button' onclick='open_filtr(2);'></button>
            	    <button class='r-z-h-f-sorting but-sort' id='but-sort-3' type='button' onclick='open_filtr(3);'></button>
            	</div>
            
            	<div class='r-z-h-saving'>
            		
            	    <button class='rzh r-z-h-s-create' alt='r-z-h-s-create' type='button' onclick=\"loadPage('$parent','$alias',$id,0,'cardCreate',{});\" title='Создать'>Создать &nbsp;&nbsp;&nbsp;<span>+</span></button>
            		
            	    <button class='rzh r-z-h-s-delete nonactive first-actives' alt='r-z-h-s-delete' type='button' title='$nonactiveMsg' 
            	    		id='delete-checked-button' onclick=\"show_is_delete_items('$appTable');\"></button>
            	    
            	    <button class='rzh r-z-h-s-close nonactive first-actives' alt='r-z-h-s-close' type='button' title='$nonactiveMsg'
            	    		id='disactivate-checked-button' onclick=\"disactivate_items('$appTable');\"></button>
            	    
            	    <button class='rzh r-z-h-s-save nonactive first-actives' alt='r-z-h-s-save' type='button' title='$nonactiveMsg'
            	    		id='activate-checked-button' onclick=\"activate_items('$appTable');\"></button>
            	    
            	    <button class='rzh r-z-h-s-new nonactive first-actives' alt='r-z-h-s-new' type='button' title='$nonactiveMsg'
            	    		id='copy-checked-button' onclick=\"copy_items('$appTable');\"></button>
            	    
            	</div>	
			</div> 
			";
			
			return $result;
		}
		
		// Return card view header
		
		public function getCardViewHeader($params=array())
		{
			$parent		= $params['parent'];
			$alias		= $params['alias'];
			$id			= $params['id'];
			$item_id	= $params['item_id'];
			$appTable	= $params['appTable'];
			
			$result = "";
			
			$result .= "
			<div class='head-app' id='head-app-1'>
		
            	<div class='r-z-h-filter'> 
            		<div class='r-z-h-return'>
            	    	<a href='javascript:void(0);' onclick=\"loadPage('$parent','$alias',$id,0,'landingPage',{});\">
            	    		<div class='return-header-icon'></div>
            	    	</a>
            		</div>
            	</div>
            
            	<div class='r-z-h-saving'>";
            	
            if(isset($params['type']))
			{
				switch($params['type'])
				{
					case 'shopOrder':
					{
						$result .= "<button class='rzh r-z-h-s-create' type='button' onclick=\"\" title='Отменить заказ'>Отменить заказ &nbsp;&nbsp;&nbsp;<span></span></button>";
						$result .= "<button class='rzh r-z-h-s-create' type='button' onclick=\"loadPage('$parent','$alias',$id,$item_id,'cardEdit',{});\" title='Редактировать'>Редактировать &nbsp;&nbsp;&nbsp;<span></span></button>";
						$result .= "<button class='rzh r-z-h-s-create' type='button' onclick=\"\" title='Подтвердить заказ'>Подтвердить заказ &nbsp;&nbsp;&nbsp;<span></span></button>";
						break;
					}
					default: break;
				}
			}else
			{
				$result .= "<button class='rzh r-z-h-s-create' type='button' onclick=\"loadPage('$parent','$alias',$id,$item_id,'cardEdit',{});\" title='Редактировать'>Редактировать &nbsp;&nbsp;&nbsp;<span></span></button>";
			}
            
			$result .= 	
				"</div>
				
			</div>
			";
			
			return $result;
		}
		
		// Return card edit header
		
		public function getCardEditHeader($params=array())
		{
			$parent		= $params['parent'];
			$alias		= $params['alias'];
			$id			= $params['id'];
			$item_id	= $params['item_id'];
			$appTable	= $params['appTable'];
			
			$result = "";
			
			$result .= "
				<div class='head-app' id='head-app-1'>
			
        	    	<div class='r-z-h-filter'> 
        	    		<div class='r-z-h-return'>
        	    	    	<a href='javascript:void(0);' onclick=\"loadPage('$parent','$alias',$id,$item_id,'cardView',{});\">
        	    	    		<div class='return-header-icon'></div>
        	    	    	</a>
        	    		</div>
        	    	</div>
        	    
        	    	<div class='r-z-h-saving'>
        	    		
        	    	    <button class='rzh r-z-h-s-create' type='button' onclick=\"submit_save_form(1);\" title='Сохранить и перейти к просмотру'>Сохранить &nbsp;&nbsp;&nbsp;<span></span></button>
						
						<button class='rzh r-z-h-s-close' type=\"button\" title='Сохранить и вернуться к списку' onclick=\"submit_save_form(2);\"></button>
        	    		<button class='rzh r-z-h-s-save' type='button' title='Сохранить и редактировать' onclick=\"submit_save_form(3);\"></button>
        	    		<button class='rzh r-z-h-s-new' type='button' title='Сохранить и скопировать для создания' onclick=\"submit_save_form(4);\"></button>
            	
					</div>
				
				</div>
			";
			
			return $result;
		}
		
		// Return card create header
		
		public function getCardCreateHeader($params=array())
		{
			$parent		= $params['parent'];
			$alias		= $params['alias'];
			$id			= $params['id'];
			$item_id	= $params['item_id'];
			$appTable	= $params['appTable'];
			
			$result = "";
			
			$result .= "
				<div class='head-app' id='head-app-1'>
		
            		<div class='r-z-h-filter'> 
            			<div class='r-z-h-return'>
                			<a href='javascript:void(0);' onclick=\"loadPage('$parent','$alias',$id,0,'landingPage',{});\">
                				<div class='return-header-icon'></div>
                			</a>
            			</div>
            		</div>
            
            		<div class='r-z-h-saving'>
            	
						<button class='rzh r-z-h-s-create' type='button' onclick=\"submit_create_form(1);\" title='Создать и очистить форму'>Создать &nbsp;&nbsp;&nbsp;<span></span></button>
            			
                		<button class='rzh r-z-h-s-close' type=\"button\" title='Создать и вернуться к списку' onclick=\"submit_create_form(2);\"></button>
            			<button class='rzh r-z-h-s-save' type='button' title='Создать и редактировать' onclick=\"submit_create_form(3);\"></button>
            			<button class='rzh r-z-h-s-new' type='button' title='Создать и перейти к просмотру' onclick=\"submit_create_form(4);\"></button>
				
					</div>
				</div>
			";
			
			return $result;
		}
		
		
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		// Content
		
		/////////////////////////////////////////////////////////////////////////////////////////////
		
		// Return filter form for Landing page
		
		public function getLandingFilterForm($params=array())
		{
			$result = "";
			
			$result .= "
				<div class='r-z-c-filter' id='filtr-wrap'>
            		<form name='wp-filtr-form' id='wp-filtr-form' action='#' method='POST'>
				
					<input type='hidden' name='start' value='1'>
				
            		<div class='r-z-c-f-search top-filtr' id='filtr-1'>
                	
                    	<input id='on-materials' class='filtr-form-group' type='text' placeholder='Search key' name='filtr_search_key' 
								value='".( (isset($params['params']['filtr']['filtr_search_key']) && trim($params['params']['filtr']['filtr_search_key']) != "") ? $params['params']['filtr']['filtr_search_key'] : "" )."' />
                        <div class='styled-select filtr-form-group'>
                            <select class='sampling_changed' name='filtr_search_field' >";
                        foreach($params['filter1_options'] as $header => $value)
						{
							$curr_selected = ( (isset($params['params']['filtr']['filtr_search_field']) && $params['params']['filtr']['filtr_search_field']==$value) ? "selected" : "");
							$result .= "<option $curr_selected value='$value'>$header</option>";
						}
						
			$result .= "
							</select>
                        </div>
                        <button class='r-z-h-s-create-sm filtr-form-group' type='button' onclick=\" 
										loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\">Поиск</button>
                        
                        <button class='r-z-h-s-close-sm filtr-form-group' id='close-filter' type='button' onclick='reset_filter_params();'></button>
                        
                </div><!-- r-z-c-f-search -->
                
                <div class='r-z-c-f-filling top-filtr' id='filtr-2'>";
                	foreach($params['filter2_options'] as $header => $field)
					{
						$result .= "
						<div class='r-z-c-f-fil-select-item'>
                        	<label for='r-z-c-f-fil-category'>$header</label>
                            <br>
                            <div class='styled-select'>               	
                                <select class='sampling_changed' id='r-z-c-f-fil-category' name='massive[".$field['fieldName']."]' onchange=\" 
										loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\">
                                	<option ".( (isset($params['params']['filtr']['massive'][$field['fieldName']]) && $params['params']['filtr']['massive'][$field['fieldName']]==(-1)) ? "selected" : "")." value='-1' data-skip='1'>Все варианты</option>
						";
						foreach($field['params'] as $paramHeader => $value)
						{
							$curr_selected = ( (isset($params['params']['filtr']['massive'][$field['fieldName']]) && $params['params']['filtr']['massive'][$field['fieldName']]==$value) ? "selected" : "");
							$result .= "<option $curr_selected value='$value'>$paramHeader</option>";
						}
						$result .= "
								</select>
                            </div><!-- styled-select -->
                        </div><!-- r-z-c-f-fil-select-item -->
						";
					}
                                
					
                $result .= " 
				
				</div><!-- r-z-c-f-filling -->
                	
                <div class='r-z-c-f-sorting top-filtr' id='filtr-3'>
                
                        <div class='r-z-c-f-fil-select-item'>
                        	<label for='r-z-c-f-sort-by'>Сортировать по</label>
                            <br>
                            <div class='styled-select'>               	
                                <select id='r-z-c-f-sort-by' name='sort_filtr' onchange=\" 
										loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\">";
                        foreach($params['filter3_options']['sort'] as $header => $value)
						{
							$curr_selected = ( (isset($params['params']['filtr']['sort_filtr']) && $params['params']['filtr']['sort_filtr']==$value) ? "selected" : "");
							$result .= "<option $curr_selected name='sort_filtr' value='$value'>$header</option>";
						}
								
                            $result .= "  
								</select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 1-->
                        
                        <div class='r-z-c-f-fil-select-item'>
                        	<label for='r-z-c-f-sort-order'>Порядок отображения</label>
                            <br>
                            <div class='styled-select'>                	
                                <select id='r-z-c-f-sort-order' name='order_filtr' onchange=\" 
										loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\">";
                        foreach($params['filter3_options']['order'] as $header => $value)
						{
							$curr_selected = ( (isset($params['params']['filtr']['order_filtr']) && $params['params']['filtr']['order_filtr']==$value) ? "selected" : "");
							$result .= "<option $curr_selected value='$value'>$header</option>";
						}
                            $result .= "    
								</select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 2-->
                        
                        <div class='r-z-c-f-fil-select-item'>
                        	<label for='r-z-c-f-sort-amount'>Выводить по</label>
                            <br>
                            <div class='styled-select'>                	
                                <select id='r-z-c-f-sort-amount' name='quant_filtr' onchange=\"$.cookie('global_on_page',$(this).val()); 
										loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\">
                                    <option ".($params['on_page'] == 10 ? "selected" : "")." data-skip='1' value='10'>10</option>
									<option ".($params['on_page'] == 15 ? "selected" : "")." data-skip='1' value='15'>15</option>
									<option ".($params['on_page'] == 30 ? "selected" : "")." data-skip='1' value='30'>30</option>
									<option ".($params['on_page'] == 45 ? "selected" : "")." data-skip='1' value='45'>45</option>
									<option ".($params['on_page'] == 60 ? "selected" : "")." data-skip='1' value='60'>60</option>
									<option ".($params['on_page'] == 75 ? "selected" : "")." data-skip='1' value='75'>75</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 3-->
                </div><!-- r-z-c-f-sorting -->
                
                </form>
            </div><!-- r-z-c-filter -->
			";
			
			return $result;
		}
		
		// Return Items Table for Landing page
		
		public function getItemsTable($params=array())
		{
			$result = "";
			
			$result .=  "
						<div class='r-z-c-table'>
            				<table class='maintable' id='main-table'>
                    			<div class='head-tr'>
						";
            foreach($params['tableColumns'] as $columnHeader => $columnParams)
			{
				switch($columnParams['type'])
				{
					case 'checkbox':
					{
						$result .= "
						<th class='main-t-th check-col' style='line-height:37px; padding-left:4px;'>
                        	<input	type='checkbox' 
                            		name='checkerAll' 
                                    class='table-checkbox' 
                                    id='checkAll'
                                    value='null' 
                                    onclick='select_all_checked();'>
                             <label	class='tab-check-lab' 
                            		for='checkAll'>&nbsp;&nbsp;</label>
                        </th>
						";
						break;
					}
					default:
					{
						$result .= "<th class='main-t-th'>$columnHeader</th>";
					} break;
				}
			}        	
			
			$result .= "
						</div>
                	<tbody>
					";	
					
			$icnt = 0;
			
			foreach($params['itemsList'] as $item)
			{
				$icnt++;
				$iid = $item['id'];
				$iclass = ($icnt%2==1 ? "trcolor" : "");
		
				$result .= "
						<tr class='$iclass' id='$iid'>
						";
				foreach($params['tableColumns'] as $columnHeader => $columnParams)
				{
					switch($columnParams['type'])
					{
						case 'checkbox':
						{
							$result .= "
										<td class='check-col'>
                    	    				<input	type='checkbox' 
                    	    	    			name='checker$iid' 
                    	    	        	    class='table-checkbox' 
                    	    	        	    id='check$iid'
                    	    	        	    value='$iid'
                    	    	        	    onchange=\"scan_active_checked();\">
                    	    	    		<label	class='tab-check-lab' 
                    	    	    			for='check$iid'>&nbsp;&nbsp;</label>
                    	    			</td>
									   ";
							break;
						}
						case 'block':
						{
							$result .= "<td class='publication'>
											<div class='".(!$item[$columnParams['field']] ? "published" : "not-published")."'></div>
                            				<span>".(!$item[$columnParams['field']] ? "Yes" : "No")."</span>
										</td>";
							break;
						}
						case 'cardView':
						{
							$result .= "<td class='main-t-td-name'>
											<a	href='javascript:void(0);' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",$iid,'cardView',{});\">".$columnParams['field']."</a>
                            			</td>";
							break;
						}
						case 'cardEdit':
						{
							$result .= "<td class='main-t-td-name'>
											<a	href='javascript:void(0);' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",$iid,'cardEdit',{});\">".$columnParams['field']."</a>
                            			</td>";
							break;
						}
						case 'parent':
						{
							$result .= "<td>".($item[$columnParams['field']] ? $item[$columnParams['field']] : "Node")."</td>";
							break;
						}
						case 'date':
						{
							$result .= "<td>".date($columnParams['params']['format'],strtotime($item[$columnParams['field']]))."</td>";
						}
						default:
						{
							if(isset($columnParams['params']))
							{
								if(isset($columnParams['params']['secondField']))
								{
									$result .= "<td>".$item[$columnParams['field']].$columnParams['params']['separate'].$item[$columnParams['params']['secondField']]."</td>";
								}
								if(isset($columnParams['params']['math']))
								{
									$math_val = $columnParams['params']['value'];
									$math_res = 0;
									
									switch($columnParams['params']['math'])
									{
										case '+':{ $math_res = $item[$columnParams['field']] + $math_val; break; }
										
										case '-':{ $math_res = $item[$columnParams['field']] - $math_val; break; }
										
										case '*':{ $math_res = $item[$columnParams['field']] * $math_val; break; }
										
										case '/':{ $math_res = $item[$columnParams['field']] / $math_val; break; }
										
										default: break;
									}
									
									$result .= "<td>".$math_res."</td>";
								}
							}else
							{
								$result .= "<td>".$item[$columnParams['field']]."</td>";
							}
							break;
						}
					}
				}
								
                $result .= "</tr>";
			}
	

			$result .= "
						</tbody>
                	</table>
            	</div>
				";
				
			return $result;			
		}
		
		// Return pagination for Landing page
		
		public function getLandingPagination($params=array())
		{
			$result = "";
			
			$countRelatedPages = 4;
			
			$result .= "
			<div class='manage-pages'>
				<div class='page-navigation'>
                	";
                    if($params['start_page'] > 2)
					{
						$result .= "
						<button id='leap-back' class='page-nav-step' type='button' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\"> << </button>
                    	<button id='step-back' class='page-nav-step' type='button' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'".($params['start_page']-1)."',filtr:$('#wp-filtr-form').serialize()});\"> < </button>
						";
					}
					
					$result .= "<ul id='page-nav-left-items' class='page-nav-items'>";
					
					for($i=1; $i<=$params['pages']; $i++)
					{
						if($i < $params['start_page']-$countRelatedPages) continue;
						if($i > $params['start_page']+$countRelatedPages) break;
		
						$result .= "<li class='".($params['start_page']==$i ? "active" : "")."' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'".$i."',filtr:$('#wp-filtr-form').serialize()});\"><a href='javascript:void(0);'>$i</a></li>";
					}
					
					$result .= "</ul>"; // closeNavItems
					
                    if($params['start_page'] < $params['pages']-1)
					{
						$result .= "
						<button id='step-forward' class='page-nav-step' type='button' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'".($params['start_page']+1)."',filtr:$('#wp-filtr-form').serialize()});\"> > </button>
                    	<button id='leap-forward' class='page-nav-step' type='button' onclick=\"loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'".$params['pages']."',filtr:$('#wp-filtr-form').serialize()});\"> >> </button>
						";
					}
					
					
					$result .= "</div>"; // closePageNavigation
					
					$result .= "<div class='number-of-items'>"; // openNumberOfItems
					
					$result .= "
					<label for='numb-of-items'>Элементов на странице:</label>
                    <div class='styled-select styled-select-sm'>
                        <select id='numb-of-items' onchange=\"$.cookie('global_on_page',$(this).val()); 
								loadPage('".$params['headParams']['parent']."','".$params['headParams']['alias']."',".$params['headParams']['id'].",0,'landingPage',{start:'1',filtr:$('#wp-filtr-form').serialize()});\">
                            <option ".($params['on_page'] == 10 ? "selected" : "")." data-skip='1' value='10'>10</option>
							<option ".($params['on_page'] == 15 ? "selected" : "")." data-skip='1' value='15'>15</option>
							<option ".($params['on_page'] == 30 ? "selected" : "")." data-skip='1' value='30'>30</option>
							<option ".($params['on_page'] == 45 ? "selected" : "")." data-skip='1' value='45'>45</option>
							<option ".($params['on_page'] == 60 ? "selected" : "")." data-skip='1' value='60'>60</option>
							<option ".($params['on_page'] == 75 ? "selected" : "")." data-skip='1' value='75'>75</option>
                        </select>
                    </div>";
			
			$result .= "</div>"; // closeNumberOfItems
					
			$result .= "</div>"; // closeManagePages
			
			return $result;
		}
		
		// Return info table for Card View Page
		
		public function getCardViewTable($params=array())
		{
			$result = "";
			
			$result .= "
				<table class='cardViewTable'>
				";
	
			$rowCnt = 0;
			foreach($params['cardTmp'] as $header => $tmp)
			{
				$rowCnt++;
				$trClass = ($rowCnt%2==1 ? "trcolor" : "");
		
				$result .= " 
					<tr class='$trClass'>
						<td class='fieldName'>$header</td>
					";
		
				switch($tmp['type'])
				{
					case 'image':
					{
						$filePath = $tmp['params']['path'].$params['cardItem'][$tmp['field']];

						$result .= "<td>".( (file_exists($params['rootPath'].$filePath) && trim($params['cardItem'][$tmp['field']]) != "" ) ? "
							<a class='theater' href='".$filePath."' title='Modal view' rel='group'>
								<img class='previewImage' alt='Image not found.' src='".$filePath."' />
							</a>
							" : "No image")."</td>";
						break;
					}
					case 'images':
					{
						$result .= "<td>";
						
						foreach($params['cardItem'][$tmp['field']] as $currImg)
						{
							$filePath = $tmp['params']['path'].$currImg[$tmp['params']['field']];
							
							$result .= ( (file_exists($params['rootPath'].$filePath) && trim($currImg[$tmp['params']['field']]) != "" ) ? "
							<a class='theater' href='".$filePath."' title='Modal view' rel='group'>
								<img class='previewImage' alt='Image not found.' src='".$filePath."' />
							</a>
							" : "<span>No image :".$currImg[$tmp['params']['field']])."</span>";
						}
						
						$result .= "</td>";

						break;
					}
					case 'date':
					{
						$result .= "<td>".date( "H:i m-d-Y", strtotime($params['cardItem'][$tmp['field']]) )."</td>";
						break;
					}
					case 'arr_mono':
					{
						if(!$params['cardItem'][$tmp['field']])
						{
							$result .= "<td>-</td>";
							break;
						}
						if(isset($tmp['params']['link']))
						{
							$lp = $tmp['params']['link'];
					
							$result .= "<td class='main-t-td-name'>&rsaquo; <a href='javascript:void(0);' onclick=\"loadPage('".$lp['parent']."','".$lp['alias']."',".$lp['id'].",".$params['cardItem'][$tmp['field']]['id'].",'cardView',{})\">";
							$result .= $params['cardItem'][$tmp['field']][$tmp['params']['field']];
							$result .= "</a></td>";
						}else
						{
							if(isset($tmp['params']['fields']))
							{
								$result .= "<td>";
								foreach($tmp['params']['fields'] as $fieldName)
								{
									$result .= $params['cardItem'][$tmp['field']][$fieldName]." / ";
								}
								$result .= "</td>";
							}else
							{
								$result .= "<td>".$params['cardItem'][$tmp['field']][$tmp['params']['field']]."</td>";
							}
						}
						break;
					}
					case 'arr_mult':
					{
						if(!$params['cardItem'][$tmp['field']])
						{
							$result .= "<td>-</td>";
							break;
						}
						$result .= "<td class='main-t-td-name'><ul>";
						foreach($params['cardItem'][$tmp['field']] as $child)
						{
							if(isset($tmp['params']['link']))
							{
								$lp = $tmp['params']['link'];
						
								$result .= "<li>&rsaquo; <a href='javascript:void(0);' onclick=\"loadPage('".$lp['parent']."','".$lp['alias']."',".$lp['id'].",".$child['id'].",'cardView',{})\">";
								$result .= $child[$tmp['params']['field']];
								$result .= "</a></li>";
							}else
							{
								if(isset($tmp['params']['type']))
								{
									switch($tmp['params']['type'])
									{
										case 'chars':
										{
											$pf = $tmp['params']['fields'];
											
												$result .= "<li>&rsaquo; ";
												$result .= $child[$pf['header']].": ".$child[$pf['val']]." <i>".$child[$pf['m']]."</i> ";
												$result .= "</li>";
											
											break;
										}
										default: break;
									}
								}else
								{
									$result .= "<li>&rsaquo; ".$child[$tmp['params']['field']]."</li>";
								}
							}	
						}
						$result .= "</ul></td>";
						break;
					}
					default:
					{
						if(isset($tmp['params']['replace']))
						{
							$result .= "<td>".$tmp['params']['replace'][$params['cardItem'][$tmp['field']]]."</td>";
						}else
						{
							$result .= "<td>".$params['cardItem'][$tmp['field']]."</td>";
						}
						break;
					}
				}
		
				$result .= "	
						</tr>
		 				";
			}
				
			$result .= "
				</table>
				";
			
			return $result;
		}
		
		// Return form for Card Edit and Create Page
		
		public function getCardEditForm($params=array())
		{
			$item = $params['cardItem'];
			
			$item_id = $item['id'];
			
			$appTable = $params['appTable'];
			
			$actionName = $params['actionName'];
			
			$ajaxFolder = $params['ajaxFolder'];
			
			$result = "";
			
			$result .= "
				<form class='cardEditForm' name='cardEditForm' action='split/ajax/".$ajaxFolder."/".$ajaxFolder."Heandler.php' method='POST' enctype='multipart/form-data' target='_blank'>
				
				<input type='hidden' name='action' value='$actionName'>
				
				<input type='hidden' name='appTable' value='$appTable'>
				
				<input type='hidden' name='item_id' value='$item_id'>
				
				<input type='hidden' name='choice' value='1' id='formSaveChoice'>
				
				";
				
			foreach($params['cardTmp'] as $fieldHeader => $tmp)
			{
				switch($tmp['type'])
				{
					case 'clear':
					{
						$result .= $this->clear();
						break;
					}
					case 'header':
					{
						$result .= $this->hr($fieldHeader);
						break;
					}
					case 'hidden':
					{
						$value = (isset($tmp['params']['arr_field']) ? $item[$tmp['params']['field']][$tmp['params']['arr_field']] : $item[$tmp['params']['field']]);
						$result .= $this->print_hidden($tmp['field'], $value);
						break;
					}
					case 'input':
					{
						$result .= $this->print_input($fieldHeader, $tmp['field'], $tmp['params']['hold'], $item[$tmp['field']], $tmp['params']['size'], $tmp['params']['onchange']);
						break;
					}
					case 'autocomplete':
					{
						$result .= $this->print_autocomplete($fieldHeader, $tmp['field'], $tmp['params']['hold'], $item[$tmp['field']], $tmp['params']['size'], $tmp['params']['value']);
						break;
					}
					case 'number':
					{
						$result .= $this->print_input($fieldHeader, $tmp['field'], $tmp['params']['hold'], $item[$tmp['field']], $tmp['params']['size'], $tmp['params']['onchange'],"number");
						break;
					}
					case 'area':
					{
						$result .= $this->print_area($fieldHeader, $tmp['field'], $tmp['params']['hold'], $item[$tmp['field']] );
						break;
					}
					case 'block':
					{
						$result .= $this->print_rotator($fieldHeader, $tmp['field'], $item[$tmp['field']],$tmp['params']['reverse']);
						break;
					}
					case 'select':
					{
						$currValue = $tmp['params']['currValue'];
						
						$typeValue = (isset($tmp['params']['type']) ? $tmp['params']['type'] : false);
						
						$result .= $this->print_select($fieldHeader, $currValue, $tmp['params']['list'], $tmp['params']['fieldValue'], $tmp['params']['fieldTitle'], $tmp['field'], $tmp['params']['onChange'], $tmp['params']['first'],$typeValue); 
						break;
					}
					case 'multiselect':
					{
						$currValue = $tmp['params']['currValue'];
						
						$typeValue = (isset($tmp['params']['type']) ? $tmp['params']['type'] : false);
						
						$result .= $this->print_multiselect($fieldHeader, $currValue, $tmp['params']['list'], $tmp['params']['fieldValue'], $tmp['params']['fieldTitle'], $tmp['field'], $tmp['params']['onChange'], $tmp['params']['first'],$typeValue); 
						break;
					}
					case 'redactor':
					{
						$result .= $this->print_redactor($fieldHeader, $tmp['field'], $item[$tmp['field']]);
						break;
					}
					case 'date':
					{
						$result .= $this->print_date($fieldHeader, $tmp['field'], $item[$tmp['field']]);
						break;
					}
					case 'image_mono':
					{
						$result .= $this->print_image_mono($fieldHeader, $tmp['field'], $item[$tmp['field']], $tmp['params']['path'], $tmp['params']['appTable'], $tmp['params']['id']);
						break;
					}
					case 'image_mult':
					{
						$result .= $this->print_image_mult($fieldHeader, $tmp['field'], $item[$tmp['field']], $tmp['params']['path'], $tmp['params']['appTable'], $tmp['params']['id'], $tmp['params']['field']);
						break;
					}
					case 'shopProductChars':
					{
						$result .= $this->print_shopProductChars($fieldHeader,$tmp['field'],$tmp['params']['chars']);
						break;
					}
					default: break;
				}
			}
				
			$result .= "
				</form>
				";
			
			return $result;
		}
		
		public function __destruct(){}
}