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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO page ( page_name, page_note, sub_cat, label_img1, label_img2, color) VALUES ( %s,   %s,   %s, %s,  %s,    %s)",
                
                       GetSQLValueString($_POST['page_name'], "text"),
                       GetSQLValueString($_POST['page_note'], "text"),
					   GetSQLValueString($_POST['sub_cat'], "int"),
					   
					   GetSQLValueString($_POST['label_img1'], "text"),
					   GetSQLValueString($_POST['label_img2'], "text"),
					   GetSQLValueString($_POST['color'], "text")
					   );

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
   $last_id = mysql_insert_id();
   
   if(isset($_POST['ahdas_id']) && is_array($_POST['ahdas_id']) && count($_POST['ahdas_id'])>0)
   foreach($_POST['ahdas_id'] as $v)
   {
    $insertSQL = sprintf("INSERT INTO pagexahdas (page_id, ahdas_id) VALUES (%s, %s)",
                       GetSQLValueString($last_id , "int"),
                       GetSQLValueString($v, "int"));
 
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
   }
   
   if(isset($_FILES['page_img1']) && $_FILES['page_img1']["name"]!="")
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
  
  
  
   if(isset($_FILES['page_img2']) && $_FILES['page_img2']["name"]!="")
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
}



mysql_select_db($database_conn, $conn);
$query_rs_info = "SELECT * FROM info";
$rs_info = mysql_query($query_rs_info, $conn) or die(mysql_error());
$row_rs_info = mysql_fetch_assoc($rs_info);
$totalRows_rs_info = mysql_num_rows($rs_info);

mysql_select_db($database_conn, $conn);
$query_rs_users = "SELECT * FROM page a 
order by a.page_id ASC
";
$rs_users = mysql_query($query_rs_users, $conn) or die(mysql_error());
$row_rs_users = mysql_fetch_assoc($rs_users);
$totalRows_rs_users = mysql_num_rows($rs_users);

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
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BookInterface</title>

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
<link rel="stylesheet" type="text/css" href="css/bootstrap-table.css">
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
                    <h1 class="page-header" align="center">Paragraph</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           <!-- -----------------------------------Start------------------------------------------------------------>
           <div class="row">
             <form method="post" name="form1"   enctype="multipart/form-data"  action="<?php echo $editFormAction; ?>">
             <div class="col-md-12">
             	<div class="col-md-6">
                	<div class="form-group">
                        <label for="Name">Name:</label>
                        <input type="text" required class="form-control" name="page_name">
                      </div>
                </div>
               
             <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Description:</label>
                        <textarea id="q1" class=" form-control" name="page_note"></textarea>
                      </div>
                </div>
                <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Image 1:</label>
                       <input type="file" name="page_img1" id="page_img1">
                        
                      </div>
                </div>
                
                 <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Label image 1:</label>
                       <input type="text" name="label_img1" id="label_img1">
                        
                      </div>
                </div>
                
                
                
                <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Image 2:</label>
                       <input type="file" name="page_img2" id="page_img2">
                        
                      </div>
                </div>
                
                <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Label image 2:</label>
                       <input type="text" name="label_img2" id="label_img2">
                        
                      </div>
                </div>
                
                <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Select Catgory:</label>
                <select name="sub_cat" style="direction: rtl;">
  <?php
do {  
?>
  <option value="<?php echo $row_rs_subcat['s_id']?>"><?php echo $row_rs_subcat['name'].' --- '.$row_rs_subcat['s_name']?> .<?php echo $row_rs_subcat['s_id']?></option>
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
                       <input type="text" name="color" id="color">
                        
                      </div>
                </div>
                
                
                   <div class="col-md-12">
                	<div class="form-group">
                       <label for="Note">Notes: </label>
                                <select name="ahdas_id[]" multiple size="6">
  <?php
do {  
?>
  <option value="<?php echo $row_rs_ahdas['id']?>"><?php echo $row_rs_ahdas['year']?></option>
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
               <input type="hidden" name="MM_insert" value="form1">
             </form>
             <p>&nbsp;</p>
<table data-toggle="table"
             		data-pagination="true"
     
      				data-page-list="[5, 10, 20, 50, 100, 200]"
                   data-search="true"
                   data-height="600"
                   data-classes="table table-hover table-condensed"
      				data-striped="true"
             >
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Desc</th>
            <th>Category</th>
            <th>Image 1</th>
             <th>Label Image 1</th>
            <th>Image 2</th>
             <th>Label Image 2</th>
             <th>Color</th>
              <th>حدث</th>
            <th data-align="center">Edit</th>
            <th data-align="center">Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php do { ?>
              <tr>
                <td><?php echo $row_rs_users['page_id']; ?></td>
                <td><?php echo $row_rs_users['page_name']; ?></td>
                <td><?php echo $row_rs_users['page_note']; ?></td>
                <td><?php echo $row_rs_users['sub_cat']; ?></td>
           		 <td><img src="upload/page/<?php echo $row_rs_users['page_img1']; ?>" style="max-width:125px;" /></td>
                 <td><?php echo $row_rs_users['label_img1']; ?></td>
                 <td><img src="upload/page/<?php echo $row_rs_users['page_img2']; ?>" style="max-width:125px;" /></td>
                  <td><?php echo $row_rs_users['label_img2']; ?></td>
                  <td><?php echo $row_rs_users['color']; ?><div style="width:50px;height:50px;background-color:<?php echo $row_rs_users['color']; ?>"></div></td>
                  <td><?php 
				  
				  mysql_select_db($database_conn, $conn);
					$query_rs_ahdas = "SELECT * FROM ahdas ad
					left join pagexahdas x on  x.ahdas_id= ad.id
					 where page_id = ".$row_rs_users['page_id']."
					";
					$rs_ahdas = mysql_query($query_rs_ahdas, $conn) or die(mysql_error());
					$row_rs_ahdas = mysql_fetch_assoc($rs_ahdas);
					$totalRows_rs_ahdas = mysql_num_rows($rs_ahdas);

   do {  
  
      echo $row_rs_ahdas['year']."<br/>";  
      
    } while ($row_rs_ahdas = mysql_fetch_assoc($rs_ahdas));  

				    ?></td>
                  
                <td><a  href="edit_page.php?id=<?php echo $row_rs_users['page_id']; ?>" title="Edit"><span class="fa fa-edit"></span></a></td>
                 <td ><a onclick="return confirm('Are you sure?');" href="delete_page.php?id=<?php echo $row_rs_users['page_id']; ?>" title="Delete"><span class="fa fa-trash"></span></a></td>
              </tr>
              <?php } while ($row_rs_users = mysql_fetch_assoc($rs_users)); ?>
          </tbody>
        </table>
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
	<script src="js/bootstrap-table.js"></script>
	<script src="js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
   CKEDITOR.replace( 'q1' );

    </script>
</body>

</html>
<?php
mysql_free_result($rs_info);

mysql_free_result($rs_users);
 
?>
