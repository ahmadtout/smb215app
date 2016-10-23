<?php require_once('Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rs_ahdas = "-1";
if (isset($_SESSION['page_id'])) {
  $colname_rs_ahdas = $_SESSION['page_id'];
}
mysql_select_db($database_conn, $conn);
$query_rs_ahdas = sprintf("SELECT * FROM pagexahdas WHERE page_id = %s", GetSQLValueString($colname_rs_ahdas, "int"));
$rs_ahdas = mysql_query($query_rs_ahdas, $conn) or die(mysql_error());
$row_rs_ahdas = mysql_fetch_assoc($rs_ahdas);
$totalRows_rs_ahdas = mysql_num_rows($rs_ahdas);

mysql_free_result($rs_ahdas);
?>

