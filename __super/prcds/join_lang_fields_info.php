<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
	$opr=pp($_POST['opr']);
	$id=pp($_POST['id'],'s');
	if($opr==1){
		$r=getRecCon('_modules',"code='$id' ");
		if($r['r']){
			$module=$r['module'];
			$title=$r['title_'.$lg];
			echo '<div class="f1 fs18 lh40 clr1">'.$title.'
			<span class="ff B fs16 "> ( '.$module.' )</span></div>';
			$sql="select * from _modules_items where mod_code='$id' and lang=1 ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				echo '<div class="f1 fs14 lh40 ">'.k_choose_merge_field.'</div>';
				while($r=mysql_f($res)){
					$c_code=$r['code'];
					$colum=$r['colum'];
					echo '<div class="bu buu bu_t1" onclick="addModTojoinCol(2,\''.$c_code.'\')">'.$colum.'</div><br>';
				}
			}else{
				echo '<div class="f1 clr5 lh30 fs16">'.k_module_no_lang_fields.'</div>';
			}
			echo '^^';
		}
	}elseif($opr==2 || $opr==3){
		$r2=getRecCon('_modules_items'," code='$id'");
		if($r2['r']){
			$mod=$r2['mod_code'];			
			$r=getRecCon('_modules',"code='$mod' ");
			if($r['r']){
				$module=$r['module'];
				$title=$r['title_'.$lg];
				$table=$r['table'];
				if($opr==2){
					echo '
					<div class="ic40x icc1 ic40_ref fr" onclick="addModTojoinCol(2,\''.$id.'\')"></div>
					<div class="f1 fs18 lh40 clr1">'.get_key($title).'
					<span class="ff B fs16 "> ( '.$module.' )</span></div>';
				}
				$r=getRecCon('_modules',"code='$mod' ");
			}
			$colum=$r2['colum'];
			$title=$r2['title_'.$lg];
			$m_col=str_replace('_(L)','',$colum);
			$col_ex=existCol($table,$m_col);
			if($opr==2){
				echo '<div class="f1 fs16 lh30 clr111 uLine">'.k_thfield.' : '.get_key($title).' <span class="ff B fs16 "> ( '.$colum.' )</span></div>';

				if($col_ex){
					echo '<div class="bu bu_t3 buu" onclick="langMrgOpr(2)">'.k_intermediate_del.'</div><br>';
					echo '<div class="bu bu_t1 buu" onclick="langMrgTot(2)">'.k_empty_fields_mrge.'</div><br>';
					echo '<div class="bu bu_t1 buu" onclick="langMrgTot(3)">'.k_equal_fields_merge.'</div><br>';
					echo '<div class="bu bu_t1 buu" onclick="langMrgTot(4)">'.k_lrgr_fields_merge.'</div><br>';
					echo '<div class="bu cbg66 buu" onclick="langMrgTot(5)">'.k_merge_finsh.'</div><br>';
					
				}else{
					echo '<div class="bu bu_t4 buu" onclick="langMrgOpr(1)">'.k_intermidiate_add.'</div>';
				}

				
				echo'^'.modFilterMrg($mod);
			}
			$r=getRecCon('_modules'," code='$mod' ");
			/*******************data*******************/
			if($opr==3){
				$selLang='id';
				if($col_ex){$selLang.=','.$m_col;}
				foreach($lg_s as $l){$selLang.=','.$m_col.'_'.$l;}
				$fil=pp($_POST['fil'],'s');
				$mlf=pp($_POST['mlf'],'s');
				$condtion=sqlFilterCondtions($mod,$fil);
				if($col_ex){
					if($mlf!=''){
						if($mlf==0){
							$mlfQ=" $m_col IS NULL OR $m_col = ' ' ";
						}else{$mlfQ=" $m_col!='' ";}
						if($condtion){
							$condtion.=" AND $mlfQ ";
						}else{
							$condtion=$mlfQ;
						}
					}
				}
				if($condtion){$condtion=' where '.$condtion;}
				$sql="select $selLang from $table $condtion";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				echo '<div class="lh50  f1 fs18">'.k_num_of_rec.' : <ff id="mlTot" >'.number_format($rows).'</ff></div>^';
				if($rows){
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" ><tr>';
					foreach($lg_s as $l){echo '<th class="Over" title="'.k_merge_lang.'" width="600" onclick="langMrgTot(1,\''.$l.'\')"><ff>'.$m_col.'_'.$l.'</ff></th>';}
					if($col_ex){echo '<th width="600"><ff>'.$m_col.'</ff></th>';}
					while($r=mysql_f($res)){
						$rec_id=$r['id'];
						echo '<tr id="tr_'.$rec_id.'">';
						foreach($lg_s as $l){	
							$colTxt=$r[$m_col.'_'.$l];
							echo '<td id="td_'.$l.'_'.$rec_id.'" lg="'.$l.'" class="Over" onclick="lgMrgRec('.$rec_id.',\''.$l.'\')">'.$colTxt.'</td>';
						}
						if($col_ex){echo '<td id="td_'.$rec_id.'">'.$r[$m_col].'</td>';}
						echo '</tr>';
					}
					echo '</tr></table>';
				}else{
					echo '<div class="f1 fs18 clr5 lh40">'.k_no_data.' </div>';
				}
			}
		}
	}
}?>