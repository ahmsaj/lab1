<? include("../../__sys/prcds/ajax_header.php");?> 
<div class="win_body"> 
    <div class="form_body so"><?
    if(isset($_POST['id'])){
        $id=pp($_POST['id']);
		if($id){
			$mod='87zc6kbbs5';
			$mod_data=loadModulData($mod);
			$cData=getColumesData($mod);
			$table=$mod_data[1];
			$sql="select * from $table where id='$id' limit 1";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$r=mysql_f($res);?>
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
							$val=$r[$fils[$f]]?>
							<tr><td n><?=get_key($fils_name[$f]);?>:</td>
							<td><?=viewRecElement($data,$val)?></td></tr><?
						}					
					}
				}?>
				</table><?
                // list($des,$notes)=get_val('gnr_m_patients','des,notes',$id);
                // if($des){
                //     echo '<div class="f1 fs14 lh30 ">'.k_descraption.':<br>'.$des.'</div>';
                // }
                // if($notes){
                //     echo '<div class="f1 fs14 lh30 ">'.k_notes.':<br>'.$notes.'</div>';
                // }
                
			}
		}
    }?>
    </div>
    <div class="form_fot fr">
	    <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <? if(modPer('87zc6kbbs5',2)){//edit patient?>
		    <div class="bu bu_t1 fl" onclick="editPatDoc(<?=$id?>);"><?=k_edit?></div>
        <?}?>
	</div>
</div>