<template>
	<div>
		<header style="background-color: #2c3e50;" class="headers">
			<div class="group">
  	  			<div class="left py-2 px-4">
  	  				<img src="img/brand/dki.png " width="65px">
  	  			</div>
		  	  	<div class="right">
		  	  		<table width="100%" border="0">   
		     			<tr><td rowspan="3" width="90px" align="center"><img src="img/avatars/avatar.png" class="foto" ></td>
						<td>Selamat datang peserta ujian</td></tr>
						<tr><td><span class="user">Jangan lupa berdo'a </span></td></tr>
					</table>
		  	  	</div>
		  	</div>
		</header>
		<div class="container">
		    <div class="row">
		      <div class="col-md-8">
		        <div class="card mt-5 rounded-0">
		          <div class="kiri">
		            <div class="card-header rounded-0">
		              <h4>Konfirmasi data tes </h4>
		            </div>
		            <div class="card-body rounded-0">
		              <table class="table table-borderless">
		              	<tr>
		              		<td width="200px">Kode tes</td>
		              		<td>DKRN-1232</td>
		              	</tr>
		              	<tr>
		              		<td>Status peserta</td>
		              		<td>XII-Teknik Informatika</td>
		              	</tr>
		              	<tr>
		              		<td>Tanggal test</td>
		              		<td>17 Desermber 2019</td>
		              	</tr>
		              	<tr>
		              		<td>Waktu test dibuka</td>
		              		<td>16:00 PM</td>
		              	</tr>
		              	<tr>
		              		<td>Alokasi waktu</td>
		              		<td>70 Menit</td>
		              	</tr>
		              </table>
		            </div> 
		            <div class="card-footer">
		            	
		            </div>
		          </div>
		        </div>
		      </div>
		      <div class="col-md-4">
		      	<div class="card mt-5 rounded-0">
		      		<div class="card-body rounded-0">
						<div id="myerror" class="alert alert-warning rounded-0">
				      		<i class="cui-bullhorn"></i>  
				      		<font size="3px">Tombol mulai hanya akan aktif apabila waktu sekarang sudah melewati waktu mulai tes.</font>
				      	</div>
				      	<button type="submit" class="btn btn-danger btn-block rounded-0">MULAI</button>
					</div>
		      		</div>
		      	</div>
		      </div>
		    </div>
		</div>
	</div>
</template> 