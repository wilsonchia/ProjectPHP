// JavaScript Document

var FormName = "FormData";

FormSendDataUpdate = function(valSystemClass, valSystemValue)
{
	$('input[name="hideClass"]').val(valSystemClass);
	$('input[name="hideValue"]').val(valSystemValue);					
	$('input[name="hideStep"]').val("U");
	$("form[name='" + FormName + "']").submit(); 	
}

FormSendDataDelete = function(valSystemClass, valSystemValue)
{
	var showMessage = "你真的確定要刪除這筆系統參數基本資料嗎";
	if (confirm(showMessage) == true)
	{
		$('input[name="hideClass"]').val(valSystemClass);
		$('input[name="hideValue"]').val(valSystemValue);						
		$('input[name="hideStep"]').val("D");
		$("form[name='" + FormName + "']").submit();	
	}
	
}

FormCheckDataInsert = function()
{
	if ($('input[name="textClassN"]').val() == ""){ 
		alert("類別不得空白!!"); $('input[name="textClassN"]').focus(); return false;
	} else {
		$('input[name="hideClass"]').val($('input[name="textClassN"]').val());
	}
	if ($('input[name="textValueN"]').val() == ""){ 
		alert("參數值不得空白!!"); $('input[name="textValueN"]').focus();	return false;
	} else {
		$('input[name="hideValue"]').val($('input[name="textValueN"]').val());
	}
	if ($('input[name="textTitleN"]').val() == ""){ 
		alert("標題不得空白!!"); 	$('input[name="textTitleN"]').focus(); return false;
	} else {
		$('input[name="hideTitle"]').val($('input[name="textTitleN"]').val());
	}
	if ($('#textNotationN').val() != ""){ 
		$('input[name="hideNotation"]').val($('#textNotationN').val());
	}
	if ($('#textRemarkN').val() != ""){ 
		$('input[name="hideRemark"]').val($('#textRemarkN').val());
	}
	if ($('#CheckStatusN').prop("checked")) { $('input[name="hideStatus"]').val("O"); } else {	$('input[name="hideStatus"]').val("X");	}
	if ($('input[name="hideClass"]').val() != "" && $('input[name="hideValue"]').val() != "" ){
		$('input[name="hideStep"]').val("N"); $("form[name='" +  FormName + "']").submit();
	}	
}

FormClearDataInsert = function() 
{
	$('input[name="textClassN"]').val("");	
	$('input[name="textValueN"]').val("");
	$('input[name="textTitleN"]').val("");	
	$('input[name="textNotationN"]').val("");
	$('input[name="textRemarkN"]').val("");	
	$('input[name="textTitleN"]').val("");	
	$('#CheckStatusN').prop("checked", false);	
	$('input[name="hideClass"]').val("");
	$('input[name="hideValue"]').val("");
	$('input[name="hideTitle"]').val("");
	$('input[name="hideNotation"]').val("");
	$('input[name="hideRemark"]').val("");
	$('input[name="hideStatus"]').val("");
	$('input[name="textClassN"]').focus();			
}

FormCheckDataUpdate = function()
{
	if ($('input[name="textTitleM"]').val() == ""){ 
		alert("標題不得空白!!"); 	$('input[name="textTitleM"]').focus(); return false;
	} else {
		$('input[name="hideTitle"]').val($('input[name="textTitleM"]').val());
	}
	if ($('#textNotationM').val() != ""){ 
		$('input[name="hideNotation"]').val($('#textNotationM').val());
	}
	if ($('#textRemarkM').val() != ""){ 
		$('input[name="hideRemark"]').val($('#textRemarkM').val());
	}
	if ($('#CheckStatusM').prop("checked")) { $('input[name="hideStatus"]').val("O"); } else { $('input[name="hideStatus"]').val("X"); }
	if ($('input[name="hideClassM"]').val() != "" && $('input[name="hideValueM"]').val() != "" ){
		$('input[name="hideStep"]').val("M"); $("form[name='" +  FormName + "']").submit();
	}	
}
	
FormClearDataUpdate = function() 
{
	$('input[name="textTitleM"]').val("");	
	$('input[name="textNotationM"]').val("");
	$('input[name="textRemarkM"]').val("");	
	$('#CheckStatusM').prop("checked", false);	
	$('input[name="hideTitle"]').val("");
	$('input[name="hideNotation"]').val("");
	$('input[name="hideRemark"]').val("");
	$('input[name="hideStatus"]').val("");
	$('input[name="textTitleM"]').focus();			
}	

FormBackData = function()
{
	$('input[name="hideStep"]').val("");
	$("form[name='" +  FormName + "']").submit();
}

funcUploadSystemData = function(){
	var reg = /^.*\.(?:xls|xlsx)$/i;
	if (reg.test($("#BtnUpload").val()) == false)
	{
		alert("上傳檔案格式必須為xls或xlsx");
		$("#DataUploadID").focus();
		return false;
	} else {
		$('input[name="hideStep"]').val("F");
		$("form[name='" +  FormName + "']").submit();
	}					
}	
