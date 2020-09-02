<template>
  <card title="New Post">
    <form @submit.prevent="savePost" @keydown="form.onKeydown($event)" v-if="!loading && !noAccess">
      <alert-success :form="form" :message="$t('info_updated')" />
      <!-- Name of Post -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Name of Post</label>
        <div class="col-md-7">
          <input v-model="form.post_name" required :class="{ 'is-invalid': form.errors.has('post_name') }" class="form-control" type="text" name="post_name">
          <has-error :form="form" field="post_name" />
        </div>
      </div>

      <!-- Name of Post -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Date Fished</label>
        <div class="col-md-7">
          <input v-model="form.date_fished" required :class="{ 'is-invalid': form.errors.has('date_fished') }" class="form-control" type="date" name="date_fished">
          <has-error :form="form" field="date_fished" />
        </div>
      </div>

      <!-- <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">State</label>
        <div class="col-md-7" v-if="states">
          <v-select v-model="form.state" :options="states" @change="stateChanged()"></v-select>
          <has-error :form="form" field="state" />
        </div>
      </div> -->

      <!-- Body of Water -->
      <!-- <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Body of Water</label>
        <div class="col-md-7" v-if="lakeList">
          <v-select v-model="form.body_of_water" :options="lakeList" value="name" label="name"></v-select>
          <has-error :form="form" field="body_of_water" />
        </div>
        <div class="text-center col-md-7" v-else>
          Please select state first...
        </div>
      </div> -->

      <!-- Species -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Species</label>
        <div class="col-md-7">
          <!-- <input v-model="form.species" :class="{ 'is-invalid': form.errors.has('species') }" class="form-control" type="text" name="species"> -->
          <v-select v-model="form.species" :options="speciesList"></v-select>

          <has-error :form="form" field="species" />
        </div>
      </div>

      <!-- # of fish caught -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Fish Caught</label>
        <div class="col-md-7">
          <input v-model="form.fish_caught" :class="{ 'is-invalid': form.errors.has('fish_caught') }" class="form-control" type="number" name="fish_caught">
          <has-error :form="form" field="fish_caught" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Water Level</label>
        <div class="col-md-7">
          <input v-model="form.water_level" :class="{ 'is-invalid': form.errors.has('water_level') }" class="form-control" type="text" name="water_level">
          <has-error :form="form" field="water_level" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Water Outflow (CFS)</label>
        <div class="col-md-7">
          <input v-model="form.water_outflow" class="form-control" type="text" name="water_outflow">
          <has-error :form="form" field="water_outflow" />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Water Inflow (CFS)</label>
        <div class="col-md-7">
          <input v-model="form.water_inflow" class="form-control" type="text" name="water_inflow">
          <has-error :form="form" field="water_inflow" />
        </div>
      </div>

      <!-- Price -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Part of Water</label>
        <div class="col-md-7">
          <input v-model="form.part_of_water" :class="{ 'is-invalid': form.errors.has('part_of_water') }" class="form-control" type="text" name="part_of_water">
          <has-error :form="form" field="part_of_water" />
        </div>
      </div>

      <!-- Target -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Target(s)</label>
        <div class="col-md-7">
          <!-- <input v-model="form.target" required :class="{ 'is-invalid': form.errors.has('target') }" class="form-control" type="text" name="target"> -->
          <v-select v-model="form.targets" :options="targetList" multiple></v-select>
          <has-error :form="form" field="targets" />
        </div>
      </div>

      <!-- Min Water Depth -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Min Water Depth (Ft)</label>
        <div class="col-md-7">
          <!-- <select v-model="form.min_water_depth" required :class="{ 'is-invalid': form.errors.has('min_water_depth') }" class="form-control">
          	<option v-for="i in 80" :value="i">{{i}}</option>
          </select> -->
          <input v-model="form.min_water_depth" required :class="{ 'is-invalid': form.errors.has('min_water_depth') }" class="form-control" type="number" name="min_water_depth">
          <has-error :form="form" field="min_water_depth" />
        </div>
      </div>

      <!-- Max Water Depth -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Max Water Depth (Ft)</label>
        <div class="col-md-7">
          <!-- <select v-model="form.max_water_depth" required :class="{ 'is-invalid': form.errors.has('max_water_depth') }" class="form-control">
          	<option v-for="i in 80" :value="i">{{i}}</option>
          </select> -->
          <input v-model="form.max_water_depth" required :class="{ 'is-invalid': form.errors.has('max_water_depth') }" class="form-control" type="number" name="max_water_depth">
          <has-error :form="form" field="max_water_depth" />
        </div>
      </div>

      <!-- Weather -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Weather</label>
        <div class="col-md-7">
          <!-- <select v-model="form.weather" required :class="{ 'is-invalid': form.errors.has('weather') }" class="form-control">
          	<option value="Cloudy">Cloudy</option>
          	<option value="Rainy">Rainy</option>
          	<option value="Sunny">Sunny</option>
          	<option value="Thunderstorms">Thunderstorms</option>
          </select> -->
          <v-select v-model="form.weather" :options="weatherList"></v-select>
          <has-error :form="form" field="weather" />
        </div>
      </div>

      <!-- Air Temp -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Air Temp (deg F)</label>
        <div class="col-md-7">
          <input v-model="form.air_temp" required :class="{ 'is-invalid': form.errors.has('air_temp') }" class="form-control" type="text" name="air_temp">
          <has-error :form="form" field="air_temp" />
        </div>
      </div>

      <!-- Water Temp -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Water Temp (deg F)</label>
        <div class="col-md-7">
          <input v-model="form.water_temp" required :class="{ 'is-invalid': form.errors.has('water_temp') }" class="form-control" type="text" name="water_temp">
          <has-error :form="form" field="water_temp" />
        </div>
      </div>

      <!-- Price -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Wind MPH</label>
        <div class="col-md-7">
          <input v-model="form.wind_mph" required :class="{ 'is-invalid': form.errors.has('wind_mph') }" class="form-control" type="text" name="wind_mph">
          <has-error :form="form" field="wind_mph" />
        </div>
      </div>

      <!-- Price -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Wind From</label>
        <div class="col-md-7">
          <select v-model="form.wind_from" required :class="{ 'is-invalid': form.errors.has('wind_from') }" class="form-control">
          	<option value="N">N</option>
          	<option value="NNE">NNE</option>
          	<option value="NE">NE</option>
          	<option value="ENE">ENE</option>
          	<option value="E">E</option>
          	<option value="ESE">ESE</option>
          	<option value="SE">SE</option>
          	<option value="SSE">SSE</option>
          	<option value="S">S</option>
          	<option value="SSW">SSW</option>
          	<option value="SW">SW</option>
          	<option value="WSW">WSW</option>
          	<option value="W">W</option>
          	<option value="WNW">WNW</option>
          	<option value="NW">NW</option>
          	<option value="NNW">NNW</option>
          </select>
          <has-error :form="form" field="wind_from" />
        </div>
      </div>      

      <!-- Comments -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Comments</label>
        <div class="col-md-7">
          <textarea v-model="form.comments" name="comments" :class="{ 'is-invalid': form.errors.has('part_of_water') }" class="form-control" col="3"></textarea>
          <has-error :form="form" field="part_of_water" />
        </div>
      </div>

      <div class="form-group row">
      	<div class="col-12">
      		<h5 style="width:100%;float:left;text-align:center;float:left;padding-top:15px;"><i class="fa fa-upload"></i> Click or Drag Files Into The Box.</h5>
      		<!-- <image-uploader @files-changed="imageAttempt" v-model="testing" button_html="" input_id="upload_test" button_class="dontShow" @upload-image-attempt="imageAttempt" name="uploads[]" :resize_enabled="true" url="" :max_files="5"></image-uploader> -->

      		<!-- <vue-dropzone @vdropzone-file-added="fileAdded" ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone> -->
      		<!-- <vue-dropify data-allowed-file-extensions="png jpeg jpg" data-max-file-size="10" :images.sync="images" multiple="true" name="testing" @change="fileAdded(this)"></vue-dropify> -->
      		<input type="file" name="files[]" class="form-control" multiple />
      	</div>
      </div>


      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-12 text-center">
          <v-button :loading="form.busy" type="success">Save</v-button>
        </div>
      </div>
    </form>
    <div class="col-12 text-center" v-else-if="noAccess">
        You do not have access to edit this post.
    </div>
    <div v-else-if="loading">
      <spinner></spinner>
    </div>
  </card>
