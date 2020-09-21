<template>
    <div id="checkoutModal" class="col-12 float-left">
        <!-- <div id="headerLogo">
            <img class="pai-logo" src="./../assets/img/pai-logo-black-no-desc.png" title="PAi, INC."/>
            <div>A <img class="fanatics-logo" src="./../assets/img/fanatics_logo.png" title="Fanatics"/> Partner</div>
        </div> -->
        <div class="col-12 float-left text-left" style="margin-top:10px;">
            <button class="btn darkImpButton" @click="$router.push('/inventory_page')">
                <i class="fa fa-arrow-left"></i> Back To Inventory
            </button>
        </div>
        <div class="col-12 col-lg-6 float-left mt-1">
            <card v-if="actual_orders">
                <div style="width:100%;float:left;overflow-x: scroll;">
                    <table id="fanaticsTable" class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <!-- <th>Sku</th> -->
                                <th>Style</th>
                                <th>Color</th>
                                <!-- <th style="text-align:center;width:75px;">XS</th>
                                <th style="text-align:center;width:75px;">S</th>
                                <th style="text-align:center;width:75px;">M</th>
                                <th style="text-align:center;width:75px;">L</th>
                                <th style="text-align:center;width:75px;">XL</th>
                                <th style="text-align:center;width:75px;">2X</th>
                                <th style="text-align:center;width:75px;">3X</th>
                                <th style="text-align:center;width:75px;">4X</th>
                                <th style="text-align:center;width:75px;">5X</th> -->
                                <th>Color Code</th>
                                <th style="text-align:center;">Size</th>
                                <th style="text-align:center;width:100px;">Quantity</th>
                                <th style="text-align:center;">Unit Price</th>
                                <th style="text-align:center;">Tot Price</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in actual_orders">
                                <!-- <td>{{value.customer_style}}</td> -->
                                <td>{{value.style}}</td>
                                <td>{{value.color}}</td>
                                <td>{{value.color_code}}</td>
                                <td style="text-align:center;">
                                    <!-- <div v-for="size in value.sizes" v-if="size.subtract_quantity !== ''" style="width:100px;float:left;">
                                        <div style="width:100%;float:left;text-align:center;">
                                            {{size.size}}
                                        </div>
                                        <div style="width:100%;float:left;text-align:center;">
                                            {{size.subtract_quantity}}
                                        </div>
                                    </div> -->
                                    {{value.size}}
                                </td>
                                <td style="text-align:center;">
                                    <!-- {{value.subtract_quantity}} -->
                                    <input type="number" v-model="value.quantity_ordered" @change="quantityChanged(value)" class="form-control" />
                                </td>
                                <td style="text-align:center;">${{value.unit_price}}</td>
                                <td style="text-align:center;">${{value.total_price}}</td>
                                <td style="width:50px;">
                                    <button type="button" class="btn impButton" tooltip="Delete" @click="remove(value, key)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Totals</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">{{configureTotalQuantity()}}</td>
                                <td></td>
                                <td style="text-align:center;">${{configureTotalPrice()}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </card>
        </div>
        <div class="col-12 col-lg-6 float-left mt-1">
            <card v-if="actual_orders">
                <div class="col-12 float-left">
                    <!-- <h4 style="width:100%;">Click on the address  that you would like to use</h4> -->
                    <div style="width:100%;float:left;">
                        <label class="control-label col-md-3" for="text">Sold To:</label>
                        <ul class="addressList mb-3">
                            <li>

                                <div style="width:100%;float:left;margin-top:15px;">
                                    <input type="text" class="form-control" v-model="order_details.sold_to.name" placeholder="Ship To" />
                                    <input type="text" style="margin-top:5px;" class="form-control" v-model="order_details.sold_to.address" placeholder="Address" />
                                    <input type="text" style="margin-top:5px;width:50%;float:left;" class="form-control" v-model="order_details.sold_to.city" placeholder="City" />
                                    <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="order_details.sold_to.state" placeholder="State (Abr)" />
                                    <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="order_details.sold_to.zip_code" placeholder="Zip Code" />
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- <ul>
                        <li>
                            {{user.name}}
                        </li>
                        <li>
                            <input type="email" v-model="user.email" class="form-control" />
                            {{user.email}}
                        </li>
                    </ul> -->
                    <hr style="width:80%;float:left;margin-left:10%;margin-top:40px;height:1px;background-color:#ccc;" />
                    <div style="width:100%;float:left;margin-top:15px;">
                        <label class="control-label col-md-3" for="text">Ship To:</label>
                        <ul class="addressList">
                            <!-- <li>{{$store.state.user.company}}</li> -->
                            <!-- <li style="padding-top:10px;">
                                <select class="form-control" v-model="selectedAddress">
                                    <option v-for="i in 3" v-if="$store.state.user['address_' + i]" :value="i">{{$store.state.user['address_' + i].nickname}}</option>
                                    <option :value="4">Other</option>
                                </select>
                            </li> -->
                            <!-- <li style="padding-top:15px;">
                                {{typeAddress.ship_to}}<br />
                                {{typeAddress.address}}<br />
                                {{typeAddress.city}}, {{typeAddress.state}} {{typeAddress.zip_code}}
                            </li> -->
                            <li>

                                <div style="width:100%;float:left;margin-top:15px;">
                                    <input type="text" class="form-control" v-model="order_details.ship_to.name" placeholder="Ship To" />
                                    <input type="text" style="margin-top:5px;" class="form-control" v-model="order_details.ship_to.address" placeholder="Address" />
                                    <input type="text" style="margin-top:5px;width:50%;float:left;" class="form-control" v-model="order_details.ship_to.city" placeholder="City" />
                                    <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="order_details.ship_to.state" placeholder="State (Abr)" />
                                    <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="order_details.ship_to.zip_code" placeholder="Zip Code" />
                                </div>
                            </li>
                            <!-- <li @click="selectedAddress = '1'" v-if="$store.state.user.address_1" style="padding-top:15px;" :class="selectedAddress === '1' ? 'selected' : ''">
                                <h4 style="width:100%;">Address 1</h4>
                                {{$store.state.user.address_1.name}}<br />
                                {{$store.state.user.address_1.address}}<br />
                                {{$store.state.user.address_1.city}}, {{$store.state.user.address_1.state}} {{$store.state.user.address_1.zip_code}}
                            </li>
                            <li @click="selectedAddress = '2'" v-if="$store.state.user.address_2" style="padding-top:15px;" :class="selectedAddress === '2' ? 'selected' : ''">
                                <h4 style="width:100%;">Address 2</h4>
                                {{$store.state.user.address_2.name}}<br />
                                {{$store.state.user.address_2.address}}<br />
                                {{$store.state.user.address_2.city}}, {{$store.state.user.address_2.state}} {{$store.state.user.address_2.zip_code}}
                            </li>
                            <li @click="selectedAddress = '3'" v-if="$store.state.user.address_3" style="padding-top:15px;" :class="selectedAddress === '3' ? 'selected' : ''">
                                <h4 style="width:100%;">Address 3</h4>
                                {{$store.state.user.address_3.name}}<br />
                                {{$store.state.user.address_3.address}}<br />
                                {{$store.state.user.address_3.city}}, {{$store.state.user.address_3.state}} {{$store.state.user.address_3.zip_code}}
                            </li> -->
                            <!-- <li>{{$store.state.user.address_2}}</li>
                            <li>{{$store.state.user.address_3}}</li> -->
                        </ul>
                    </div>
                    <!-- <ul class="addressList" v-else>
                        <li style="padding-top:15px;">
                            <input type="text" class="form-control" v-model="typeAddress.ship_to" placeholder="Ship To" />
                            <input type="text" style="margin-top:5px;" class="form-control" v-model="typeAddress.address" placeholder="Address" />
                            <input type="text" style="margin-top:5px;width:50%;float:left;" class="form-control" v-model="typeAddress.city" placeholder="City" />
                            <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="typeAddress.state" placeholder="State (Abr)" />
                            <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="typeAddress.zip_code" placeholder="Zip Code" />
                        </li>
                    </ul> -->
                    <hr style="width:80%;float:left;margin-left:10%;margin-top:40px;height:1px;background-color:#ccc;" />
                    <div style="width:100%;float:left;margin-top:15px;">
                        <label class="control-label col-md-3" for="text">Order Details:</label>
                        <ul>
                            <li>
                                <div style="width:100%;float:left;margin-top:15px;">
                                    <input type="text" style="margin-top:5px;float:left;" class="form-control" v-model="order_details.po_number" placeholder="PO #" />
                                    <br /><br />
                                    Ship Date
                                    <input type="date" style="margin-top:5px;float:left;" class="form-control" v-model="order_details.ship_date" placeholder="Ship Date" />
                                </div>
                            </li>
                        </ul>
                    </div>

                    <hr style="width:80%;float:left;margin-left:10%;margin-top:40px;height:1px;background-color:#ccc;" />
                    <div style="width:100%;float:left;margin-top:15px;">
                        <label class="control-label col-md-3" for="text">Event Details:</label>
                        <ul>
                            <li>
                                <div style="width:100%;float:left;margin-top:15px;">
                                    <button class="btn btn-sm btn-default" @click="order_details.event = 'Yes'" :class="order_details.event === 'Yes' ? 'btn-success' : ''">Yes</button>
                                    <button class="btn btn-sm btn-default" @click="order_details.event = 'No'" :class="order_details.event === 'No' ? 'btn-success' : ''">No</button>
                                    <br /><br />
                                    <div style="width:100%;float:left;" v-if="order_details.event === 'Yes'">
                                        Event Date
                                        <div style="width:100%;float:left;margin-top:5px;">
                                            <input type="date" class="form-control" v-model="order_details.event_date" placeholder="Event Date" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <hr style="width:80%;float:left;margin-left:10%;margin-top:40px;height:1px;background-color:#ccc;" />
                    <div style="width:100%;float:left;margin-top:15px;">
                        <label class="control-label col-md-3" for="text">Shipping Details:</label>
                        <ul>
                            <li>
                                <div style="width:100%;float:left;margin-top:15px;">
                                    <select class="form-control" v-model="order_details.ship_method">
                                        <option value="">Select Ship Method</option>
                                        <option v-for="val in shipping_options" :value="val">{{val}}</option>
                                    </select>

                                    <div style="width:100%;float:left;margin-top:5px;" v-if="order_details.ship_method !== 'Other' && order_details.ship_method !== ''">
                                        <input type="text" class="form-control" v-model="order_details.ship_code" placeholder="Ship Code" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- <label class="control-label col-md-3" for="text">In Hands Date:</label>
                    <ul>
                        <li>
                            <input type="date" class="form-control" v-model="in_hands_date" id="text">
                        </li>
                    </ul> -->
                </div>
                <div class="col-12 float-left text-center mt-3">
                    <!-- <button v-if="!checkoutLoading" class="btn impButton" @click="stripe_checkout()">Complete Order</button> -->
                    <button v-if="!checkoutLoading && user.invoice" class="btn impButton" @click="completeOrder()">Invoice Order</button>
                    <!-- <button v-else-if="!checkoutLoading && !user.invoice" class="btn impButton" @click="completeOrder()">Complete Order</button> -->
                    <!-- <stripe-checkout
                        ref="checkoutRef"
                        :pk="publishableKey"
                        :items="items"
                        v-else-if="!checkoutLoading && !user.invoice">
                        <template slot="checkout-button">
                          <button @click="stripe_checkout()">Shut up and take my money!</button>
                        </template>
                    </stripe-checkout>
                     -->
                    <div style="width:100%;float:left;" v-else-if="!checkoutLoading && !user.invoice">
                        <stripe-elements
                            ref="elementsRef"
                            :pk="publishableKey"
                            :amount="configureAmount()"
                            local="de"
                            @token="tokenCreated"
                            ></stripe-elements>
                            <button class="btn impButton" @click="submit()">Complete Order</button>
                    </div>
                    <small-loader v-else></small-loader>
                </div>
            </card>
        </div>
    </div>
</template>
<script>
var methods = {}
import swal from 'sweetalert2';
import SmallLoader from './../components/small_loader'
import { mapGetters } from 'vuex'
import { StripeCheckout } from 'vue-stripe-checkout';
import { StripeElements } from 'vue-stripe-checkout';

methods.submit = function () {
      this.$refs.elementsRef.submit();
}

methods.completeOrder = function () {
    // this.actual_orders.forEach(function (val) {
    //     if (parseInt(val.quantity_ordered) > parseInt(val.units)) {
    //         val.quantity_ordered = val.units
    //         swal('Oops!', 'You tried ordering too many units for ' + val.)
    //         return
    //     }
    // })
    for (var key in this.actual_orders) {
        if (parseInt(this.actual_orders[key].quantity_ordered) > parseInt(this.actual_orders[key].units)) {
            this.actual_orders[key].quantity_ordered = this.actual_orders[key].units
            swal('Oops!', 'You tried ordering too many units for ' + val.sku, 'error')
            return
        }
    }
    const postData = {
        email: this.email,
        orders: this.actual_orders,
        order_details: this.order_details,
        user: this.user,
        charge: this.charge
    }
    console.log(postData)
    axios.post('/api/submitOrder', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            if (response.data.result === 'success') {
                window.localStorage.removeItem('cart')
                this.$store.dispatch('cart_details/setCart')
                this.$router.push('/order_summary/' + response.data.res.token)
            }
        }
    })
}

