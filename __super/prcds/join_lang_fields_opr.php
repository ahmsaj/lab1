<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
	$opr=pp($_POST['opr']);
	$id=pp($_POST['id'],'s');
	$r2=getRecCon('_modules_items'," code='$id'");
	if($r2['r']){
		$mod=$r2['mod_code'];			
		$r=getRecCon('_modules',"code='$mod' ");
		if($r['r']){
			$module=$r['module'];
			$title=$r['title'];
			$table=$r['table'];
		}
		$colum=$r2['colum'];
		$title=$r2['title'];
		$col_type=$r2['type'];
		$m_col=str_replace('_(L)','',$colum);
		$col_ex=existCol($table,$m_col);
		if($opr==1){
			if(!$col_ex){
				if($col_type==1){
					$t=" varchar(255) ";
				}else{
					$t=" TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ";
				}
				mysql_q("ALTER TABLE `$table` ADD `$m_col` $t ");
			}
		}
		if($opr==2){
			if($col_ex){
				mysql_q("ALTER TABLE `$table` DROP `$m_col`");
			}
		}
		if($opr==3){
			$rec=pp($_POST['rec']);
			$recLg=pp($_POST['lg'],'s');			
			if(mysql_q("UPDATE `$table` SET `$m_col`=".$m_col."_$recLg where id='$rec' ")){
				echo 1;
			}
		}
	}
}?>