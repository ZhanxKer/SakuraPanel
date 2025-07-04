<?php
global $_config;
if(!$_config['register']['enable']) {
	exit("<script>location='?page=login';</script>");
}
?>
<!DOCTYPE HTML>
<html lang="zh_CN">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=11">
		<meta name="msapplication-TileColor" content="#F1F1F1">
		<link href="https://lf9-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
		<?php if($_config['recaptcha']['enable']) echo '<script src="https://www.recaptcha.net/recaptcha/api.js?render=' . $_config['recaptcha']['sitekey'] . '" defer></script>'; ?>
		<title>注册 :: <?php echo $_config['sitename']; ?> - <?php echo $_config['description']; ?></title>
		<style type="text/css">.full-width{width:100%;}.logo{font-weight:400;}body:before{content:"";display:block;position:fixed;left:0;top:0;width:100%;height:100%;z-index:-10;}body,body:before{background-color:#000;background-image:url(https://i.loli.net/2019/08/13/7EqLWfi1tw6M2Qn.jpg);background-size:cover;background-position:center;background-attachment:fixed;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;}.main-box{width:100%;background:rgba(255,255,255,0.9);border:32px solid rgba(0,0,0,0);border-bottom:16px solid rgba(0,0,0,0);box-shadow:0px 0px 32px rgba(0,0,0,0.75);}.copyright{position:fixed;bottom:16px;left:32px;color:#FFF;font-size:16px;text-shadow:0px 0px 8px rgba(0,0,0,0.75);}@media screen and (max-width:992px){.padding-content{display:none;}.main-content{width:100%;max-width:100%;flex:0 0 100%;}.main-box{width:70%;}}@media screen and (max-width:768px){.padding-content{display:none;}.main-content{width:100%;max-width:100%;flex:0 0 100%;}.main-box{width:100%;}}</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 padding-content"></div>
				<div class="col-sm-6 main-content">
					<table style="width: 100%;height: 100vh;">
						<tr style="height: 100%;">
							<td style="height: 100%;padding-bottom: 64px;">
								<center>
									<?php
									if(isset($data['status']) && isset($data['message'])) {
										$alertType = $data['status'] ? "success" : "danger";
										echo '<div class="alert alert-' . $alertType . ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $data['message'] . '</div>';
									}
									?>
									<div class="main-box text-left">
										<h2 class="logo"><?php echo $_config['sitename']; ?></h2>
										<p><?php echo $_config['description']; ?></p>
										<hr>
										<form method="POST" action="?action=register&page=register">
											<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
											<p><b>账号</b></p>
											<p><input type="text" class="form-control" name="username" id="username" require /></p>
											<p><b>邮箱</b></p>
											<p><input type="email" class="form-control" name="email" id="email" require /></p>
											<?php
											if($_config['smtp']['enable']) {
											?>
											<p><b>验证码</b> <small><a href="javascript:sendcode()">[点击发送]</a></small></p>
											<p><input type="number" class="form-control" name="verifycode" id="verifycode" require /></p>
											<?php
											}
											if($_config['register']['invite']) {
											?>
											<p><b>邀请码</b></p>
											<p><input type="text" class="form-control" name="invitecode" id="invitecode" require /></p>
											<?php
											}
											?>
											<p><b>密码</b></p>
											<p><input type="password" class="form-control" name="password" id="password" require /></p>
											<p><button type="submit" class="btn btn-primary full-width">注册</button></p>
											<?php
											if($_config['register']['enable']) {
												echo "<p class='text-center'>已经注册了？<a href='?page=login'>立即登录</a></p>";
											}
											?>
										</form>
									</div>
								</center>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<p class="copyright">&copy; <?php echo date("Y") . " {$_config['sitename']}"; ?></p>
		<?php
		if($_config['recaptcha']['enable']) {
			echo <<<EOF
		<script type="text/javascript">
			window.onload = function() {
				grecaptcha.ready(function() {
					grecaptcha.execute('{$_config['recaptcha']['sitekey']}', {action:'validate_captcha'}).then(function(token) {
						document.getElementById('g-recaptcha-response').value = token;
					});
				});
			}
		</script>
EOF;
		}
		?>
		<script type="text/javascript">
			function sendcode() {
				var htmlobj = $.ajax({
					type: 'POST',
					url: "?action=sendmail",
					data: {
						mail: $("#email").val()
					},
					async:true,
					error: function() {
						return;
					},
					success: function() {
						alert(htmlobj.responseText);
						return;
					}
				});
			}
		</script>
	</body>
</html>
