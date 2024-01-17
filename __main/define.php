<?
$projectVersion='7.0.1';
/******Images Files*******/
$_defImgTyp=['jpg','jpeg','png','gif','svg'];

$_img_multi=0;
$_img_width=1000;
$_img_height=1000;
//-----Images Taypes
$__imgRTypes =[];
$__imgRTypes['jpg']=['image/jpg','image/jpeg'];
$__imgRTypes['JPG']=['image/jpg','image/jpeg'];
$__imgRTypes['jpeg']=['image/jpg','image/jpeg'];
$__imgRTypes['JPEG']=['image/jpg','image/jpeg'];
$__imgRTypes['gif']=['image/gif'];
$__imgRTypes['GIF']=['image/gif'];
$__imgRTypes['png']=['image/png'];
$__imgRTypes['PNG}']=['image/png'];
$__imgRTypes['svg']=['image/svg+xml'];
$__imgRTypes['SVG']=['image/svg+xml'];
/***********************************************************************/
//-----Uploade Images Fileds
$uploadImagesFileds=array();//[extintion,Multi,with,hegiht]]
$uploadImagesFileds['xryPhoto']=['','0','5000','5000'];
$uploadImagesFileds['promo']=['','0','5000','5000'];// <--Ex.
/***********************************************************************/
//-----Object List
$objectListSetFileds=array();
//----$objectListSetFileds['CODE'][0]=['TITLE','NAME','TYPE','ADD VALUES','LANG'];
//----Types=text,textarea,list,act
$objectListSetFileds['denCln'][0]=[k_status,'status','list','1: '.k_not_specified.',2:'.k_norm.',3: '.k_not_norm,'0'];
$objectListSetFileds['denCln'][1]=[k_extra_text,'show','act','1','0'];


/***********************************************************************/
$mail_actCode_title=' ';
?>