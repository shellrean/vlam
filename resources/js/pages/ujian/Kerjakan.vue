<template>
	<div>
		<div class="card mt-5">
			<div class="card-header">
				SOAL NO. 
		    	<b-button variant="primary" size="sm" squared disabled >{{ questionIndex+1 }}</b-button>
		    	<b-button variant="outline-dark" class="float-right" size="sm" squared disabled>Sisa waktu:&nbsp; {{ prettyTime }}</b-button>
			</div>
			<div class="card-body fade-in" v-if="filleds">
		    	<table class="table table-borderless table-sm">
		    		<tr>
		    			<td colspan="2" v-html="filleds[questionIndex].soal.pertanyaan"></td>
		    		</tr>
		    		<tr v-for="(jawab,index) in filleds[questionIndex].soal.jawabans" :key="index">
		    			<td width="50px"><b-form-radio v-model="selected" name="jwb" :value="jawab.id" @change="selectOption(index)"><span class="text-uppercase">{{ index | charIndex }}</span>.</b-form-radio></td>
		    			<td v-html="jawab.text_jawaban"></td>
		    		</tr>
		    	</table>
		    </div>
		    <div class="card-footer" v-if="filleds">
		    	<b-button variant="secondary" size="md" squared @click="prev()" v-if="questionIndex != 0"><font-awesome-icon icon="angle-left" /> &nbsp; Sebelumnya</b-button>

  				<b-button variant="warning" squared style="position: absolute; left: 41%">
  					<b-form-checkbox size="lg" value="1" v-model="ragu">Ragu ragu</b-form-checkbox>
  				</b-button>

		    	<b-button variant="success" class="float-right" size="md" squared @click="next()" v-if="questionIndex+1 != filleds.length">Selanjutnya &nbsp; <font-awesome-icon icon="angle-right" /></b-button>
		    	<b-button variant="success" class="float-right" size="md" squared @click="$bvModal.show('modal-selesai')" v-if="questionIndex+1 == filleds.length && checkRagu() == false">Selesai &nbsp; <font-awesome-icon icon="check" /></b-button>
		    	<b-button variant="danger" class="float-right" size="md" squared v-b-modal.modal-1 v-if="questionIndex+1 == filleds.length && checkRagu() == true">Selesai &nbsp; <font-awesome-icon icon="check" /></b-button>
		    	
				<b-modal id="modal-1" title="Peringatan" ok-only v-if="checkRagu()">
				  <p class="my-4"><font-awesome-icon icon="exclamation-triangle" /> &nbsp; Masih ada jawaban ragu ragu. </p>
				</b-modal>
		    </div>
		</div>
		<b-modal id="modal-selesai">
		    <template v-slot:modal-header="{ close }">
		      <h5>Konfirmasi</h5>
		    </template>

		    <template v-slot:default="{ hide }">
			  <b-form-checkbox size="lg" v-model="isKonfirm">Saya sudah selesai mengerjakan</b-form-checkbox>
		    </template>

		    <template v-slot:modal-footer="{ cancel }">
		      <b-button size="sm" variant="success" @click="selesai()" :disabled="!isKonfirm">
		        Selesai
		      </b-button>
		      <b-button size="sm" variant="danger" @click="cancel()">
		        Cancel
		      </b-button>
		    </template>
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
			<font-awesome-icon icon="angle-left" v-show="!sidebar" />
			<font-awesome-icon icon="angle-right" v-show="sidebar" />
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
			time: 0,
			isKonfirm : false,
			interval: ''
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
		...mapActions('ujian', ['submitJawaban','takeFilled','updateWaktuSiswa','updateRaguJawaban','selesaiUjianPeserta']),
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
	        	jawaban_id : this.filleds[this.questionIndex].id,
	        	jawab : this.filleds[this.questionIndex].soal.jawabans[index].id,
	        	correct: this.filleds[this.questionIndex].soal.jawabans[index].correct,
	        	index : this.questionIndex
	        })
		},
		raguRagu(val) {
			this.updateRaguJawaban({
				ragu_ragu: val,
				index: this.questionIndex,
				jawaban_id : this.filleds[this.questionIndex].id
			})
		},
		selesai() {
			this.selesaiUjianPeserta({
				peserta_id : this.peserta.id,
				jadwal_id : this.detail.jadwal_id
			})
			this.$router.push({ name: 'ujian.selesai' })
			clearInterval(this.interval); 
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
		},
		checkRagu() {
			let ragger = 0
			this.filleds
			.filter(function(element) {
			    if (element.ragu_ragu == "1") {
			       ragger++
			    }
			})

			if (ragger > 0) {
				return true
			}
			return false
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
			this.interval = setInterval( () => {
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