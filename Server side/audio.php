<?php require_once('template_header.php');
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO audio (`audio_name`, audio_link) VALUES (%s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['link'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "audio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_rs_audio = "SELECT * FROM audio";
$rs_audio = mysql_query($query_rs_audio, $conn) or die(mysql_error());
$row_rs_audio = mysql_fetch_assoc($rs_audio);
$totalRows_rs_audio = mysql_num_rows($rs_audio);
 ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include("top_left_menu.php");?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" align="center">Audio</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           <!-- -----------------------------------Start------------------------------------------------------------>
           <div class="row">
                
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center" width="">
    <tr valign="middle">
      <td nowrap align="right">Audio Name:</td>
      <td><input type="text" class="form-control" name="name" value="" size="32"></td>
    </tr>
    <tr valign="middle">
      <td nowrap align="right">Audio Link:</td>
      <td><textarea name="link" class="form-control" ></textarea></td>
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
    <th>Name</th>
    <th>Link</th>
    <th>Delete</th>
  </tr>
  </thead>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rs_audio['audio_id']; ?></td>
      <td><?php echo $row_rs_audio['audio_name']; ?></td>
      <td><?php echo $row_rs_audio['audio_link']; ?></td>
       <td ><a href="edit_audio.php?id=<?php echo $row_rs_audio['audio_id']; ?>" title="Delete"><span class="fa fa-edit"></span></a></td>
       <td ><a onclick="return confirm('Are you sure?');" href="delete_audio.php?id=<?php echo $row_rs_audio['audio_id']; ?>" title="Delete"><span class="fa fa-trash"></span></a></td>
    </tr>
    <?php } while ($row_rs_audio = mysql_fetch_assoc($rs_audio)); ?>
</table>

                
            </div>
            <!-- -------------------------- End --------------------------------------------------------------------->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require_once('template_footer.php'); ?>