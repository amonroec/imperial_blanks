<template>
    <div>
      <card title="Stripe Account">
        <!-- Stripe Status -->
        <div class="form-group row">
          <div class="col-12 float-left text-center">
            Stripe Verification Status: {{stripe.legal_entity.verification.status}}
          </div>
        </div>

        <div v-if="account" class="col-12 float-left">
          <div class="form-group row">
            <div class="col-12 float-left text-left">
              <b>Account Info</b>
            </div>
          </div>
          <div class="col-6 float-left text-center">
            Pending Balance<br />
            ${{configureBalance(account.pending)}}
          </div>
          <div class="col-6 float-left text-center">
            Account Balance<br />
            ${{configureBalance(account.available)}}
          </div>
          <br />
          <hr style="width:100%;float:left;" />
        </div>

        <div class="col-12 float-left">
          
          <form @submit.prevent="updateStripeEntity" @keydown="form.onKeydown($event)">
            <alert-success :form="stripe" :message="$t('info_updated')"/>      

            <input type="hidden" name="user_id" v-model="user.id" />

            <!-- Personal Info Label -->
            <div class="form-group row">
              <div class="col-12 float-left text-left">
                <b>User Info</b>
              </div>
            </div>

            <!-- Name -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">First Name</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.first_name" :class="{ 'is-invalid': stripe.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                <has-error :form="stripe" field="first_name"/>
              </div>
            </div>

            <!-- Card Number -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Last Name</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.last_name" :class="{ 'is-invalid': stripe.errors.has('last_name') }" class="form-control" type="text" max="16" name="last_name">
                <has-error :form="stripe" field="last_name" />
              </div>
            </div>

            <!-- CC -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Personal Email</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.personal_email" :class="{ 'is-invalid': stripe.errors.has('personal_email') }" class="form-control" type="email" max="3" name="personal_email">
                <has-error :form="stripe" field="personal_email" />
              </div>
            </div>

            <!-- Price -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Phone Number</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.personal_phone_number" :class="{ 'is-invalid': stripe.errors.has('personal_phone_number') }" class="form-control" type="text" name="personal_phone_number">
                <has-error :form="stripe" field="personal_phone_number" />
              </div>
            </div>

            <!-- Date Of Birth -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Birthday</label>
              <div class="col-md-7">
                <div class="col-sm-12 col-md-3 float-left text-center">
                  <label class="birth">Month</label>
                  <input v-model="stripe.legal_entity.dob.month" maxlength="2" class="form-control text-center" type="text" name="month">
                </div>
                <div class="col-sm-12 col-md-3 float-left text-center">
                  <label class="birth">Day</label>
                  <input v-model="stripe.legal_entity.dob.day" maxlength="2" class="form-control text-center" type="text" name="day">
                </div>
                <div class="col-sm-12 col-md-6 float-left text-center">
                  <label class="birth">Year</label>
                  <input v-model="stripe.legal_entity.dob.year" maxlength="4" class="form-control text-center" type="text" name="year">
                </div>
              </div>
            </div>
            <br />
            <hr style="width:100%;float:left;" />
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
                <input v-model="stripe.legal_entity.personal_address.line1" :class="{ 'is-invalid': stripe.errors.has('line1') }" class="form-control" type="text" name="line1">
                <has-error :form="stripe" field="line1" />
              </div>
            </div>

            <!-- Price -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">City</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.personal_address.city" :class="{ 'is-invalid': stripe.errors.has('city') }" class="form-control" type="text" name="city">
                <has-error :form="stripe" field="city" />
              </div>
            </div>

            <!-- Price -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Zip Code</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.personal_address.postal_code" :class="{ 'is-invalid': stripe.errors.has('postal_code') }" class="form-control" type="text" name="postal_code">
                <has-error :form="stripe" field="postal_code" />
              </div>
            </div>

            <!-- Price -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">State</label>
              <div class="col-md-7">
                <!-- <input v-model="stripe.legal_entity.address.line1" :class="{ 'is-invalid': stripe.errors.has('line1') }" class="form-control" type="text" name="line1"> -->
                <v-select v-model="stripe.legal_entity.personal_address.state" :options="statesList"></v-select>
              </div>
            </div>

            <br />
            <hr style="width:100%;float:left;" />
            <!-- Address Label -->
            <div class="form-group row">
              <div class="col-12 float-left text-left">
                <b>Current Card Info</b>
              </div>
            </div>

            <div style="width:100%;float:left;" v-for="value in stripe.external_accounts.data">
              <!-- Last 4 -->
                <div class="col-md-12">
                  <div class="col-4 float-left text-center">
                    <label class="birth">Last 4</label>
                    <input v-model="value.last4" disabled class="form-control text-center" type="text">
                  </div>
                  <div class="col-4 float-left text-center">
                    <label class="birth">Month</label>
                    <input v-model="value.exp_month" disabled maxlength="2" class="form-control text-center" type="text" >
                  </div>
                  <div class="col-4 float-left text-center">
                    <label class="birth">Year</label>
                    <input v-model="value.exp_year" disabled maxlength="4" placeholder="Ex 2020" class="form-control text-center" type="text">
                  </div>
                  <!-- <has-error :form="stripe" field="line1" /> -->
                </div>

            </div>

            <div style="width:100%;float:left;text-align:center;margin-top:15px;">
              <a class="btn btn-outline-warning" data-toggle="modal" data-target="#addCard"><i class="fa fa-plus"></i> Add New Card</a>
            </div>

            <div class="col-md-12 ml-md-auto text-center float-left mt-5">
              <v-button :loading="stripe.busy" type="success">{{ $t('update') }}</v-button><br />
              By updating your account, you agree to our Services Agreement and the <a href="https://stripe.com/connect-account/legal" class="link">Stripe Connected Account Agreement</a>.
            </div>
          </form>
        </div>

        <div id="addCard" ref="addCard" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title float-left text-left">Card Info</h4>
                <button type="button" style="color:#000 !important;" class="close" data-dismiss="modal">&times;</button>
              </div>
              <form method="POST" @submit.prevent="addNewCard()">
                <div class="modal-body">

                    <!-- Price -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right">Card Number</label>
                      <div class="col-md-7">
                        <input v-model="newCard.card.number" maxlength="16" minlength="16" required class="form-control" type="text" name="number">
                        <has-error :form="form" field="number" />
                      </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right">Expiration</label>
                      <div class="col-md-7">
                        <!-- <input v-model="form.card.routing_number" disabled :class="{ 'is-invalid': form.errors.has('routing_number') }" class="form-control" type="text" name="routing_number"> -->
                        <div class="col-6 float-left text-center">
                          <label class="birth">Month</label>
                          <input v-model="newCard.card.exp_month" maxlength="2" class="form-control text-center" type="text" name="exp_month">
                        </div>
                        <div class="col-6 float-left text-center">
                          <label class="birth">Year</label>
                          <input v-model="newCard.card.exp_year" maxlength="4" placeholder="Ex 2020" class="form-control text-center" type="text" name="exp_year">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-4 col-form-label text-md-right">CVC</label>
                      <div class="col-md-7">
                        <input v-model="newCard.card.cvc" maxlength="3" class="form-control" type="text" name="cvc">
                      </div>
                    </div>                 
                  </div>
                  <div class="modal-footer">
                    <div class="col-md-12 ml-md-auto text-center float-left">
                        <v-button :loading="newCard.busy" type="success">Add Card</v-button><br />
                        By adding a card to your account, you agree to our Services Agreement and the <a href="https://stripe.com/connect-account/legal" class="link">Stripe Connected Account Agreement</a>.
                      </div>
                  </div>
                </form>
            </div>

          </div>
        </div>
        <!-- <div class="col-12 float-left">
          <div class="form-group row">
            <div class="col-12 float-left text-left">
              Payment Info
            </div>
          </div>
          <form @submit.prevent="updateStripeBanking" @keydown="form.onKeydown($event)">
            <alert-success :form="stripe" :message="$t('info_updated')"/>      

            <input type="hidden" name="user_id" v-model="user.id" />

            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">First Name</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.first_name" :class="{ 'is-invalid': stripe.errors.has('first_name') }" class="form-control" type="text" name="first_name">
                <has-error :form="stripe" field="first_name"/>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Last Name</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.last_name" :class="{ 'is-invalid': stripe.errors.has('last_name') }" class="form-control" type="text" max="16" name="last_name">
                <has-error :form="stripe" field="last_name" />
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Personal Email</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.personal_email" :class="{ 'is-invalid': stripe.errors.has('personal_email') }" class="form-control" type="email" max="3" name="personal_email">
                <has-error :form="stripe" field="personal_email" />
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 col-form-label text-md-right">Phone Number</label>
              <div class="col-md-7">
                <input v-model="stripe.legal_entity.personal_phone_number" :class="{ 'is-invalid': stripe.errors.has('personal_phone_number') }" class="form-control" type="text" name="personal_phone_number">
                <has-error :form="stripe" field="personal_phone_number" />
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-12 ml-md-auto">
                <v-button :loading="stripe.busy" type="success">{{ $t('update') }}</v-button>
              </div>
            </div>
          </form>
        </div> -->
      </card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
var methods = {}

methods.addNewCard = function () {
  console.log(this.newCard)
  this.newCard.user_id = this.user.id
  const { data } = this.newCard.post('/api/addCard').then(response => {

  })
}

methods.updateStripeEntity = function () {

}

export default {
    name: "ActivatedAccount",
    middleware: 'auth',
    props: ['stripe'],
    data: function () {
      return {
        newCardDiv: false,
        newCard: new Form({
          user_id: '',
          card: {
            number: '',
            exp_month: '',
            exp_year: '',
            cvc: '',
            currency: 'usd'
          }
        })
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
