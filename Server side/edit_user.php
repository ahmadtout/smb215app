<?php require_once('template_header.php'); 

$colname_rs_users = "-1";
if (isset($_GET['id'])) {
  $colname_rs_users = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_rs_users = sprintf("SELECT * FROM users WHERE user_id = %s", GetSQLValueString($colname_rs_users, "int"));
$rs_users = mysql_query($query_rs_users, $conn) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_users);
$totalRows_rs_users = mysql_num_rows($rs_users);


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET user_name=%s, user_username=%s, user_password=%s, user_level=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  
   $updateGoTo = "users.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include("top_left_menu.php");?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" align="center"><?php echo $_SESSION['MM_AppTitle'] ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           <!-- -----------------------------------Start------------------------------------------------------------>
           <div class="row">
             <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
              <div class="col-md-12">
             	<div class="col-md-6">
                	<div class="form-group">
                        <label for="username">User name:</label>
                        <input type="text" required class="  form-control" value="<?php echo htmlentities($row_rs_user['user_username'], ENT_COMPAT, 'utf-8'); ?>" name="username">
                      </div>
                </div>
                 <div class="col-md-6">
                	<div class="form-group">
                        <label for="Password">Password:</label>
                        <input type="password" required class="form-control" value="*****************" name="password">
                      </div>
                </div>
             
             	<div class="col-md-6">
                	<div class="form-group">
                        <label for="name">Full Name:</label>
                        <input required type="text" value="<?php echo htmlentities($row_rs_user['user_name']); ?>" class=" form-control" name="name">
                      </div>
                </div>
                
                <div class="col-md-6">
                	<div class="form-group">
                        <label for="level">level:</label>
                        <select name="level" class="form-control">
                          <option value="admin" <?php if (!(strcmp("admin", $row_rs_user['user_level']))) {echo "selected=\"selected\"";} ?>>Admin</option>
                          <option value="user" <?php if (!(strcmp("user", $row_rs_user['user_level']))) {echo "selected=\"selected\"";} ?>>User</option>
                   </select>
                      </div>
                </div>
                
                   
                 <div class="col-md-6">
                  <label for="submit">&nbsp;</label>
                 <input type="submit" class="form-control btn btn-primary" value="Save">
                 
                 </div>
                
             </div>
               <input type="hidden" name="MM_update" value="form1" />
               <input type="hidden" name="id" value="<?php echo $row_rs_user['user_id']; ?>">
             </form>
             <p>&nbsp;</p>
           </div>
            <!-- -------------------------- End --------------------------------------------------------------------->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require_once('template_footer.php'); ?>