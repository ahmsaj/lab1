<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
	$opr=pp($_POST['opr']);
	$id=pp($_POST['id'],'s');
	$fil=pp($_POST['fil'],'s');
	$mlf=pp($_POST['mlf']);
	$mLg=pp($_POST['lg'],'s');

	$r2=getRecCon('_modules_items'," code='$id'");
	if($r2['r']){
		$mod=$r2['mod_code'];
		$colum=$r2['colum'];
		$r=getRecCon('_modules',"code='$mod' ");
		if($r['r']){			
			$table=$r['table'];			
			$m_col=str_replace('_(L)','',$colum);
			$col_ex=existCol($table,$m_col);
			if($col_ex){
				if($opr==5){										
					foreach($lg_s as $l){
						$lCol=$m_col.'_'.$l;
						mysql_q("alter table $table drop column $lCol");
					}
					mysql_q("update _modules_items set colum='$m_col',lang='0' where code='$id'");
					echo 1;					
				}else{
					$selLang='id';
					if($col_ex){$selLang.=','.$m_col;}
					foreach($lg_s as $l){$selLang.=','.$m_col.'_'.$l;}
					$condtion=sqlFilterCondtions($mod,$fil);				
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

					if($opr==2){
						if($condtion){$condtion.=" AND ";}
						$qc='';
						foreach($lg_s as $l){
							if($qc){$qc.=' OR ';}
							$qc.=$m_col.'_'.$l.'=\'\' ';
						}
						$condtion.=" ( $qc ) ";					
					}
					if($opr==3){
						if($condtion){$condtion.=" AND ";}
						$qc='';
						$m_val='';
						foreach($lg_s as $l){
							if($qc){$qc.=' = ';}
							$qc.=$m_col.'_'.$l.' ';
							$m_val=$m_col.'_'.$l;
						}
						$condtion.="  $qc  ";					
					}
					if($condtion){$condtion=' where '.$condtion;}
					if($opr==1){
						$m_val=$m_col.'_'.$mLg;					
						mysql_q("UPDATE `$table` SET `$m_col`=$m_val $condtion ");					
					}
					if($opr==2 || $opr==4){
						$sql="select $selLang from $table $condtion";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows){
							while($r=mysql_f($res)){
								$rec_id=$r['id'];
								if($opr==2){
									$m_val='';
									foreach($lg_s as $l){	
										if($r[$m_col.'_'.$l]){$m_val=$r[$m_col.'_'.$l];}
									}
									if($m_val){								
										mysql_q("UPDATE `$table` SET `$m_col`='$m_val' where id='$rec_id' ");
									}
								}
								if($opr==4){
									$m_val='';
									foreach($lg_s as $l){
										$thisVal=$r[$m_col.'_'.$l];
										if(mb_strlen($thisVal,"UTF-8")>mb_strlen($m_val,"UTF-8")){
											$m_val=$thisVal;
										}
									}
									if($m_val){								
										mysql_q("UPDATE `$table` SET `$m_col`='$m_val' where id='$rec_id' ");
									}
								}
							}					
						}
					}
					if($opr==3){					
						mysql_q("UPDATE `$table` SET `$m_col`=$m_val $condtion ");					
					}
					echo 1;
				}
			}
		}
	}
}?>