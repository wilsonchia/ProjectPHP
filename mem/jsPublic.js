// JavaScript Document

var FormName = "FormData";

PageLoadPageFunction = function(funcFinalPageIndex,funcNowPageIndex) {
	
	if (funcFinalPageIndex == 1 ) {
		$("#btnPageFirstB").attr("disabled",true);	$("#btnPagePrevB").attr("disabled",true);
		$("#btnPageNextB").attr("disabled",true);	$("#btnPageEndB").attr("disabled",true);
		$("#btnPageFirstE").attr("disabled",true);	$("#btnPagePrevE").attr("disabled",true);
		$("#btnPageNextE").attr("disabled",true); $("#btnPageEndE").attr("disabled",true);
	} else {
		if (funcNowPageIndex == 1)
		{
			$("#btnPageFirstB").attr("disabled",true);	$("#btnPagePrevB").attr("disabled",true);
			$("#btnPageNextB").attr("disabled",false);	$("#btnPageEndB").attr("disabled",false);
			$("#btnPageFirstE").attr("disabled",true);	$("#btnPagePrevE").attr("disabled",true);
			$("#btnPageNextE").attr("disabled",false);	$("#btnPageEndE").attr("disabled",false);
		} else if (funcNowPageIndex == $('input[name="hidePageCount"]').val() ) {
			$("#btnPageFirstB").attr("disabled",false);	$("#btnPagePrevB").attr("disabled",false);
			$("#btnPageNextB").attr("disabled",true);	$("#btnPageEndB").attr("disabled",true);		
			$("#btnPageFirstE").attr("disabled",false);	$("#btnPagePrevE").attr("disabled",false);
			$("#btnPageNextE").attr("disabled",true);	$("#btnPageEndE").attr("disabled",true);															
		} else {
			$("#btnPageFirstB").attr("disabled",false);	$("#btnPagePrevB").attr("disabled",false);
			$("#btnPageNextB").attr("disabled",false);	$("#btnPageEndB").attr("disabled",false);					
			$("#btnPageFirstE").attr("disabled",false);	$("#btnPagePrevE").attr("disabled",false);
			$("#btnPageNextE").attr("disabled",false);	$("#btnPageEndE").attr("disabled",false);											
		}
		$("#btnPageFirstB").click(btnPageFirst);	$("#btnPagePrevB").click(btnPagePrev);
		$("#btnPageNextB").click(btnPageNext);	$("#btnPageEndB").click(btnPageEnd);
		$("#btnPageFirstE").click(btnPageFirst);	$("#btnPagePrevE").click(btnPagePrev);
		$("#btnPageNextE").click(btnPageNext);	$("#btnPageEndE").click(btnPageEnd);
		$("#selPageIndexB").change(PageSelectB);	$("#selPageIndexE").change(PageSelectE);	
	}

}

PageSelectB = function() {
	NowPageIndex = $("select[name='selPageIndexB']").val();
	$('input[name="hidePageIndex"]').val(NowPageIndex);
	$('input[name="hideStep"]').val("");
	$("form[name='" + FormName + "']").submit();
}

PageSelectE = function() {
	NowPageIndex = $("select[name='selPageIndexE']").val();
	$('input[name="hidePageIndex"]').val(NowPageIndex);
	$('input[name="hideStep"]').val("");
	$("form[name='" + FormName + "']").submit();
}
			
btnPageFirst = function(){
	$('input[name="hidePageIndex"]').val("1");
	$('input[name="hideStep"]').val("");
	$("form[name='" + FormName + "']").submit();
}

btnPagePrev = function(){
	NowPageIndex = $('input[name="hidePageIndex"]').val();
	$('input[name="hidePageIndex"]').val(eval(NowPageIndex)-1);
	$('input[name="hideStep"]').val("");
	$("form[name='" + FormName + "']").submit();
}

btnPageNext = function(){
	NowPageIndex = $('input[name="hidePageIndex"]').val();
	$('input[name="hidePageIndex"]').val(eval(NowPageIndex)+1);
	$('input[name="hideStep"]').val("");
	$("form[name='" + FormName + "']").submit();
}

btnPageEnd = function(){
	NowPageIndex = $('input[name="hidePageCount"]').val();
	$('input[name="hidePageIndex"]').val(NowPageIndex);
	$('input[name="hideStep"]').val("");
	$("form[name='" + FormName + "']").submit();
}