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
                    
    			</div> 
    		</div>
    	</div>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'

export default {
    data() {
        return {
            search: ''
        }
    }
}
</script>