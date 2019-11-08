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
            						<select v-model="data.periode" class="form-control select2">
            							<option>1</option>
            							<option>2</option>
            						</select>
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
	export default {
		data() {
			return {
				data: {
					periode: ''
				}
			}
		}
	}
</script>