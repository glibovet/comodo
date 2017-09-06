<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	require_once "../../../require.base.php";
		
	$article_id	= $_POST['article_id'];

	//SELECT ARTICLE BY ID///////////////////////////////
	
	$query = "SELECT *
				FROM [pre]articles
				WHERE id=$article_id
				LIMIT 1
				";

	$artData = $ah->rs($query);	

	

	$art_title        	= $artData[0]['name'];
	$art_number        	= $artData[0]['id'];
	$art_alias      	= $artData[0]['alias'];
	$art_modify  		= $artData[0]['dateModify'];
	$art_img			= $artData[0]['filename'];
	$art_cont			= $ah->next_sub_str(strip_tags($artData[0]['content']),600);
	
	//echo "<pre>"; print_r($art_cont); echo "</pre>"; exit();	

	$query = "SELECT *
				FROM [pre]subscribers
				WHERE active = '1'
				ORDER BY id
				";

	$subscribers = $ah->rs($query);

	$from = "info@dveri-prestige.kiev.ua";

	$sendMessage .= "
	<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#FFFFFF\">
    <tr>
        <td>
            <!--email container-->
            <table cellspacing=\"0\" border=\"0\" align=\"center\" cellpadding=\"0\" width=\"624\">
                <tr>
                    <td>
                        <!--header-->
                        <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                            <tr>
                                <td valign=\"top\"> <img src=\"http://dveri-prestige.kiev.ua/split/files/banners/formail/spacer-top.jpg\" height=\"12\" width=\"624\" />
                                    <!--top links-->
                                    <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                                        <tr>
                                            <td valign=\"middle\" width=\"221\">
                                                <p style=\"font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #333; margin: 0px;\"><img style=\"height:70px; width:auto;\" src=\"http://dveri-prestige.kiev.ua/assets/images/demo/logo/dv_prestige_logo.png\">
                                                <span class=\"date\" style=\" color: #616161; padding: 5px 15px; background: #9EC561;\">$art_modify</span>
                                                </p>
                                            </td>
                                            <td valign=\"bottom\" width=\"118\">
                                                <p style=\"font-size: 12px; font-family: Helvetica, Arial, sans-serif; color: #333; margin: 0px;\">
                                                    <a style=\"border-radius: 3px;font-weight:bold;text-decoration:none;color:#fff;float: right; background: #A0CE4D; padding: 10px;\" href=\"http://dveri-prestige.kiev.ua/news/$art_alias\">Показать в браузере</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/top links-->
                                    <!--line break-->
                                    <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                                        <tr>
                                            <td valign=\"top\" width=\"624\">
                                                <p><img src=\"http://dveri-prestige.kiev.ua/split/files/banners/formail/line-break.jpg\" height=\"10\" width=\"624\" /></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/line break-->
                                    <!--header content-->
                                    <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                                        <tr>
                                            <td>
                                                <h1 style=\"color: #333; margin: 0px; font-weight: normal; font-size: 40px; font-family: Helvetica, Arial, sans-serif;\">Новости от DveriPrestige</h1>
                                            </td>
                                            <td id=\"issue\" valign=\"top\" style=\"background-image: url('http://dveri-prestige.kiev.ua/split/files/banners/formail/issue-no.jpg'); background-repeat: no-repeat; background-position: top; width: 109px; height: 109px;\">
                                                <!--number-->
                                                <table width=\"104\" align=\"right\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                                                    <tr>
                                                        <td width=\"52\" height=\"73\" valign=\"bottom\"></td>
                                                        <td width=\"52\" valign=\"bottom\">
                                                            <h3 style=\"margin: 0px; padding:0; font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #FFF;\">$art_number</h3>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--/number-->
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/header content-->
                                </td>
                            </tr>
                        </table>
                        <!--/header-->
                        <!--line break-->
                        <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                            <tr>
                                <td height=\"50\" valign=\"middle\" width=\"624\"><img src=\"http://dveri-prestige.kiev.ua/split/files/banners/formail/line-break-2.jpg\" height=\"13\" width=\"624\" /></td>
                            </tr>
                        </table>
                        <!--/line break-->
                        <!--email content-->
                        <table cellspacing=\"0\" border=\"0\" id=\"email-content\" cellpadding=\"0\" width=\"624\">
                            <tr>
                                <td>
                                    <!--section 1-->
                                    <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                                        <tr>
                                            <td>
                                                <p style=\"font-size: 17px; line-height: 24px; font-family: Georgia, 'Times New Roman', Times, serif; color: #333; margin: 0px;\"><a href=\"http://dveri-prestige.kiev.ua/news/$art_alias\"><img src=\"http://dveri-prestige.kiev.ua/split/files/banners/$art_img\" height=\"330\" alt=\"image dsc\" style=\"border: solid 1px #FFF; box-shadow: 2px 2px 6px #333; -webkit-box-shadow: 2px 2px 6px #333; -khtml-box-shadow: 2px 2px 6px #333; -moz-box-shadow: 2px 2px 6px #333;\" width=\"600\" /></a></p>
                                                <p style=\"font-size: 17px; line-height: 24px; font-family: Georgia, 'Times New Roman', Times, serif; color: #333; margin: 0px;\"><img src=\"http://dveri-prestige.kiev.ua/split/files/banners/formail/spacer-ten.jpg\" height=\"10\" width=\"624\" /></p>
                                                <h2 style=\"font-size: 36px; font-family: Helvetica, Arial, sans-serif; color: #333 !important; margin: 0px;\">$art_title</h2>
                                                <p style=\"font-size: 17px; line-height: 24px; font-family: Georgia, 'Times New Roman', Times, serif; color: #333; margin: 0px;\">$art_cont ...</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/section 1-->
                                    <!--line break-->
                                    <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                                        <tr>
                                            <td height=\"30\" valign=\"middle\" width=\"624\"><img src=\"http://dveri-prestige.kiev.ua/split/files/banners/formail/line-break-2.jpg\" height=\"13\" width=\"624\" /></td>
                                        </tr>
                                    </table>
                                    <!--/line break-->
                                    <!--footer-->
                                    <table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" width=\"624\">
                                        <tr>
                                            <td>
                                                <p style=\"font-size: 12px; float:right; font-family: Helvetica, Arial, sans-serif; color: #333; margin: 0px;\">
                                                    <a  style=\"border-radius: 3px;font-weight:bold;text-decoration:none;color:#fff;float: right; background: #A0CE4D; padding: 10px;\" href=\"http://dveri-prestige.kiev.ua/news/$art_alias\">Читать далее ...</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--/footer-->
                                </td>
                            </tr>
                        </table>
                        <!--/email content-->
                    </td>
                </tr>
            </table>
            <!--/email container-->
        </td>
    </tr>
</table>
	";

	foreach ($subscribers as $user) 
	{
		$sendTo = $user['login'];

		$sendStatus = $ah->send_letter($sendTo,$from,"Новость от Dveri Prestige!  ",$sendMessage,"Dveri Prestige");
	}








	//SEND MESSAGE//////////////////////////////////////
		
	


	if(isset($sendStatus))
	{
		$data['status'] = "success";
		
		$data['message'] = "Сообщение успешно отправлено";
	}
	
