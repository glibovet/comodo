
<!---- ОБРАТНЫЙ ЗВОНОК ----->
<div class="remodal modal" data-remodal-id="call-back">
	<h3 class="modal__caption"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Заказать звонок") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></h3>
	<form id="callbackForm" action="#" method="post">    
    	<label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Имя") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label> 
		<input type="text" name="name" value="" class="offerUserEnterInput">  
    	<label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Телефон") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label> 
		<input  class="offerUserEnterInput phone_number" type="text" name="phone" placeholder="+38(0__)___-__-__">
        
        <div class="response"></div>  
                
        <a class="modal__link" href="#"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отменить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>
        <a href="javascript:void(0);" class="modal__link" onClick="mainScript.callback('<?=$_SERVER['REQUEST_URI']?>');"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отправить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>
	</form>
	
</div>


<!---- ПОДПИСКА НА РАССЫЛКУ ----->
<div class="remodal modal" data-remodal-id="subscribe">
	<h3 class="modal__caption"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Подписаться на рассылку") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></h3>
	<form id="subscribeForm" action="#" method="post">    
    	<label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Имя") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label> 
		<input type="text" name="name" value="" class="offerUserEnterInput">  
    	<label>Email</label>
        <input type="email" name="mail" value="" class="offerUserEnterInput">
        
        <div class="response"></div>  
                
        <a class="modal__link" href="#"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отменить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>
        <a href="javascript:void(0);" class="modal__link" onClick="mainScript.subscribe('<?=$_SERVER['REQUEST_URI']?>');"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отправить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>
	</form>
</div>

<!---- ДОГОВОРИТЬСЯ О ВСТРЕЧЕ ----->
<div class="remodal modal" data-remodal-id="meeting">
	<h3 class="modal__caption"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Договориться о встрече") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></h3>
	<form id="meetingForm" action="#" method="post">
        <input type="hidden" name="uid" value="<?=$wId?>">
        <label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Имя") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label>
        <input type="text" name="name" value="" class="offerUserEnterInput">
        
        <label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Телефон") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label>
        <input  class="offerUserEnterInput phone_number" type="text" name="phone" placeholder="+38(0__)___-__-__">
        
        <label>Email</label>
        <input type="email" name="mail" value="" class="offerUserEnterInput">
        
        <label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Примечание") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label>
        <textarea name="comment"></textarea>
        
    	<div class="response"></div> 
        
        <a class="modal__link" href="#"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отменить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>         
        <a class="modal__link" href="javascript:void(0);" onClick="mainScript.addNewMeeting('<?=$_SERVER['REQUEST_URI']?>');"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отправить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>                  
    </form>
</div>

<!---- ОФОРМЛЕНИЕ ЗАКАЗА ----->
<div class="remodal modal" data-remodal-id="send-request">
	<h3 class="modal__caption"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отправить запрос") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></h3>
	<form id="modalOrderForm" action="#" method="post">
        <label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Имя") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label>
        <input type="text" name="name" value="" class="offerUserEnterInput">
        
        <label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Телефон") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label>
        <input  class="offerUserEnterInput phone_number" type="text" name="phone" placeholder="+38(0__)___-__-__">
        
        <label>Email</label>
        <input type="email" name="mail" value="" class="offerUserEnterInput">
        
        <label><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Примечание") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></label>
        <textarea name="comment"></textarea>
        
    	<div class="response"></div> 
        
        <a class="modal__link" href="#"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отменить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>         
        <a class="modal__link" href="javascript:void(0);" onClick="mainScript.addNewOrder();"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Отправить") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></a>                  
    </form>
</div>


<!---- СПАСИБО ЗА ЗАКАЗ ----->
<div class="remodal thanks-you" data-remodal-id="thanks-you">
	<form id="thanksForm" action="#" method="post">
        <h3 class="thanks-you__caption"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Спасибо за заказ") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?>!</h3>
        <p class="thanks-you__text"><?php $i=0; foreach ($site_translate as $translate){					
									if ($translate['ru_text'] == "Наш менеджер свяжется с вами в ближайшее время") {
										$i++;
										if ($i==1 ) {
											echo $translate['text'];
											}
										}?>    
								<?php }?></p>
        
        <div class="response"></div>
        
        <a class="thanks-you__link" href="<?=RS.LANG?>/catalog/"><?php $i=0; foreach ($site_translate as $translate){					
                                        if ($translate['ru_text'] == "Продолжить покупки") {
                                            $i++;
                                            if ($i==1 ) {
                                                echo $translate['text'];
                                                }
                                            }?>    
                                    <?php }?></a>
	</form>
</div>