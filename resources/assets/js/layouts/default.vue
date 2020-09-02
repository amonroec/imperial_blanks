<template>
  <div class="main-layout">
    <navbar />
    <child style="margin-top:55px;" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Navbar from '~/components/Navbar'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  },
  computed: mapGetters({
    user: 'auth/user'
  })
}
</script>
<style src="@fortawesome/fontawesome-free/css/all.css"></style>
<style lang="scss" scoped>
// @media (max-width:579px) {
//   .main-layout {
//     width:100vw;
//     max-width:100vw;
//     height:100vh;
//     max-height:100vh;
//     // background-image: url("./../../images/nk-bg-small.jpg");
//     // background-position: center;
//     // background-size: cover;
//     float:left;
//     // overflow:scroll;
//   }
// }
// @media (min-width:580px) {
//   .main-layout {
//     width:100vw;
//     max-width:100vw;
//     height:100vh;
//     max-height:100vh;
//     // background-image: url("./../../images/nk-bg.jpg");
//     // background-position: center;
//     // background-size: cover;
//     float:left;
//     // overflow:scroll;
//   }
// }
</style>
