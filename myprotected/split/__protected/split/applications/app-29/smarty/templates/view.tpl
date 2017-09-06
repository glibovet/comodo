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
                        <th class="main-t-th" style="">Состояние</th>
                        <th class="main-t-th" style="">Товаров в группе</th>
                        <th class="main-t-th" style="">ID</th>
                    </div>
                	<tbody>
                    	<tr class="trcolor" id="">
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
                        	<div><a href="javascript:void(0);" onclick="">Акционные</a></div>
                        </td>
                        <td>Опубликован</td>
                        <td>120</td>
                        <td>9</td>
                        </tr>
                        <tr class="" id="">
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
                        	<div><a href="javascript:void(0);" onclick="">Новинки</a></div>
                        </td>
                        <td>Не опубликован</td>
                        <td>85</td>
                        <td>17</td>
                        </tr>
                    </tbody>
                </table>