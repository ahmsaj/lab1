<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['p_id'])&& isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$sql="select note from cln_x_visits where id='$v_id' and patient='$p_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$note=$r['note'];
		?><div class="form_body so" type="full">
    	<div class="win_inside_con">
		<div class="f1 blc_win_title bwt_icon5"><?=k_notes_regarding_the_visit?></div>
		<textarea id="report" t class="w100" ><?=$note?></textarea>
		</div></div>
		 <div class="form_fot fr">
	        <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div> 
            <div class="bu bu_t1 fr" onclick="saveNote()"><?=k_save?></div>                       
        </div>
	<?
	}	 
}?>
</div>