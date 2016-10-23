<?php require_once('template_header.php'); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO users ( user_name, user_username, user_password, user_level) VALUES ( %s, %s, %s, %s)",
                     
                       GetSQLValueString($_POST['user_name'], "text"),
                       GetSQLValueString($_POST['user_username'], "text"),
                       GetSQLValueString($_POST['user_password'], "text"),
                       GetSQLValueString($_POST['user_level'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

mysql_select_db($database_conn, $conn);
$query_rs_users = "SELECT * FROM users";
$rs_users = mysql_query($query_rs_users, $conn) or die(mysql_error());
$row_rs_users = mysql_fetch_assoc($rs_users);
$totalRows_rs_users = mysql_num_rows($rs_users);


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
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      
      <div class="col-lg-12">
        <div class="col-lg-6">
          <div class="form-group">
            <label for="username">User name:</label>
            <input type="text" required class="  form-control" name="user_username" autocomplete="off">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="Password">Password:</label>
            <input type="password" required class="form-control" name="user_password" autocomplete="off">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="name">Full Name:</label>
            <input required type="text" class=" form-control" name="user_name" autocomplete="off">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="level">level:</label>
            <select name="user_level" class="form-control">
              <option value="admin" >Admin</option>
              <option value="user"  >User</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
            <label for="submit">&nbsp;</label>
            <input type="submit" class="form-control btn btn-primary" value="Save">
            <input type="hidden" name="MM_insert" value="form1" />
          </div>
        </div>
      </div>
    </form>
    <br>
    <br>
    <table id="USERS_TABLE" class="display" cellspacing="0" width="100%"   >
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>User Name</th>
          <th>Level</th>
          <th data-align="center">Edit</th>
          <th data-align="center">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php do { ?>
          <tr>
            <td><?php echo $row_rs_users['user_id']; ?></td>
            <td><?php echo $row_rs_users['user_name']; ?></td>
            <td><?php echo $row_rs_users['user_username']; ?></td>
            <td><?php echo $row_rs_users['user_level']; ?></td>
            <td><a  href="edit_user.php?id=<?php echo $row_rs_users['user_id']; ?>" title="Delete"><span class="fa fa-edit"></span></a></td>
            <td ><a onclick="return confirm('Are you sure?');" href="delete_user.php?id=<?php echo $row_rs_users['user_id']; ?>" title="Delete"><span class="fa fa-trash"></span></a></td>
          </tr>
          <?php } while ($row_rs_users = mysql_fetch_assoc($rs_users)); ?>
      </tbody>
    </table>
    <!-- -------------------------- End ---------------------------------------------------------------------> 
  </div>
  <!-- /#page-wrapper --> 
  
</div>
<script type="text/javascript">
	$(document).ready(function() {
	var USERS_TABLE=	$('#USERS_TABLE').DataTable();
 
	});
    </script> 
<!-- /#wrapper -->
<?php require_once('template_footer.php'); ?>
