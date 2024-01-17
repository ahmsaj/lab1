<? session_start();/***XRY***/
header("Content-Type: text/css");
include('../../__sys/dbc.php');
include('../../__sys/f_funs.php');
include('../../__sys/cssSet.php');
include('../../__main/cssSet.php');?>
<style>
start{}
/***dicom***/
.ic_checked{
		background-color: <?=$clr1?>;
		background-image:url(images/dcm_checked.png);
		position: relative;
		width:18px;
		height: 18px;
		border-radius: 2px;
		margin: 3px;
		background-position: center center;
		background-repeat: no-repeat;
	}
.ic_err{
	background-color: <?=$clr5?>;
	background-image:url(images/err_dcm.png);
	position: relative;
	width:18px;
	height: 18px;
	border-radius: 2px;
	margin: 3px;
	background-position: center center;
	background-repeat: no-repeat;

}
.ic_dicom_file{
	background-image:url(images/dcm_file.png);
	background-color:black;
}

#content{
	border:2px #ccc dashed;
	margin-top:10px;
}
#listing div[txt]{
	color:<?=$clr1?>;
	position:absolute;
	top:40%;
}
#listing div[img]{
	position:absolute;
	right:45%;
	margin-left:45%;
	top:50%;

}
.err_dcm{
	margin-<?=$align?>:40px;
	font-size: 12px;
	color:<?=$clr5?>;
	font-family:'f1',Tahoma;
}

.ic_dicom_sync{background-image:url(images/dcm_synch.png);}
.ic_dicom_crush{background-image:url(images/dcm_crush.png);}
.ic_dicom_studies{background-image:url(images/dcm_studies.png);}
.ic_dicom_series{background-image:url(images/dcm_series.png);}
.ic_dicom_details{background-image:url(images/list_icon.png);}
.ic_dicom_edit{background-image:url(images/exc_report_icon.png);}
.ic_dicom_view2{background-image:url(images/dcm_view_icon.png);}
.ic_dicom_view{
	background-color:<?=$clr1?>;
	position: relative;
	width:18px;
	height: 18px;
	border-radius: 2px;
	margin: 3px;
	background-position: center center;
	background-repeat: no-repeat;
	background-image:url(images/dcm_view.png);
}
	
.ic_dicom_edit_name{
	background-image:url(images/dcm_edit_name.png);
}

div[count]{
	height:30px;
	border-radius:20px;
	background-color: #E21DAA;
	margin-top:10px;
}

.center {
	margin-left:auto;
	margin-right:auto;
  }
.centerPH {
	padding-top:auto;
	paddin-bottom:auto;
  }
.studies_list{
	border:1px #5F9FAE solid;
	border-bottom: 2px #5F9FAE solid;
	border-radius: 1px;
	margin-bottom: 10px;
	cursor: pointer;
	margin:10px;
}
	.studies_list > div[tit]{
		border-bottom: 1px #5F9FAE solid;
		color:<?=$clr1111?>;
		line-height: 30px;
	}
.studies_list div[att]{padding-top:10px; line-height: 25px;}
/*.studies_list[act] div[att]{background-color:#0D646B;}*/
.b_bord_dashed{border-bottom: 2px #ebf3f5 dashed;}
.series_list > div{
	box-sizing: border-box;
	border: 1px #ccc solid;
	border-<?=$align?>: 5px #ccc solid;
	margin: 5px;
	padding: 5px;
	cursor: pointer;
	border-radius: 1px;
}

.winButts2{
	float:right;
	height:48px;
	position:absolute;
	z-index:500;
	<?=$Xalign?>:0;
	top:0;
}
.winButts2 > div{	
	height:48px;
	line-height:48px;
	width:48px;
	border-<?=$align?>:1px <?=$clr111?> solid;
	background-position:center center;
	background-repeat:no-repeat;
	float:<?=$Xalign?>;
}
.winButts2 > div:hover{background-color:<?=$clr1111?>; cursor:pointer;}	
.dcm_error{
	background-color: <?=$clr5?>;
	background-image:url(images/dcm_error.png);
	position: relative;
	width:80px;
	height:80px;
	background-position: center center;
	background-repeat: no-repeat;
	margin-left: auto;
	margin-right: auto;

}
#dcm_loader{
	position:absolute;
	background-color:rgba(234,239,77,0.8);
	line-height:80px;
	width:100%;
	z-index:100;
	display:none;
	top: 40%;
}
</style>