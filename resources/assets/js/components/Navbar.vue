<template>
  <nav class="navbar navbar-expand navbar-light bg-white">
    <div class="container">
      <div class="d-block">
        <router-link style="float:left;" to="/">
          <!-- <img style="height:40px;margin-top:-10px;margin-left:-18px;" src="./../../images/bass_believe_it_logo.png" /> -->
        </router-link>
        <!-- <i @click="hamburgerClicked()" style="font-size:20px;margin-top:5px;position:absolute;right:15px;" class="d-block d-sm-none fa fa-list float-left"></i> -->
      </div>
      <div id="navbarToggler" style="float:left;" class="collapse navbar-collapse navbarTest">
        <ul class="navbar-nav ml-auto">
          <template>

            <li class="nav-item" v-if="user && user.confirmed">
              <router-link :to="{ name: 'inventory_page' }" class="dropdown-item">
                Inventory
              </router-link>
            </li>

            <li class="nav-item" v-if="user && user.confirmed">
              <router-link :to="{ name: 'new_inventory_page' }" class="dropdown-item">
                New Inventory
              </router-link>
            </li>

            <li class="nav-item" v-if="user && user.confirmed && user.admin">
              <router-link :to="{ name: 'orders_table' }" class="dropdown-item">
                Orders
              </router-link>
            </li>

            <li v-if="user && user.confirmed" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark"
                 href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fa-stack">
                    <i class="fas fa-shopping-bag fa-stack-2x" style="color:#C92227;"></i>
                    <i class="fas fa-stack-1x fa-inverse" style="padding-top:5px;"><a style="font-family: helvetica;">{{$store.state.cart_details.cart.length}}</a></i>
                </span>
              </a>
              <div class="dropdown-menu" id="cartWidget" style="z-index:2000;position:absolute;width:100%; color:#fff;">
                <h3 v-if="$store.state.cart_details.cart.length" style="background-color:#C92227;line-height:30px;color:white;font-weight:bold;">My Cart</h3>
                  <div v-if="$store.state.cart_details.cart.length">
                      <div style="width:100%;overflow-y: scroll;">
                          <div class="col-12 float-left" v-for="value in $store.state.cart_details.cart">
                              <div class="col-9 float-left" style="font-size:12px;line-height:26px;">{{value.customer_style}} - {{value.customer_color}}</div>
                              <div class="col-3 float-left" style="font-size:12px;line-height:26px;">{{value.quantity_ordered}}</div>
                              <hr style="width:100%;float:left;height:2px;margin-top:1px;margin-bottom: 1px;" />
                          </div>
                      </div>
                      <div class="col-12 text-center" v-if="$store.state.cart_details.cart.length">
                          <button class="btn darkImpButton mb-3 mt-3" @click="cartShow = false, $router.push('/checkout')">Review / Checkout</button>
                      </div>
                  </div>
                  <div v-else style="height:100px;line-height: 100px;width:100%;float:left;">
                      <h3 style="height:100%;line-height:100px;">Your Cart Is Empty</h3>
                  </div>
              </div>
            </li>
            
            <li v-if="user" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark"
                 href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <!-- <img :src="user.photo_url" class="rounded-circle profile-photo mr-1"> -->
                <i class="fas fa-user-circle" style="font-size:24px;line-height:32px;"></i>
                <label id="userName">{{ user.name.split(' ')[0] }}</label>
              </a>
              <div class="dropdown-menu" style="z-index:2000;position:absolute;width:100%; color:#fff;">
                <router-link :to="{ name: 'settings.profile' }" class="dropdown-item">
                  <fa icon="user" fixed-width/>
                  My Profile
                </router-link>

                <div v-if="user.admin" class="dropdown-divider"/>
                <router-link v-if="user.admin" :to="{ name: 'admin.users_table' }" class="dropdown-item">
                  <!-- <fa icon="crown" fixed-width/> -->
                  <i class="fas fa-crown"></i>
                  Admin Page
                </router-link>

                <div class="dropdown-divider"/>
                <a href="#" class="dropdown-item" @click.prevent="logout">
                  <fa icon="sign-out-alt" fixed-width/>
                  {{ $t('logout') }}
                </a>
              </div>
            </li>
            <!-- Guest -->
            <li v-if="!user" class="nav-item">
              <router-link :to="{ name: 'login' }" class="dropdown-item">
                {{ $t('login') }}
              </router-link>
            </li>

            <li v-if="!user" class="nav-item">
              <router-link :to="{ name: 'register' }" class="dropdown-item">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
          
            <!-- <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="dropdown-item pl-3" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li> -->
        </ul>
      </div>

    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: function () {
    return {
      appName: window.config.appName,
      searchValue: '',
      cartShow: false
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    show_started: 'auth/show_started'
  }),

  mounted: function () {
  	console.log(this.user)
    console.log(this.$store)
    this.$store.dispatch('cart_details/setCart')
    // this.$store.dispatch('auth/checkShowStart')
  },

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    hamburgerClicked () {
      // console.log('clickedddd')
      // if ($('.navbarTest').hasClass('collapse')) {
      //   console.log('collllll')
      //   $('.navbarTest').removeClass('collapse');
      // } else {
      //   console.log('elseeeee')
      //   $('.navbarTest').addClass('collapse');
      // }
      if ($('.collapse').hasClass('collapse')) {
        $('.collapse').removeClass('collapse');
      } else {
        $('.navbar-collapse').addClass('collapse');
      }
    },
    searchUser () {
      var str = this.searchValue.replace(' ', '_')
      this.$router.push('/search/' + str)
    }
  }
}
</script>

<style lang="scss" scoped>
@media (max-width: 850px) {
  #userName {
    display: none;
  }
}

.navbar {
  position: fixed;
  top:0;
  left:0;
  right:0;
  width:100%;
  z-index: 10;
  box-shadow: 0 4px 2px -2px #818181;

  .dropdown-item {
    color: #000;

  }
  .nav-item {
    .router-link-active {
      color: #00cf11 !important;
    }
  }
}

#cartWidget {
    position:fixed;
    top: 50px; right: 0;
    width: 250px;
    background-color: white;
    border-bottom-left-radius: 10px;
    z-index:99999;
    box-shadow: 0px 4px 4px #ccc;

    h3 {
        font-size: 1.2rem;
        text-align: center;
    }
}

#overlay {
  position:fixed;
  top:0;left:0;right:0;bottom:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,.3);
  text-align:center;
  font-size:35px;
  z-index:100000;
}
.profile-photo {
  width: 1.5rem;
  height: 1.5rem;
  margin: -.375rem 0;
}
.container {
  width:100% !important;
  max-width:100% !important;
}
li {
  height: 40px;
  padding: 4px 8px !important;
}
a {
  height: 32px;
  line-height:32px;
  padding:0 4px;
}
.brand-image {
  height: 60px;
  position: absolute;
  left: 0;
  top: 0;
  padding: 6px;
  background-color: #fff !important;
  border-bottom-right-radius: 6px;
  z-index:10;
}
</style>
