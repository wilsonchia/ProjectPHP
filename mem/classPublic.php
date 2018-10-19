<?php 

class classPublicFunction 
{

	function returnValueToRandomCount($funcTopStrValue, $funcValueLen)
	{
		$ReturnValue = ""; $randValue = "";
		for ($len=0; $len < $funcValueLen; $len++){
			$randValue = rand("0","9");
			$ReturnValue .= $randValue;
		}
		return $funcTopStrValue . $ReturnValue;
	}

	function returnValueToGetDateTime($showClass, $sendDateTimeValue)
	{
		$funcReturnValue = "";
		if ($sendDateTimeValue == "") {
			$yy = trim(date(Y));
			$mm = trim(str_pad(date(m),2,'0',STR_PAD_LEFT));
			$dd = trim(str_pad(date(d),2,'0',STR_PAD_LEFT));
			$hr = trim(str_pad(date(H),2,'0',STR_PAD_LEFT));
			$min = trim(str_pad(date(i),2,'0',STR_PAD_LEFT));
			$sec = trim(str_pad(date(s),2,'0',STR_PAD_LEFT));
		} else {
			if (strlen($sendDateTimeValue) == 14){
				$yy = trim(substr($sendDateTimeValue,1,4));
				$mm = trim(substr($sendDateTimeValue,5,2));
				$dd = trim(substr($sendDateTimeValue,7,2));
				$hr = trim(substr($sendDateTimeValue,9,2));
				$min = trim(substr($sendDateTimeValue,11,2));
				$sec = trim(substr($sendDateTimeValue,13,2));
			}
		}	
		switch ($showClass) {
			case "VF" : $funcReturnValue = $yy . $mm . $dd . $hr . $min . $sec; break;
			case "VY" : $funcReturnValue = $yy . $mm; break;
			case "VD" : $funcReturnValue = $yy . $mm . $dd; break;
			case "VT" : $funcReturnValue = $hr . $min . $sec; break;
			case "VYY" : $funcReturnValue = $yy; break;
			case "VMM" : $funcReturnValue = $mm; break;
			case "VDD" : $funcReturnValue = $dd; break;
			case "VHH" : $funcReturnValue = $hr; break;
			case "VII" : $funcReturnValue = $min;  break;
			case "VSS" : $funcReturnValue = $sec;  break;
		}
		return $funcReturnValue;
	}


}
?>