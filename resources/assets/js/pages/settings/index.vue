<template>
  <div class="row" style="padding:10px;">
    <div class="col-md-3">
      <card :title="$t('settings')" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" style="text-transform: capitalize;" class="nav-link" active-class="active">
              <!-- <fa :icon="tab.icon" fixed-width/> -->
              <i :class="'fa fa-' + tab.icon"></i>
              {{ tab.name }}
            </router-link>
          </li>
          <li v-if="user.admin" key="users_table" class="nav-item">
            <router-link to="users_table" style="text-transform: capitalize;" class="nav-link" active-class="active">
              <!-- <fa :icon="tab.icon" fixed-width/> -->
              <i class="fa fa-user"></i>
              Users Table
            </router-link>
          </li>
        </ul>
      </card>
    </div>

    <div class="col-md-9">
      <transition name="fade" mode="out-in">
        <router-view/>
      </transition>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  },
  computed: mapGetters({
      user: 'auth/user'
  }),
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
