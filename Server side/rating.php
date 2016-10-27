<?php
header('Access-Control-Allow-Origin: *'); 
 require_once('Connections/conn.php'); ?>
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

mysql_select_db($database_conn, $conn);
$query_rs_rat = "SELECT * FROM rating WHERE name<>'' limit 25";
$rs_rat = mysql_query($query_rs_rat, $conn) or die(mysql_error());
$row_rs_rat = mysql_fetch_assoc($rs_rat);
$totalRows_rs_rat = mysql_num_rows($rs_rat);
 ?>
 <div style="padding-top:20px;">
 <?php
  do { ?>
   <div   class="col-xs-12 white-bg  rating-container"  >
 	<div class="col-xs-9" dir="rtl">
    	<h3 class="color-brown"><?php echo $row_rs_rat['name']; ?></h3>
        <p><?php echo $row_rs_rat['notes']; ?></p>
        <div><?php
		if($row_rs_rat['rate']<6 && $row_rs_rat['rate']>0)
		for($i=0; $i<$row_rs_rat['rate']; $i++)
			echo '<i class="fa fa-star rating-star" aria-hidden="true"></i>';
		 ?></div>
    </div>
    <div class="col-xs-3"><i class="fa fa-spinner fa-3x" style="padding-top:24px;color:<?php printf( "#%06X\n", mt_rand( 0, 0xFFFFFF )); ?>" aria-hidden="true"></i></div>
 </div>
    
    <?php } while ($row_rs_rat = mysql_fetch_assoc($rs_rat)); ?>
 
</div>