<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){
	$type=pp($_GET['type']);
	$id=pp($_GET['id']);
	$thisCode=$type.'-'.$id;
	$pageSize='print_page5';    
    $style_file=styleFiles('P');
    $headerHi=_set_76nyqowzwb;
    $headerImg=_set_2lgaamrmla;
    /*******Set*******/
    if($type==1){
        $titlee=k_precpiction;
        $headerImg=_set_f4uxc868xc;
    }
    /*****header*********/
    if($headerImg){
        $image=getImages($headerImg);
        $file=$image[0]['file'];
        $folder=$image[0]['folder'];
        list($w,$h)=getimagesize("sData/".$folder.$file);
        $fullfile=$m_path.'upi/'.$folder.$file;
        $logo= '<img src="'.$fullfile.'" width="100%"/>';
    }?>
	<head><link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>">
        <div class="<?=$pageSize?>">
            <div class="pageHead of" style="height:<?=$headerHi?>cm "><?=$logo?></div>
            <div class=""><?
            /***************************************************************/
            switch($type){
                case 1:
                    list($doc,$patient)=get_val('gnr_x_prescription','doc,patient',$id);?>                
                    <div class="w100 fl uLine ">    
                        <div class="fl f1s fs16 lh40"><?=get_p_name($patient)?> <span class="fs14"><?=getPatAge($patient)?></span></div>
                        <div class="fr fs16 ff B lh40"><?=date('Y - n - j')?></div>                        
                    </div>
                    <?
                    echo getMdcList($id,1); 
                    $info_doc=presc_info_doctor($thisUser);
					echo '
					<div class="fl2 fs14 f1 lh10 pd10f TC mg10v clr9">
						'.$info_doc['name'].'<br>'.
						 '<span class="f1 fs12 TC" dir="rtl">'.nl2br($info_doc['specialization']).'</span><br>'.
						 '<ff class="fs12 TC">'.$info_doc['mobile'].'</ff>
					</div>';
                    if(_set_rsl9opwx0x){ 
                        $address=_info_477lvyxqhi;//f
                        $mailBox=_info_sozi33uok5;//nf
                        $fax=_info_1gw3l8c7m3;//nf
                        $website=_info_npjhwjnbsh;//nf
                        $email=_info_lktpmrxb64;//nf
                        $phone=_info_r9a7vy4d6n;///f
                        $head_ph=_set_f4uxc868xc;///nf
                        $footData=array();                        
                        if($address){array_push($footData,''.$address);}
                        if($mailBox){array_push($footData,'صندوق بريد:'.$mailBox);}
                        if($phone){array_push($footData,'الهاتف: '.$phone);} 
                        if($fax){array_push($footData,'فاكس: '.$fax);}
                        if($email){array_push($footData,'البريد الإلكتروني: '.$email);}
                        if($website){array_push($footData,'الموقع الالكتروني: '.$website);}
                        $footTxt='';
                        if(_info_dj6u8h73va){$footTxt='<div>'._info_dj6u8h73va.'</div>';}
                        echo '<div class="print_page5_footer fs14 TC lh20 clr9" sheet_foot >'.$footTxt.'
                        '.implode(' - ',$footData).'</div>';                                            
                    }
                break;
            }
            /*********************************************/?>
            </div>
        </div>
    </body>
    <script>window.print();setTimeout(function(){window.close();},500);</script><?
}?>