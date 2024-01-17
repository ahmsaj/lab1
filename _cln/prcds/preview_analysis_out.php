<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	$view=get_val('cln_x_pro_analy','view',$id);
	$p_id=get_val('cln_x_pro_analy','p_id',$id);
	$c_id=getLabId();?>
    <div class="form_body so">
    <? if($c_id){?>
    <div class="f1 fs18 clr1 lh40"><?=k_sel_exp_typ?></div>
    <form name="a_out" id="x_out" action="<?=$f_path?>X/cln_preview_analysis_out_save.php" method="post"  cb="" bv="">
	<input type="hidden" name="id" id="id" value="<?=$id?>"/>
    <input type="hidden" name="p" id="id" value="<?=$p_id?>"/>
    <input type="hidden" name="c" id="id" value="<?=$c_id?>"/>
    <div class="radioBlc so fl" name="type" req="1" par="swt" >
    <input type="radio" name="type" checked value="1" par="swt"/><label><?=k_print?></label>
    <input type="radio" name="type" value="2" par="swt"/><label><?=k_crt_adserv?></label>
    </div>
    <table width="100%" border="0" class="grad_s " type="static" cellspacing="0" cellpadding="4" over="0">
	<tr>
    <th width="40">#</th>            	
    <th><?=k_service?></th>
    <th><?=k_corr_serv_cntr?></th>
    </tr><?
	
	//$status_txt=array(k_report_not_enterd,k_report_enterd);
	//$status_color=array($clr5,$clr6);
	//$status_color2=array('#ffffff',$clr4);
	$sql="select * from cln_x_pro_analy_items where ana_id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$mad_id=$r['mad_id'];
			$photo=$r['ana_id'];
			$note=$r['note'];
			$status=$r['status'];
			$s_link=get_val('cln_m_pro_analysis','s_link',$mad_id);
			$serv_txt=k_srv_ntav_hos;
			$serv_color=$clr5;
			$mood=1;
			$ch='checked';
			$price='';
			if($s_link){
				$sql2="select hos_part,doc_part , name_$lg from cln_m_services where id='$s_link' ";
				$res2=mysql_q($sql2);
				$rows2=mysql_n($res2);
				if($rows2){
					$r2=mysql_f($res2);
					$hos_part=$r2['hos_part'];
					$doc_part=$r2['doc_part'];
					$serv_txt=$r2['name_'.$lg];				
					$serv_color=$clr6;
					$price='<br><ff>'.number_format($hos_part+$doc_part).'</ff>';
					$mood=2;
					$ch='';
				}
			}?>
			<tr mood="<?=$mood?>">
            	<td><input type="checkbox" par="lxo" name="srv_<?=$s_id?>" <?=$ch?>/></td>
				<td class="fs12 f1"><?=get_val('cln_m_pro_analysis','name_'.$lg,$mad_id)?></td>
                <td class="fs12 f1" style="color:<?=$serv_color?>"><?=$serv_txt.$price?></td>
			</tr><?
		}
	}?>
    </table>
    </form>
    <? }else{ echo '<div class="f1 fs16 clr5 lh30">'.k_nolb_hos.'</div>';}?>
    </div>
    <div class="form_fot fr">
    	<? if($c_id){?><div class="bu bu_t3 fl" onclick="exportAOut();" ><?=k_export?></div><? }?>
        <div class="bu bu_t2 fr" onclick="win('close','#m_info3');" ><?=k_close?></div>        
    </div><?	
}?>
</div>