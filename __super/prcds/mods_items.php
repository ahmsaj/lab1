<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
$m_code=addslashes($_POST['id']);
$m_id=get_val_c('_modules','id',$m_code,'code');
?>
<div class="win_body">
<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');loadModule()"></div></div><?
	$txtT='<select name=\"txt_[id]\">';
	foreach($TxtcolTypes as $key => $d){$txtT.='<option value=\"'.$key.'\" >'.$d[1].'</option>';}$txtT.='</select>';
	echo script('txtT="'.$txtT.'";');
	$title=get_val('_modules','title_'.$lg,$m_id);?>
    <div class="form_header lh40">
    	<div class="fl f1 lh40 fs18 f1 clr1 ws"><?=$title?></div>
  		<div title="<?=k_add?>" class=" fr List_add_butt" onclick="oChild(1,'<?=$m_code?>')"></div>		
    </div>
	<div class="form_body so ofxy" type="pd0"><?
	$mod_data=loadModulData($m_code);
	if(checkCoulmEx($mod_data[1],$m_code)){?>
		<form name="modForm" id="modForm" method="post" action="<?=$f_path?>M/mods_items_save.php"   cb="loadModule()" >
		<input type="hidden" name="sub" value="1" >
		<input type="hidden" name="resord" id="resord" value="0" >
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s g_ord holdH" type="static" t_ord="_modules_items" c_ord="ord">
		<thead>
		<tr>
			<th width="20" class="reSoHoldH" tilte="<?=k_rank_possib?>"></th>
			<th width="30">#</th>
			<th width="30"><?=k_code?></th>
			<th width="30"><?=k_active?></th>
			<th width="30"><?=k_show?></th>			
			<th width="30"><?=k_req_fld?></th>
			<th width="40"><?=k_field?></th>
			<th width="140"><?=k_feld_nam?></th>
			<th width="80"><?=k_type?></th>           
			<th width="140"><?=k_addit_sett?></th>			
			<th width="120"><?=k_def_val?></th>			
		    <th width="60"><?=k_search?></th>
		    <th width="120"><?=k_links?></th>	
		    <th><?=k_notes?></th>
		</tr>
		</thead>
		<tbody><?
		$sql="select * from `_modules_items` where mod_code='$m_code' order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['id'];
				$c_code=$r['code'];
				$colum=$r['colum'];
				$title=$r['title'];
				$type=$r['type'];
				$validit=$r['validit'];
				$prams=$r['prams'];
				$show=$r['show'];
				$requerd=$r['requerd'];
				$defult=$r['defult'];
				$c_lang=$r['lang'];
				$note=$r['note'];								
				$ord=$r['ord'];
				$filter=$r['filter'];
				$link=$r['link'];
				$act=$r['act'];
				$pramsSView=getColPrams($type,$id,stripcslashes($prams));			
				if (!($mod_data[12]==1 && $colum==$mod_data[3]) && $type!=10 && $type!=15){?>
					<tr row_id="<?=$id?>" row_ord="<?=$ord?>">
                        <td width="20" class="reSoHold"><div></div></td>
                        <td width="40"><?=$id?></td>
                        <td width="40" class="ff B"><?=$c_code?></td>
                        <td><input type="checkbox" name="act_<?=$id?>" <? if($act) echo ' checked '; ?>/></td>
                        <td><input type="checkbox" name="show_<?=$id?>" <? if($show) echo ' checked '; ?>/></td>
                        <td id="req_<?=$id?>"><?=getColRequerd($type,$id,$requerd)?></td>
						<td><?=$colum?></td>
						<td>
                            <input type="hidden" name="ids[]" value="<?=$id?>"/>
						    <input type="text" name="name_<?=$id?>" value="<?=$title?>" style="width:120px;"/>
                        </td>
						<td>
						    <select name="type_<?=$id?>" style="width:80px;" onChange="changeColType(<?=$id?>,this.value,'<?=$prams?>')">
                            <? 
                            $cc=0;
                            $ActListArry=$columsTypes;
                            if($c_lang)$ActListArry=$columsTypesLang;
                            foreach($ActListArry as $key =>$thisType){
                                $cc++;
                                $sel='';
                                if($type==$key){$sel=' selected ';}
                                echo '<option value="'.$key.'" '.$sel.'>'.$thisType.'</option>';	
                            }?>
                            </select>                   
						</td>                    
						<td id="pars_<?=$id?>"><?=$pramsSView?>
						<input type="hidden" name="link_<?=$id?>" value="<?=$link?>"/></td>						
						<td id="def_<?=$id?>"><?=getColDefult($type,$id,$defult)?></td>
						<td><?=getFilterInput($type,$id,$filter)?></td>
						<td><div id="link_<?=$id?>"><? if($type==5 || $type==6){echo getLinkData($c_code,$link);}?></div>
						<td><input type="text" name="note_<?=$id?>" value="<?=$note?>"/></td>
						
					</tr><?			
				}
				if($type==10 || $type==15){?>
					<tr row_id="<?=$id?>" row_ord="<?=$ord?>">
						<td width="20" class="reSoHold"><div></div></td>
						<td width="40"><?=$id?></td>
						<td width="40" class="ff B"><?=$c_code?></td>
						<td><input type="checkbox" name="act_<?=$id?>" <? if($act) echo ' checked '; ?>/></td>
						<td><input type="checkbox" name="show_<?=$id?>" <? if($show) echo ' checked '; ?>/></td>
						<td align="center" id="req_<?=$id?>"><div class="i30 i30_del" onclick="oChild(0,'<?=$c_code?>')" title="<?=k_delete?>"></div></td>
						<td><input type="text" name="col_<?=$id?>" value="<?=$colum?>" style="width:120px"/></td>
						<td>
						<input type="hidden" name="ids[]" value="<?=$id?>"/>
						<input type="text" name="name_<?=$id?>" value="<?=$title?>"/></td>
						<td>
						<select name="type_<?=$id?>" onChange="changeColType(<?=$id?>,this.value,'<?=$prams?>')"><? 
						$cc=0;
						$ActListArry=$columsTypesCustom;                    
						foreach($ActListArry as $key =>$thisType){
							$cc++;
							$sel='';
							if($type==$key){$sel=' selected ';}
							echo '<option value="'.$key.'" '.$sel.'>'.$thisType.'</option>';	
						}?>
						</select></td>                    
						<td id="pars_<?=$id?>" colspan="5" style="text-align:<?=k_align?>"><?=$pramsSView?></td>
					</tr><?			
				}
			}
		}?>
		</tbody>
		</table>      
		</form><? 		
	}?>
	</div>
	<div class="form_fot fr">
	    <div class="bu bu_t3 fl" onclick="sub('modForm');"><?=k_save?></div>		
    	<div class="bu bu_t1 fl" onclick="fixOrder()"><?=k_corr_ord?></div>
    	<div class="bu bu_t2 fr" onclick="win('close','#full_win1');loadModule()"><?=k_close?></div>
	</div>
</div><?
}?>