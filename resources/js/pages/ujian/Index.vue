<template>
	<div>
    <header style="background-color: #2c3e50;" class="headers">
      <div class="group">
        <div class="left py-2 px-4">
          <img src="/img/brand/dki.png " width="65px">
        </div>
        <div class="right">
          <table width="100%" border="0">   
            <tr>
              <td rowspan="3" width="90px" align="center"><img src="/img/avatars/avatar.png" class="foto" ></td>
              <td>Selamat datang peserta ujian</td>
            </tr>
            <tr>
              <td><span class="user">Jangan lupa berdo'a </span></td>
            </tr>
          </table>
        </div>
      </div>
    </header>
    <div class="container">
      <div class="fade-in">
        <router-view></router-view>
      </div>
    </div>
  </div>


</template>
<script>
	export default {
		name: 'IndexUjian'
	}
</script>