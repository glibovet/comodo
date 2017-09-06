			<div class="r-z-c-filter" id="filtr-wrap">
            	                
            	<div class="r-z-c-f-search top-filtr" id="filtr-1">
                	<form>
                    	<input id="on-materials" class="filtr-form-group" type="text" placeholder="Поиск" value="" name="on-materials" />
                        <div class="styled-select filtr-form-group">
                            <select class="sampling_changed" >
                                <option  selected="selected" data-skip="1">Имя</option>
                                <option value="1">Alias</option>
                                <option value="2">ID</option>
                            </select>
                        </div>
                        <button class="r-z-h-s-create-sm filtr-form-group" type="button">Поиск</button>
                        
                        <button class="r-z-h-s-close-sm filtr-form-group" id="close-filter" type="button" onclick="reset_filter_params();"></button>
                    </form>
                </div><!-- r-z-c-f-search -->
                
                <div class="r-z-c-f-filling top-filtr" id="filtr-2">
                	<form>
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-fil-category">Состояние</label>
                            <br>
                            <div class="styled-select">               	
                                <select class="sampling_changed" id="r-z-c-f-fil-category">
                                    <option selected="selected" data-skip="1">Все</option>
                                    <option value="1">Опубликован</option>
                                    <option value="2">Не опубликован</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div><!-- styled-select -->
                        </div><!-- r-z-c-f-fil-select-item 1-->                 
                    </form>
                </div><!-- r-z-c-f-filling -->
                
                <div class="r-z-c-f-sorting top-filtr" id="filtr-3">
                	<form>
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-by">Сортировать по</label>
                            <br>
                            <div class="styled-select">               	
                                <select class="sampling_changed" id="r-z-c-f-sort-by">
                                    <option selected="selected" data-skip="1">Имени</option>
                                    <option value="1">Alias</option>
                                    <option value="2">Состоянию</option>
                                    <option value="3">Автору</option>
                                    <option value="4">Дате</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 1-->
                        
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-order">Порядок отображения</label>
                            <br>
                            <div class="styled-select">                	
                                <select class="sampling_changed" id="r-z-c-f-sort-order">
                                    <option selected="selected" data-skip="1">По возростанию</option>
                                    <option value="1">По убыванию</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 2-->
                        
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-amount">Выводить по</label>
                            <br>
                            <div class="styled-select">                	
                                <select class="sampling_changed" id="r-z-c-f-sort-amount">
                                    <option selected="selected" data-skip="1">15</option>
                                    <option value="1">30</option>
                                    <option value="2">45</option>
                                    <option value="3">60</option>
                                    <option value="4">75</option>
                                </select><!-- r-z-c-f-fil-category -->
                            </div>
                        </div><!-- r-z-c-f-fil-select-item 3-->
                    </form>
                </div><!-- r-z-c-f-sorting -->
                	
            </div><!-- r-z-c-filter -->
            
            <div class="inajax" id="inajax-1">
            	<center><img alt="Loading..." src="{$data.loadsrc}"></center>
            </div>