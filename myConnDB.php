<?php 

	define("ConnHost","127.0.0.1");
	define("ConnDatabase","dbemployee");
	define("ConnAccount","admSQL");
	define("ConnPassword","t/6ru8jo3");

class classMySqlDataBase 
{

	/*	****************************************************************************************************************
		函數名稱	:	checkrowExecuteDataDetail
		函數功能	:	進行查詢語法確認是否有相關資料
		更新紀錄	:
					2018-09-14	Cheng	新建函數
		****************************************************************************************************************	*/
	function checkRowExecuteDataDetail($funcTableName,$ArrayColumnValue)
	{
		$Conn = mysql_connect(ConnHost,ConnAccount,ConnPassword) or die("Error with MySQL Connection");
		mysql_query("SET NAMES 'tuf8'");
		mysql_select_db(ConnDatabase);
		$num = 0 ;
		$funcQuerySQL = "select * from " . $funcTableName . " where ";
		foreach($ArrayColumnValue as $key => $value)
		{
			if ($num > 0 ) { $funcQuerySQL .=  " and "; }
			$funcQuerySQL .=  $key . "='" . $value . "' ";
			$num += 1;
		}
		$result = mysql_query($funcQuerySQL, $Conn); 
		$row_total = mysql_num_rows($result);
		if ($row_total > 0) { $returnCheckValue = "O"; } else { $returnCheckValue = "X"; }
		return $returnCheckValue;	
        		
	}
	
	/*	****************************************************************************************************************
		函數名稱	:	returnResultQueryDataDetail
		函數功能	:	進行查詢語法取得資料庫陣列
		更新紀錄	:
					2018-09-14	Cheng	新建函數
		****************************************************************************************************************	*/
	function returnResultQueryDataDetail($funcQuerySQL)
	{
		$Conn = mysql_connect(ConnHost,ConnAccount,ConnPassword) or die("Error with MySQL Connection");
		mysql_query("SET NAMES 'tuf8'");
		mysql_select_db(ConnDatabase);
		$returnResult = mysql_query($funcQuerySQL, $Conn);
		return $returnResult;
	}
	
	/*	****************************************************************************************************************
		函數名稱	:	returnColumnValueQueryDataDetail
		函數功能	:	進行查詢語法取得資料庫陣列欄位值
		更新紀錄	:
					2018-09-14	Cheng	新建函數
		****************************************************************************************************************	*/	
	function returnColumnValueQueryDataDetail($funcTableName, $funcColumnName, $funcRowsLimit, $funcDataBaseValue)
	{
		$ReturnValue = "";
		$Conn = mysql_connect(ConnHost,ConnAccount,ConnPassword) or die("Error with MySQL Connection");
		mysql_query("SET NAMES 'tuf8'");
		mysql_select_db(ConnDatabase);
		$funcQuerySQL = sprintf("select %s from %s where %s %s", $funcColumnName, $funcTableName, $funcDataBaseValue, $funcRowsLimit);
		$result = mysql_query($funcQuerySQL, $Conn); 			
		while($row=mysql_fetch_array($result)){	$ReturnValue=$row[0]; }
		return $ReturnValue;
	}

	/*	****************************************************************************************************************
		函數名稱	:	execInsertExecuteDataDetail
		函數功能	:	進行查詢語法進行新增資料庫的資料
		更新紀錄	:
					2018-09-14	Cheng	新建函數
		****************************************************************************************************************	*/		
	function execInsertExecuteDataDetail($funcTableName, $ArrayDataColumn, $ArrayDataValue)
	{
		$Conn = mysql_connect(ConnHost,ConnAccount,ConnPassword) or die("Error with MySQL Connection");
		mysql_query("SET NAMES 'tuf8'");
		mysql_select_db(ConnDatabase);
		$funcExecuteSQL = " Insert Into ".$funcTableName." ( ";
		foreach($ArrayDataColumn as $key => $value)
		{
			$funcExecuteSQL .= $key;
			if (next($ArrayDataColumn) == true){ $funcExecuteSQL .= ",";}
		} 
		$funcExecuteSQL .= " ) values ( ";
		foreach($ArrayDataValue as $key => $value)
		{
			$funcExecuteSQL .= "'".$value."'";
			if (next($ArrayDataValue) == true){ $funcExecuteSQL .= ",";}
		} 
		$funcExecuteSQL .= " )";				
		mysql_query($funcExecuteSQL, $Conn);
		return  "O";
	}

	/*	****************************************************************************************************************
		函數名稱	:	execUpdateExecuteDataDetail
		函數功能	:	進行查詢語法進行更新資料庫的資料
		更新紀錄	:
					2018-09-14	Cheng	新建函數
		****************************************************************************************************************	*/	
	function execUpdateExecuteDataDetail($funcTableName, $ArrayDataQuery, $ArrayDataUpdate) 
	{ 
		$Conn = mysql_connect(ConnHost,ConnAccount,ConnPassword) or die("Error with MySQL Connection");
		mysql_query("SET NAMES 'tuf8'");
		mysql_select_db(ConnDatabase);
		$num = 0;
		$funcExecuteSQL = "Update " . $funcTableName . " set ";
		foreach($ArrayDataUpdate as $key => $value )
		{
			$funcExecuteSQL .= $key . "='" . $value . "' ";
			if (next($ArrayDataUpdate) == true){ $funcExecuteSQL .= ","; } 
		}
		$funcExecuteSQL .= " where ";
		foreach($ArrayDataQuery as $key => $value ) 
		{
			if ($num > 0 ) { $funcExecuteSQL .= " and "; }
			$funcExecuteSQL .= $key . "='" . $value . "' " ;
			$num += 1 ;
		}
		mysql_query($funcExecuteSQL, $Conn);
		return  "O" ;
	}

	/*	****************************************************************************************************************
		函數名稱	:	execUpdateExecuteDataDetail
		函數功能	:	進行查詢語法進行刪除資料庫的資料
		更新紀錄	:
					2018-09-14	Cheng	新建函數
		****************************************************************************************************************	*/	
	function execDeleteExecuteDataDetail($funcTableName, $ArrayDataQuery)
	{
		$Conn = mysql_connect(ConnHost,ConnAccount,ConnPassword) or die("Error with MySQL Connection");
		mysql_query("SET NAMES 'tuf8'");
		mysql_select_db(ConnDatabase);
		$num = 0;
		$funcExecuteSQL = "Delete From " . $funcTableName . " where ";
		foreach($ArrayDataQuery as $key => $value ) 
		{
			if ($num > 0 ) { $funcExecuteSQL .= " and "; }
			$funcExecuteSQL .= $key . "='" . $value . "' " ;
			$num += 1 ;
		}
		mysql_query($funcExecuteSQL, $Conn);
		return  "O" ;
	}

}
?>