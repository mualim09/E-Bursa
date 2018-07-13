<?php include "views/partials/carousel.php"; ?>

<div class="card bg-scondary my-4 text-center">
	<div class="card-body">
		<p class="m-0">
			Selamat datang di Bursa Kerja Online. Bagi yang belum mempunyai akun silahkan 
			<a href="?page=daftar">Daftar</a> terlebih dahulu. Sudah punya akun? 
			<a href="?page=login">Login</a> disini.
		</p>
	</div>
</div>

<?php  

	$id = $_GET['id'];
	
	$query = "SELECT * FROM lowongan WHERE id = '$id'";
	$process = mysqli_query($conn, $query);
	$data = mysqli_fetch_assoc($process);

	$query2 = "SELECT * FROM profil_perusahaan WHERE id = '".$data['profil_perusahaan_id']."'";
	$process2 = mysqli_query($conn, $query2);
	$data2 = mysqli_fetch_assoc($process2);

?>

<div class="row">
	<div class="col-md-8">
		<h3 class="home-title"><?php echo $data['judul'] ?></h3>
		<div class="loker-sub-head">DESKRIPSI PEKERJAAN :</div>
		<div><?php echo $data['deskripsi_pekerjaan'] ?></div>
		<div class="loker-sub-head">DESKRIPSI PERSYARATAN :</div>
		<div><?php echo $data['deskripsi_persyaratan'] ?></div>
		<div class="loker-sub-head">GAJI :</div>
		<div>IDR <?php echo number_format($data['gaji'], 0) ?></div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div>
					<table width="100%">
						<tr>
							<td class="text-center">
								<img src="assets/img/profil/perusahaan/<?php echo $data2["logo_perusahaan"] ?>" class="rounded-circle text-center" height="150px"><hr>
								<p><strong><?php echo $data2['nama_perusahaan'] ?></strong></p>
								<hr>
							</td>
						</tr>
						<tr>
							<td class="text-center"><strong>No SIUP</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['no_siup'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>No SITU</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['no_situ'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>Bidang Usaha</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['bidang_usaha'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>Deskripsi Perusahaan</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['deskripsi_perusahaan'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>Alamat</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['alamat'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>Telepon</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['telepon'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>E-Mail</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['email'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>Website</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['website'] ?></td>
						</tr>
						<tr>
							<td class="text-center"><strong>Slogan</strong></td>
						</tr>
						<tr>
							<td class="text-center"><?php echo $data2['slogan'] ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div><hr>

<?php 
	if (isset($_SESSION['hak_akses'])) {
		if ($_SESSION['hak_akses'] == 'pencaker') {
?>
	
	<div class="row">
		<div class="col-md-12 text-center">
			<a href="" class="btn btn-primary btn-lg btn-block">LAMAR SEKARANG !</a>
		</div>
	</div><hr>
<?php 
		}
?>
	<div class="row">
		<div class="col-md-8">
			<form action="?page=tambah-komentar-loker" method="POST">
				<input type="hidden" name="lowongan_id" value="<?php echo $data['id'] ?>">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
				<div class="form-group">
					<label for="komentar">TULIS KOMENTAR DISINI :</label>
					<textarea name="komentar" id="komentar" rows="5" class="form-control"></textarea>
				</div>
				<div class="form-group text-right">
					<button type="submit" class="btn btn-success">TAMBAH KOMENTAR</button>
				</div>
			</form> <hr>
		</div>
	</div>

<?php			
	}
?>
	
<div class="row">
	<div class="col-md-8">
		<?php  

			$list_data = [];
			$query3 = "SELECT * FROM lowongan_komentar WHERE lowongan_id = '".$data['id']."'";
			$process3 = mysqli_query($conn, $query3);
			while($row = mysqli_fetch_array($process3)) {
				$list_data[] = $row;
			}
			
		?>
		<div class="loker-sub-head"><?php echo count($list_data) ?> KOMENTAR :</div>
		<ul class="list-unstyled">

			<?php
				foreach ($list_data as $value) {
					$list_detail_profil = getKomentarDetailUser($value['user_akun_id']);
			?>
				
				<li class="media my-4">
					<img class="mr-3 rounded-circle" src="<?php echo $list_detail_profil['foto'] ?>" width="64" height="64" alt="Generic placeholder image">
					<div class="media-body">
						<h5 class="mt-0 mb-1"><?php echo $list_detail_profil['nama'] ?></h5>
						<span class="badge badge-primary"><?php echo strtoupper($list_detail_profil['hak_akses']) ?></span> <span class="badge badge-success"><?php echo date('d M Y', strtotime($value['tanggal'])) ?></span>
						<div><?php echo $value['konten'] ?></div>
					</div>
				</li><hr>

			<?php
				}

			?>
			
		</ul>
	</div>
</div>