methods.tokenCreated = function (e) {
    this.checkoutLoading = true
    var description = this.user.name + ' purchase of ' + this.order_details.po_number + '.'
    console.log(e)
    this.charge = {
        source: e.id,
        amount: this.amount,
        description: description
    }
    var that = this
    setTimeout(function () {
        that.completeOrder()
    }, 1000)
}

methods.configureAmount = function () {
    var total = 0
    for (var key in this.actual_orders) {
        // var obj = {
        //     sku: 'sku_' + this.actual_orders[key].style + '_' + this.actual_orders[key].color_code,
        //     quantity: this.actual_orders[key].quantity_ordered
        // }
        // this.items.push(obj)
        total += parseFloat(this.actual_orders[key].total_price)
    }
    this.amount = parseFloat(total).toFixed(2)
    this.amount = this.amount * 100
    return this.amount
}

methods.configureTotalPrice = function () {
    var total = 0
    for (var key in this.actual_orders) {
        total += parseFloat(this.actual_orders[key].total_price)
    }
    return parseFloat(total).toFixed(2)
}

methods.configureTotalQuantity = function () {
    var total = 0
    for (var key in this.actual_orders) {
        total += parseInt(this.actual_orders[key].quantity_ordered)
    }
    return total
}

methods.quantityChanged = function (value) {
    console.log(value)
    var tot = 0
    if (parseInt(value.quantity_ordered) > parseInt(value.quantity)) {
        value.quantity_ordered = value.quantity
    }
    tot = parseFloat(parseInt(value.quantity_ordered) * parseFloat(value.unit_price)).toFixed(2)
    value.total_price = tot
    var arr = []
    for (var key in this.actual_orders) {
        arr.push(this.actual_orders[key])
    }
    window.localStorage.setItem('cart', JSON.stringify(arr))
    // this.$store.dispatch('cart_details/setCart')
}

