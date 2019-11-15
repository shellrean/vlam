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

		<div class="alert alert-danger" v-if="errors.invalid">{{ errors.invalid }}</div>
		<div class="container mt-100 mb-5">
			<div class="row">
			    <div class="col-3"></div>
			    <div class="col-sm">
			      <div class="card">
			      	<div class="card-header">
			          <table>
			            <tr>
			              <td><img src="img/brand/dki.png" width="40px"></td>
			              <td><h4 class="mx-2">Login peserta</h4></td>
			            </tr>
			          </table>
			      	</div>
			      	<div class="card-body py-5">
					  <div class="form-group row">
					    <label for="staticEmail" class="col-sm-3 col-form-label">No peserta</label>
					    <div class="col-sm-9">
					      <div class="input-group mb-2 mr-sm-2">
						    <div class="input-group-prepend">
						      <div class="input-group-text rounded-0"><i class="cui-user"></i></div>
						    </div>
						    <input type="text" class="form-control rounded-0" :class="{ 'is-invalid' : errors.email }" v-model="data.email" placeholder="No peserta" required>
						    <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</div>
						  </div>
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
					    <div class="col-sm-9">
					      <div class="input-group mb-2 mr-sm-2">
						    <div class="input-group-prepend">
						      <div class="input-group-text rounded-0"><i class="cui-lock-locked"></i></div>
						    </div>
						    <input type="password" class="form-control rounded-0" :class="{ 'is-invalid' : errors.password }"placeholder="Password" v-model="data.password" required>
						    <div class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }} </div>
						  </div>
					    </div>
					  </div>
					  <div class="form-group row">
					  	<label for="inputPassword" class="col-sm-3 col-form-label">&nbsp;</label>
					  	<div class="col-sm-9">
					      <button type="button" class="btn btn-success btn-block doblockui rounded-0" @click.prevent="postLogin">LOGIN</button>
					    </div>
					  </div>
			      	</div>
			      	<div class="card-footer">
			          <i class="cui-info text-info"></i> Masukkan no peserta dan password untuk masuk
			        </div>
			      </div>
			    </div>
			    <div class="col-3"></div>
			</div>
		</div>
		<div class="">
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
	import { mapActions, mapMutations, mapGetters, mapState } from 'vuex'
	export default {
		data() {
			return {
				data: {
					email: '',
					password: ''
				}
			}
		},
		created() {
			if (this.isAuth) {
				this.$router.push({ name: 'ujian' })
			}
		},
		computed: {
			...mapGetters(['isAuth']),
			...mapState(['errors'])
		},
		methods: {
			...mapActions('auth',['submit']),
			...mapMutations(['CLEAR_ERRORS']),
			postLogin() {
				this.submit(this.data).then( () => {
					if (this.isAuth) {
						this.CLEAR_ERRORS()
						this.$router.push({ name: 'ujian' })
					}
				})
			}
		}
	}
</script>