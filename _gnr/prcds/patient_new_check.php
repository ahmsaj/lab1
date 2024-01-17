<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><div class="form_body so"><?
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$sql="select * from gnr_m_patients where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		echo '<div class="f1 fs18 clr5">'.k_pat_pre_entd.'</div>';
		$f_name=$r['f_name'];
		$l_name=$r['l_name'];
		$ft_name=$r['ft_name'];
		$mother_name=$r['mother_name'];
		$no=$r['no'];
		$mobile=$r['mobile'];
		$birth_date=$r['birth_date'];
		$print_card=$r['print_card'];
		$sex=$r['sex'];
		$phone=$r['phone'];
		$date=$r['date'];
		
		?>
		<table border="0" class="fTable" cellspacing="0" cellpadding="4">
            <tr><td n><?=k_num?> : <ff><?=$id?></ff></td></tr>
            <tr><td n><?=k_name?> : <?=$f_name.' '.$ft_name.' '.$l_name?></td></tr>
			<tr><td n><?=k_sex?> : <? if($sex==1)echo k_male; else echo k_female;?></td></tr>            
            <tr><td n><?=k_reg_date?> : <ff dir="ltr"><?=date('Y / m / d')?></ff></td></tr>            
            <tr><td n><?
			if($print_card){
				echo '<text class="clr5 f1 fs14">'.k_crd_prntd.' <ff>'.$print_card.'</ff></text>';
			}else{
				echo '<text class="clr6 f1 fs14">'.k_crd_ntprntd.'</text>';
			}?></td>
            </tr>
        </table>
		<?
	}
}?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t3 fl" id="pc<?=$id?>" onclick="pr_card(<?=$id?>)"><?=k_pat_card_print?></div> 
	<div class="bu bu_t1 fl" onclick="editPat(<?=$id?>)"><?=k_edit?></div> 
    <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
</div> 
</div>