<div class="tab-content" id="password">
    <form id="changePasswordForm" action="#" method="POST">
        <div class="input-wrap">
            <p class="title">Старый пароль</p><label><input type="password" name="old_password" value=""></label>
        </div>
        <div class="input-wrap">
            <p class="title">Новый пароль</p><label><input type="password" name="new_password" value=""></label>
        </div>
        <div class="input-wrap">
            <p class="title">Повторите новый пароль</p><label><input type="password" name="new_password_repeat" value=""></label>
        </div>
        <div>
            <button type="button" onclick="mainScript.userChangePass();">Редактировать</button>
        </div>
        <p class="response"></p>
    </form>
</div>