<template>
  <div id="contact_us">
    <div class="col-6 col-sm-12" id="formWrapper">
      <h3>Contact Us</h3>
      <!-- <hr style="width:75px;height:2px;background-color:#e0e0e0;margin-top:30px;margin-bottom:30px;" />
      <div class="col-12 text-center float-left" style="color:#fff;">
        We're located off Interstate 44, Exit 230, in Stanton, Missouri, approximately 60 miles west of St. Louis. You can contact us via e-mail, phone or in person with the information below.
      </div>

      <div class="col-12 float-left">
        <hr style="width:75px;height:2px;background-color:#e0e0e0;margin-top:30px;margin-bottom:30px;" />
      </div>

      <div class="col-12 text-center float-left" style="color:#fff;">
        <b>Address</b><br />
        <span style="color: #e0e0e0;">Meramec Caverns<br />
        P.O. Box 948<br />
        Stanton, MO 63079</span>
      </div>

      <div class="col-12 float-left">
        <hr style="width:75px;height:2px;background-color:#e0e0e0;margin-top:30px;margin-bottom:30px;" />
      </div>

      <div class="col-12 text-center float-left" style="color:#fff;">
        <b>GPS Coordinates</b><br />
        <span style="color: #e0e0e0;">
          Latitude: 38.25<br />
          Longitude: -91.09
        </span>
      </div>

      <div class="col-12 float-left">
        <hr style="width:75px;height:2px;background-color:#e0e0e0;margin-top:30px;margin-bottom:30px;" />
      </div>

      <div class="col-12 text-center float-left" style="color:#fff;">
        <b>GPS Address</b><br />
        <span style="color: #e0e0e0;">
          1135 MO-W<br />
          Sullivan, MO 63080
        </span>
      </div>

      <div class="col-12 float-left">
        <hr style="width:75px;height:2px;background-color:#e0e0e0;margin-top:30px;margin-bottom:30px;" />
      </div>

      <div class="col-12 text-center float-left" style="color:#fff;">
        <b>Telephone</b><br />
        <span style="color: #e0e0e0;">
          Local: 573-468-CAVE (2283)<br />
          Fax: 573-468-2633 
        </span><br />
        For additional information on Meramec Caverns fill out the form below or simply drop us an e-mail at info@americascave.com. 
      </div>

      <div class="col-12 float-left">
        <hr style="width:75px;height:2px;background-color:#e0e0e0;margin-top:30px;margin-bottom:30px;" />
      </div>

      <div class="col-12 text-center float-left" style="color:#fff;">
        For additional information on Meramec Caverns fill out the form below or simply drop us an e-mail at info@americascave.com. 
      </div> -->

      <form method="POST" class="mt-3 float-left" v-on:submit.prevent="submitForm()">
        <input type="text" required v-model="form.name" class="form-control" placeholder="Name*" />
        <input type="text" required v-model="form.email" class="form-control" placeholder="Email*" />
        <input type="text" required v-model="form.subject" class="form-control" placeholder="Subject*" />
        <textarea v-model="form.message" class="form-control" placeholder="Your Message"></textarea>

        <button type="submit" class="btn btn-success" style="width:100%;margin-top:15px;">Send</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import swal from 'sweetalert2'
var methods = {}

methods.submitForm = function () {
  const postData = {
    form: this.form
  }
  axios.post('/api/submitContactRequest', postData).then(response => {
    if (response.status === 201 || response.status === 200) {
      swal('Success!', 'We have received your message and will get back with you as soon as possible.', 'success')
      this.form = {
        name: '',
        email: '',
        subject: '',
        message: ''
      }
    }
  })
}

export default {
  name: 'ContactUs',

  data: function () {
    return {
      form: {
        name: '',
        email: '',
        subject: '',
        message: ''
      }
    }
  },

  methods: methods
}
</script>
<style lang="scss" scoped>
#contact_us {
  width: 100%;
  background-color: #000;
  height: auto;
  padding-bottom:80px;
  float:left;


  #formWrapper {
    margin-left: auto;
    margin-right: auto;
    text-align:center;
    max-width: 600px;

    h3 {
      color: #fff;
      padding-top: 25px;
      font-weight:bold;
    }

    form {
      width:100% !important;

      input {
        margin-top: 15px;
      }
      textarea {
        margin-top: 15px;
      }
    }
  }
}
</style>
