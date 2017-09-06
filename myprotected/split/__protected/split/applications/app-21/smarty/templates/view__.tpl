<div class="r-z-c-table">
            	<table class="maintable" id="main-table">
                    <div class="head-tr">
                    	<th class="main-t-th check-col" style="line-height:37px; padding-left:4px;">
                        	<input	type="checkbox" 
                            		name="checkerAll" 
                                    class="table-checkbox" 
                                    id="checkAll"
                                    value="null" 
                                    onclick="select_all_checked();">
                             <label	class="tab-check-lab" 
                            		for="checkAll">&nbsp;&nbsp;</label>
                        </th>
                        <th class="main-t-th" style="">Название</th>
                        <th class="main-t-th" style="">Тип</th>
                        <th class="main-t-th" style="">Категория</th>
                        <th class="main-t-th" style="">Состояние</th>
                        <th class="main-t-th" style="">ID</th>
                    </div>
                	<tbody>
                    	<tr class="<?php echo $row['row_class'] ?>" id="<?php echo $row['id'] ?>">
                        <td class="check-col">
                        	<input	type="checkbox" 
                            		name="checker<?php	echo $row['id'] ?>" 
                                    class="table-checkbox" 
                                    id="check<?php 		echo $row['id'] ?>"
                                    value="<?php 		echo $row['id'] ?>">
                            <label	class="tab-check-lab" 
                            		for="check<?php 	echo $row['id'] ?>">&nbsp;&nbsp;</label>
                        </td>
                        <td class="main-t-td-name">
                        	<div><a href="javascript:void(0);" onclick="">Цвет</a></div>
                        </td>
                        <td>Строка</td>
                        <td>Тех. характеристика</td>
                        <td>Опубликован</td>
                        <td>9</td>
                        </tr>
                        <tr class="<?php echo $row['row_class'] ?>" id="<?php echo $row['id'] ?>">
                        <td class="check-col">
                        	<input	type="checkbox" 
                            		name="checker<?php	echo $row['id'] ?>" 
                                    class="table-checkbox" 
                                    id="check<?php 		echo $row['id'] ?>"
                                    value="<?php 		echo $row['id'] ?>">
                            <label	class="tab-check-lab" 
                            		for="check<?php 	echo $row['id'] ?>">&nbsp;&nbsp;</label>
                        </td>
                        <td class="main-t-td-name">
                        	<div><a href="javascript:void(0);" onclick="">Вес</a></div>
                        </td>
                        <td>Строка</td>
                        <td>Тех. характеристика</td>
                        <td>Опубликован</td>
                        <td>8</td>
                        </tr>
                        <tr class="<?php echo $row['row_class'] ?>" id="<?php echo $row['id'] ?>">
                        <td class="check-col">
                        	<input	type="checkbox" 
                            		name="checker<?php	echo $row['id'] ?>" 
                                    class="table-checkbox" 
                                    id="check<?php 		echo $row['id'] ?>"
                                    value="<?php 		echo $row['id'] ?>">
                            <label	class="tab-check-lab" 
                            		for="check<?php 	echo $row['id'] ?>">&nbsp;&nbsp;</label>
                        </td>
                        <td class="main-t-td-name">
                        	<div><a href="javascript:void(0);" onclick="">Производитель</a></div>
                        </td>
                        <td>Строка</td>
                        <td>Тех. характеристика</td>
                        <td>Опубликован</td>
                        <td>5</td>
                        </tr>
                    </tbody>
                </table>