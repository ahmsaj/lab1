<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$code=$_POST['id'];
	$type=0;
	$act=1;
	if($code=='t'){$type=3;$code=0;}
	if($code!='0' && $code!='t'){
		$sql="select * from _modules_list where code='$code'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$sys=$r['sys'];
			$type=$r['type'];
			$icon=$r['icon'];
			//$mod_code=$r['mod_code'];
			$act=$r['act'];
			$hide=$r['hide'];
		}
	}?>
	<div class="win_body">
		<form name="co_menu" id="co_menu" action="<?=$f_path?>M/menu_new_save.php" method="post" cb="loadModMenu()">
	        <input type="hidden" name="code" value="<?=$code?>"/>
            <input type="hidden" name="type" value="<?=$type?>"/>
			<div class="form_body so">
            	<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<?
				$i=0;
				foreach($lg_s as $l){
					echo '<tr><td n>'.k_title.' <span>('.$lg_n[$i].')</span>: </td>
					<td i><input name="title_'.$l.'" value="'.$r['title_'.$l].'" type="text"></td></tr>';
					$i++;
				}?>
                <tr><td n><?=k_icon?>: </td><td i><?=selectIcon($icon,'icon',1)?></td></tr>                
                <tr><td n><?=k_sys_pro?>: </td><td i><input name="sys" <? if($sys)echo 'checked'; ?> value="1" type="checkbox"></td></tr>
                <tr><td n><?=k_active?>: </td><td i><input name="act" <? if($act)echo 'checked'; ?> value="1" type="checkbox"></td></tr>
                <tr><td n><?=k_hide?>: </td><td i><input name="hide" <? if($hide)echo 'checked'; ?> value="1" type="checkbox"></td></tr>
                </table>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
				<div class="bu bu_t3 fl" onclick="sub('co_menu')"><?=k_save?></div>                    
			</div>
		</form>
	</div>
<? }?>    