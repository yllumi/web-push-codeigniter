
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<link rel="canonical" href="<?= site_url(); ?>">
	<title>Web Push PHP</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		small {font-style:italic;color:#666;margin: -10px 0 10px;display: block;}
	</style>
</head>
<body>
	<div class="container my-5">
		<h1 class="text-center mb-5">Kirim Web Push dengan PHP</h1>

		<div class="row">

			<div class="col-md-6 mb-3">

				<div class="card">
					<div class="card-body">

						<p>Generate VAPID key dari server:</p>

						<div class="form-group">
							<label for="publickey">Public Key</label>
							<small>Gunakan <em>public key</em> ini pada aplikasi push notification di client side</small>
							<div class="input-group">
								<input type="text" class="form-control" id="publickey">
								<div class="input-group-append">
									<button type="button" class="btn btn-outline-secondary" onclick='document.getElementById("publickey").select();document.execCommand("copy");'>copy</button>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="privatekey">Private Key</label> 	
							<small>Digunakan oleh server untuk autentikasi. <strong>Jangan simpan di client side!</strong></small>
							<input type="text" class="form-control" id="privatekey" disabled value="">
						</div>

						<div class="form-group">
							<button type="button" class="btn btn-outline-primary" id="regenerate">Regenerate Key</button>
						</div>

						<small><strong>Perhatian:</strong> Kamu akan perlu subscribe ulang notifikasi di client bila kamu menggenerate ulang VAPID</small>

					</div>
				</div>
			</div>

			<div class="col-md-6">

				<div class="card">
					<div class="card-body">

						<p>Gunakan form ini untuk mensimulasikan web push dari server:</p>

						<div class="form-group">
							<label for="subscription">Subscription JSON</label>
							<small>Salin subscription JSON disini</small>
							<textarea id="subscription" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="payload">Payload</label>
							<small>Tulis payload yang akan dikirim kesini</small>
							<textarea id="payload" class="form-control">{"title":"Judul Notifikasi","body":"Pesan notifikasi diterima.","url":"https://www.codepolitan.com"}</textarea>
						</div>

						<button class="btn btn-outline-success" id="send" type="button">Kirim Payload</button>

					</div>
				</div>

			</div>

			<div class="col-12">
				<div id="result" class="p-2 mt-3 bg-light text-secondary border"></div>
			</div>
		</div>
	</div>
	
	<script>
		var base_url = '<?= base_url(); ?>';
		var site_url = '<?= site_url(); ?>';
	</script>
	<script src="<?= base_url(); ?>main.js"></script>
</body>
</html>
