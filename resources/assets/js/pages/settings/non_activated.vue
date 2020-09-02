<template>
    <div>
      <card class="text-center" title="Activate Account">
        <h4>Are you wanting to make MONEY being a fisherman?</h4>
        <h5 style="color:#787878;">Activate your account to start making posts and watch the money come in!</h5>
        <p>You can setup a debit card with us or setup your bank account. We use Stripe payment gateway for all of our transactions.</p>
        <div v-if="!user.price || user.price === ''" class="col-12 float-left text-center">
            <h4>Before you setup a card, you need to setup the amount on what you want to charge customers to pay for a monthly subscription.</h4><br />
            <button class="btn btn-info" @click="$router.push('/settings/profile')">Click To Set Price</button>
        </div>

        <!-- <div class="col-12 text-center">
            <a href="https://connect.stripe.com/express/oauth/authorize?redirect_uri=https://stripe.com/connect/default/oauth/test&client_id=ca_FexxDajn8B4WeMkTWTQOToFiuSqqMkMq">
                <img src="./../../../images/stripe_button_smaller.png" />
            </a>
        </div> -->
        <div style="width:100%;" v-else>
          <button class="btn btn-secondary" :class="form.type === 'card' ? 'btn-success' : ''" @click="form.type = 'card'">Setup Debit Card</button>
          <button class="btn btn-secondary" :class="form.type === 'bank' ? 'btn-success' : ''" @click="form.type = 'bank'">Setup Bank</button>


          <!-- BANK ENTRY -->
          <div class="col-12 float-left" v-if="form.type === 'bank'">
            
            <form @submit.prevent="createStripe" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="$t('info_updated')"/>      

              <input type="hidden" name="user_id" v-model="user.id" />

              <!-- Personal Info Label -->
              <div class="form-group row">
                <div class="col-12 float-left text-left">
                  <b>Personal Info</b>
                </div>
              </div>

              <!-- Name -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">First Name</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.first_name" required :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                  <has-error :form="form" field="first_name"/>
                </div>
              </div>

              <!-- Card Number -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Last Name</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.last_name" required :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" max="16" name="last_name">
                  <has-error :form="form" field="last_name" />
                </div>
              </div>

              <!-- CC -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Personal Email</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_email" required :class="{ 'is-invalid': form.errors.has('personal_email') }" class="form-control" type="email" max="3" name="personal_email">
                  <has-error :form="form" field="personal_email" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Phone Number</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_phone_number" required :class="{ 'is-invalid': form.errors.has('personal_phone_number') }" class="form-control" type="text" name="personal_phone_number">
                  <has-error :form="form" field="personal_phone_number" />
                </div>
              </div>

              <!-- Date Of Birth -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Birthday</label>
                <div class="col-md-7">
                  <div class="col-sm-12 col-md-3 float-left text-center">
                    <label class="birth">Month</label>
                    <input v-model="form.legal_entity.dob.month" maxlength="2" required class="form-control text-center" type="text" name="month">
                  </div>
                  <div class="col-sm-12 col-md-3 float-left text-center">
                    <label class="birth">Day</label>
                    <input v-model="form.legal_entity.dob.day" maxlength="2" required class="form-control text-center" type="text" name="day">
                  </div>
                  <div class="col-sm-12 col-md-6 float-left text-center">
                    <label class="birth">Year</label>
                    <input v-model="form.legal_entity.dob.year" maxlength="4" required class="form-control text-center" type="text" name="year">
                  </div>
                </div>
              </div>

              <!-- Last 4 of SSN -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Last 4 of Social Security#</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.ssn_last_4" required :class="{ 'is-invalid': form.errors.has('ssn_last_4') }" maxlength="4" class="form-control" type="text" name="ssn_last_4">
                  <has-error :form="form" field="ssn_last_4" />
                </div>
              </div>

              <br />
              <hr style="width:90%;" />
              <!-- Address Label -->
              <div class="form-group row">
                <div class="col-12 float-left text-left">
                  <b>Address Info</b>
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Address</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_address.line1" required :class="{ 'is-invalid': form.errors.has('line1') }" class="form-control" type="text" name="line1">
                  <has-error :form="form" field="line1" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">City</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_address.city" required :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city">
                  <has-error :form="form" field="city" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Zip Code</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_address.postal_code" required :class="{ 'is-invalid': form.errors.has('postal_code') }" class="form-control" type="text" name="postal_code">
                  <has-error :form="form" field="postal_code" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">State</label>
                <div class="col-md-7">
                  <!-- <input v-model="stripe.legal_entity.address.line1" :class="{ 'is-invalid': stripe.errors.has('line1') }" class="form-control" type="text" name="line1"> -->
                  <!-- <v-select v-model="form.legal_entity.personal_address.state" required :options="statesList"></v-select> -->
                  <select v-model="form.legal_entity.address.state" required class="form-control" name="state">
                    <option selected value="">Select State</option>
                    <option v-for="val in statesList" :value="val">{{val}}</option>
                  </select>
                </div>
              </div>

              <br />
              <hr style="width:90%;" />

              <div class="form-group row">
                <div class="col-12 float-left text-left">
                  <b>Address Info</b>
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Account Holder Name</label>
                <div class="col-md-7">
                  <input v-model="form.bank_account.account_holder_name" disabled :class="{ 'is-invalid': form.errors.has('account_holder_name') }" class="form-control" type="text" name="account_holder_name">
                  <has-error :form="form" field="account_holder_name" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Routing Number</label>
                <div class="col-md-7">
                  <input v-model="form.bank_account.routing_number" disabled :class="{ 'is-invalid': form.errors.has('routing_number') }" class="form-control" type="text" name="routing_number">
                  <has-error :form="form" field="routing_number" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Account Number</label>
                <div class="col-md-7">
                  <input v-model="form.bank_account.account_number" disabled :class="{ 'is-invalid': form.errors.has('account_number') }" class="form-control" type="text" name="account_number">
                  <has-error :form="form" field="account_number" />
                </div>
              </div>

              <!-- Submit Button -->
              <div class="form-group row">
                <div class="col-md-12 ml-md-auto text-center">
                  <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button><br />
                  By registering your account, you agree to our Services Agreement and the <a href="https://stripe.com/connect-account/legal" target="_blank" class="link">Stripe Connected Account Agreement</a>.
                </div>
              </div>
            </form>
          </div>



          <!-- DEBIT CARD ENTRY -->
          <div class="col-12 float-left" v-else-if="form.type === 'card'">
            <h4 style="color:red;margin-top:15px;font-size:14px;">THIS WILL ONLY ACCEPT DEBIT CARDS FOR PAYMENTS (NOT CREDIT CARDS), OTHERWISE USE YOUR BANK ACCOUNT TO RECEIVE PAYMENTS.</h4>
            
            <form @submit.prevent="createStripe" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="$t('info_updated')"/>      

              <input type="hidden" name="user_id" v-model="user.id" />

              <!-- Personal Info Label -->
              <div class="form-group row">
                <div class="col-12 float-left text-left">
                  <b>Personal Info</b>
                </div>
              </div>

              <!-- Name -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">First Name</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.first_name" required :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                  <has-error :form="form" field="first_name"/>
                </div>
              </div>

              <!-- Card Number -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Last Name</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.last_name" required :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" type="text" max="16" name="last_name">
                  <has-error :form="form" field="last_name" />
                </div>
              </div>

              <!-- CC -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Personal Email</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_email" required :class="{ 'is-invalid': form.errors.has('personal_email') }" class="form-control" type="email" max="3" name="personal_email">
                  <has-error :form="form" field="personal_email" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Phone Number</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_phone_number" required :class="{ 'is-invalid': form.errors.has('personal_phone_number') }" class="form-control" type="text" name="personal_phone_number">
                  <has-error :form="form" field="personal_phone_number" />
                </div>
              </div>

              <!-- Date Of Birth -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Birthday</label>
                <div class="col-md-7">
                  <div class="col-sm-12 col-md-3 float-left text-center">
                    <label class="birth">Month</label>
                    <input v-model="form.legal_entity.dob.month" maxlength="2" required class="form-control text-center" type="text" name="month">
                  </div>
                  <div class="col-sm-12 col-md-3 float-left text-center">
                    <label class="birth">Day</label>
                    <input v-model="form.legal_entity.dob.day" maxlength="2" required class="form-control text-center" type="text" name="day">
                  </div>
                  <div class="col-sm-12 col-md-6 float-left text-center">
                    <label class="birth">Year</label>
                    <input v-model="form.legal_entity.dob.year" maxlength="4" required class="form-control text-center" type="text" name="year">
                  </div>
                </div>
              </div>

              <!-- Last 4 of SSN -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Last 4 of Social Security#</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.ssn_last_4" required :class="{ 'is-invalid': form.errors.has('ssn_last_4') }" maxlength="4" class="form-control" type="text" name="ssn_last_4">
                  <has-error :form="form" field="ssn_last_4" />
                </div>
              </div>

              <br />
              <hr style="width:90%;" />
              <!-- Address Label -->
              <div class="form-group row">
                <div class="col-12 float-left text-left">
                  <b>Address Info</b>
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Address</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_address.line1" :class="{ 'is-invalid': form.errors.has('line1') }" class="form-control" type="text" name="line1">
                  <has-error :form="form" field="line1" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">City</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_address.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city">
                  <has-error :form="form" field="city" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Zip Code</label>
                <div class="col-md-7">
                  <input v-model="form.legal_entity.personal_address.postal_code" :class="{ 'is-invalid': form.errors.has('postal_code') }" class="form-control" type="text" name="postal_code">
                  <has-error :form="form" field="postal_code" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">State</label>
                <div class="col-md-7">
                  <!-- <input v-model="stripe.legal_entity.address.line1" :class="{ 'is-invalid': stripe.errors.has('line1') }" class="form-control" type="text" name="line1"> -->
                  <!-- <v-select v-model="form.legal_entity.personal_address.state" :options="statesList"></v-select> -->
                  <select v-model="form.legal_entity.personal_address.state" required class="form-control" name="state">
                    <option selected value="">Select State</option>
                    <option v-for="val in statesList" :value="val">{{val}}</option>
                  </select>
                </div>
              </div>

              <br />
              <hr style="width:90%;" />

              <div class="form-group row">
                <div class="col-12 float-left text-left">
                  <b>Card Info</b>
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Card Number</label>
                <div class="col-md-7">
                  <input v-model="form.card.number" :class="{ 'is-invalid': form.errors.has('number') }" maxlength="16" minlength="16" required class="form-control" type="text" name="number">
                  <has-error :form="form" field="number" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Expiration</label>
                <div class="col-md-7">
                  <!-- <input v-model="form.card.routing_number" disabled :class="{ 'is-invalid': form.errors.has('routing_number') }" class="form-control" type="text" name="routing_number"> -->
                  <div class="col-6 float-left text-center">
                    <label class="birth">Month</label>
                    <input v-model="form.card.exp_month" maxlength="2" class="form-control text-center" type="text" name="exp_month">
                  </div>
                  <div class="col-6 float-left text-center">
                    <label class="birth">Year</label>
                    <input v-model="form.card.exp_year" maxlength="4" placeholder="Ex 2020" class="form-control text-center" type="text" name="exp_year">
                  </div>
                  <has-error :form="form" field="routing_number" />
                </div>
              </div>

              <!-- Price -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">CVC</label>
                <div class="col-md-7">
                  <input v-model="form.card.cvc" maxlength="3" :class="{ 'is-invalid': form.errors.has('cvc') }" class="form-control" type="text" name="cvc">
                  <has-error :form="form" field="cvc" />
                </div>
              </div>

              <!-- Submit Button -->
              <div class="form-group row">
                <div class="col-md-12 ml-md-auto text-center">
                  <v-button :loading="form.busy" type="success">{{ $t('update') }}</v-button><br />
                  By registering your account, you agree to our Services Agreement and the <a href="https://stripe.com/connect-account/legal" target="_blank" class="link">Stripe Connected Account Agreement</a>.
                </div>
              </div>
            </form>
          </div>
        </div>
      </card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
var methods = {}

methods.createStripe = function () {
    const { data } = this.form.post('/api/activateAccount').then(response => {
        console.log(response)
        if (response.status === 200 || response.status === 201) {
          swal({
           title: "Success!",
           text: "Your account with stripe has been created. Your page will refresh in 5 seconds...",
           type: "success",
           timer: 5000
           }).then(function () {
            window.location.reload()
           })
        }
    }, error => {
      console.log(error.response)
    })
}

export default {
    name: "NonActivated",
    middleware: 'auth',
    data: function () {
      return {

      }
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {

    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
