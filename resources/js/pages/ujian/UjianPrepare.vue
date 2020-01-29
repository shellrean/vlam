<template>
	<div class="container">
		<div class="row">
		  <div class="col-md-8">
		    <div class="card mt-5 rounded-0">
		      <div class="kiri">
		        <div class="card-header rounded-0">
		          <h4>Data ujian </h4>
		        </div>
		        <div class="card-body rounded-0" v-if="jadwal">
		          <table class="table table-borderless">
		          	<tr>
		          		<td width="150px">Waktu ujian</td>
		          		<td v-text="mulai"></td>
		          	</tr>
		          	<tr>
		          		<td>Durasi</td>
		          		<td v-text="durasi"></td>
		          	</tr>
		          	<tr>
		          		<td>Mata ujian</td>
		          		<td v-text="matpel.nama"></td>
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
		  		<div class="card-body">
				  	<div class="alert alert-warning rounded-0">
				    	<i class="cui-bullhorn"></i>  
				    	Tombol "mulai" disable sampai waktu ujian tiba.
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
		this.ujianAktif()
		this.starTime()
	},
	data() {
		return {
			disable: true,
			time: '',
			starter: '',
			durasi: ''
		}
	},
	computed: {
		...mapState('jadwal', {
			jadwal: state => state.banksoalAktif.data,
			mulai: state => state.banksoalAktif.data.jadwal.mulai,
			matpel: state => state.matpelAktif
		}),
		...mapState('user', {
		    peserta: state => state.pesertaDetail
		}),
	},
	methods: {
	    ...mapActions('jadwal',['ujianAktif']),
	    ...mapActions('ujian',['pesertaMulai']),
	    start() {
	    	this.pesertaMulai({
	    		peserta_id: this.peserta.id
	    	})
	    	this.$router.push({ 
	    		name: 'ujian.while', 
	    		params: { 
	    			banksoal: this.jadwal.jadwal.banksoal_id, 
	    			jadwal_id: this.jadwal.jadwal.id
	    		} 
	    	})
	    },
	    starTime() {
			setInterval( () => {
				this.time = new Date()
			}, 1000 )
		}
	},
	watch: {
		jadwal() {
			const date = new Date()
			const ye = date.getFullYear()
			const mo = date.getMonth()
			const da = date.getDate()

			const mulai = this.jadwal.jadwal.mulai
        	const splicer = mulai.split(":");

        	const h = parseInt(splicer[0])
        	const i = parseInt(splicer[1])
        	const s = parseInt(splicer[2])

			const rest = new Date(ye,mo,da,h,i,s)

			let sec_num = parseInt(this.jadwal.jadwal.lama, 10)
    		let hours   = Math.floor(sec_num / 3600)
    		let minutes = Math.floor((sec_num - (hours * 3600)) / 60)

			this.starter = rest
			this.durasi = hours+' Jam '+minutes+' Menit'
		},
		time() {
			if(this.starter < this.time) {
				this.disable = false
			}
		}
	}
}
</script>