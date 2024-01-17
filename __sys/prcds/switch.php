<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['f'] , $_POST['r'] , $_POST['v'])){
	$f=pp($_POST['f'],'s');
	$r=pp($_POST['r']);	
	$v=pp($_POST['v'],'s');
	$id=pp($_POST['id'],'s');
	list($c,$p)=get_val_c('_modules_items','mod_code,prams',$f,'code');
	$pp=explode('|',$p);	
	$code=get_val_c('_modules_list','code',$c,'mod_code');
	$ch=checkPer($code);	
	if($ch[0] && $ch[2]){	
		$t=get_val_c('_modules','table',$c,'code');
		$cData=getColumesData($code,1,$f);
		$c=$cData[$f][1];
		if($pp[1]==1){
			if(mysql_q("UPDATE `$t` set `$c`=$v where id='$r'")){echo 1;}
		}else{
			if(get_val($t,$c,$r)==0){
				if(mysql_q("UPDATE `$t` set `$c`=0 ")){
					if(mysql_q("UPDATE `$t` set `$c`=1 where id='$r'")){echo 2;}
				}
			}
		}
	}else{echo out();}
}?>