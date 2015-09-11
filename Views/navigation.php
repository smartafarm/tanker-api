<?php ?>
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class ="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only"> Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>	
			</button>
			<a class="navbar-brand" href="dashboard"><?php echo PROJECT_NAME;?></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="dashboard">Dashboard </a></li>
				<li><a href="index">Index </a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php echo ucfirst(Session::get('user'));?> 
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="dashboard/logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>