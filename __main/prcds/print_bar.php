<? include("../../__sys/prcds/ajax_header.php");
$portName='com3';$baudRate=9600;$bits=8;$spotBit=1;
const NUL="\x00";const LF="\x0a";const ESC="\x1b";const FS="\x1c";const FF="\x0c";const GS="\x1d";const DLE="\x10";const EOT="\x04";
if(isset($_POST['t'] , $_POST['id'])){
	echo $type=pp($_POST['t']);
	echo $id=pp($_POST['id']);
	/********************************************************/		
	function echoFlush($string){echo $string . "\n";flush();ob_flush();}
	if(!extension_loaded('dio')){
	echoFlush("PHP Direct IO does not appear to be installed for more info see: http://www.php.net/manual/en/book.dio.php");exit;}try{
	$bbSerialPort="";	
	echoFlush("Connecting to serial port: {$portName}");	
	if (strtoupper(substr(PHP_OS,0,3))==='WIN'){ 
		$bbSerialPort=dio_open($portName,O_RDWR);
		exec("mode {$portName} baud={$baudRate} data={$bits} stop={$spotBit} parity=n xon=on");
	}else{
		$bbSerialPort = dio_open($portName, O_RDWR | O_NOCTTY | O_NONBLOCK );
		dio_fcntl($bbSerialPort, F_SETFL, O_SYNC);			
		dio_tcsetattr($bbSerialPort, array('baud'=>$baudRate,'bits'=>$bits,'stop'=>$spotBit,'parity'=>0));
	}if(!$bbSerialPort){echoFlush( "Could not open Serial port {$portName} ");exit;}
	/********************************************************/
	/********************************************************/
	/********************************************************/
	if($type==1){
		if($thisGrp=='buvw7qvpwq'){
			$id_no=convTolongNo($id,7);
			$sql="select * from gnr_m_patients where id='$id'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$r=mysql_f($res);
				$f_name=$r['f_name'];
				$l_name=$r['l_name'];
				$ft_name=$r['ft_name'];
				$mother_name=$r['mother_name'];
				$no=$r['no'];
				$mobile=$r['mobile'];
				$birth_date=$r['birth_date'];
				$print_card=$r['print_card'];
				$last_print=$r['last_print'];
				$sex=$r['sex'];
				$phone=$r['phone'];
				$date=$r['date'];			
				if($print_card==0 && (($now-$last_print)>60000)){exit;}
				/****************CardPars******/
				$pName=$f_name.' '.$ft_name.' '.$l_name;
				$pName=iconv("UTF-8","Windows-1256//TRANSLIT",$pName);
				$pNo=$id_no;
				$birth_date;
				$mobile;
				/****************CardCode******/
				/*هون حط الكود معلم*/
				$dataToSend = "--test EAN-13 barcode wide--\n";
				$dataToSend .= "\x1d\x77\x04";   # GS w 4
				$dataToSend .= "\x1d\x6b\x03";   # GS k 2 
				$dataToSend .= "59012341\x00";  # [data] 00
				$dataToSend .= "-end-\n";
				$dataToSend .=chr(10);			
				$dataToSend .=chr(10).chr(10).chr(10).chr(10).chr(27).chr(105);				
			}	
		}
	}
	/********************************************************/
	if($type==2){
		if($thisGrp=='pfx33zco65'){
			resetRles();
			$id_no=convTolongNo($id,8);
			$sql="select * from cln_x_visits where id='$id' and status!=3 ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$r=mysql_f($res);
				addPay($id,1);
				$clinic=$r['clinic'];
				$cType=get_val('gnr_m_clinics','type',$clinic);
				$role_no=addRoles($id,$cType);
				if($role_no){
					$clinic=$r['clinic'];
					$clinic_code=get_val('gnr_m_clinics','code',$clinic);
					$d_start=$r['d_start'];
					if(_set_2lgaamrmla){
						$image=getImages(_set_2lgaamrmla);
						$file=$image[0]['file'];
						$folder=$image[0]['folder'];
						list($w,$h)=getimagesize("sData/".$folder.$file);
						$fullfile=$m_path.'upi/'.$folder.$file;
						//echo '<img src="'.$fullfile.'" />';
					}
					/****************Tik Pars******/
					$Title=_info_7dvjz4qg9g;
					$logo=$fullfile;
					$barCodeToShow=$clinic_code.'-'.$role_no;
					$barCodeToPrint=$id_no;
					$clinic_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
					$date=dateToTimeS3($d_start);
					$mount=number_format(get_sum('cln_x_visits_services','pay_net'," visit_id ='$id' and status!=3")).' '.k_sp;
					$note=_info_0e7tea245s;
					/****************Tik Code******/
					/*هون حط الكود معلم*/
					$dataToSend = "--test EAN-13 barcode wide--\n";
					$dataToSend .= "\x1d\x77\x04";   # GS w 4
					$dataToSend .= "\x1d\x6b\x03";   # GS k 2 
					$dataToSend .= "59012341\x00";  # [data] 00
					$dataToSend .= "-end-\n";
					$dataToSend .=chr(10);			
					$dataToSend .=chr(10).chr(10).chr(10).chr(10).chr(27).chr(105);				
				}
			}
		}
	}
	/********************************************************/
	/********************************************************/
	/********************************************************/
	echoFlush( "Writing to serial port data: \"{$dataToSend}\"" );
	$bytesSent = dio_write($bbSerialPort, $dataToSend );
	echoFlush( "Sent: {$bytesSent} bytes" );
	echoFlush("Closing Port");	
	dio_close($bbSerialPort);
	}catch (Exception $e){echoFlush(  $e->getMessage() );exit(1);}
}?>