<template>
	<div>
		<div class="card mt-5">
			<div class="card-header">
				SOAL NO. 
		    	<b-button variant="primary" size="sm" squared disabled >{{ questionIndex+1 }}</b-button>
		    	<b-button variant="outline-dark" class="float-right" size="sm" squared disabled>Sisa waktu:&nbsp; {{ prettyTime }}</b-button>
			</div>
			<div class="card-body fade-in" v-if="filleds">
		    	<p v-html="filleds[questionIndex].soal.pertanyaan"></p>
		    	<b-form-group>
		    		<b-form-radio v-for="(jawab,index) in filleds[questionIndex].soal.jawabans" :key="index" v-model="selected" name="jwb" :value="jawab.id" @change="selectOption(index)">
		    			<span class="text-uppercase">{{ index | charIndex }}</span>. <span v-html="jawab.text_jawaban"></span>
		    		</b-form-radio>
		    	</b-form-group>
		    </div>
		    <div class="card-footer" v-if="filleds">
		    	<b-button variant="secondary" size="md" squared @click="prev()" v-if="questionIndex != 0"><i class="cui-chevron-left"></i> &nbsp; Sebelumnya</b-button>

  				<b-button variant="warning" squared style="position: absolute; left: 41%">
  					<b-form-checkbox size="lg" value="1" v-model="ragu">Ragu ragu</b-form-checkbox>
  				</b-button>

		    	<b-button variant="success" class="float-right" size="md" squared @click="next()" v-if="questionIndex+1 != filleds.length">Selanjutnya &nbsp; <i class="cui-chevron-right"></i></b-button>
		    	<b-button variant="success" class="float-right" size="md" squared v-b-modal.modal-no-backdrop v-if="questionIndex+1 == filleds.length">Selesai &nbsp; <i class="cui-check"></i></b-button>
		    </div>
		</div>
		<b-modal id="modal-no-backdrop" hide-backdrop squared content-class="shadow" title="BootstrapVue">
		    <p class="my-2">
		      <i class="cui-warning"></i>
		    </p>
		</b-modal>

		<div class="side" v-show="sidebar">
			<div class="inner-side">
				<button type="button" class="btn my-1 rounded-0 w-2 mx-1" v-for="(fiel,index) in filleds" :class="{
					'btn-primary' : (fiel.jawab != 0), 
					'btn-outline-primary' : (fiel.jawab == 0), 
					'btn-warning' : (fiel.ragu_ragu == 1),
					'btn-dark text-light' : (index == questionIndex)}" @click="toLand(index)">
				  {{ index+1 }} 
				</button>
			</div>
		</div>
		<button class="coss btn btn-info rounded-0" @click="toggle"> 
			<i class="cui-chevron-left" v-show="!sidebar"></i>
			<i class="cui-chevron-right" v-show="sidebar"></i>
		</button>
	</div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
export default {
	name: 'DataUjian',
	created() {
		this.getAllSoal()
		this.start()
	},
	data() {
		return {
			questionIndex: 0,
			selected: '',
			patt: 17,
			sidebar: false,
			ragu: '',
			time: 0
		}
	},
	filters: {
		charIndex(i) {
			return String.fromCharCode(97 + i)
		}
	},
	computed: {
		...mapState('banksoal', { soals: state => state.ujian.data }),
		...mapState('ujian',{ 
			jawabanPeserta: state => state.jawabanPeserta,
			filleds: state => state.filledUjian.data,
			detail: state => state.filledUjian.detail
		}),
		...mapState('user', {
        	peserta: state => state.pesertaDetail
      	}),
      	prettyTime () {
			let sec_num = parseInt(this.time, 10)
    		let hours   = Math.floor(sec_num / 3600)
    		let minutes = Math.floor((sec_num - (hours * 3600)) / 60)
    		let seconds = sec_num - (hours * 3600) - (minutes * 60)
    		return hours+':'+minutes+':'+seconds
		}
	},
	methods: {
		...mapActions('banksoal', ['getUjian']),
		...mapActions('ujian', ['submitJawaban','takeFilled','updateWaktuSiswa','updateRaguJawaban']),
		getAllSoal() {
			this.getUjian(this.$route.params.banksoal)
			.then((resp) => {

			})
		},
		filledAllSoal() {
			const payld = {
				peserta_id: this.peserta.id,
				banksoal: this.$route.params.banksoal,
				jadwal_id: this.$route.params.jadwal_id
			}
			this.takeFilled(payld) 
			.then((resp) => {

			})
		},
		updateSisaWaktu(time) {
			this.updateWaktuSiswa({ 
				sisa_waktu: time,
				peserta_id: this.peserta.id,
				jadwal_id: this.$route.params.jadwal_id
			})
			.then((resp) => {

			})
		},
		selectOption(index) {
			const fill = this.filleds[this.questionIndex]

	        this.submitJawaban({ 
	        	jadwal_id: this.$route.params.jadwal_id,
	        	banksoal_id: fill.banksoal_id,
	        	soal_id : fill.soal_id,
	        	jawab : this.filleds[this.questionIndex].soal.jawabans[index].id,
	        	correct: this.filleds[this.questionIndex].soal.jawabans[index].correct,
	        	peserta_id: this.peserta.id,
	        	index : this.questionIndex
	        })
		},
		raguRagu(val) {
			this.updateRaguJawaban({
				jadwal_id : this.$route.params.jadwal_id,
				banksoal: this.$route.params.banksoal,
				soal_id: this.filleds[this.questionIndex].id,
				ragu_ragu: val,
				index: this.questionIndex,
				peserta_id: this.peserta.id,
			})
		},
		selesai() {
			this.$router.push({ name: 'ujian.selesai' })
		},
		selesaiUjian() {
			this.$swal({
                title: 'Kamu Yakin?',
                text: "Tindakan ini akan menghapus secara permanent!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Lanjutkan!'
            })
		},
		prev() {
		    if (this.filleds.length > 0) this.questionIndex--
		},
		next() {
			if (this.questionIndex < this.filleds.length) this.questionIndex++
		},
		toggle() {
	    	this.sidebar = !this.sidebar;
	    },
	    toLand(index) {
	    	this.questionIndex = index
	    },
	    start () {
			this.timer = setInterval( () => {
				if (this.time > 0) {
					 this.time--
				} else {

				}
			}, 1000 )
		}
	},
	watch: {
		soals(val) {
			this.filledAllSoal()
		},
		questionIndex() {
			this.selected = this.filleds[this.questionIndex
			].jawab
			this.ragu = this.filleds[this.questionIndex].ragu_ragu
		},
		filleds() {
			this.selected = this.filleds[this.questionIndex].jawab
			this.ragu = this.filleds[this.questionIndex].ragu_ragu
		},
		detail(val) {
			this.time = val.sisa_waktu
			setInterval( () => {
				if (this.time > 0) {
					this.updateSisaWaktu(this.time)
				} else {
					this.selesai()
				}
			}, 5000 )
		}, 
		ragu(val) {
			if (val == false) {
				const set = 0
				this.raguRagu(set)
			}

			this.raguRagu(val)
		}
	}
}
</script>