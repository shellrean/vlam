<template>
	<div class="container">
		<div class="row justify-content-md-center">
		  <div class="col-md-6">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-body rounded-0">
		          <h6 class="text-success"><i class="cui-check"></i> &nbsp; Ujian selesai dilaksanakan</h6>
		          <p class="text-muted">
		          	Terimakasih, berani jujur itu hebat
		          </p>
		        </div> 
		        <div class="card-footer">
		        	<b-button variant="danger" squared @click="logout">Logout</b-button>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</template>
<script>
export default {
	methods: {
      logout() { 
        return new Promise((resolve, reject) => {
            localStorage.removeItem('token')
            localStorage.removeItem('no_ujian')
            localStorage.removeItem('nama')
            localStorage.removeItem('id')
            resolve()
        }).then(() => {
            this.$store.state.token = localStorage.getItem('token')
            this.$router.push('/login')
        })
      }
    }
}
</script>