</template>
<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import ImageUploader from './../components/image_uploader'
import VueDropzone from 'vue2-dropzone'
import VueDropify from 'vue-dropify'
import swal from 'sweetalert2'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
var methods = {}

methods.savePost = function () {
	var form = document.querySelector('form')
	var request = new XMLHttpRequest()
  var formData = new FormData(form)
  // var comments = new FormData()
  var that = this
  // console.log(comments)
  console.log($('#upload_image_form__input--upload_test'))
  console.log(formData)
  request.open('post', '/api/savePost')
  formData.append('id', this.form.id)
  formData.append('user_id', this.user.id)
  formData.append('user_name', this.user.name)
  formData.append('username', this.user.username)
  formData.append('user_email', this.user.email)
  formData.append('post_name', this.form.post_name)
	formData.append('date_fished', this.form.date_fished)
  formData.append('body_of_water', this.form.body_of_water.name)
  formData.append('lat', this.form.body_of_water.lat)
  formData.append('lng', this.form.body_of_water.lng)
  formData.append('coordinates', this.form.body_of_water.coordinates)
	formData.append('size', this.form.body_of_water.size)
	formData.append('targets', JSON.stringify(this.form.targets))
	formData.append('min_water_depth', this.form.min_water_depth)
	formData.append('max_water_depth', this.form.max_water_depth)
	formData.append('weather', this.form.weather)
	formData.append('air_temp', this.form.air_temp)
	formData.append('water_temp', this.form.water_temp)
	formData.append('wind_mph', this.form.wind_mph)
	formData.append('wind_from', this.form.wind_from)
	formData.append('species', this.form.species)
	formData.append('fish_caught', this.form.fish_caught)
  formData.append('water_level', this.form.water_level)
	formData.append('state', this.form.state)
	formData.append('part_of_water', this.form.part_of_water)
	formData.append('comments', this.form.comments)
	formData.append('uploads', this.form.uploads)
	formData.append('likes', this.form.likes)
	formData.append('dislikes', this.form.dislikes)
	formData.append('images', this.images)
  formData.append('files', this.files)
	formData.append('uploads', this.form.uploads)
	console.log(this.files)
  // formData.append('decoration_location', JSON.stringify(that.form.decoration_location))
  // formData.append('design_number', that.form.design_number)
  // formData.append('technique', that.form.technique)
  request.send(formData)
  request.addEventListener("load", function(data)
  {
      console.log(data)
      if (data.currentTarget.status === 200 || data.currentTarget.status === 201)
      {
          swal('Success!', 'You have successfully saved this post.', 'success')
      }
      // else
      // {
      //     that.$router.push('/500')
      // }
  })






	// this.form.user_id = this.user.id
	// this.form.user_name = this.user.name
	// this.form.user_email = this.user.email
	// const postData = {
	// 	form: this.form
	// }
	// console.log(postData)
	// axios.post('/api/submitPost', postData).then(response => {
	// 	if (response.status === 200) {
	// 		console.log(response)
	// 	}
	// })
}

