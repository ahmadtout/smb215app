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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


    
<div class="panel-group  fahras-accordion" id="accordion" dir="rtl" role="tablist" aria-multiselectable="true">



<?php


mysql_select_db($database_conn, $conn);
$query_rs_category = "SELECT * FROM category";
$rs_category = mysql_query($query_rs_category, $conn) or die(mysql_error());
$row_rs_category = mysql_fetch_assoc($rs_category);
$totalRows_rs_category = mysql_num_rows($rs_category);

 do { 
 
 ?>
 
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapse<?php echo $row_rs_category['id'] ?>" aria-expanded="true" aria-controls="collapse<?php echo $row_rs_category['id'] ?>">
         <?php echo $row_rs_category['name'] ?>
        </a>
      </h4>
    </div>
    <div id="collapse<?php echo $row_rs_category['id'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $row_rs_category['id'] ?>">
      <div class="panel-body">
      
      <ul  class="list-group">
      <?php 
	  
	  
mysql_select_db($database_conn, $conn);
$query_rs_subcat = "SELECT * FROM subcat where category_id = ".$row_rs_category['id'];
$rs_subcat = mysql_query($query_rs_subcat, $conn) or die(mysql_error());
$row_rs_subcat = mysql_fetch_assoc($rs_subcat);
$totalRows_rs_subcat = mysql_num_rows($rs_subcat);

do {
	
 
 echo '<li class="list-group-item"><a  onclick="loadPage('.$row_rs_subcat['s_id'].')" class="list-group-item">'.$row_rs_subcat['s_name'].'</a></li>';
	
    
} while ($row_rs_subcat = mysql_fetch_assoc($rs_subcat)); 

?>
</ul>
      
      </div>
    </div>
  </div>
<?php


} while ($row_rs_category = mysql_fetch_assoc($rs_category)); ?>

<!-- Rating form -->
 <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button"   onclick="loadPage('form')"    >تقييم الكتاب </a>
      </h4>
    </div>
     
  </div>
 <!-- End Ratin form-->
   
   
</div>

</body>
</html>