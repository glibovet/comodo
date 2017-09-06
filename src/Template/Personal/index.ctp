<section class="banner">
		<h1>Личный <span>кабинет</span></h1>
	</section>

	<section class="data-and-history">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12 col-lg-offset-6 col-md-16 col-md-offset-4 col-sm-20 col-sm-offset-2 col-xs-24 col-xs-0">
					<div class="tabs" id="data-and-history">
						<div class="tab-button-wrap"><p class="tab-button active" data-tab="data">личные <span>данные</span></p><p class="tab-button" data-tab="password">Сменить <span>пароль</span></p><p class="tab-button" data-tab="history">мои <span>заказы</span></p></div>
						<div class="tab-content active" id="data">
							<form action="#" method="post" id="persInfoForm">
								<div class="input-wrap">
									<p class="title">Имя</p><label><input type="text" name="name" value="<?php echo $userInfo['name'] ?>"></label>
								</div>
								<div class="input-wrap">
									<p class="title">Фамилия</p><label><input type="text" name="lname" value="<?php echo $userInfo['lname'] ?>"></label>
								</div>
								<div class="input-wrap">
									<p class="title">E-mail</p><label><input type="email" name="email" value="<?php echo $userInfo['login'] ?>"></label>
								</div>
								<div class="input-wrap">
									<p class="title">Телефон</p><label><input type="text" placeholder="+38(0__)___-__-__" name="phone" value="<?php echo $userInfo['phone'] ?>"></label>
								</div>
								<div class="input-wrap">
									<p class="title">Адрес</p><label><input type="text" name="adress" value="<?php echo $userInfo['delivery_address'] ?>"></label>
								</div>
								<p class="send-an-email">Я хочу получать рассылку по новостям и скидкам</p>
								<p class="radio-button">
                                    <input type="radio" name="confirm" id="yes" class="radio" <?php if(!$userInfo['newsletter']){echo "checked";} ?> value="0"><label for="yes">Да</label>
                                    <input type="radio" name="confirm" id="no" class="radio"<?php if($userInfo['newsletter']){echo "checked";} ?> value="1"><label for="no">Нет</label>
                                </p>
								<div>
									<button type="button" onclick="mainScript.userPersInfo();">Редактировать</button>
								</div>
            					<p class="response"></p>
							</form>
						</div>
						                                           
                        <?php include_once "change-pas.php"; ?>
						                                           
                        <?php include_once "order_history.php"; ?>
					</div>
				</div>
			</div>
		</div>
	</section>