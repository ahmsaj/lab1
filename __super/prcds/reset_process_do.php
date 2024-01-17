<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$type=pp($_POST['type'],'s');
	if($type=='prog'){
		if(isset($_POST['prog'])){
			$progs=pp($_POST['prog'],'s');
			$progs=explode(',',$progs);
			foreach($progs as $prog){
				$co="";
				$sql="select * from _modules where sys=0 and progs='$prog'";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$mod=$r['code'];                    
					$lk_tables=$r['lk_tables'];
					$table=$r['table'];
					$exFile=$r['exFile'];
					//if($table[0]!='_'){
						reset_modules_delete($mod);
					//}
				}
				//------
				$sql="select * from _modules_ where sys=0 and progs='$prog'";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$mod=$r['code'];
					$lk_tables=$r['lk_tables'];
					$table=$r['table'];
					$mod_file=$r['file'];
					if($mod_file[0]!='_' && !in_array($mod_file,$mod_files_gnr) ){
						reset_add_modules_delete($mod,1);
					}
				}
				//--------------
				$exFiles_gnr_s="'".implode("','",$exFiles_gnr)."'";
				$exFiles=get_vals('_modules_files_pro','code',"prog = '$prog' ");
				reset_ajax_file($exFiles);
				//--------------
				$sql="select TABLE_NAME from information_schema.TABLES where TABLE_NAME like '$prog"."_%' and TABLE_SCHEMA='"._database."'";
				$res=mysql_q($sql);
				$tables='';
				while($r=mysql_f($res)){
					if($tables!=''){$tables.=',';}
					$tables.=$r['TABLE_NAME'];
				}
				//echo $tables.'<br>';
				reset_tables_delete($tables);
				//-------
				$groups=get_vals('_groups','code',"pro='$prog'");
				$groups="'".str_replace(',',"','",$groups)."'";
				reset_group_delete($groups);
				//-------
				$info=get_vals('_information','code',"pro='$prog'");
				$info="'".str_replace(',',"','",$info)."'";
				reset_info_delete($info);
				//----------
				$settings=get_vals('_settings','code',"pro='$prog'");
				$settings="'".str_replace(',',"','",$settings)."'";
				reset_settings_delete($settings);
				//--------
				reset_program_delete($prog);
			}
		}
	}if($type=='mod'){
		if(isset($_POST['sel'],$_POST['lk'],$_POST['ex'])){
			$sel=$_POST['sel'];
			$lk=$_POST['lk'];
			$ajax=$_POST['ex'];
			$ok=1;
			foreach($sel as $mod){
				if(reset_modules_delete($mod)){
					if($lk[$mod]){reset_tables_delete($lk[$mod]);}
					if($ajax[$mod]){reset_ajax_file($ajax[$mod]);}
				}else{$ok=0; break;}
			}
			echo $ok;
		}
	}elseif($type=='mod_'){
		if(isset($_POST['sel'],$_POST['lk'],$_POST['ex'],$_POST['mod_file'])){
			$sel=$_POST['sel'];
			$lk=$_POST['lk'];
			$ajax=$_POST['ex'];
			$mod_file=$_POST['mod_file'];
			$ok=1;
			foreach($sel as $mod){
				$delete_file=0;
				if($mod_file[$mod]){$delete_file=1;}
				if(reset_add_modules_delete($mod,$delete_file)){
					if($lk[$mod]){reset_tables_delete($lk[$mod]);}
					if($ajax[$mod]){reset_ajax_file($ajax[$mod]);}
				}else{$ok=0; break;}
			}
			echo $ok;
		}
	}elseif($type=='group'){
		if(isset($_POST['sel'])){
			$sel=$_POST['sel'];
			echo $groups="'".implode("','",$sel)."'";
			echo reset_group_delete($groups);
		}
	}elseif($type=='opr'){
		if(isset($_POST['opr'])){            
			$opr=pp($_POST['opr']);
			if($opr==1){
                $file='funs.js';
                $tmp_content='function alert_function(){	
	$(\'#alert_win\').dialog(\'close\');
	switch(alert_no){
		//case 1:fun(alert_data);break;		
	}
	fixPage();
}
function refPage(s,time){
	thisTime=time;
	clearTimeout(ref_page);
	busyReq=chReqStatus();
	if(winIsOpen()==0 && busyReq==0){
		switch(s){
			//case \'1\':fun(0);break;
		}
	}else{thisTime=800;}
	ref_page=setTimeout(function(){refPage(s,time)},thisTime);
}
function CLE(s,filed,val){//Custom List Event	
	switch(s){
		//case \'1\':fun(val);break;
	}
}
//---------------------------------------------------------------------------------	
function DuplEntry(id){ 
	win(\'close\',\'#opr_form0\');
	/*loadWindow(\'#m_info\',1,\'title\',600,0);
	$.post(f_path+"X/path.php",{id:id}, function(data){
		d=GAD(data);
		$(\'#m_info\').html(d);
		fixForm();
	})	*/
}
function print_(pro,type,id){
	url=f_path+\'Print-\'+pro+\'/T\'+type+\'-\'+id;popWin(url,800,600);
} 
function fixPage_add(){
	var CSI_H=hhh-141;
	var CSI_W=www;
	//---------For Project ---------------------	
}
//---------Pablic Project function ----------------------------------------------
';				
                $path='../../__main/'.$file;                		
				$objFile= fopen($path, "w") or die("Unable to open file!");
				fwrite($objFile,$tmp_content);
				fclose($objFile);
            }
            if($opr==2){				
				$file='funs.php';
				$tmp_content='<?
function indexStartFuns(){
    
}
function getCustomFiled($r,$val){
	global $mod_data;
	switch ($val){		
		//case \'1\':return fun($id);break;	
	}
}
function getCustomFiledIN($opr,$fun,$id,$val,$filed=\'\'){
	global $mod_data;
	switch ($fun){
		//case \'1\':return fun($id,$opr,$filed,$val);break;
	}
}
function modEvents($fun,$id,$event_no){
	global $mod_data;
	switch ($fun){
		//case \'1\':return fun($id);break;
	}
}
function addFunctionsTime(){
	global $thisGrp,$MO_ID;
}
//---------Pablic Project functionS ----------------------------------------------
?>';
                $path='../../__main/'.$file;                		
				$objFile= fopen($path, "w") or die("Unable to open file!");
				fwrite($objFile,$tmp_content);
				fclose($objFile);
			}
            if($opr==3){
                $sql="select * from _modules_list where type in(0,3)";
                $res=mysql_q($sql);
                while($r=mysql_f($res)){
                    $id=$r['id'];
                    $type=$r['type'];
                    $code=$r['code'];
                    
                    if($type==3){                        
                        mysql_q("DELETE from _modules_list where id='$id'");
                    }else{
                        echo $subMenu=getTotalCo('_modules_list',"p_code='$code'");
                        echo '-';
                        if($subMenu==0){                            
                            mysql_q("DELETE from _modules_list where id='$id'");
                        }
                    }
                }
            }
            if($opr==4){
                mysql_q("DELETE from _perm where type=1 and g_code NOT IN(select code from _groups )");
                mysql_q("DELETE from _perm where type=2 and g_code NOT IN(select code from _users )");
                mysql_q("DELETE from _perm where m_code NOT IN(select `code` from _modules_list)");
            }
            if($opr==5){
                mysql_q("DELETE from _fav_list where p_type=1 and g_code NOT IN(select code from _groups )");
                mysql_q("DELETE from _fav_list where p_type=2 and g_code NOT IN(select code from _users )");
                mysql_q("DELETE from _fav_list where m_code NOT IN(select `code` from _modules_list)");
            }
            if($opr==6){
                $table=['_ex_col','_help_hints','_indexes','_lists_achieve','_log_his','_log_opr','_maintenance','_p404','_q_time','_sys_alerts','_sys_alerts_items','_backup'];
                foreach($table as $table){
                    mysql_q("TRUNCATE $table");    
                }
            }
			echo 1;
		}
	}
}