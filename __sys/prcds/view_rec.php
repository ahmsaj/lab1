<? include("ajax_header.php");
if($chPer[4]){
	if(isset($_POST['mod'] , $_POST['id'])){
		$mod=pp($_POST['mod'],'s');	
		$id=pp($_POST['id']);
		$mod_data=loadModulData($mod);
		$cData=getColumesData($mod,0,0,'act<2');
		$table=$mod_data[1];
		$sql="select * from $table where id='$id' limit 1";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);?>
	        <div class="win_body"> 
			<div class="form_body so">
            <table class="fTable" cellpadding="0" cellspacing="0" border="0">
            <? 			
			foreach($cData as $data){
				$fils=array();
				$fils_name=array();
				if(!in_array($data[3],array(10,12,15)) && !($mod_data[12]==1 && $data[1]==$mod_data[3])){									
					if($data[9]==1){
						$l=0;
						foreach($lg_s as $ls){
							array_push($fils,str_replace('(L)',$ls,$data[1]));
							array_push($fils_name,get_key($data[2]).' <b>( '.$lg_n[$l].')</b>');
							$l++;
						}		
					}else{array_push($fils,$data[1]);array_push($fils_name,$data[2]);}
					for($f=0;$f<count($fils);$f++){	
						if($data[6] || $data['act']){
							$val=$r[$fils[$f]]?>
							<tr><td n><?=get_key($fils_name[$f]);?>:</td>
							<td><?=viewRecElement($data,$val,$id)?></td></tr><?
						}
					}					
				}
			}?>
            </table>            
            </div>
            <div class="form_fot fr">
                <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="<?=$wlp?>win('close','#m_info');"><?=k_close?></div>
            </div>
			</div><?
		}
	}
}else{out();}?>