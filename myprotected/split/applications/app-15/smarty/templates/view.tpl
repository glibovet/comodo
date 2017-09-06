			<div class="r-z-c-filter" id="filtr-wrap">
            	<form name="wp-filtr-form" action="#" method="POST">
                <input type="hidden" name="filtr_table" value="{$filtr_table}">             
            	<div class="r-z-c-f-search top-filtr" id="filtr-1">
                	
                    	<input id="on-materials" class="filtr-form-group" type="text" placeholder="{$filtr_1.search}" value="" name="filtr_search_key" />
                        <div class="styled-select filtr-form-group">
                            <select class="sampling_changed" name="filtr_search_field" >
                             {section name=sec1 loop=$filtr_1.options}
                             	<option value="{$filtr_1.options[sec1].value}">{$filtr_1.options[sec1].title}</option>
                             {/section}
                            </select>
                        </div>
                        <button class="r-z-h-s-create-sm filtr-form-group" type="button" onclick="filtr_content();">Поиск</button>
                        
                        <button class="r-z-h-s-close-sm filtr-form-group" id="close-filter" type="button" onclick="reset_filter_params();"></button>
                        
                </div><!-- r-z-c-f-search -->
                
                <div class="r-z-c-f-filling top-filtr" id="filtr-2">
                	{section name=sec2 loop=$filtr_2}
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-fil-category">{$filtr_2[sec2].select_title}</label>
                            <br>
                            <div class="styled-select">               	
                                <select class="sampling_changed" id="r-z-c-f-fil-category" name="{$filtr_2[sec2].select_name}" 
                                		onchange="filtr_content($(this).attr('name'),$(this).val());">
                                <option name="{$filtr_2[sec2].select_name}" value="-1" selected="selected" data-skip="1">Все варианты</option>
                                {section name=secS loop=$filtr_2[sec2].options}
                                	<option name="{$filtr_2[sec2].select_name}" value="{$filtr_2[sec2].options[secS].value}">{$filtr_2[sec2].options[secS].title}</option>
                                {/section}
                                </select><!-- r-z-c-f-fil-category -->
                            </div><!-- styled-select -->
                        </div><!-- r-z-c-f-fil-select-item -->
                    {/section}
                </div><!-- r-z-c-f-filling -->
                	
                <div class="r-z-c-f-sorting top-filtr" id="filtr-3">
                
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-by">Сортировать по</label>
                            <br>
                            <div class="styled-select">               	
                                <select class="" id="r-z-c-f-sort-by" name="sort_filtr" onchange="change_sortpage($(this).val());">
                                {section name=sec3 loop=$filtr_3}
                                	<option name="sort_filtr" value="{$filtr_3[sec3].value}">{$filtr_3[sec3].title}</option>
                                {/section}
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 1-->
                        
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-order">Порядок отображения</label>
                            <br>
                            <div class="styled-select">                	
                                <select class="" id="r-z-c-f-sort-order" name="order_filtr" onchange="change_orderpage($(this).val());">
                                    <option name="order_filtr" value="" selected="selected" data-skip="1">По возрастанию</option>
                                    <option name="order_filtr" value="DESC">По убыванию</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 2-->
                        
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-amount">Выводить по</label>
                            <br>
                            <div class="styled-select">                	
                                <select class="" id="r-z-c-f-sort-amount" name="quant_filtr" onchange="change_onpage($(this).val());">
                                    <option name="quant_filtr" value="10" selected="selected" data-skip="1">10</option>
                                    <option name="quant_filtr" value="15">15</option>
                                    <option name="quant_filtr" value="30">30</option>
                                    <option name="quant_filtr" value="45">45</option>
                                    <option name="quant_filtr" value="60">60</option>
                                    <option name="quant_filtr" value="75">75</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 3-->
                </div><!-- r-z-c-f-sorting -->
                
                </form>
            </div><!-- r-z-c-filter -->
            
            <div class="inajax" id="inajax-1">
            	<center><img alt="Loading..." src="{$data.loadsrc}"></center>
            </div>