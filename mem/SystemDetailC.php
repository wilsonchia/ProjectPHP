<?php date_default_timezone_set('Asia/Taipei'); 		?>
<?php require_once "../myConnDB.php"; 					?>
<?php require_once "classPublic.php";		    		?>
<?php require_once "../PHPExcel.php"; 					?>
<?php require_once "../PHPExcel/Writer/Excel2007.php";  ?>
<?php require_once "../PHPExcel/IOFactory.php"; 		?>
<?php 
	class classSystemDetail {
		
		function FormDataList()
		{
			$textSearchValue = $_POST["textSearch"];
			$QuerySearch = ""; 
			if ($textSearchValue != ""){ $QuerySearch = " and ( SystemClass LIKE  '%" . $textSearchValue . "%' or SystemValue LIKE  '%" . $textSearchValue . "%' or SystemTitle LIKE  '%" . $textSearchValue . "%' )";}
			$myConn = new classMySqlDataBase();
			$funcQuerySQL = sprintf("select * from SystemDetail where 1=1 %s Order by SystemClass asc", $QuerySearch);
			$DataTableReturn = $myConn->returnResultQueryDataDetail($funcQuerySQL);
			$FinalDataRows = mysql_num_rows($DataTableReturn);
			$PageDataRows = 30;			
			if (is_int($FinalDataRows / $PageDataRows) == ""){
				$FinalPageCount = ceil($FinalDataRows / $PageDataRows);
			} else {
				$FinalPageCount = $FinalDataRows / $PageDataRows;
			}
			$PageNowIndex = 0; if ($_POST["hidePageIndex"] == ""){$PageNowIndex = 1; } else { $PageNowIndex = $_POST["hidePageIndex"]; }
			$PagePrevIndex = 0; if ($_POST["hidePageIndex"] == ""){$PagePrevIndex = 0;} else { $PagePrevIndex = $PageNowIndex - 1;} 
			$PageNextIndex = 0; if ($_POST["hidePageIndex"] == ""){$PageNextIndex = 0;} else { $PageNextIndex = $PageNowIndex + 1;} 
			if ($PageNowIndex == 1 ) { $LimitBeginIndex = 0; } else {$LimitBeginIndex = ($PageNowIndex-1) * $PageDataRows;}		
?>
			<script type="text/javascript">
			
				$(function(){
					
					 $('#btnDataIns').click(function(){
						$('input[name="hideStep"]').val("I");
						$("form[name='FormData']").submit();
					});
					$('#btnSearch').click(function(){
						$('input[name="hideStep"]').val("L");
						$("form[name='FormData']").submit();
					});
					$('#BtnUpload').click(funcUploadSystemData); 
					$('#btnOutExcel').click(function() {
						$('input[name="hideStep"]').val("O");
						$("form[name='FormData']").submit();
					});
					
					funcNowPageIndex = $('input[name="hidePageIndex"]').val();
					funcFinalPageIndex = $('input[name="hidePageCount"]').val();
					PageLoadPageFunction(funcFinalPageIndex, funcNowPageIndex);
				});
			</script>
			<input type="hidden" name="hidePageIndex" id="hidePageIndex" value="<?php echo $PageNowIndex; ?>" />
            <input type="hidden" name="hidePageRowCount" id="hideRowCount" value="<?php echo $PageDataRows; ?>" />
            <input type="hidden" name="hidePageCount" id="hidePageCount" value="<?php echo $FinalPageCount; ?>" />
            <input type="hidden" name="hideRowCount" id="hideRowCount" value="<?php echo $FinalDataRows; ?>" />
            <table style="width:100%;font-size:14px" border="0" cellpadding="1" cellspacing="1">
            	<tr style="height:35px; font-weight:bold;font-size:24pt"><td style="width:100%; text-align:center" colspan="7">系統參數明細清單</td></tr> 
                
                <tr style="height:30px;width:100%; text-align:right">
                    <td style="width:100%; text-align:center" colspan="7">
                    	關鍵字:<input type="text" name="textSearch" id="textSearch" style="width:600px; height:30px" value="<?php echo $textSearchValue; ?>" />
                        <input type="button" id="btnSearch" value="查詢"  style="height:30px; width:100px; font-size:18px" />
                    	
                    </td>
                </tr>
                <tr ><td colspan="7">
                    	上傳系統參數檔<input type="file" name="DataUpload" id="DataUploadID" style="height:30px; width:300px; font-size:18px" accept="application/msexcel" />
                        <input type="button" id="BtnUpload" value="檔案上傳中" style="height:30px; width:100px; font-size:18px" />                
                        <input type="button" id="btnDataIns" value="新增系統參數" style="height:30px; width:150px; font-size:18px" />
                        <input type="button" id="btnOutExcel" value="匯出Excel檔" style="height:30px; width:150px; font-size:18px" />
                </td></tr>
                <tr><td colspan="7"><hr /></td></tr>
                <tr style="height:35px; font-weight:bold">
                    <td style="width:100%; text-align:center" colspan="7">
                        <input type="button" id="btnPageFirstB" value="第一頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                        <input type="button" id="btnPagePrevB" value="前一頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                        <select name="selPageIndexB" id="selPageIndexB" style="height:35px; width:100px;font-weight:bold;font-size:18px">
                        <?php for ($i = 1; $i <= $FinalPageCount; $i++){ echo sprintf("<option value='%d' %s >第 %d 頁 </option>", $i, ($i == ($PageNowIndex)) ? "selected" : "", $i); } ?>
                        </select>
                        <input type="button" id="btnPageNextB" value="下一頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                        <input type="button" id="btnPageEndB" value="最後頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                    </td>
                </tr>
                <tr style="height:35px; font-weight:bold">
                    <td style="width:100px; text-align:center">系統類別</td><td style="width:100px; text-align:center">系統參數</td>                            
                    <td style="width:100px; text-align:center">參數標題</td><td style="width:150px; text-align:center">參數說明</td>
                    <td style="width:150px; text-align:center">參數備註</td><td style="width:50px; text-align:center">使用狀態</td>                            
                    <td style="width:50px; text-align:center">功能處理</td>
                </tr>
                <tr><td colspan="7"><hr /></td></tr>  
                <?php 	$QueryList = sprintf("Select * From systemdetail where 1=1 %s order by systemclass,systemvalue asc limit $LimitBeginIndex,$PageDataRows", $QuerySearch);
						$QueryFinalData = $myConn->returnResultQueryDataDetail($QueryList);
						$FinalDataRows = mysql_num_rows($QueryFinalData);	$showTitle = "";
						if ($FinalDataRows > 0 ) {
							while ($RowList = mysql_fetch_object($QueryFinalData)) {
								$showDetail = "	<tr style='height:30px'><td style='width:100px; text-align:left'>%s</td>
												<td style='width:100px; text-align:left'>%s</td><td style='width:100px; text-align:left'>%s</td>
												<td style='width:150px; text-align:left'>%s</td><td style='width:150px; text-align:left'>%s</td>
												<td style='width:50px; text-align:left'>%s</td><td style='width:50px; text-align:left'>
												<input type='button' value='修改' onclick=FormSendDataUpdate('%s','%s'); /><br>
												<input type='button' value='刪除' onclick=FormSendDataDelete('%s','%s'); /></td></tr>
											   	<tr><td colspan='7'><hr /></td></tr>";
								$showTitle .= sprintf($showDetail, $RowList->SystemClass, $RowList->SystemValue, $RowList->SystemTitle, $RowList->SystemNotation, $RowList->SystemRemark
												, $RowList->SystemStatus, $RowList->SystemClass, $RowList->SystemValue, $RowList->SystemClass, $RowList->SystemValue);
							}
						}
						echo $showTitle;	?>
                <tr style="height:35px; font-weight:bold">
                    <td style="width:100%; text-align:center" colspan="7">
                        <input type="button" id="btnPageFirstE" value="第一頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                        <input type="button" id="btnPagePrevE" value="前一頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                        <select name="selPageIndexE" id="selPageIndexE" style="height:35px; width:100px;font-weight:bold;font-size:18px">
                        <?php for ($i = 1; $i <= $FinalPageCount; $i++){ echo sprintf("<option value='%d' %s >第 %d 頁 </option>", $i, ($i == ($PageNowIndex)) ? "selected" : "", $i); }	?>
                        </select>
                        <input type="button" id="btnPageNextE" value="下一頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                        <input type="button" id="btnPageEndE" value="最後頁" style="height:35px; width:100px;font-weight:bold;font-size:18px" />
                    </td>
                </tr>
            </table>
<?php		
		}

		function FormDataInsert()
		{
?>
			<script type="text/javascript">			
				$(function() {			
					$("#btnDataNew").click(FormCheckDataInsert);
					$("#btnDataClear").click(FormClearDataInsert);
					$("#btnDataBack").click(FormBackData);			
				});
			</script>
			<table style="width:100%" border="0" cellpadding="1" cellspacing="1">
                <tr style="height:35px; font-weight:bold;font-size:24px">
                    <td style="width:100%; text-align:center" colspan="2">新增系統參數基本資料</td>
                </tr> 
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">系統類別</td>
                    <td style="width:500px; text-align:left"><input type="text" name="textClassN" style="width:500px;height:30px" /></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">系統參數值</td>
                    <td style="width:500px; text-align:left"><input type="text" name="textValueN" style="width:500px;height:30px" /></td>
                </tr>            
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">參數標題</td>
                    <td style="width:500px; text-align:left"><input type="text" name="textTitleN" style="width:500px;height:30px" /></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">參數說明</td>
                    <td style="width:500px; text-align:left"><textarea name="textNotationN" id="textNotationN" style="width:500px; height:100px"></textarea></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">參數備註</td>
                    <td style="width:500px; text-align:left"><textarea name="textRemarkN" id="textRemarkN" style="width:500px; height:100px"></textarea></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">使用狀態</td>
                    <td style="width:500px; text-align:left"><input type="checkbox" name="CheckStatusN" id="CheckStatusN" />開放</td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:100%; text-align:center" colspan="2">
                        <input type="button" id="btnDataNew" value="確認新增" style="width:100px; height:30px;font-weight:bold" />
                        <input type="button" id="btnDataClear" value="清除重填" style="width:100px; height:30px;font-weight:bold" />
                        <input type="button" id="btnDataBack" value="取消新增" style="width:100px; height:30px;font-weight:bold" />
                    </td>
                </tr>                                  
                <tr><td style="width:100%" colspan="2"><hr /></td></tr> 
            </table>
<?php		
		}


		function FormDataUpdate()
		{
			$Conn = new classMySqlDataBase();
			$SystemClass = $_POST["hideClass"];
			$SystemValue = $_POST["hideValue"];
			$QueryTableName = "systemdetail";
			$QueryDataBase = sprintf(" SystemClass='%s' and SystemValue='%s' ", $SystemClass, $SystemValue);
			$SystemTitle = $Conn->returnColumnValueQueryDataDetail($QueryTableName,"SystemTitle","",$QueryDataBase);
			$SystemNotation = $Conn->returnColumnValueQueryDataDetail($QueryTableName,"SystemNotation","",$QueryDataBase);
			$SystemRemark = $Conn->returnColumnValueQueryDataDetail($QueryTableName,"SystemRemark","",$QueryDataBase);
			$SystemStatus = $Conn->returnColumnValueQueryDataDetail($QueryTableName,"SystemStatus","",$QueryDataBase);
?>
			<script type="text/javascript">			
				$(function() {			
					$("#btnDataUpdate").click(FormCheckDataUpdate);
					$("#btnDataClear").click(FormClearDataUpdate);
					$("#btnDataBack").click(FormBackData);			
				});
			</script>

			<input type="hidden" name="hideClassM" id="hideClassM" value="<?php echo $SystemClass; ?>" />
            <input type="hidden" name="hideValueM" id="hideValueM" value="<?php echo $SystemValue; ?>" />
            <table style="width:100%" border="0" cellpadding="1" cellspacing="1">
                <tr style="height:35px; font-weight:bold;font-size:24px">
                    <td style="width:100%; text-align:center" colspan="2">修改系統參數基本資料</td>
                </tr> 
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">系統類別</td>
                    <td style="width:500px; text-align:left"><?php echo $SystemClass; ?></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">系統參數值</td>
                    <td style="width:500px; text-align:left"><?php echo $SystemValue; ?></td>
                </tr>            
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">參數標題</td>
                    <td style="width:500px; text-align:left"><input type="text" name="textTitleM" style="width:500px;height:30px" value="<?php echo $SystemTitle; ?>" /></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">參數說明</td>
                    <td style="width:500px; text-align:left"><textarea name="textNotationM" id="textNotationM" style="width:500px; height:100px"><?php echo $SystemNotation; ?></textarea></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">參數備註</td>
                    <td style="width:500px; text-align:left"><textarea name="textRemarkM" id="textRemarkM" style="width:500px; height:100px"><?php echo $SystemRemark; ?></textarea></td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:200px; text-align:left">使用狀態</td>
                    <td style="width:500px; text-align:left"><input type="checkbox" name="CheckStatusM" id="CheckStatusM" <?php echo ($SystemStatus == "O" )?( "checked" ):( "" ); ?> />開放</td>
                </tr>
                <tr><td style="width:100%" colspan="2"><hr /></td></tr>
                <tr style="height:30px;font-weight:bold">
                    <td style="width:100%; text-align:center" colspan="2">
                        <input type="button" id="btnDataUpdate" value="確認修改" style="width:100px; height:30px;font-weight:bold" />
                        <input type="button" id="btnDataClear" value="清除重填" style="width:100px; height:30px;font-weight:bold" />
                        <input type="button" id="btnDataBack" value="取消修改" style="width:100px; height:30px;font-weight:bold" />
                    </td>
                </tr>                                  
                <tr><td style="width:100%" colspan="2"><hr /></td></tr> 
            </table>        
<?php 		
		}

		function ExecuteDataNew()
		{
			$NewSystemClass = $_POST["hideClass"];
			$NewSystemValue = $_POST["hideValue"];
			$NewSystemTitle = $_POST["hideTitle"];
			$NewSystemNotation = $_POST["hideNotation"];
			$NewSystemRemark = $_POST["hideRemark"];
			$NewSystemStatus = $_POST["hideStatus"];
			
			$Conn = new classMySqlDataBase();
			$NewDataTableName = "SystemDetail";
			$ArrayQueryCheckValue = array(
				"systemClass"=>$NewSystemClass,
				"systemValue"=>$NewSystemValue
			);
			$QueryCheckValue = $Conn->checkRowExecuteDataDetail($NewDataTableName,$ArrayQueryCheckValue);			
			if ($QueryCheckValue == "X") 
			{
				$ArrayNewTableColumn = array(
					"systemclass"=>$NewSystemClass,
					"systemvalue"=>$NewSystemValue,
					"systemtitle"=>$NewSystemTitle,
					"systemnotation"=>$NewSystemNotation,
					"systemremark"=>$NewSystemRemark,
					"systemstatus"=>$NewSystemStatus
				);
				$ReturnExecuteValue = $Conn->execInsertExecuteDataDetail($NewDataTableName,$ArrayNewTableColumn,$ArrayNewTableColumn,count($ArrayNewTableColumn));
?>
				<script type="text/javascript">
					$('input[name="hideStep"]').val(""); $("form[name='FormData']").submit();				
				</script>	
<?php		} else {	?>				
				<script type="text/javascript">
					alert("資料重覆新增!!請重新填寫!!"); $('input[name="hideStep"]').val("I"); $("form[name='FormData']").submit();				
				</script>
<?php 
			}				
		}
		
		function ExecuteDataMod()
		{
			$NewSystemClass = $_POST["hideClassM"];
			$NewSystemValue = $_POST["hideValueM"];
			$NewSystemTitle = $_POST["hideTitle"];
			$NewSystemNotation = $_POST["hideNotation"];
			$NewSystemRemark = $_POST["hideRemark"];
			$NewSystemStatus = $_POST["hideStatus"];
			
			$Conn = new classMySqlDataBase();
			$NewDataTableName = "SystemDetail";
			$ArrayQueryCheckValue = array(
				"systemClass"=>$NewSystemClass,
				"systemValue"=>$NewSystemValue
			);
			$QueryCheckValue = $Conn->checkRowExecuteDataDetail($NewDataTableName,$ArrayQueryCheckValue);			
			if ($QueryCheckValue == "O") {
				$ArrayQueryColumn = array(
					"systemClass"=>$NewSystemClass,	"systemValue"=>$NewSystemValue					
				);
				$ArrayModTableColumn = array(
					"systemtitle"=>$NewSystemTitle,	"systemnotation"=>$NewSystemNotation,
					"systemremark"=>$NewSystemRemark, "systemstatus"=>$NewSystemStatus
				);
				$ReturnExecuteValue = $Conn->execUpdateExecuteDataDetail($NewDataTableName,$ArrayQueryColumn,$ArrayModTableColumn);
?>
				<script type="text/javascript">
					$('input[name="hideStep"]').val(""); $("form[name='FormData']").submit();				
				</script>	
<?php		} else {	
?>				
				<script type="text/javascript">
					alert("查無相關資料!!請重新選擇!!");
					$('input[name="hideStep"]').val(""); $("form[name='FormData']").submit();				
				</script>
<?php 		}		
		}
		
		function ExecuteDataDelete()
		{
			$Conn = new classMySqlDataBase();
			$SystemClass = $_POST["hideClass"];
			$SystemValue = $_POST["hideValue"];
			$QueryTableName = "systemdetail";
			$ArrayDeleteValue = array(
				"SystemClass"=>$SystemClass, "SystemValue"=>$SystemValue
			);
			$ReturnExecuteValue = $Conn->execDeleteExecuteDataDetail($QueryTableName,$ArrayDeleteValue);
?>
			<script type="text/javascript">
				$('input[name="hideStep"]').val(""); $("form[name='FormData']").submit();				
			</script>
<?php		
		}
		
		function ExecuteDataUpload()
		{
			$NewDataTableName = "systemdetail";
			$classPublic = new classPublicFunction();
			$Conn = new classMySqlDataBase();
			//	取得上傳檔案的名稱
			$ReadExcelName = "systemdetail_" . $classPublic->returnValueToGetDateTime("", "VF");			
			//	將暫存的temp檔複製到指定的資料夾中
			move_uploaded_file($_FILES["DataUploadID"]["tmp_name"],"upload/".$ReadExcelName);
			//  讀取2007 excel 檔案
			$ExcelReader = PHPExcel_IOFactory::createReader('Excel2007');
			//  檔案名稱 需已經上傳到主機上
			$PHPExcel = $ExcelReader->load("upload/".$ReadExcelName); 	
		
?>			
			<script type="text/javascript">
				$('input[name="hideStep"]').val(""); $("form[name='FormData']").submit();				
			</script>	
<?php 			
		}
		
		function ExecuteDataOutExcel()
		{
			$objPHPExcel = new PHPExcel(); 
			$objPHPExcel->setActiveSheetIndex(0);
			//合併儲存隔 
			$objPHPExcel->getActiveSheet()->mergeCells("A1:D2");
			//設定漸層背景顏色雙色(灰/白) 
			$objPHPExcel->getActiveSheet()->getStyle("A1:D2")->applyFromArray( 
				array( "font"    => array( "bold"   => true ), 
				"alignment" => array( "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, ), 
				"borders" => array( "top" => array( "style" => PHPExcel_Style_Border::BORDER_THIN ) 
				), "fill" => array( "type"    => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, "rotation"   => 90, "startcolor" => array( "rgb" => "DCDCDC" ), 
				"endcolor"   => array( 	"rgb" => "FFFFFF" ) ) ) 
			);
			//設定字型大小 
			$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);
			//設定A1欄位顯示文字PHPEXCEL TEST 
			$objPHPExcel->getActiveSheet()->setCellValue("A1","PHPEXCEL TEST");
			//設定字體顏色 
			//$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
			//設定背景顏色單色 
			$objPHPExcel->getActiveSheet()->getStyle("A3:D3")->applyFromArray( array("fill" => array( "type" => PHPExcel_Style_Fill::FILL_SOLID, "color" => array("rgb" => "D1EEEE") ), ) );
			//設定欄位值 
			$objPHPExcel->getActiveSheet()->setCellValue("A3","test1"); 
			$objPHPExcel->getActiveSheet()->setCellValue("B3","test2"); 
			$objPHPExcel->getActiveSheet()->setCellValue("C3","test3"); 
			$objPHPExcel->getActiveSheet()->setCellValue("D3","test4");
			// Rename sheet 
			$objPHPExcel->getActiveSheet()->setTitle("sheet");
			//設定的欄位寬度(自動) 
			$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet 
			$objPHPExcel->setActiveSheetIndex(0);
			// Export to Excel2007 (.xlsx) 匯出成2007
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007"); 
			$objWriter->save("test.xlsx");
			// Export to Excel5 (.xls) 匯出成2003
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5"); 
			$objWriter->save("test.xls");
		}		
		
	}
?>
