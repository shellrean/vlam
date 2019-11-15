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
		<div class="container-fluid mt-5">
		    <div class="card">
		    	<div class="card-header">
		    		SOAL NO. <b-button variant="primary" size="sm" squared disabled >{{ questionIndex+1 }}</b-button>
		    		<b-button variant="outline-dark" class="float-right" size="sm" squared disabled>Siwa waktu: 17:00</b-button>
		    	</div>
		    	<div class="card-body">
		    		<div class="questionContainer" v-if="questionIndex<soals.data.pertanyaans.length" :key="questionIndex">
		    			<p>{{ soals.data.pertanyaans[questionIndex].pertanyaan }}</p>
		    			<b-form-group>
					      <b-form-radio v-for="(jawab,index) in soals.data.pertanyaans[questionIndex].jawabans" v-model="selected"  :value="jawab.id" name="jawaban" @change="selectOption(index)"><span class="text-uppercase">{{ index | charIndex }}</span>. {{ jawab.text_jawaban }}</b-form-radio>
					    </b-form-group>
		    		</div>
		    	</div>
		    	<div class="card-footer">
		    		<b-button variant="secondary" size="md" squared @click="prev()" :disabled="questionIndex < 1"><i class="cui-chevron-left"></i> &nbsp; Sebelumnya</b-button>

		    		<b-button variant="success" class="float-right" size="md" squared @click="next()" :disabled="questionIndex >= soals.data.pertanyaans.length">Selanjutnya &nbsp; <i class="cui-chevron-right"></i></b-button>
		    	</div>

		   	</div>
		</div>
		<div class="fixed-bottom">
		 	<div style="margin-top:0px; bottom:50px; background-color:#dcdcdc; padding:7px; font-size:12px">
		    	<div class="content">
			 	<strong> VLAMP-CBT v1.0</strong><br>
			 	<strong> SystemAppData</strong>
		    	</div>
			</div>
		 	<footer class="bg-dark text-center py-2">
				&copy; 2019, Shellrean 
			</footer>
		</div>
	</div>
</template>
<script>
	import { mapActions, mapState } from 'vuex' 

	export default {
		name: 'DataBanksoal',
	    created() {
	        this.getUjian()
	        this.getJawabanPeserta()
	     	
	    },
		data() {
			return {
				questionIndex: 0,
				selected: ''
			}
		},
		filters: {
	      charIndex: function(i) {
	         return String.fromCharCode(97 + i);
	      }
	   	},
		computed: {
	        ...mapState('banksoal', {
	            soals: state => state.ujian
	        }),
	        ...mapState('ujian', {
	        	jawabanPeserta: state => state.jawabanPeserta
	        })
	    },
		methods: {
        	...mapActions('banksoal', ['getUjian']),
        	...mapActions('ujian',['submitJawaban','getJawabanPeserta']),
        	prev() {
		        if (this.soals.data.pertanyaans.length > 0) this.questionIndex--;
		    },
		    next() {
		        if (this.questionIndex < this.soals.data.pertanyaans.length)
		            this.questionIndex++;
		    },
		    selectOption(index) {
		    	const pertanyaan = this.soals.data.pertanyaans[this.questionIndex]
	         	let data = {
	         		banksoal_id: this.soals.data.id,
	         		soal_id : pertanyaan.id,
	         		jawab : pertanyaan.jawabans[index].id,
	         		correct: pertanyaan.jawabans[index].correct
	         	}

	         	this.submitJawaban({ data })
	      	},
	      	getData(index) {
	      		this.getJawabanPeserta(this.soals.data.pertanyaans[index].id)
	      		.then((res) => {
	      			this.selected = res.data.jawab
	      		})
	      	}
        },
        watch: {
		    questionIndex(val) {
		    	this.getData(val)
		    },
		    soals(val) {
		    	this.getData(0)
		    }
		}
	}
</script>