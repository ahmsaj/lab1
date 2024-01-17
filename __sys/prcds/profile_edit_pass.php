<? include("ajax_header.php");
list($un,$name)=get_val('_users','un,name_'.$lg,$thisUser);
?>	
<div class="win_body">
<div class="form_header so lh40 clr1 f1 fs18"><?=$name?></div>
<div class="form_body so" type="pd0">
	<form id="perAcc" name="perAcc" method="post" action="<?=$f_path?>S/sys_profile_edit_pass_save.php" cb="ePPsSaveCb([1])" bv="a">
    <table width="100%" class="fTable" cellspacing="0" cellpadding="4"  >
	<tr><td n><?=k_user_name?> : <span>*</span></td>
	<td><input type="text" name="user" value="<?=$un?>" /></td></tr>
    <tr><td n><?=k_old_password?> : <span>*</span></td>
	<td><input type="password" name="op" required /></td></tr>
    <tr><td n><?=k_new_password?> : <span>*</span></td>
	<td>
		<input type="password" name="np" required passCheck="1"/>
		<span class="lh20 clr5">يجب انا تكون كلمة السر مؤلفة من 6 أحرف على الأقل وتحتوي على احرف صغيرة وكبير وأرقام ورموز مثال(AbCabc123#@$)</span>      		
	</td></tr>
    <tr><td n><?=k_confirm_Password?> : <span>*</span></td>
	<td><input type="password" name="rp" required/></td>
    </table>   
	</form>
</div>
<div class="form_fot fr">
	<div class="bu bu_t3 fl" onclick="ePPsSave()"><?=k_save?></div>
	<div class="bu bu_t2 fr" onclick="win('close','#m_info5');"><?=k_close?></div>	
</div>
</div>