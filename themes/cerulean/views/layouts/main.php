<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-wid th, initial-scale=1">
	<meta name="Description" content="Make your business optimize with Capella ERP Indonesia The Best Web ERP Apps">
	<meta name="msapplication-square310x310logo" content="<?php echo Yii::app()->request->baseUrl;?>/images/launcher-icon-192192.png">
	<meta name="theme-color" content="#f00">
	<link rel="manifest" href="<?php echo Yii::app()->request->baseUrl;?>/manifest.json">
	<link rel="icon" sizes="192x192" href="<?php echo Yii::app()->request->baseUrl;?>/images/launcher-icon-192192.png">
	<link rel="apple-touch-icon" sizes="192x192" href="<?php echo Yii::app()->request->baseUrl;?>/images/launcher-icon-192192.png">
  <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="<?= Yii::app()->theme->baseUrl;?>/bootstrap/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo Yii::app()->createUrl('admin')?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>C</b>MS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php echo $this->getParameter('sitetitle')?></b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <img src="<?php echo Yii::app()->request->baseUrl?>/images/useraccess/<?php echo Yii::app()->user->id ?>.jpg" class="user-image" alt="User Image">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $this->getUserData()['realname']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <img src="<?php echo Yii::app()->request->baseUrl?>/images/useraccess/<?php echo Yii::app()->user->id ?>.jpg" class="img-circle" alt="User Image">
                    <p>
                      <?php echo $this->getUserData()['realname']?>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="<?php echo Yii::app()->createUrl('site/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                    <div class="pull-left">
                      <a href="<?php echo Yii::app()->createUrl('admin/dashboard')?>" class="btn btn-default btn-flat">Dashboard</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo Yii::app()->request->baseUrl?>/images/useraccess/<?php echo Yii::app()->user->id ?>.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $this->getUserData()['realname']?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
					<?php
					foreach($this->getUserSuperMenu() as $row)
					{
						if ($row['jumlah'] > 0)
						{
							echo "<li class='treeview'>";
							echo "<a href='#'><i class='fa fa-link'></i><span>".$row['description']."</span> <i class='fa fa-angle-left pull-right'></i></a>";
							echo "<ul class='treeview-menu'>";
							foreach($this->getUserMenu($row['menuaccessid']) as $menu)
							{
								echo "<li><a href='".Yii::app()->createUrl($menu['menuurl'])."'>".$this->getcatalog($menu['menuname'])."</a></li>";
							}
							echo "</ul>";
							echo "</li>";
						}
						else
							echo "<li><a href='#'><i class='fa fa-link'></i><span>".$row['description']."</span></a></li>";
					}
					?>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
<div id="pesan"></div>
          <?php echo $content ?>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

			
      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2015 <a href="#"><?php echo $this->getParameter('sitename')?></a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

<?php
    $this->widget('ext.etoastr.EToastr',array(
        'flashMessagesOnly'=>true, 
        'message'=>'will be ignored', 
        'options'=>array(
            'positionClass'=>'toast-bottom-full-width',
            'fadeOut'   =>  1000,
            'timeOut'   =>  5000,
            'fadeIn'    =>  1000
            )
        ));
    ?>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/bootstrap/js/bootstrap-modal.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/bootstrap/js/bootstrap-modalmanager.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/js/app.min.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/js/lte.messager.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/bootstrap/js/summernote.min.js"></script> 
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/plugins/daterangepicker/moment.min.js"></script>  
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/plugins/daterangepicker/daterangepicker.js"></script>   
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/js/autoNumeric.js"></script>
	<script src="<?php echo Yii::app()->theme->baseUrl;?>/adminlte/js/jquery.priceformat.min.js"></script>
  <script src="<?php echo Yii::app()->theme->baseUrl;?>/bootstrap/js/bootstrap-select.min.js"></script>


<script>
$(document).ready(function(){
	$(document).keyup(function (e) {
		switch(e.which) {
			case 113: //F2 - Baru
				$('#InputDialog').modal("show");
			break;
			case 115: //F4 - Aktif / Not Aktif atau Reject
				deletedata($.fn.yiiGridView.getSelection('GridList'));
			break;
			case 118: //F7 - Purge / Hapus
				purgedata($.fn.yiiGridView.getSelection('GridList'));
			break;
			case 119: //F8 - Search
				$('#SearchDialog').modal("show");
			break;
			case 121: //F10 - PDF
				downpdf($.fn.yiiGridView.getSelection('GridList'));
			break;
			case 123: //F12 - XLS
				downxls($.fn.yiiGridView.getSelection('GridList'));
			break;
		}
		e.preventDefault();
	});
	$( ":input[name*='dlg_search_']" ).keyup(function(e){
	if(e.keyCode == 13)
	{
		searchdata();
	}});
	$('#SearchDialog').on('shown.bs.modal', function() {
		$(":input[name*='search_']:visible:first").focus();
	});
	$('#InputDialog').on('shown.bs.modal', function() {
		$(":input:not(input[type=button],input[type=submit],button):visible:first").focus();
	});
});
</script>
	<script type="text/javascript">
$(document).ready(function(){
	$('.auto').autoNumeric('init');
	});
</script>
<script type="text/javascript">
$(document).ready(function(){
		$('#formatuang').priceFormat({
			prefix:'',
			centsSeparator: ',',
			centsLimit: 2,
			thousandsSeparator: '.'
		});
});
</script>
</body>
</html>
