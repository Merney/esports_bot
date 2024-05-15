<?php
    session_start();
    if(isset($_SESSION['id'])) {
        header('Location: index.php');
        exit;
    }
?>
<!doctype html>
<html lang="en" class="semi-dark">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>Esports - Login Page</title>
</head>

<body class="bg-login">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mb-0">
							<div class="card-body">
								<div class="p-4">
									<div class="text-center mb-4">
										<h5 class="">Esports Admin</h5>
										<p  class="mb-0">Please log in to your account</p>
                                        <p style="color: red;" id="res" class="mb-0"></p>
									</div>
									<div class="form-body">
											<div class="col-12">
												<label for="token" class="form-label">Token</label>
												<input type="text" class="form-control" name="token" id="token" placeholder="Token">
											</div>
                                            <br>
											<div class="col-12">
												<div class="d-grid">
													<button onclick="login()" class="btn btn-primary">Sign in</button>
												</div>
											</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
        function login() {
            var settings = {
                "url": "/API/Admin/login.php",
                "method": "POST",
                "timeout": 0,
                "headers": {
                    "Content-Type": "text/plain"
                },
                "data": "{\"token\":\"" + $("#token").val() + "\"}",
            };

            $.ajax(settings).done(function (response) {
                res = JSON.parse(response);
                console.log("Good");
                $("#res").html(res.message);
                setTimeout(function(){
                    window.location = "index.php";
                },3000);

                //console.log(res.userId);
            })
            .fail(function (jqXHR, response, errorThrown) {
                res = JSON.parse(jqXHR.responseText);
                console.log(res);
                $("#res").html(res.message);
            });
        }
	</script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
</body>

</html>