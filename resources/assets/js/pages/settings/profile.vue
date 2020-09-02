<template>
  <card :title="$t('your_info')">
    <!-- User Pic -->

    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')"/>      

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
          <has-error :form="form" field="email" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button>
        </div>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      price: '',
      user_pic: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      // var formData = new FormData();
      // var form = document.querySelector('form')
      // var request = new XMLHttpRequest()
      // var formData = new FormData(form)
      // request.send(formData)
      //   request.addEventListener("load", function(data)
      //   {
      //       console.log(data)
      //       if (data.currentTarget.status === 200)
      //       {
                
      //       }
      //       // else
      //       // {
      //       //     that.$router.push('/500')
      //       // }
      //   })
      // formData.append('id', this.user.id)
      // formData.append('file', this.form.user_pic);
      // formData.append('name', this.form.name);
      // formData.append('email', this.form.email);
      // formData.append('price', this.form.price);

      // const postData = {
      //   id: this.user.id,
      //   file: this.form.user_pic,
      //   name: this.form.name,
      //   email: this.form.email,
      //   price: this.form.price
      // }

      // console.log(postData)
      const { data } = await this.form.patch('/api/settings/profile')
      // axios.patch('/api/settings/profile', postData).then(response => {
      //   console.log(response)
      // })
      console.log(data)

      this.$store.dispatch('auth/updateUser', { user: data })


    },
    handleFile () {
      console.log(this.$refs.file.files[0])
      if (this.$refs.file.files.length) {
        this.form.user_pic = this.$refs.file.files[0]

        var formData = new FormData();
        var form = document.getElementById('imageForm')
        var request = new XMLHttpRequest()
        var formData = new FormData(form)
        formData.append('id', this.user.id)
        request.open('post', '/api/updateUserImage')
        request.send(formData)
        request.addEventListener("load", function(data)
        {
            console.log(data)
            if (data.currentTarget.status === 200)
            {
                
            }
            // else
            // {
            //     that.$router.push('/500')
            // }
        })
      }
    },
    email() {
      axios.post('/api/testEmail').then(response => {
        if (response.status === 200 || response.status === 201) {
          console.log(response)
        }
      })
    }
  }
}
</script>
