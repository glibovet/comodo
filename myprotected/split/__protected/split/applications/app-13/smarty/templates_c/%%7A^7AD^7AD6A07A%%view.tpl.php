<?php /* Smarty version 2.6.27, created on 2014-01-09 15:03:10
         compiled from view.tpl */ ?>
			<div class="r-z-c-filter" id="filtr-wrap">
            	<form name="wp-filtr-form" action="#" method="POST">
                <input type="hidden" name="filtr_table" value="<?php echo $this->_tpl_vars['filtr_table']; ?>
">             
            	<div class="r-z-c-f-search top-filtr" id="filtr-1">
                	
                    	<input id="on-materials" class="filtr-form-group" type="text" placeholder="<?php echo $this->_tpl_vars['filtr_1']['search']; ?>
" value="" name="filtr_search_key" />
                        <div class="styled-select filtr-form-group">
                            <select class="sampling_changed" name="filtr_search_field" >
                             <?php unset($this->_sections['sec1']);
$this->_sections['sec1']['name'] = 'sec1';
$this->_sections['sec1']['loop'] = is_array($_loop=$this->_tpl_vars['filtr_1']['options']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec1']['show'] = true;
$this->_sections['sec1']['max'] = $this->_sections['sec1']['loop'];
$this->_sections['sec1']['step'] = 1;
$this->_sections['sec1']['start'] = $this->_sections['sec1']['step'] > 0 ? 0 : $this->_sections['sec1']['loop']-1;
if ($this->_sections['sec1']['show']) {
    $this->_sections['sec1']['total'] = $this->_sections['sec1']['loop'];
    if ($this->_sections['sec1']['total'] == 0)
        $this->_sections['sec1']['show'] = false;
} else
    $this->_sections['sec1']['total'] = 0;
if ($this->_sections['sec1']['show']):

            for ($this->_sections['sec1']['index'] = $this->_sections['sec1']['start'], $this->_sections['sec1']['iteration'] = 1;
                 $this->_sections['sec1']['iteration'] <= $this->_sections['sec1']['total'];
                 $this->_sections['sec1']['index'] += $this->_sections['sec1']['step'], $this->_sections['sec1']['iteration']++):
$this->_sections['sec1']['rownum'] = $this->_sections['sec1']['iteration'];
$this->_sections['sec1']['index_prev'] = $this->_sections['sec1']['index'] - $this->_sections['sec1']['step'];
$this->_sections['sec1']['index_next'] = $this->_sections['sec1']['index'] + $this->_sections['sec1']['step'];
$this->_sections['sec1']['first']      = ($this->_sections['sec1']['iteration'] == 1);
$this->_sections['sec1']['last']       = ($this->_sections['sec1']['iteration'] == $this->_sections['sec1']['total']);
?>
                             	<option value="<?php echo $this->_tpl_vars['filtr_1']['options'][$this->_sections['sec1']['index']]['value']; ?>
"><?php echo $this->_tpl_vars['filtr_1']['options'][$this->_sections['sec1']['index']]['title']; ?>
</option>
                             <?php endfor; endif; ?>
                            </select>
                        </div>
                        <button class="r-z-h-s-create-sm filtr-form-group" type="button" onclick="filtr_content();">Поиск</button>
                        
                        <button class="r-z-h-s-close-sm filtr-form-group" id="close-filter" type="button" onclick="reset_filter_params();"></button>
                        
                </div><!-- r-z-c-f-search -->
                
                <div class="r-z-c-f-filling top-filtr" id="filtr-2">
                	<?php unset($this->_sections['sec2']);
$this->_sections['sec2']['name'] = 'sec2';
$this->_sections['sec2']['loop'] = is_array($_loop=$this->_tpl_vars['filtr_2']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec2']['show'] = true;
$this->_sections['sec2']['max'] = $this->_sections['sec2']['loop'];
$this->_sections['sec2']['step'] = 1;
$this->_sections['sec2']['start'] = $this->_sections['sec2']['step'] > 0 ? 0 : $this->_sections['sec2']['loop']-1;
if ($this->_sections['sec2']['show']) {
    $this->_sections['sec2']['total'] = $this->_sections['sec2']['loop'];
    if ($this->_sections['sec2']['total'] == 0)
        $this->_sections['sec2']['show'] = false;
} else
    $this->_sections['sec2']['total'] = 0;
if ($this->_sections['sec2']['show']):

            for ($this->_sections['sec2']['index'] = $this->_sections['sec2']['start'], $this->_sections['sec2']['iteration'] = 1;
                 $this->_sections['sec2']['iteration'] <= $this->_sections['sec2']['total'];
                 $this->_sections['sec2']['index'] += $this->_sections['sec2']['step'], $this->_sections['sec2']['iteration']++):
$this->_sections['sec2']['rownum'] = $this->_sections['sec2']['iteration'];
$this->_sections['sec2']['index_prev'] = $this->_sections['sec2']['index'] - $this->_sections['sec2']['step'];
$this->_sections['sec2']['index_next'] = $this->_sections['sec2']['index'] + $this->_sections['sec2']['step'];
$this->_sections['sec2']['first']      = ($this->_sections['sec2']['iteration'] == 1);
$this->_sections['sec2']['last']       = ($this->_sections['sec2']['iteration'] == $this->_sections['sec2']['total']);
?>
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-fil-category"><?php echo $this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['select_title']; ?>
</label>
                            <br>
                            <div class="styled-select">               	
                                <select class="sampling_changed" id="r-z-c-f-fil-category" name="<?php echo $this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['select_name']; ?>
" 
                                		onchange="filtr_content($(this).attr('name'),$(this).val());">
                                <option name="<?php echo $this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['select_name']; ?>
" value="-1" selected="selected" data-skip="1">Все варианты</option>
                                <?php unset($this->_sections['secS']);
$this->_sections['secS']['name'] = 'secS';
$this->_sections['secS']['loop'] = is_array($_loop=$this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['options']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['secS']['show'] = true;
$this->_sections['secS']['max'] = $this->_sections['secS']['loop'];
$this->_sections['secS']['step'] = 1;
$this->_sections['secS']['start'] = $this->_sections['secS']['step'] > 0 ? 0 : $this->_sections['secS']['loop']-1;
if ($this->_sections['secS']['show']) {
    $this->_sections['secS']['total'] = $this->_sections['secS']['loop'];
    if ($this->_sections['secS']['total'] == 0)
        $this->_sections['secS']['show'] = false;
} else
    $this->_sections['secS']['total'] = 0;
if ($this->_sections['secS']['show']):

            for ($this->_sections['secS']['index'] = $this->_sections['secS']['start'], $this->_sections['secS']['iteration'] = 1;
                 $this->_sections['secS']['iteration'] <= $this->_sections['secS']['total'];
                 $this->_sections['secS']['index'] += $this->_sections['secS']['step'], $this->_sections['secS']['iteration']++):
$this->_sections['secS']['rownum'] = $this->_sections['secS']['iteration'];
$this->_sections['secS']['index_prev'] = $this->_sections['secS']['index'] - $this->_sections['secS']['step'];
$this->_sections['secS']['index_next'] = $this->_sections['secS']['index'] + $this->_sections['secS']['step'];
$this->_sections['secS']['first']      = ($this->_sections['secS']['iteration'] == 1);
$this->_sections['secS']['last']       = ($this->_sections['secS']['iteration'] == $this->_sections['secS']['total']);
?>
                                	<option name="<?php echo $this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['select_name']; ?>
" value="<?php echo $this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['options'][$this->_sections['secS']['index']]['value']; ?>
"><?php echo $this->_tpl_vars['filtr_2'][$this->_sections['sec2']['index']]['options'][$this->_sections['secS']['index']]['title']; ?>
</option>
                                <?php endfor; endif; ?>
                                </select><!-- r-z-c-f-fil-category -->
                            </div><!-- styled-select -->
                        </div><!-- r-z-c-f-fil-select-item -->
                    <?php endfor; endif; ?>
                </div><!-- r-z-c-f-filling -->
                	
                <div class="r-z-c-f-sorting top-filtr" id="filtr-3">
                
                        <div class="r-z-c-f-fil-select-item">
                        	<label for="r-z-c-f-sort-by">Сортировать по</label>
                            <br>
                            <div class="styled-select">               	
                                <select class="" id="r-z-c-f-sort-by" name="sort_filtr" onchange="change_sortpage($(this).val());">
                                <?php unset($this->_sections['sec3']);
$this->_sections['sec3']['name'] = 'sec3';
$this->_sections['sec3']['loop'] = is_array($_loop=$this->_tpl_vars['filtr_3']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec3']['show'] = true;
$this->_sections['sec3']['max'] = $this->_sections['sec3']['loop'];
$this->_sections['sec3']['step'] = 1;
$this->_sections['sec3']['start'] = $this->_sections['sec3']['step'] > 0 ? 0 : $this->_sections['sec3']['loop']-1;
if ($this->_sections['sec3']['show']) {
    $this->_sections['sec3']['total'] = $this->_sections['sec3']['loop'];
    if ($this->_sections['sec3']['total'] == 0)
        $this->_sections['sec3']['show'] = false;
} else
    $this->_sections['sec3']['total'] = 0;
if ($this->_sections['sec3']['show']):

            for ($this->_sections['sec3']['index'] = $this->_sections['sec3']['start'], $this->_sections['sec3']['iteration'] = 1;
                 $this->_sections['sec3']['iteration'] <= $this->_sections['sec3']['total'];
                 $this->_sections['sec3']['index'] += $this->_sections['sec3']['step'], $this->_sections['sec3']['iteration']++):
$this->_sections['sec3']['rownum'] = $this->_sections['sec3']['iteration'];
$this->_sections['sec3']['index_prev'] = $this->_sections['sec3']['index'] - $this->_sections['sec3']['step'];
$this->_sections['sec3']['index_next'] = $this->_sections['sec3']['index'] + $this->_sections['sec3']['step'];
$this->_sections['sec3']['first']      = ($this->_sections['sec3']['iteration'] == 1);
$this->_sections['sec3']['last']       = ($this->_sections['sec3']['iteration'] == $this->_sections['sec3']['total']);
?>
                                	<option name="sort_filtr" value="<?php echo $this->_tpl_vars['filtr_3'][$this->_sections['sec3']['index']]['value']; ?>
"><?php echo $this->_tpl_vars['filtr_3'][$this->_sections['sec3']['index']]['title']; ?>
</option>
                                <?php endfor; endif; ?>
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
            	<center><img alt="Loading..." src="<?php echo $this->_tpl_vars['data']['loadsrc']; ?>
"></center>
            </div>