methods.stripe_checkout = function () {
    this.items = []
    for (var key in this.actual_orders) {
        var obj = {
            sku: 'sku_' + this.actual_orders[key].style + '_' + this.actual_orders[key].color_code,
            quantity: this.actual_orders[key].quantity_ordered
        }
        this.items.push(obj)
    }
    var that = this
    setTimeout(function () {
        that.$refs.checkoutRef.redirectToCheckout();
    }, 1000);
}

methods.remove = function (value, key) {
    // this.order.splice(index, 1)
    // if (this.order.length) {
    //     window.localStorage.setItem('cart', JSON.stringify(this.order))
    // } else {
    //     window.localStorage.removeItem('cart')
    // }
    // this.actual_orders.splice(index, 1)
    // this.$store.state.order = this.order
    var arr = []
    for (var k in this.actual_orders) {
        if (key !== k) {
            arr.push(this.actual_orders[k])
        }
    }
    if (arr.length) {
        window.localStorage.setItem('cart', JSON.stringify(arr))
        this.actual_orders = arr
        this.$store.dispatch('cart_details/setCart')
    } else {
        window.localStorage.removeItem('cart')
        this.actual_orders = null
        this.$store.dispatch('cart_details/setCart')
    }
    
}

methods.getUnitPrice = function (val) {
    var unitPrice = ''
    var i = 0
    var that = this
    this.quant_arr.forEach(function (v) {
        if (parseInt(val.quantity_ordered) < v && unitPrice === '') {
            unitPrice = that.price_arr[i]
        }
        i++
    })
    return parseFloat(unitPrice).toFixed(2)
}

