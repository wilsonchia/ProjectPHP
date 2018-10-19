<?php require_once "SystemDetailC.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<script type="text/javascript" src="/jquery-3.3.1.js"></script>
<script type="text/javascript" src="/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/notify.js"></script>
<script language="javascript" type="text/javascript" src="jsPublic.js"></script>
<script type="text/javascript" src="jsSystemDetail.js"></script>
<link rel="stylesheet" rev="stylesheet" href="/Style.css" type="text/css" media="all" />

<body><center>
	<form name="FormData" id="FormData" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
		<input type="hidden" id="hideStep" name="hideStep" />
        <input type="hidden" name="hideClass" id="hideClass" /><input type="hidden" name="hideValue" id="hideValue" />
        <input type="hidden" name="hideTitle" id="hideTitle" /><input type="hidden" name="hideNotation" id="hideNotation" />
        <input type="hidden" name="hideRemark" id="hideRemark" /><input type="hidden" name="hideStatus" id="hideStatus" />
        <table style="width:1000px;" border="0" cellpadding="0" cellspacing="0">
        	<tr><td style="width:100%; text-align:center">
			<?php	$classDetail = new classSystemDetail();
					$valStep = ($_POST["hideStep"] == "") ? "L" : $_POST["hideStep"];
					switch ($valStep)
					{
						case "L" : echo $classDetail->FormDataList(); break;
						case "I" : echo $classDetail->FormDataInsert(); break;
						case "N" : echo $classDetail->ExecuteDataNew(); break;
						case "U" : echo $classDetail->FormDataUpdate(); break;
						case "M" : echo $classDetail->ExecuteDataMod(); break;
						case "D" : echo $classDetail->ExecuteDataDelete(); break;
						case "F" : echo $classDetail->ExecuteDataUpload(); break;
						case "O" : echo $classDetail->ExecuteDataOutExcel(); break;
					}
			?>
			</td></tr>
        </table> 
		<div id="sModel" class="modal" onclick ="$('.modal').hide();"  style="display:none;">
           <div class ="modal_body">
               <div class ="modal_title"></div>
               <div style ="padding-top:10px"></div>
               <div class ="modal_content"></div>
               <div style ="padding-top:10px"></div>
           </div>
       </div>  
	</form>
</center></body></html>