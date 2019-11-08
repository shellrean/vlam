<template>
	<div class="c-app flex-row align-items-center">
		<div class="container">
	      <div class="row justify-content-center">
	        <div class="col-md-8">
	          <div class="card-group">
	            <div class="card p-4">
	              <div class="card-body">
	                <h1>Login</h1>
	                <p class="text-muted">Sign In to your account</p>
	                <div class="alert alert-danger" v-if="errors.invalid">{{ errors.invalid }}</div>
	                <div class="input-group mb-3">
	                  <div class="input-group-prepend">
	                  	<span class="input-group-text">
	                  		<i class="cui-user"></i>
	                  	</span>
	                  </div>
	                  <input class="form-control" :class="{ 'is-invalid' : errors.email }" type="email" placeholder="Email" v-model="data.email">
	                  <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</div>
	                </div>
	                <div class="input-group mb-4">
	                  <div class="input-group-prepend">
	                  	<span class="input-group-text">
	                  		<i class="cui-https"></i>
	                  	</span>
	                  </div>
	                  <input class="form-control" :class="{ 'is-invalid' : errors.password }" type="password" placeholder="Password" v-model="data.password">
	                  <div class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }} </div>
	                </div>
	                <div class="row">
	                  <div class="col-6">
	                    <button class="btn btn-primary px-4" type="button" @click.prevent="postLogin">Login</button>
	                  </div>
	                  <div class="col-6 text-right">
	                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
	                  </div>
	                </div>
	              </div>
	            </div>
	            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
	              <div class="card-body text-center">
	                <div>
	                  <h2>Sign up</h2>
	                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	                  <button class="btn btn-lg btn-outline-light mt-3" type="button">Register Now!</button>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
    </div>
</template>
<script>
	import { mapActions, mapMutations, mapGetters, mapState } from 'vuex';
	export default {
		data() {
			return {
				data : {
					email: '',
					password: '',
					remember_me: false
				}
			}
		},
		created() {
			if (this.isAuth) {
				this.$router.push({ name: 'home' })
			}
		},
		computed: {
			...mapGetters(['isAuth']),
			...mapState(['errors'])
		},
		methods: {
			...mapActions('auth', ['submit']),
			...mapActions('user', ['getUserLogin']),
			...mapMutations(['CLEAR_ERRORS']),
			postLogin() {
				this.submit(this.data).then( () => {
					if (this.isAuth) {
						this.CLEAR_ERRORS()
						this.$router.push({ name: 'home' })
					}
				})
			}
		},
		destroyed() {
			this.getUserLogin()
		}
	}
</script>