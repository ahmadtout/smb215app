<?php require_once('template_header.php'); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE audio SET audio_name=%s, audio_link=%s WHERE audio_id=%s",
                       GetSQLValueString($_POST['audio_name'], "text"),
                       GetSQLValueString($_POST['audio_link'], "text"),
                       GetSQLValueString($_POST['audio_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "audio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs_audio = "-1";
if (isset($_GET['id'])) {
  $colname_rs_audio = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_rs_audio = sprintf("SELECT * FROM audio WHERE audio_id = %s", GetSQLValueString($colname_rs_audio, "int"));
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
                    <h1 class="page-header" align="center"><?php echo $_SESSION['MM_AppTitle'] ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
           <!-- -----------------------------------Start------------------------------------------------------------>
           <div class="row">
                
                
                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Audio_name:</td>
      <td><input type="text" name="audio_name" value="<?php echo htmlentities($row_rs_audio['audio_name'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Audio_link:</td>
      <td><input type="text" name="audio_link" value="<?php echo htmlentities($row_rs_audio['audio_link'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="audio_id" value="<?php echo $row_rs_audio['audio_id']; ?>" />
</form>
                
            </div>
            <!-- -------------------------- End --------------------------------------------------------------------->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php require_once('template_footer.php'); ?>