methods.getPost = function () {
  this.loading = true
  const postData = {
    token: this.token,
    user_id: this.user.id
  }
  console.log(postData)
  axios.post("/api/getEditPost", postData).then(response => {
    if (response.status === 200 || response.status === 201) {
      console.log(response)
      if (response.data !== 'no-access') {
        this.form.id = response.data.id
        this.form.post_name = response.data.post_name
        this.form.date_fished = response.data.date_fished
        // this.form.body_of_water = response.data.body_of_water
        // this.form.state = response.data.state
        this.form.targets = response.data.targets
        this.form.min_water_depth = response.data.min_water_depth
        this.form.max_water_depth = response.data.max_water_depth
        this.form.weather = response.data.weather
        this.form.air_temp = response.data.air_temp
        this.form.water_temp = response.data.water_temp
        this.form.wind_mph = response.data.wind_mph
        this.form.wind_from = response.data.wind_from
        this.form.species = response.data.species
        this.form.fish_caught = response.data.fish_caught
        this.form.water_level = response.data.water_level
        this.form.part_of_water = response.data.part_of_water
        this.form.water_outflow = response.data.water_outflow
        this.form.water_inflow = response.data.water_inflow
        this.form.comments = response.data.comments
        this.form.uploads = response.data.uploads
        this.loading = false
      } else {
        this.noAccess = true
      }
    }
  })
}

