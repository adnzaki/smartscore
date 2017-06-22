<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>{title}</title>
	<?php $this->view('elements/meta') ?>
	<?php $this->view('elements/style') ?>
</head>

<body>
	<?php $this->view('content/loader') ?>
	<div class="app" id="app">
		<?php $this->view('elements/sidebar') ?>
		<div id="content" class="app-content box-shadow-z0" role="main">
			<?php $this->view('elements/app-header') ?>
			<?php $this->view('elements/app-footer') ?>
			<div ui-view class="app-body" id="view">
				<div id="beranda">
					<h2 v-if="showDashboard">Halaman dashboard</h2>
				</div>
				<div id="dataSiswa">
					<?php $this->view('pages/siswa/siswa') ?>
					<?php $this->view('pages/siswa/tambah-siswa') ?>
					<?php $this->view('pages/siswa/edit-siswa') ?>
				</div>
				<div id="dataRombel">
					<?php $this->view('pages/rombel/rombel') ?>
				</div>
			</div>
		</div>
	</div>
	<?php $this->view('elements/script') ?>
</body>

</html>
