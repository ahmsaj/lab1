<? include("ajax_header.php");
if(isset($_POST['status'])){
	$status=pp($_POST['status'],'s');
	if($status=='view'){
		if(isset($_POST['mod'])){
			$mod_code=pp($_POST['mod'],'s');
			$sql="select * from _modules_items where mod_code='$mod_code' and lang='1'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				 while($r=mysql_f($res)){
					   $mode_code=$r['mod_code'];
					   $code=$r['code'];
					   $item_title=get_key($r['title']);
					   echo '<div class="mg10" mod="'.$mod_code.'" code="'.$code.'" >'.$item_title.'</div>';
				 }
			}
		}
	}
	elseif($status=='view1'){
		$sql="select * from _modules where code in (select mod_code from _modules_items where lang='1') ORDER BY `module` DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$mod_code=0;  
			while($r=mysql_f($res)){
				$actCat='';
				$title=get_key($r['title']);
				$code=$r['code'];
				if(!$mod_code){$mod_code=$code; $actCat='actCat';}
				echo '<div  '.$actCat.' cn="'.$code.'">'.SplitNo($title).'</div>';		
			}
		}
	}
	elseif($status=='view2'){
		$joinTypes=[
			'1:'.k_main_lang,
			'2:'.k_main_lang_blank_space,
			'3:'.k_thlonger
		];
		?>
		<div class="join_type_box " fix="h:250|w:360" id="join_type_sel">
			<div class="lh40 fs16 f1 clr55"><?=k_sel_merge_type?>:</div>
			<div class="lh40" style="width:300px;" >
				<?=selectFromArrayWithVal('join_types',$joinTypes,0,0,1,'');?>
			</div>
			<div class="fr mg10 Over cbg5 f1 clrw TC fs14 B lh40" fix="h:50|w:120"  onclick="join_done()" style="margin-top:50px;"><?=k_merge_start?></div>

		</div><?
	}
	elseif($status=='process'){
		if(isset($_POST['item'],$_POST['type'])){
			$type_join=pp($_POST['type']);
			$item=pp($_POST['item'],'s');
			$rec=getRecCon('_modules_items',"code='$item'");
			$col_name=str_replace('(L)','',$rec['colum']);
			$col_new_name=trim(str_replace('_(L)','',$rec['colum']));
			$mod=$rec['mod_code'];
			$table=get_val_con('_modules','table',"code='$mod'");
			$co=getTotalCO($table,""); 
			$eff=0;
			if($rec['r']){
				//تحديد نمط الحقل
				$sql="select * FROM INFORMATION_SCHEMA.COLUMNS where TABLE_NAME = '$table' and COLUMN_NAME = '$col_name$lg'";
				$res=mysql_q($sql);
				$r=mysql_f($res);
				$item_type=$r['COLUMN_TYPE'];
				//جلب اللغات الموجودة
				$langs=get_vals('_langs','lang',"1=1 order by ord asc",'arr');
				//إنشاء الحقل
				$sql="ALTER TABLE $table ADD $col_new_name $item_type";
				mysql_q($sql);
				// (نسخ الداتا (المعالجة حسب نوع الدمج 
				if($type_join==1){
					$sql="update $table set $col_new_name=$col_name$lg";
					mysql_q($sql);
					$eff=mysql_a();
				}
				elseif($type_join==2){
					$sql="update $table set $col_new_name=$col_name$lg where length($col_name$lg)>0 and $col_name$lg is not null";
					mysql_q($sql);
					$eff=mysql_a();
					
					if($eff<$co){
						//$langs=get_vals('_langs','lang',"lang!='$lg'",'arr');
						foreach($langs as $lang){
							if($lang!=$lg){
								$sql="update $table set $col_new_name=$col_name$lang where (length($col_new_name)<=0 or $col_new_name is null) and (length($col_name$lang)>0 and $col_name$lang is not null)" ; 
								mysql_q($sql);
								$eff+=mysql_a();
								if($eff==$co){break;}
							}
						}
					}
				}
				elseif($type_join==3){
					
					$sql="select * from $table";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					$comp=[];
					if($rows){
					   while($r=mysql_f($res)){
						   $id=$r['id'];
						   foreach($langs as $lang){
							    ${$lang}=$r["$col_name$lang"]; 
								$comp[$lang]=mb_strlen(${$lang},"UTF-8");
						   }
						   $max_val=array_keys($comp,max($comp));
						   $join_val=$col_name.$max_val[0];
						   $sql="update $table set $col_new_name='$join_val' where id='$id'";
						   mysql_q($sql);
						   $eff+=mysql_a();
					   }
					}
					
				}
			}
			$join_cols_name='';
			foreach($langs as $lang){
				if($join_cols_name!=''){$join_cols_name.=' , ';}
				$join_cols_name.=$col_name.$lang;
			} 
			echo '
				<div class="pd10 f1 clr5 fs18 lh40"> '.k_merge_done_results_show.':</div>
				<table width="100%" class="fTable" cellpadding="5" cellspacing="2" type="static">
					<tr>
						<td width="30%" class="f1 fs14 clr1111 lh20">'.k_table.' :</td>
						<td><div class="fs14 lh20 fl" dir="ltr">'.$table.'</div></td>
					</tr>
					<tr>
						<td class="f1 fs14 clr1111 lh20">'.k_merged_lang_cols.': </td>
						<td><div class="fs14 lh20 fl" dir="ltr">'.$join_cols_name.'</div></td>
					</tr>
					<tr>
						<td class="f1 fs14 clr1111 lh20">'.k_merge_generated_col.': </td>
						<td><div class="fs14 lh20 fl" dir="ltr">'.$col_new_name.'</div></td>
					</tr>
					<tr>
						<td class="f1 fs14 clr1111 lh20">'.k_tot_table_rows.':</div></td>
						<td><ff class="lh20 cbg555 pd10">'.$co.'</ff> '.k_lin.'</td>
					</tr>
					<tr>
						<td class="f1 fs14 clr1111 lh20">'.k_merge_affected_lines.':</td>
						<td><ff class="lh20 cbg555 pd10">'.$eff.'</ff> '.k_lin.'</td>
					</tr>
				  </table>
				<div style="margin-top:10px;" id="post_proc_join" class="fl pd10 f1 clr5 fs18 lh40">
					<div class="fl pd10 f1 clr5 fs18 lh40">'.k_wld_del_lang_cols.'</div>
					<div class="fl mg10 Over cbg5 f1 clrw TC fs14 B lh40" fix="h:40|w:100"  onclick="lang_field_del()">'.k_delete.'</div>
				</div>';
		}
		
	}
	elseif($status=='del'){
		if(isset($_POST['item'])){
			$ok=1;
			$item=pp($_POST['item'],'s');
			$rec=getRecCon('_modules_items',"code='$item'");
			$col_name=str_replace('(L)','',$rec['colum']);
			$col_new_name=trim(str_replace('_(L)','',$rec['colum']));
			$mod=$rec['mod_code'];
			$table=get_val_con('_modules','table',"code='$mod'");
			$langs=get_vals('_langs','lang',"1=1",'arr');
			foreach($langs as $lang){
				$sql="alter table $table drop column $col_name$lang";
				if(!mysql_q($sql)){$ok=0; break;}
			}
			if($ok){
				$sql="update _modules_items set colum='$col_new_name',lang='0' where code='$item'";
				mysql_q($sql);
				if(mysql_a()==1){echo 1;}
			}			
		}
		
	}

}?>