<title>Myapp</title>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <a class="navbar-brand" href="index.php"><?php echo $_SESSION['MM_AppTitle'] ?></a> </div>
    
    <h3 align="center" style="position: absolute;left: 45%;top: -9px;"><?php echo $_SESSION['MM_AppTitle'] ?></h3>
  <!-- /.navbar-header -->
  
 
  <!-- /.navbar-top-links -->
  
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        
        <li> <a  href="new_page.php"><i class="fa fa-barcode fa-fw"></i> Pages</a> </li>
          <li> <a  href="ahdas.php"><i class="fa fa-barcode fa-fw"></i> Ahdas</a> </li>
         
        
         
          <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a> </li>
      </ul>
    </div>
    <!-- /.sidebar-collapse --> 
  </div>
  <!-- /.navbar-static-side --> 
</nav>
