<link type="text/css" href="split/css/log-style.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>

  <div id="login-content">
  	<div id="login-input">
    	<div id="login-input-logo"></div>
        <div id="login-input-cont">
        	<form name="zen-admin-enter-form" action="#zen-admin-enter" method="POST">
            <div id="login-input-log">
            	<input id="login_login" type="text" placeholder="Email" value="" onfocus="$('#login-input-log').css('background','#3f4856');" onblur="$('#login-input-log').css('background','none');">
            </div>
            
            <div id="login-input-pass">
            	<input id="login_pass" type="password" placeholder="Пароль" value="" onfocus="$('#login-input-pass').css('background','#3f4856');" onblur="$('#login-input-pass').css('background','none');">
            </div>
            </form>
        </div><!-- login-input-cont --> 
    </div><!-- login-input --> 
  </div><!-- login-content --> 
  
  <div id="login_result"></div>

<script type="text/javascript" language="javascript">
	$(function(){
			$('#login_login').focus();
		});
	
	function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }
	
	window.onkeypress = pressed;
	
	function pressed(e)
	{
    	var key = e.keyCode || e.which;
		//alert(key);
		if(key == 13)
		{
			var login = $('#login_login').val();
			var pass = $('#login_pass').val();
			
			if(isValidEmailAddress(login))
			{
				var data = {
							login:login,
							pass:pass
							}
				$.post("split/ajax/heandlers/action.json.adminEnter.php",data,function(data,status){
						if(status=="success")
						{
							//alert(data.message);
							
							jQuery.cookie('user_id',data.user_id);
							jQuery.cookie('user_pass','[p1gH'+data.user_pass);
							
							document.location.reload();
						}else{
								$('#login-input-cont').animate({'marginLeft':'-20px'},200,function(){
									$('#login-input-cont').animate({'marginLeft':'0px'},400,'easeOutBounce');
								});
							}
					},"json");
			}else
			{
				$('#login-input-cont').animate({'marginLeft':'-20px'},200,function(){
					$('#login-input-cont').animate({'marginLeft':'0px'},400,'easeOutBounce');
				});
			}
		}
	}
</script>	