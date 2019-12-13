<template>
	<div class="fade-in-up">
    <header style="background-color: #2c3e50;" class="headers">
      <div class="group">
        <div class="left py-2 px-4">
          <img src="/img/brand/dki.png " width="65px">
        </div>
        <div class="right">
          <table width="100%" border="0" style="margin-top: 10px">   
            <tr>
              <td rowspan="3" width="90px" align="center"><img src="/img/avatars/avatar.png" class="foto" ></td>
              <td style="color: #ecf0f1; font-size: 12px" v-text="peserta.no_ujian"></td>
            </tr>
            <tr>
              <td><span class="user" v-text="peserta.nama"></span></td>
            </tr>
            <tr><td><b-link style="color: #ecf0f1" href="javascript:void(0)" @click="logout" variant="white"><small>Logout</small></b-link></td></tr>
          </table>
        </div>
      </div>
    </header>
    <div class="container-fluid" style="margin-bottom: 100px">
      <div>
        <router-view></router-view>
      </div>
    </div>
    <div class="fixed-bottom">
      <div style="margin-top:0px; bottom:50px; background-color:#dcdcdc; padding:7px; font-size:8px">
          <div class="content">
        <strong> VLAMP-CBT v1.0</strong><br>
        <strong> SystemAppData</strong>
          </div>
      </div>
      <footer class="bg-dark text-center py-2">
        Copyright © 2019 Shellrean. All Rights Reserved 
      </footer>
    </div>
  </div>
</template>
<script>
  import { mapState, mapActions } from 'vuex'

	export default {
		name: 'IndexUjian',
    created() {
      this.setPesertaDetail()
    },
    data() {
      return {

      } 
    },
    computed: {
      ...mapState('user', {
        peserta: state => state.pesertaDetail
      })
    },
    methods: {
      ...mapActions('user',['setPesertaDetail']),
      ...mapActions('auth',['logoutPeserta']),
      logout() { 
        return new Promise((resolve, reject) => {
            this.logoutPeserta({ no_ujian : localStorage.getItem('no_ujian') })
            .then(() => {
              localStorage.removeItem('token')
              localStorage.removeItem('no_ujian')
              localStorage.removeItem('nama')
              localStorage.removeItem('id')
            })
            resolve()
        }).then(() => {
            this.$store.state.token = localStorage.getItem('token')
            this.$router.push('/login')
        })
      }
    }
	}
</script>