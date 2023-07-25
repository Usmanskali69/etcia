<fieldset>
<div class="col-lg-12">
<div class="col-lg-6">
<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">General Instructions</h3>
			</div>
			<div class="panel-body">

<div class="panel-body">
	
	<ul>
		<li><a href="http://www.aicte-india.org/JnKadmissions.php" target="_blank" style="color:blue"><u>Notifications about J&K Admissions Online Process</u></a><br></li>
		<li><a href="http://http://"<?php echo $_SERVER['HTTP_HOST'];?>"/partials/instructions.php" target="_blank" style="color:blue"><u>Instructions for J&K Admissions Online Process</u></a></li>
	</ul>
	
	</div>
</div>
</div>
</div>

<div class="col-lg-6">
<div class="row">

		<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Sign In</h3>
			</div>
			<div class="panel-body ">
				<!--<div class="alert alert-danger">
					<cite>**Incorrect Username or Password**</cite>
				</div>-->
				<div class="col-lg-offset-2 col-lg-8">
				<form role="form" method="post" action="session/auth.php?do=login">
						
						<div class="form-group" style="padding-left:0px;">
							<input class="form-control" name="loginName" placeholder="Email or username" type="text" autofocus />
						</div>
						<div class="form-group" >
							<input class="form-control" name="password" placeholder="Password" type="password">
						</div>
						<!--<div class="checkbox">
							<label>
								<input type="checkbox" name="remember" value="Remember Me">Remember Me
							</label>
						</div>-->
						<!-- Change this to a button or input when using this as a form -->
						<button class="btn btn-lg btn-success btn-block">Login</button>
						
					
				</form>
				</div>
				</div>
				</div>
</div>
</div>
</fieldset>  