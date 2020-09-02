<template>
  <div class="row" style="padding:10px;">
    <div class="col-md-3">
      <card title="Admin Portal" class="settings-card">
        <ul class="nav flex-column nav-pills">
          <!-- <li v-for="tab in tabs" :key="tab.route" class="nav-item">
            <router-link :to="{ name: tab.route }" style="text-transform: capitalize;" class="nav-link" active-class="active">
              <i :class="'fa fa-' + tab.icon"></i>
              {{ tab.name }}
            </router-link>
          </li> -->
          <li key="admin.users_table" class="nav-item">
            <router-link to="users_table" style="text-transform: capitalize;" class="nav-link" active-class="active">
              <i class="fas fa-user"></i>
              Users Table
            </router-link>
          </li>
          <li key="admin.confirm_user" class="nav-item">
            <router-link to="confirm_user" style="text-transform: capitalize;" class="nav-link" active-class="active">
              <i class="fas fa-check"></i>
              Confirm Users
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
export default {
  middleware: 'admin',

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
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
