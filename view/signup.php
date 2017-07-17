<html>
<head>
	<title>User sign up</title>
	<meta charset="utf-8">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-0"></div>
			<div class="col-md-8 col-sm-8 col-xs-12">
				<div class="page-header">
		  			<h1>Sign Up</h1>
				</div>

				<?php if (!empty($successTxt)) : ?>
				<div class="alert alert-success">
					<?= $successTxt ?>
				</div>
				<?php endif; ?>
	
				<form method="post" action="">
					<fieldset>
						<?php if (!empty($errorList['emailToto'])) : ?>
						<div class="alert alert-danger">
							<?php foreach ($errorList['emailToto'] as $currentError) : ?>
								<?= $currentError ?><br>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
						<input type="email" class="form-control" name="emailToto" value="<?= $email ?>" placeholder="Email address" /><br />
						<?php if (!empty($errorList['passwordToto'])) : ?>
						<div class="alert alert-danger">
							<?php foreach ($errorList['passwordToto'] as $currentError) : ?>
								<?= $currentError ?><br>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
						<input type="password" class="form-control" name="passwordToto1" value="" placeholder="Your password" /><br />
						<input type="password" class="form-control" name="passwordToto2" value="" placeholder="Confirm your password" /><br />
						<input type="submit" class="btn btn-success btn-block" value="Sign up" />
					</fieldset>
				</form>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-0"></div>
		</div>

	</div>

</body>
</html>