<template>
  <div class="row" style="margin-top:15px;">
    <div class="col-lg-8 m-auto mt-3">
      <card :title="$t('register')">
        <!-- <div class="col-12 float-left text-center">
          <button class="btn btn-secondary" @click="typeAccount = 'normal_user'" :class="typeAccount === 'normal_user' ? 'btn-success' : ''">Normal Account</button>
          <button class="btn btn-secondary" @click="typeAccount = 'fisherman'" :class="typeAccount === 'fisherman' ? 'btn-success' : ''">Fisherman Account</button>
        </div> -->
        <div style="width:100%;float:left;" v-if="typeAccount === 'normal_user'">
          <form @submit.prevent="register" @keydown="form.onKeydown($event)">
            <!-- Name -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
              <div class="col-md-7">
                <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name">
                <has-error :form="form" field="name"/>
              </div>
            </div>

            <!-- Email -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
              <div class="col-md-7">
                <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                <has-error :form="form" field="email"/>
              </div>
            </div>

            <!-- Password -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
              <div class="col-md-7">
                <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                <has-error :form="form" field="password"/>
              </div>
            </div>

            <!-- Password Confirmation -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
              <div class="col-md-7">
                <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                <has-error :form="form" field="password_confirmation"/>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="form.busy">
                  {{ $t('register') }}
                </v-button>

                <!-- GitHub Register Button -->
                <login-with-github/>
              </div>
            </div>
          </form>
        </div>

        <!-- Fisherman Creation -->
        <div style="width:100%;float:left;" v-if="typeAccount === 'fisherman'">
          <form @submit.prevent="registerFisherman" @keydown="form.onKeydown($event)">
            <!-- First Name -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('first_name') }}</label>
              <div class="col-md-7">
                <input v-model="fisherman_form.first_name" :class="{ 'is-invalid': fisherman_form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                <has-error :form="fisherman_form" field="first_name"/>
              </div>
            </div>

            <!-- Last Name -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('last_name') }}</label>
              <div class="col-md-7">
                <input v-model="fisherman_form.last_name" :class="{ 'is-invalid': fisherman_form.errors.has('last_name') }" class="form-control" type="text" name="last_name">
                <has-error :form="fisherman_form" field="last_name"/>
              </div>
            </div>

            <!-- Email -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
              <div class="col-md-7">
                <input v-model="fisherman_form.email" :class="{ 'is-invalid': fisherman_form.errors.has('email') }" class="form-control" type="email" name="email">
                <has-error :form="fisherman_form" field="email"/>
              </div>
            </div>

            <!-- Price -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('price') }}</label>
              <div class="col-md-7">
                <input v-model="fisherman_form.price" :class="{ 'is-invalid': fisherman_form.errors.has('price') }" class="form-control" type="price" name="price">
                <has-error :form="fisherman_form" field="price"/>
              </div>
            </div>

            <!-- Password -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('password') }}</label>
              <div class="col-md-7">
                <input v-model="fisherman_form.password" :class="{ 'is-invalid': fisherman_form.errors.has('password') }" class="form-control" type="password" name="password">
                <has-error :form="fisherman_form" field="password"/>
              </div>
            </div>

            <!-- Password Confirmation -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
              <div class="col-md-7">
                <input v-model="fisherman_form.password_confirmation" :class="{ 'is-invalid': fisherman_form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                <has-error :form="fisherman_form" field="password_confirmation"/>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="fisherman_form.busy">
                  {{ $t('register') }}
                </v-button>

                <!-- GitHub Register Button -->
                <login-with-github/>
              </div>
            </div>
          </form>
        </div>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      type: 'normal',
      username: ''
    }),
    fisherman_form: new Form({
      first_name: '',
      last_name: '',
      email: '',
      price: '',
      password: '',
      password_confirmation: '',
      type: 'fisherman'
    }),
    typeAccount: 'normal_user'
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Log in the user.
      const { data: { token } } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

      // Redirect home.
      this.$router.push({ name: 'home' })
    },
    async registerFisherman () {
      // Register the user.
      const { data } = await this.fisherman_form.post('/api/registerFisherman')

      // Log in the user.
      const { data: { token } } = await this.fisherman_form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