methods.fileAdded = function (e) {
	console.log(e)
}

methods.imageAttempt = function (files, images) {
	console.log(files)
	console.log(images.length)
	this.files = files
	this.images = images
}

methods.getLakes = function () {
  var that = this
  axios.post('/api/getLakes').then(response => {
    if (response.status === 200 || response.status === 201) {
      console.log(response)
      var obj = {}
      this.states = []
      response.data.forEach(function (val) {
        if (!obj[val.state]) {
          that.states.push(val.state)
          obj[val.state] = []
        }
        obj[val.state].push(val)
      })
      this.fullList = obj
    }
  })
}

export default {
  name: "EditPost",

  middleware: 'auth',

  props: ['token'],

  data: () => ({
    lakeList: null,
    states: null,
    noAccess: false,
    loading: true,
    fullList: null,
    form: new Form({
      id: '',
      user_id: '',
      user_name: '',
      user_email: '',
      post_name: '',
      date_fished: '',
      body_of_water: '',
      state: '',
      targets: '',
      min_water_depth: '',
      max_water_depth: '',
      weather: '',
      air_temp: '',
      water_temp: '',
      wind_mph: '',
      wind_from: '',
      species: '',
      fish_caught: '',
      water_level: '',
      part_of_water: '',
      water_outflow: '',
      water_inflow: '',
      comments: '',
      uploads: '',
      likes: '',
      dislikes: '',
    }),
    testing: '',
    files: '',
    images: [],
    shared: VueDropify.data().images,
    dropzoneOptions: {
        url: '/api/test',
        thumbnailWidth: 150,
        maxFilesize: 8.0,
        headers: { "My-Awesome-Header": "header value" }
    },
    speciesList: [
      'Bass',
      'Catfish',
      'Crappie'
    ],
    targetList: [
      'Brush',
      'Chunk Rock',
      'Docks',
      'Primary Points',
      'Secondary Points'
    ],
    weatherList: [
      'Clear Skies',
      'Cloudy',
      'Rainy',
      'Sunny',
      'Windy'
    ]
  }),

  components: {
  	ImageUploader,
  	VueDropzone,
  	VueDropify
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  watch: {
    'form.state': function () {
      if (this.form.state !== '') {
        this.lakeList = this.fullList[this.form.state]
      }
    }
  },

  mounted: function() {
  	var that = this
    this.getLakes()
    this.getPost()
  	setTimeout(function () {
  		that.$on('upload-image-attempt', function (v) {
  			console.log('ohhh')
  		})
  		$('#file_input').on('change', function (val) {
  			// console.log(VueDropify.data().images)
  			// console.log(this)
  			// console.log(val)
  			that.files = val.currentTarget.files
  		})
  	}, 1000)
  },

  methods: methods,

  destroyed: function() {

  }
}

</script>
<style lang="scss" scoped>
	.upload_image_form__thumbnails {
		width:100%;
		height:500px;
	}
</style>
