<?php /* Smarty version 2.6.27, created on 2014-01-13 15:49:02
         compiled from view.tpl */ ?>
		<div class="l-z-left-menu">
        	<ul>
            <?php unset($this->_sections['sec1']);
$this->_sections['sec1']['name'] = 'sec1';
$this->_sections['sec1']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            	<?php if ($this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias'] == 'personal'): ?>
                <li class="l-z-user-li<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['active']; ?>
" id="sub-zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
"><a href="<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['link']; ?>
" 
                	onclick="$('.l-z-right-menu-item').hide(); $('#zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
').show();
                    $('.l-z-left-menu ul li').removeClass('active'); $('#sub-zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
').addClass('active');" >
                	<div class="<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['class']; ?>
 zen-left-menu-item">
                    	<div class="l-z-user-messages" id="quant-new-messages"><?php echo $this->_tpl_vars['user']['mess_quant']; ?>
</div>
                        <div class="l-z-left-menu-text">
                        	<p><?php echo $this->_tpl_vars['user']['name']; ?>
</p>
                            <p><?php echo $this->_tpl_vars['user']['fname']; ?>
</p>
                        </div>
                   </div>
                </a></li><!-- l-z-left-menu-user -->
                <?php else: ?>
                <li id="sub-zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
" class="<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['active']; ?>
">
                	<a href="<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['link']; ?>
" onclick="$('.l-z-right-menu-item').hide(); $('#zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
').show();
                    	$('.l-z-left-menu ul li').removeClass('active'); $('#sub-zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
').addClass('active');" >
                	<div class="<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['class']; ?>
 zen-left-menu-item">
                        <div class="l-z-left-menu-text"><?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['name']; ?>
</div>
                   </div>
                </a></li><!-- l-z-left-menu-item -->    
                <?php endif; ?>
            <?php endfor; endif; ?>
            </ul>
        </div><!-- l-z-left-menu -->
        
        
        <div class="l-z-right-menu" id="l-z-right-menu">
        	<?php unset($this->_sections['sec1']);
$this->_sections['sec1']['name'] = 'sec1';
$this->_sections['sec1']['loop'] = is_array($_loop=$this->_tpl_vars['data']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            	<ul class="l-z-right-menu-item<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['classto']; ?>
" id="zen-<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
">
                <?php unset($this->_sections['sec2']);
$this->_sections['sec2']['name'] = 'sec2';
$this->_sections['sec2']['loop'] = is_array($_loop=$this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                	<a href="index.php?control=<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['alias']; ?>
&item=<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['id']; ?>
" ><li class="<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['class']; ?>
">
                		<?php echo $this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['name']; ?>
 
                        <?php if ($this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['name'] == 'Задания'): ?>
                        	(<?php echo $this->_tpl_vars['quant_paid_orders']; ?>
)
                        	<span  class="right">&rsaquo;</span>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['name'] == 'Сообщения'): ?>
                        	(<?php echo $this->_tpl_vars['quant_messages']; ?>
)
                        	<span  class="right">&rsaquo;</span>
                        <?php endif; ?>
                	</li></a>
                    <?php if ($this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['name'] == 'Задания'): ?>
                    	<ul class="tickets" id="zen_tickets">
                        	<?php unset($this->_sections['sec3']);
$this->_sections['sec3']['name'] = 'sec3';
$this->_sections['sec3']['loop'] = is_array($_loop=$this->_tpl_vars['paid_orders']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                            	<li onclick="change_head(21); load_card('<?php echo $this->_tpl_vars['paid_orders_card_path']; ?>
',<?php echo $this->_tpl_vars['paid_orders'][$this->_sections['sec3']['index']]['id']; ?>
);">Заказ <?php echo $this->_tpl_vars['paid_orders'][$this->_sections['sec3']['index']]['id']+5000; ?>
 
                                <span class="right"><?php echo $this->_tpl_vars['paid_orders'][$this->_sections['sec3']['index']]['date_paid']; ?>
</span></li>
                            <?php endfor; endif; ?>
                        </ul>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['data'][$this->_sections['sec1']['index']]['childs'][$this->_sections['sec2']['index']]['name'] == 'Сообщения'): ?>
                    	<ul class="tickets" id="zen_messages">
                        	<?php unset($this->_sections['sec4']);
$this->_sections['sec4']['name'] = 'sec4';
$this->_sections['sec4']['loop'] = is_array($_loop=$this->_tpl_vars['messages']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['sec4']['show'] = true;
$this->_sections['sec4']['max'] = $this->_sections['sec4']['loop'];
$this->_sections['sec4']['step'] = 1;
$this->_sections['sec4']['start'] = $this->_sections['sec4']['step'] > 0 ? 0 : $this->_sections['sec4']['loop']-1;
if ($this->_sections['sec4']['show']) {
    $this->_sections['sec4']['total'] = $this->_sections['sec4']['loop'];
    if ($this->_sections['sec4']['total'] == 0)
        $this->_sections['sec4']['show'] = false;
} else
    $this->_sections['sec4']['total'] = 0;
if ($this->_sections['sec4']['show']):

            for ($this->_sections['sec4']['index'] = $this->_sections['sec4']['start'], $this->_sections['sec4']['iteration'] = 1;
                 $this->_sections['sec4']['iteration'] <= $this->_sections['sec4']['total'];
                 $this->_sections['sec4']['index'] += $this->_sections['sec4']['step'], $this->_sections['sec4']['iteration']++):
$this->_sections['sec4']['rownum'] = $this->_sections['sec4']['iteration'];
$this->_sections['sec4']['index_prev'] = $this->_sections['sec4']['index'] - $this->_sections['sec4']['step'];
$this->_sections['sec4']['index_next'] = $this->_sections['sec4']['index'] + $this->_sections['sec4']['step'];
$this->_sections['sec4']['first']      = ($this->_sections['sec4']['iteration'] == 1);
$this->_sections['sec4']['last']       = ($this->_sections['sec4']['iteration'] == $this->_sections['sec4']['total']);
?>
                            	<li id="mess_loop_<?php echo $this->_tpl_vars['messages'][$this->_sections['sec4']['index']]['id']; ?>
" title="Прочитать" onclick="document.location.href='index.php?control=personal&item=29&id=<?php echo $this->_tpl_vars['messages'][$this->_sections['sec4']['index']]['id']; ?>
'">
                                <span class="left"><?php echo $this->_tpl_vars['messages'][$this->_sections['sec4']['index']]['friend_name']; ?>
</span>
                                <span class="right"><?php echo $this->_tpl_vars['messages'][$this->_sections['sec4']['index']]['date_mess']; ?>
</span>
                                <br>
                                <?php echo $this->_tpl_vars['messages'][$this->_sections['sec4']['index']]['sub_mess']; ?>

                                </li>
                            <?php endfor; endif; ?>
                        </ul>
                    <?php endif; ?>
                <?php endfor; endif; ?>
                </ul>
            <?php endfor; endif; ?>
        </div><!-- l-z-right-menu -->