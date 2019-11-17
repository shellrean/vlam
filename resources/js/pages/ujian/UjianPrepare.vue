<template>
	<div class="container">
		<div class="row">
		  <div class="col-md-8">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-header rounded-0">
		          <h4>Penting untuk diingat </h4>
		        </div>
		        <div class="card-body rounded-0">
		          <h6 class="text-danger"><i class="cui-info"></i> &nbsp; No system is safe</h6>
		          <p class="text-muted">
		          	Kita hidup di dunia yang pentuh dengan masalah, jangan sampai menyontek termasuk masalah anda
		          </p>
		        </div> 
		        <div class="card-footer">
		        	
		        </div>
		      </div>
		    </div>
		  </div>
		  <div class="col-md-4">
		  	<div class="card mt-5 rounded-0">
		  		<div class="card-body">
				  	<div class="alert alert-warning rounded-0">
				    	<i class="cui-bullhorn"></i>  
				    	Tombol mulai disable sampai waktu ujian tiba.
				    </div>
				    <button class="btn btn-block btn-danger rounded-0" @click="start" :disabled="disable">Mulai</button>
				</div>
			</div>
		  </div>
		</div>
	</div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
export default {
	name: 'PrepareUjian',
	created() {
		this.ujianHariIni()
		this.starTime()
	},
	data() {
		return {
			disable: true,
			time: '',
			starter: '',
		}
	},
	computed: {
		...mapState('jadwal', {
			jadwal: state => state.banksoalHariIni,
			mulai: state => state.banksoalHariIni.mulai
		})
	},
	methods: {
	    ...mapActions('jadwal',['ujianHariIni']),
	    start() {
	    	this.$router.push({ 
	    		name: 'ujian.while', 
	    		params: { banksoal: this.jadwal.banksoal_id, jadwal_id: this.jadwal.id } 
	    	})
	    },
	    starTime() {
			setInterval( () => {
				this.time = new Date()
			}, 3000 )
		}
	},
	watch: {
		jadwal() {
			const date = new Date()
			const ye = date.getFullYear()
			const mo = date.getMonth()
			const da = date.getDate()

			const mulai = this.jadwal.mulai
        	const splicer = mulai.split(":");

        	const h = parseInt(splicer[0])
        	const i = parseInt(splicer[1])
        	const s = parseInt(splicer[2])

			const rest = new Date(ye,mo,da,h,i,s)

			this.starter = rest
		},
		time() {
			if(this.starter < this.time) {
				this.disable = false
			}
		}
	}
}
</script>