<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

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

mysql_select_db($database_conn, $conn);
$query_rs_subcat = "SELECT * FROM subcat";
$rs_subcat = mysql_query($query_rs_subcat, $conn) or die(mysql_error());
$row_rs_subcat = mysql_fetch_assoc($rs_subcat);
$totalRows_rs_subcat = mysql_num_rows($rs_subcat);


do {
	
	
	
mysql_select_db($database_conn, $conn);
$query_rs_page = sprintf("SELECT * FROM page WHERE sub_cat=".$row_rs_subcat['s_id']);
$rs_page = mysql_query($query_rs_page, $conn) or die(mysql_error());
$row_rs_page = mysql_fetch_assoc($rs_page);
$totalRows_rs_page = mysql_num_rows($rs_page);

$PATH_TO_IMAGES = 'img/pages/';
 $PAGE = "";
 
 $BG_COLOR = 0;
 
 do { 
 
 if($BG_COLOR==0)
 {
	 	$PAGE .='<div class="white-bg section">';
		$BG_COLOR = 1;
 }
else	
	{
		$PAGE .='<div class="gray-bg section">';
		$BG_COLOR = 0;
	}
	
 
 $PAGE .='
 <h2>'.$row_rs_page['page_name'].'</h2>';
 
 if($row_rs_page['page_img2'])
 $PAGE .='<img src="'.$PATH_TO_IMAGES.$row_rs_page['page_img1'].'" class="page-img-2" />';
 
$PAGE .='<p>'.$row_rs_page['page_note'].'</p>';

if($row_rs_page['page_img2'])
 $PAGE .='<img src="'.$PATH_TO_IMAGES.$row_rs_page['page_img2'].'"  class="page-img-2" />';
 
 $PAGE .='</div>';



 } while ($row_rs_page = mysql_fetch_assoc($rs_page));  

	
	$myfile = fopen("pages/".$row_rs_subcat['s_id'].".html", "w+") or die("Unable to open file!");
	
	fwrite($myfile,  $PAGE);
	 
	fclose($myfile);
	
	
    
} while ($row_rs_subcat = mysql_fetch_assoc($rs_subcat)); ?>
