<template>
    <div class="col-12" id="activateAccount">
        <card class="text-center" title="Activate Account" v-if="!loading && accountNotMade">
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
        <card title="Stripe Account" v-else-if="!loading && stripe">
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
                  <b>Payment Info</b>
                </div>
              </div>

              <!-- <div style="width:100%;float:left;" v-for="value in stripe.external_accounts.data">
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
                  </div>
              </div> -->
              <div class="col-12 float-left">
                <table class="table">
                  <thead>
                    <tr>
                      <th></th>
                      <th style="text-align:right;">Type</th>
                      <th style="text-align:right;">Last 4</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="value in stripe.external_accounts.data">
                      <td v-if="value.object === 'bank_account'">{{value.bank_name}}</td>
                      <td v-if="value.object === 'card'">{{value.brand}} - {{value.funding}}</td>
                      <td style="text-align:right;">{{value.object}}</td>
                      <td style="text-align:right;">{{value.last4}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div style="width:100%;float:left;text-align:center;margin-top:15px;">
                <a class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#addCard"><i class="fa fa-plus"></i> Add New Card</a>
                <a class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#addBank"><i class="fa fa-plus"></i> Add New Bank Account</a>
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

          <div id="addBank" ref="addBank" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title float-left text-left">Bank Info</h4>
                  <button type="button" style="color:#000 !important;" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form method="POST" @submit.prevent="addNewBank()">
                  <div class="modal-body">

                      <!-- Price -->
                      <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Account Holder Name</label>
                        <div class="col-md-7">
                          <input v-model="newBank.bank_account.account_holder_name" required class="form-control" type="text" name="account_holder_name">
                          <has-error :form="form" field="account_holder_name" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Routing Number</label>
                        <div class="col-md-7">
                          <input v-model="newBank.bank_account.routing_number" required class="form-control" type="text" name="routing_number">
                          <has-error :form="form" field="routing_number" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right">Number</label>
                        <div class="col-md-7">
                          <input v-model="newBank.bank_account.account_number" required class="form-control" type="text" name="account_number">
                          <has-error :form="form" field="account_number" />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="col-md-12 ml-md-auto text-center float-left">
                          <v-button :loading="newBank.busy" type="success">Add Bank</v-button><br />
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
        <spinner v-else-if="loading" :color="'#fff'"></spinner>
    </div>
</template>
<script>
import Form from 'vform'
import { mapGetters } from 'vuex'
import swal from 'sweetalert2'
var methods = {}

methods.checkStripe = function () {
  this.loading = true
  const postData = {
    user_id: this.user.id
  }
  axios.post('/api/checkStripeAccount', postData).then(response => {
    if (response.status === 200 || 201) {
      console.log(response)
      if (response.data !== 'account_not_made') {
        var per = response.data.per
        this.stripe = new Form(per)
        this.account = response.data.balance
        console.log(this.stripe)
      } else {
        this.accountNotMade = true
      }
      this.loading = false
    }
  })
}

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

methods.configureBalance = function (arr) {
  var calc = 0
  arr.forEach(function (val) {
    calc += val.amount
  })
  return (calc / 100).toFixed(2)
}

methods.addNewCard = function () {
  console.log(this.newCard)
  this.newCard.user_id = this.user.id
  const { data } = this.newCard.post('/api/addCard').then(response => {
    if (response.status === 200 || response.status === 201) {
      swal({
        title: "Success!",
        text: "You have added a card to your stripe account. Your page will refresh in 5 seconds...",
        type: "success",
        timer: 5000
      }).then(function () {
        window.location.reload()
      })
    }
  })
}

methods.addNewBank = function () {
  this.newBank.user_id = this.user.id
  const { data } = this.newBank.post('/api/addNewBank').then(response => {
    if (response.status === 200 || response.status === 201) {
      swal({
        title: "Success!",
        text: "You have added a bank to your stripe account. Your page will refresh in 5 seconds...",
        type: "success",
        timer: 5000
      }).then(function () {
        window.location.reload()
      })
    }
  })
}

methods.updateStripeEntity = function () {

}

export default {
    name: "ActivateAccount",
    middleware: 'auth',
    data: function () {
    	return {
            loading: false,
            accountNotMade: false,
            stripe: null,
            account: null,
            type: '',
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
            }),
            newBank: new Form({
              user_id: '',
              bank_account: {
                country: 'US',
                currency: 'usd',
                account_holder_name: 'Testing',
                account_holder_type: 'individual',
                routing_number: '110000000',
                account_number: '000123456789'
              }
            }),
            form: new Form({
              type: '',
              user_id: '',
              // name_on_card: '',
              // card_number: '',
              // cc: '',
              // expiration_date: ''
              legal_entity: {
                type: 'individual',
                first_name: '',
                last_name: '',
                personal_email: '',
                personal_phone_number: '',
                dob: {
                  month: '',
                  day: '',
                  year: ''
                },
                personal_address: {
                  line1: '',
                  city: '',
                  postal_code: '',
                  state: ''
                },
                ssn_last_4: ''
              },
              bank_account: {
                country: 'US',
                currency: 'usd',
                account_holder_name: 'Testing',
                account_holder_type: 'individual',
                routing_number: '110000000',
                account_number: '000123456789'
              },
              card: {
                number: '',
                exp_month: '',
                exp_year: '',
                cvc: '',
                currency: 'usd'
              }
            }),
            statesList: [
              'Alabama',
              'Alaska',
              'Arizona',
              'Arkansas',
              'California',
              'Colorado',
              'Connecticut',
              'Delaware',
              'District of Columbia',
              'Florida',
              'Georgia',
              'Hawaii',
              'Idaho',
              'Illinois',
              'Indiana',
              'Iowa',
              'Kansas',
              'Kentucky',
              'Louisiana',
              'Maine',
              'Maryland',
              'Massachusetts',
              'Michigan',
              'Minnesota',
              'Mississippi',
              'Missouri',
              'Montana',
              'Nebraska',
              'Nevada',
              'New Hampshire',
              'New Jersey',
              'New Mexico',
              'New York',
              'North Carolina',
              'North Dakota',
              'Ohio',
              'Oklahoma',
              'Oregon',
              'Pennsylvania',
              'Rhode Island',
              'South Carolina',
              'South Dakota',
              'Tennessee',
              'Texas',
              'Utah',
              'Vermont',
              'Virginia',
              'Washington',
              'West Virginia',
              'Wisconsin',
              'Wyoming'
            ]
    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
      console.log(this.user)
      this.checkStripe()
      this.form.user_id = this.user.id
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
