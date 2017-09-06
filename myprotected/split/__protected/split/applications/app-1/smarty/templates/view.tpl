		<div class="l-z-left-menu">
        	<ul>
            {section name=sec1 loop=$data}
            	{if $data[sec1].alias == 'personal'}
                <li class="l-z-user-li{$data[sec1].active}" id="sub-zen-{$data[sec1].alias}"><a href="{$data[sec1].link}" 
                	onclick="$('.l-z-right-menu-item').hide(); $('#zen-{$data[sec1].alias}').show();
                    $('.l-z-left-menu ul li').removeClass('active'); $('#sub-zen-{$data[sec1].alias}').addClass('active');" >
                	<div class="{$data[sec1].class} zen-left-menu-item">
                    	<div class="l-z-user-messages" id="quant-new-messages">{$user.mess_quant}</div>
                        <div class="l-z-left-menu-text">
                        	<p>{$user.name}</p>
                            <p>{$user.fname}</p>
                        </div>
                   </div>
                </a></li><!-- l-z-left-menu-user -->
                {else}
                <li id="sub-zen-{$data[sec1].alias}" class="{$data[sec1].active}">
                	<a href="{$data[sec1].link}" onclick="$('.l-z-right-menu-item').hide(); $('#zen-{$data[sec1].alias}').show();
                    	$('.l-z-left-menu ul li').removeClass('active'); $('#sub-zen-{$data[sec1].alias}').addClass('active');" >
                	<div class="{$data[sec1].class} zen-left-menu-item">
                        <div class="l-z-left-menu-text">{$data[sec1].name}</div>
                   </div>
                </a></li><!-- l-z-left-menu-item -->    
                {/if}
            {/section}
            </ul>
        </div><!-- l-z-left-menu -->
        
        
        <div class="l-z-right-menu" id="l-z-right-menu">
        	{section name=sec1 loop=$data}
            	<ul class="l-z-right-menu-item{$data[sec1].classto}" id="zen-{$data[sec1].alias}">
                {section name=sec2 loop=$data[sec1].childs}
                	<a href="index.php?control={$data[sec1].alias}&item={$data[sec1].childs[sec2].id}" ><li class="{$data[sec1].childs[sec2].class}">
                		{$data[sec1].childs[sec2].name} 
                        {if $data[sec1].childs[sec2].name == 'Задания'}
                        	({$quant_paid_orders})
                        	<span  class="right">&rsaquo;</span>
                        {/if}
                        {if $data[sec1].childs[sec2].name == 'Сообщения'}
                        	({$quant_messages})
                        	<span  class="right">&rsaquo;</span>
                        {/if}
                	</li></a>
                    {if $data[sec1].childs[sec2].name == 'Задания'}
                    	<ul class="tickets" id="zen_tickets">
                        	{section name=sec3 loop=$paid_orders}
                            	<li onclick="change_head(21); load_card('{$paid_orders_card_path}',{$paid_orders[sec3].id});">Заказ {$paid_orders[sec3].id+5000} 
                                <span class="right">{$paid_orders[sec3].date_paid}</span></li>
                            {/section}
                        </ul>
                    {/if}
                    {if $data[sec1].childs[sec2].name == 'Сообщения'}
                    	<ul class="tickets" id="zen_messages">
                        	{section name=sec4 loop=$messages}
                            	<li id="mess_loop_{$messages[sec4].id}" title="Прочитать" onclick="document.location.href='index.php?control=personal&item=29&id={$messages[sec4].id}'">
                                <span class="left">{$messages[sec4].friend_name}</span>
                                <span class="right">{$messages[sec4].date_mess}</span>
                                <br>
                                {$messages[sec4].sub_mess}
                                </li>
                            {/section}
                        </ul>
                    {/if}
                {/section}
                </ul>
            {/section}
        </div><!-- l-z-right-menu -->