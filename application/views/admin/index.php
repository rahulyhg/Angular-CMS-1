
<!DOCTYPE html>

<!-- define angular app -->
<html ng-app="scotchApp">
<head>
  <!-- SCROLLS -->
  <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" />
  <link rel="stylesheet" href="<?=base_url();?>assets/css/ng-ckeditor.css">
  <style>
	  input.ng-invalid.ng-dirty ~ .help-block {
	  color: #b94a48;
	  }
	.right_bar{float: left;
		width: 170px;
		background: whitesmoke;
		margin-left: 25px;
		min-height: 600px;
		border-radius: 5px;padding:15px;}
  </style>
  <!-- SPELLS -->
  <script src="<?=base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?=base_url();?>assets/js/angular.js"></script>  
  <script src="<?=base_url();?>assets/js/angular-route.js"></script>
  <script src="<?=base_url();?>assets/js/script.js"></script>
  
   <script src="<?=base_url();?>assets/js/ckeditor.js"></script>
   <script src="<?=base_url();?>assets/js/02-directive.js"></script>

  
  
</head>

<!-- define angular controller -->
<body ng-controller="mainController">
  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" >Angular CMS</a>
      </div>

      <ul class="nav navbar-nav navbar-right" style="float: right;">
	<li><a href="#home"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-home"></i> Add page</a></li>
        <!--<li><a href="#about"><i class="fa fa-shield"></i> About</a></li>
        <li><a href="#contact"><i class="fa fa-comment"></i> Contact</a></li>-->
        <li><a href="#pages"><i class="fa fa-book"></i> Pages</a></li>
	<li><a ng-click="logout()"><i class="fa fa-book"></i> Log out</a></li>
      </ul>
    </div>
  </nav>  
    <!-- angular templating -->
    <!-- this is where content will be injected -->
    <div id="main">
    <div ng-view></div>    
  </div>  
  <footer class="text-center"> </footer>  
</body>
</html>
