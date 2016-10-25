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
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE page SET  page_name=%s, page_note=%s, sub_cat=%s, label_img1=%s, label_img2=%s, color=%s WHERE page_id=%s",
                      
					   
					   GetSQLValueString($_POST['page_name'], "text"),
                      
                       GetSQLValueString($_POST['page_note'], "text"),
					   GetSQLValueString($_POST['sub_cat'], "id"),
					    GetSQLValueString($_POST['label_img1'], "text"),
					   GetSQLValueString($_POST['label_img2'], "text"),
					   GetSQLValueString($_POST['color'], "text"),
					     
                       GetSQLValueString($_POST['page_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());


  $last_id =$_POST['page_id'];
  
  //deleted all related ahdas 
  $deleteSQL = sprintf("DELETE FROM pagexahdas WHERE page_id=%s",
                       GetSQLValueString( $last_id, "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
  
   if(isset($_POST['ahdas_id']) && is_array($_POST['ahdas_id']) && count($_POST['ahdas_id'])>0)
   foreach($_POST['ahdas_id'] as $v)
   {
    $insertSQL = sprintf("INSERT INTO pagexahdas (page_id, ahdas_id) VALUES (%s, %s)",
                       GetSQLValueString($last_id , "int"),
                       GetSQLValueString($v, "int"));
 
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
   }
 
   if(isset($_FILES['page_img1']) && $_FILES['page_img1']!="")
  {  
  	$uploadOk = 1;
 	 //upload image
    $target_dir = "upload/page/";
	$filename = $_FILES['page_img1']["name"];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$target_file = $target_dir . $last_id."_1.".$ext;
	$FILE_NAME = $last_id."_1.".$ext;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);	 
	 
		// Check file size
	if ($_FILES["page_img1"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		 
			if (move_uploaded_file($_FILES["page_img1"]["tmp_name"], $target_file)) {
				$SQL="UPDATE `page` SET `page_img1`='".$FILE_NAME."' WHERE `page_id`=".$last_id;
				mysql_query($SQL, $conn) or die(mysql_error());
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
			
		 
				
	  }
 
  }
  
  
  
   if(isset($_FILES['page_img2']) && $_FILES['page_img2']!="")
  {  
  	$uploadOk = 1;
 	 //upload image
    $target_dir = "upload/page/";
	$filename = $_FILES['page_img2']["name"];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$target_file = $target_dir . $last_id."_2.".$ext;
	$FILE_NAME = $last_id."_2.".$ext;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);	 
	 
		// Check file size
	if ($_FILES["page_img2"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		 
			if (move_uploaded_file($_FILES["page_img2"]["tmp_name"], $target_file)) {
				$SQL="UPDATE `page` SET `page_img2`='".$FILE_NAME."' WHERE `page_id`=".$last_id;
				mysql_query($SQL, $conn) or die(mysql_error());
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
			
		 
				
	  }
 
 
  }
 
  if(isset($_FILES['page_pdf']) && $_FILES['page_pdf']["name"]!="")
  {  
  	$uploadOk = 1;
 	 //upload image
    $target_dir = "upload/page/";
	$filename = $_FILES['page_pdf']["name"];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$target_file = $target_dir . $last_id.".".$ext;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);	 
	 
	 
	// Allow certain file formats
	if($imageFileType != "pdf"  ) {
		echo "Sorry, only pdf files are allowed.";
		$uploadOk = 0;
	}
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		 
			if (move_uploaded_file($_FILES["page_pdf"]["tmp_name"], $target_file)) {
				$SQL="UPDATE `page` SET `page_pdf`='".$target_file."' WHERE `page_id`=".$last_id;
				mysql_query($SQL, $conn) or die(mysql_error());
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
			
		 
				
	  }
 
  } 
  
    
  
  $updateGoTo = "new_page.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conn, $conn);
$query_rs_info = "SELECT * FROM info";
$rs_info = mysql_query($query_rs_info, $conn) or die(mysql_error());
$row_rs_info = mysql_fetch_assoc($rs_info);
$totalRows_rs_info = mysql_num_rows($rs_info);

$colname_rs_user = "-1";
if (isset($_GET['id'])) {
  $colname_rs_user = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_rs_user = sprintf("SELECT * FROM page WHERE page_id = %s", GetSQLValueString($colname_rs_user, "int"));
$rs_user = mysql_query($query_rs_user, $conn) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);

 mysql_select_db($database_conn, $conn);
$query_rs_subcat = "SELECT * FROM subcat LEFT JOIN category ON category_id = id";
$rs_subcat = mysql_query($query_rs_subcat, $conn) or die(mysql_error());
$row_rs_subcat = mysql_fetch_assoc($rs_subcat);
$totalRows_rs_subcat = mysql_num_rows($rs_subcat);



mysql_select_db($database_conn, $conn);
$query_rs_ahdas = "SELECT * FROM ahdas";
$rs_ahdas = mysql_query($query_rs_ahdas, $conn) or die(mysql_error());
$row_rs_ahdas = mysql_fetch_assoc($rs_ahdas);
$totalRows_rs_ahdas = mysql_num_rows($rs_ahdas);


mysql_select_db($database_conn, $conn);
$query_rs_pagexahdas = sprintf("SELECT * FROM pagexahdas WHERE page_id = %s", GetSQLValueString($_GET['id'], "int"));
$rs_pagexahdas = mysql_query($query_rs_pagexahdas, $conn) or die(mysql_error());
$selected_ahdas=array();
while ($row_rs_pagexahdas = mysql_fetch_assoc($rs_pagexahdas))
{
	$selected_ahdas[] = $row_rs_pagexahdas['ahdas_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sira</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include("top_left_menu.php");?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" align="center">Update Paragraph</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           <!-- -----------------------------------Start------------------------------------------------------------>
           <div class="row">
             <form method="post" name="form1"  enctype="multipart/form-data" action="<?php echo $editFormAction; ?>">
           <div class="col-md-12">
             	<div class="col-md-6">
                	<div class="form-group">
                        <label for="Name">Name:</label>
                        <input type="text" required class="form-control" name="page_name" value="<?php echo $row_rs_user['page_name']; ?>">
                      </div>
                </div>
               
             <div class="col-md-12">
                	<div class="form-group">
                     <label for="Note">Description:</label>
                       
                        <textarea id="q1" class=" form-control" name="page_note"><?php echo $row_rs_user['page_note']; ?></textarea>
                      </div>
                </div>
                 <div class="col-md-12">
                	<div class="form-group">
                    	<img src="upload/page/<?php echo $row_rs_user['page_img1']; ?>" style="max-height:125px;"   /><br>

                        <label for="Note">Image 1:</label>
                       <input type="file" name="page_img1" id="page_img1">
                        
                      </div>
                </div>
                
                 <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Label image 1:</label>
                       <input type="text" name="label_img1" value="<?php echo $row_rs_user['label_img1']; ?>" id="label_img1">
                        
                      </div>
                </div>
                
                <br>
<br>

                 <div class="col-md-12">
                	<div class="form-group">
                    	<img src="upload/page/<?php echo $row_rs_user['page_img2']; ?>"  style="max-height:125px;"  /><br>

                        <label for="Note">Image 2:</label>
                       <input type="file" name="page_img2" id="page_img2">
                        
                      </div>
                </div>
                   <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Label image 2:</label>
                       <input type="text" name="label_img2" value="<?php echo $row_rs_user['label_img2']; ?>" id="label_img2">
                        
                      </div>
                </div>
                 
                <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Select Catgory:</label>
                <select name="sub_cat" style="direction: rtl;">
  <?php
do {  
?>
  <option value="<?php echo $row_rs_subcat['s_id']?>" <?php if (!(strcmp($row_rs_subcat['s_id'], $row_rs_user['sub_cat']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_subcat['name'].' --- '.$row_rs_subcat['s_name']?> .<?php echo $row_rs_subcat['s_id']?></option>
  <?php
} while ($row_rs_subcat = mysql_fetch_assoc($rs_subcat));
  $rows = mysql_num_rows($rs_subcat);
  if($rows > 0) {
      mysql_data_seek($rs_subcat, 0);
	  $row_rs_subcat = mysql_fetch_assoc($rs_subcat);
  }
?>
</select>
   
                      </div>
                </div>
                
                 <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Background code color(e.g #FFFFFF):</label>
                       <input type="text" name="color" value="<?php echo $row_rs_user['color']; ?>" id="color">
                        
                      </div>
                </div>
                
                
                 <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">اضافة حدث</label>
                                <select name="ahdas_id[]" multiple size="6">
  <?php
do {  
?>
  <option value="<?php echo $row_rs_ahdas['id']?>" <?php if(in_array($row_rs_ahdas['id'] ,$selected_ahdas)) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_ahdas['year']?></option>
  <?php
} while ($row_rs_ahdas = mysql_fetch_assoc($rs_ahdas));
  $rows = mysql_num_rows($rs_ahdas);
  if($rows > 0) {
      mysql_data_seek($rs_ahdas, 0);
	  $row_rs_ahdas = mysql_fetch_assoc($rs_ahdas);
  }
?>
</select>
                        
                      </div>
                </div>
                 
                
                 <div class="col-md-6">
                  <label for="submit">&nbsp;</label>
                 <input type="submit" class="form-control btn btn-primary" value="Save">
                 
                 </div>
                
             </div>
              
                   
             
               <input type="hidden" name="MM_update" value="form1">
               <input type="hidden" name="page_id" value="<?php echo $row_rs_user['page_id']; ?>">
             </form>
             <p>&nbsp;</p>
           </div>
            <!-- -------------------------- End --------------------------------------------------------------------->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    <script src="js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
   CKEDITOR.replace( 'q1' );

    </script>

</body>

</html>
<?php
mysql_free_result($rs_info);

mysql_free_result($rs_user);
 
?>
