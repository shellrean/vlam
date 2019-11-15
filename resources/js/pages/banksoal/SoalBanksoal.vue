<template>
	<div class="row">
    	<div class="col-lg-12">
    		<div class="card">
    			<div class="card-header">
    				<router-link :to="{ name: 'banksoals.addsoal' }" class="btn btn-primary btn-sm">Tambah</router-link>
                    <div class="float-right">
                        <input type="text" class="form-control" placeholder="Cari..." v-model="search">
                    </div>
    			</div>
    			<div class="card-body">
    				<b-table striped hover bordered small :items="banksoals.data" :fields="fields" show-empty>
                       <template v-slot:cell(actions)="row">
                            <router-link :to="{ name: 'banksoals.soal', params: {id: row.item.id} }" class="btn btn-success btn-sm"><i class="cui-pencil"></i></router-link>
                        </template>
                    </b-table>
                    <div class="row">
                        <div class="col-md-6">
                            <p v-if="banksoals.data">{{ banksoals.data.length }} item dari {{ banksoals.meta.total }} total data</p>
                        </div>
                        <div class="col-md-6">
                            <div class="float-right">
                                <b-pagination
                                    v-model="page"
                                    :total-rows="banksoals.meta.total"
                                    :per-page="banksoals.meta.per_page"
                                    aria-controls="banksoals"
                                    v-if="banksoals.data && banksoals.data.length > 0"
                                    ></b-pagination>
                            </div>
                        </div>
                    </div>
    			</div> 
    		</div>
    	</div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'

export default {
    name: 'DataSoal',
    created() {
        this.getSoals()
    },
    data() {
        return {
            fields: [
                { key: 'pertanyaan', label: 'Pertanyaan'},
                { key: 'actions', label: 'Aksi' }
            ],
            search: '',
        }
    },
    computed: {
        ...mapState('soal', {
            soals: state => state.soals
        }),
        page: {
            get() {
                return this.$store.state.soal.page
            },
            set(val) {
                this.$store.commit('soal/SET_PAGE', val)
            }
        }
    },
    watch: {
        page() {
            this.getSoals()
        },
        search() {
            this.getSoals(this.search)
        }
    },
    methods: {
        ...mapActions('soal', ['getSoals']),
        deleteBanksoal(id) {

        }
    }
}
</script>