<?php require_once('template_header.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO ahdas (`year`, text) VALUES (%s, %s)",
                       GetSQLValueString($_POST['year'], "text"),
                       GetSQLValueString($_POST['text'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "notes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_rs_ahdas = "SELECT * FROM ahdas";
$rs_ahdas = mysql_query($query_rs_ahdas, $conn) or die(mysql_error());
$row_rs_ahdas = mysql_fetch_assoc($rs_ahdas);
$totalRows_rs_ahdas = mysql_num_rows($rs_ahdas);
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
  <table align="center" width="">
    <tr valign="middle">
      <td nowrap align="right">Title:</td>
      <td><input type="text" class="form-control" name="year" value="" size="32"></td>
    </tr>
    <tr valign="middle">
      <td nowrap align="right">Text:</td>
      <td><textarea name="text" class="form-control" ></textarea></td>
    </tr>
    <tr valign="middle">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="btn btn-primary" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
                
                <br>
<br>
<br>
<br>
<table border="0" class="table table-stripped table-bordered">
  <thead>
  <tr>
    <th>id</th>
    <th>year</th>
    <th>text</th>
    <th>Delete</th>
  </tr>
  </thead>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rs_ahdas['id']; ?></td>
      <td><?php echo $row_rs_ahdas['year']; ?></td>
      <td><?php echo $row_rs_ahdas['text']; ?></td>
       <td ><a onclick="return confirm('Are you sure?');" href="delete_notes.php?id=<?php echo $row_rs_ahdas['id']; ?>" title="Delete"><span class="fa fa-trash"></span></a></td>
    </tr>
    <?php } while ($row_rs_ahdas = mysql_fetch_assoc($rs_ahdas)); ?>
</table>

                
            </div>
            <!-- -------------------------- End --------------------------------------------------------------------->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require_once('template_footer.php'); ?>