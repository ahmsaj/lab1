<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$mod_id=$_POST['id'];
	$type=$_POST['type'];
	if($type==1){$table=get_val_c('_modules','table',$mod_id,'code');}?>
<div class="win_body">
    <div class="form_body so">
    <div class="winOprNote_err f1"><?=k_wnt_dt_md?></div>
    <? if($type==1){?>   <form name="delMod" id="delMod" action="" method="post">
    <table class="" cellpadding="0" cellspacing="0" border="0">      
        <tr>
        	<td width="30"><input type="checkbox" name="d_table" id="d_table" ></td>
            <td n style="text-align:<?=k_align?>"><?=k_dt_tb_db?> [<?=$table?>]</td>
        </tr>           
    </table>        
    </form>
	<? }?> 
    </div>
    <div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div> 
        <div class="bu bu_t1 fr" onclick="DM('<?=$mod_id?>')"><?=k_delete?></div>  	               
    </div>
</div>
<?
}?>