export default {
    // ===Component name
    name: "Checkout",
    // ===Props passed to component
    // props: ['order'],
    // ===Components used by this component
    components: {
        SmallLoader,
        StripeCheckout,
        StripeElements
    },
    middleware: 'auth',
    // ====component Data properties
    data(){
        return{
            order: null,
            actual_orders: null,
            selectedAddress: null,
            in_hands_date: '',
            checkoutLoading: false,
            publishableKey: "pk_test_zYHtIgvalM3NFNipQwqLjqIy",
            newAddress: false,
            quant_arr: [5, 23, 47, 71, 143],
            price_arr: [25.00, 15.20, 10.20, 9.80, 9.20],
            email: 'accountspayable@bandondunesgolf.com',
            charge: null,
            order_details: {
                ship_to: {
                    name: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: ''
                },
                sold_to: {
                    name: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: ''
                },
                po_number: '',
                event: 'No',
                ship_date: '',
                ship_method: '',
                ship_code: ''
            },
            items: null,
            shipping_options: ['UPS Ground', 'FEDEX Ground', 'UPS 2nd Day Air', 'UPS Overnight', 'FEDEX Express', 'Other'],
            addresses: null,
            addressOptions: null,
            otherAddressSelected: null,
            fanaticsAddress: null
        }
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    // ===Code to be executed when Component is mounted
    mounted() {
        console.log(this.publishableKey)
        if (window.localStorage.getItem('cart')) {
            this.order = JSON.parse(window.localStorage.getItem('cart'))
            this.actual_orders = []
            var that = this
            var obj = {}
            var same = false
            var quantArr = [5, 23, 47, 71, 143]
            var priceArr = [25.00, 15.20, 10.20, 9.80, 9.20]
            this.order.forEach(function (val) {
                console.log(val)
                var str = val.style + '_' + val.color_code
                console.log(str)
                if (!obj[str]) {
                    var unit_price = that.getUnitPrice(val)
                    var totalPrice = parseFloat(parseInt(val.quantity_ordered) * parseFloat(unit_price)).toFixed(2)
                    obj[str] = {
                        style: val.style,
                        color: val.color,
                        color_code: val.color_code,
                        // customer_style: val.customer_style,
                        // customer_color: val.customer_color,
                        size: val.size,
                        retail_price: val.retail_price,
                        our_price: val.our_price,
                        unit_price: unit_price,
                        quantity_ordered: val.quantity_ordered,
                        available_units: val.quantity,
                        total_price: totalPrice
                    }
                } else {
                    obj[str].quantity_ordered += val.quantity_ordered
                    if (parseInt(obj[str].quantity_ordered) > parseInt(obj[str].available_units)) {
                        obj[str].quantity_ordered = obj[str].available_units
                    }
                    var unit_price = that.getUnitPrice(obj)
                    var totalPrice = parseFloat(parseInt(val.quantity_ordered) * parseFloat(unit_price)).toFixed(2)
                    obj[str].total_price = totalPrice
                    same = true
                }
                
                // var obj = {
                    
                // }
                // that.actual_orders.push(obj)
            })
            console.log(obj)
            that.actual_orders = obj
            if (same) {
                var arr = []
                for (var key in that.actual_orders) {
                    arr.push(that.actual_orders[key])
                }
                window.localStorage.setItem('cart', JSON.stringify(arr))
            }
            console.log(that.actual_orders)
        }
    },

    watch: {
        'otherAddressSelected': function () {
            if (this.otherAddressSelected && this.otherAddressSelected !== '') {
                this.fanaticsAddress = this.addresses[this.otherAddressSelected]
                console.log(this.fanaticsAddress)
                this.newAddress = false
            } else {
                this.fanaticsAddress = null
            }
        }
    },
    // ===Component methods
    methods: methods
}
</script>
<!-- styles -->
<!-- adding scoped attribute will apply the css to this component only -->
<style scoped lang="scss">
#checkoutModal {

    ul {
        list-style-type: none;
    }

    #headerLogo {
        position:fixed;
        left: 10px;top:6px;
        z-index:1049;
        
        .pai-logo {
            height:38px;
            position:relative;
            float:left; 
        }

        div {
            height: 20px;
            margin-top:18px;
            margin-left: 10px;
            position:relative;
            float:left;

            .fanatics-logo {
                height:100%;
            }
        }
    }

    .addressList {
        list-style-type: none;
        li {
            cursor: pointer;
        }
        .selected {
            border: 2px solid green;
            border-radius: 5px;
        }
    }

    .darkImpButton {
        background-color:#2b2b2b;
        border-color:#CED4DA;
        height:30.75px;
        color:white;
        font-weight:bold;

        &:hover {
            background-color:#141414;
        }
    }

    .impButton {
        background-color:#C92227;
        border-color:#CED4DA;
        height:30.75px;
        color:white;
        font-weight:bold;
        line-height:15px;

        &:hover {
            background-color:#a91d21;
        }
    }
    /*width:100%;
    height:100%;
    background-color: #fff;*/
}
</style>
