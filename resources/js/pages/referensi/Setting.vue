<template>
	<div class="c-body">
        <main class="c-main">
          <div class="container-fluid">
            <div class="fade-in">
            	<div class="row">
            		<div class="col-lg-6">
            			<div class="card">
            				<div class="card-header">
            					Konfigurasi umum aplikasi
            				</div>
            				<div class="card-body">
            					<div class="form-group">
            						<label>Tahun ajaran</label>
            						<select v-model="reference.periode" class="form-control select2">
            							<option v-for="ajar in ajaran" :value="ajar.value">{{ ajar.value }}</option>
            						</select>
            					</div>
                                <div class="form-group">
                                    <button class="btn btn-primary" @click.prevent="submit">Simpan</button>
                                </div>
            				</div> 
            			</div>
            		</div>
            	</div>
            </div>
          </div>
        </main>
    </div>
</template>
<script>
    import { mapState, mapMutations, mapActions } from 'vuex'
	export default {
        computed: {
            ...mapState(['errors']),
            ...mapState('reference', {
                reference: state => state.reference,
                ajaran: state => state.ajaran
            })
        },
        mounted() {
            this.getSetting()
            this.getAjaranSelect()
        },
        methods: {
            ...mapActions('reference', ['getAjaranSelect','getSetting','submitSetting']),
            submit() {
                this.submitSetting()
                .then(() => {
                    this.$notify({
                      group: 'foo',
                      title: 'Sukses',
                      type: 'success',
                      text: 'Konfigurasi berhasil disimpan.'
                    })
                })
            }
        }
	}
</script>