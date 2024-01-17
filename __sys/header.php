<? include("../__sys/mods/protected.php");
$folderBack='';
if($_GET['root']){
    $folderBack=intval($_GET['root']);
    $folderBack=str_repeat('../',$folderBack);
}
include($folderBack."__sys/dbc.php");
include($folderBack.'__sys/start.php');
$noti=intval(get_val('_sys_notification_live','no',$thisUser));?>
<!doctype html>
<html lang="<?=$lg?>" class="no-js">
<head>
<meta charset="utf-8">
<title><?=$def_title?></title>
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport" />
<? include($folderBack.'__sys/headSet.php');?></head>
<body>
<div class="PageStart"><div><?=k_loading?></div></div>
<div class="alert_nav" id="alert_box"></div>
<div class="navMSG"><div class="c_cont f1 fs16"></div></div>
<div id="notiList" nwn="alertW" class="notiList ofx so"></div>
<div class="PageLoaderWin c_cont"><div class="c_cont" c><div class="fl" i></div><div class="f1 fl" s><?=k_loading?></div></div></div>
<div class="loadWin"></div>
<div class="miraware-queue hide"><div class="up_title f1"><?=k_ftbup?></div><div id="miraware-queue"></div></div>
<div id="alert_win" style="display:none">
	<div class="win_body2 fl">
		<div id="alert_win_cont"></div>
        <div class="form_fot fr">
			<div class="uLine lh20">&nbsp;</div>
            <div class="bu bu_t2 buu fr" onclick="$('#alert_win').dialog('close');"><?=k_no?></div>
            <div class="bu bu_t3 buu fl" onclick="alert_function_m();"><?=k_yes?></div>
        </div>
    </div>
</div>
<div id="m_info" class="hide"></div><? for($i=1;$i<6;$i++){echo'<div id="m_info'.$i.'" class="hide"></div>';}?>
<div class="menuBg"></div>
<div class="body">	
	<div class="th_win th_mH" n="1">		
		<div class="th_mHIn fx">
			<div class="thic_x fl"></div>
			<div class="th_menu_src"><input type="text" id="mnSrc"/></div>
		</div>
		<div class="ofx so clrw" id="mHList"></div>		
	</div>
	<div class="th_win" n="2">
		<div class="mlWinTitle fx">
			<div class="thic_x"></div>
			<div class="clr444 f1 fs16 lh40 pd10" style="width:180px"><?=k_favorite?></div>
			<div class="thicF favSet" title="<?=k_fav_setts?>"></div>
			<div class="thicF favOrd fx-js-e" title="<?=k_ord_lst?>"></div>	
		</div>		
		<div class=" ofx so clrw w100" id="favList" fix1="hp:75"></div>		
	</div>
	<div class=" th_win th_lang" n="3">		
		<div class="mlWinTitle">
			<div class="thic_x"></div>
			<div class="clr444 f1 fs16 lh40 pd10" fix1="wp:40"><?=k_langs?></div>		
		</div>		
	</div>	

	<div class="user_pro_win ofx so" nwn="profile" id="profileWin">
		<div class="fx clrw">
			<? $i=0;
			foreach($lg_s as $l){
				$lsty='nor';
				if($l==$lg){$lsty='cbg1';}
				if($lsty=='nor'){echo '<a href="'.getLangLink($l).'">';}
				echo '<div class=" f1 pd5v pd10 mg5r mg5b br5 clrw '.$lsty.' ">'.$lg_n[$i].'</div>';
				if($lsty=='nor'){echo '</a>';}
				$i++;
			}?>
		</div>
		<? if($thisGrp!='s'){?>
			<div class="fx">
				<? if(modPer('3qzmn1xuwa',2)){?><div icon class=" thicF profEdit w100" title="<?=k_edit?>"></div><? }?>			
				<div class=" lh40 clrw f1 pd5"><?=k_pers_profile?></div>			
			</div>
		<? }?>
		<div class="ofx so clrw w100" id="profList"></div>
		<div class="fx">
			<div class="thic thic_exit" id="thic_exit"></div>
			<div class="lh40 clrw f1 pd5" ><?=k_logout?></div>
		</div>
		<div class="fx fx-js-sb">
			<div class="clrw ff fs12 lh30 pd10"> V<?=$ProVer?></div>
			<div class="clrw ff fs12 lh30 pd10" clc><?=date('h:i',$now)?></div>        
		</div>
	</div>
		
	<div class="topHeader fx fx-js-sb">
		<div class="fx">
			<div class="thic thic_menu" n="1" title="<?=k_menu?>"></div>
			<div class="thic thic_fav" n="2" title="<?=k_favorite?>"></div>
			<a href="<?=$f_path?>"><div class="thic thic_home" title="<?=k_home_page?>"></div></a>
			<div class="fl lh40 clrw pd10 fs14 f1 topUserName"><?=get_val_c('_groups','name_'.$lg,$thisGrp,'code').' : '.get_val('_users','name_'.$lg,$thisUser);?></div>
		</div>
		<div class="fx">			
			<?=viewHelp()?>
			<div class="thic thic_con fr" id="conectS"></div>
			<div class="thic thic_alert" nw="alertW"><div c="<?=$noti?>"><?=$noti?></div></div>
			<div class="thic thic_user " nw="profile" title="<?=k_pers_profile?>"></div>
		</div>
	</div>

	<div class="centerSide so fl ">