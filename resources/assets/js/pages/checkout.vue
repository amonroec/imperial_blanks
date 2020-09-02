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
                                <th>Sku</th>
                                <th>Style</th>
                                <th>Var</th>
                                <!-- <th style="text-align:center;width:75px;">XS</th>
                                <th style="text-align:center;width:75px;">S</th>
                                <th style="text-align:center;width:75px;">M</th>
                                <th style="text-align:center;width:75px;">L</th>
                                <th style="text-align:center;width:75px;">XL</th>
                                <th style="text-align:center;width:75px;">2X</th>
                                <th style="text-align:center;width:75px;">3X</th>
                                <th style="text-align:center;width:75px;">4X</th>
                                <th style="text-align:center;width:75px;">5X</th> -->
                                <th>Color</th>
                                <th style="text-align:center;">Size</th>
                                <th style="text-align:center;width:100px;">Quantity</th>
                                <th style="text-align:center;">Unit Price</th>
                                <th style="text-align:center;">Tot Price</th>
                                <th style="width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in actual_orders">
                                <td>{{value.customer_style}}</td>
                                <td>{{value.booking_style}}</td>
                                <td>{{value.booking_color}}</td>
                                <td>{{value.pai_color}}</td>
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
                                <td style="text-align:center;">{{value.retail_price}}</td>
                                <td style="text-align:center;">{{value.total_price}}</td>
                                <td style="width:50px;">
                                    <button type="button" class="btn impButton" tooltip="Delete" @click="remove(value, key)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
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
                    <label class="control-label col-md-3" for="text">User:</label>
                    <ul>
                        <li>
                            {{user.name}}
                        </li>
                        <li>
                            <!-- <input type="email" v-model="user.email" class="form-control" /> -->
                            {{user.email}}
                        </li>
                    </ul>
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
                                <input type="text" class="form-control" v-model="typeAddress.ship_to" placeholder="Ship To" />
                                <input type="text" style="margin-top:5px;" class="form-control" v-model="typeAddress.address" placeholder="Address" />
                                <input type="text" style="margin-top:5px;width:50%;float:left;" class="form-control" v-model="typeAddress.city" placeholder="City" />
                                <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="typeAddress.state" placeholder="State (Abr)" />
                                <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="typeAddress.zip_code" placeholder="Zip Code" />
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
                    <!-- <ul class="addressList" v-else>
                        <li style="padding-top:15px;">
                            <input type="text" class="form-control" v-model="typeAddress.ship_to" placeholder="Ship To" />
                            <input type="text" style="margin-top:5px;" class="form-control" v-model="typeAddress.address" placeholder="Address" />
                            <input type="text" style="margin-top:5px;width:50%;float:left;" class="form-control" v-model="typeAddress.city" placeholder="City" />
                            <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="typeAddress.state" placeholder="State (Abr)" />
                            <input type="text" style="margin-top:5px;width:25%;float:left;" class="form-control" v-model="typeAddress.zip_code" placeholder="Zip Code" />
                        </li>
                    </ul> -->
                    <label class="control-label col-md-3" for="text">PO #:</label>
                    <ul>
                        <li>
                            <input type="text" class="form-control" v-model="po_number" id="text" placeholder="Your PO">
                        </li>
                    </ul>
                    <!-- <label class="control-label col-md-3" for="text">In Hands Date:</label>
                    <ul>
                        <li>
                            <input type="date" class="form-control" v-model="in_hands_date" id="text">
                        </li>
                    </ul> -->
                </div>
                <div class="col-12 float-left text-center">
                    <button v-if="!checkoutLoading" class="btn impButton" @click="completeOrder()">Complete Order</button>
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
        address: this.typeAddress,
        po_number: this.po_number,
        orders: this.actual_orders,
        user: this.user
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

methods.quantityChanged = function (value) {
    console.log(value)
    var tot = 0
    if (parseInt(value.quantity_ordered) > parseInt(value.available_units)) {
        value.quantity_ordered = value.available_units
    }
    tot = parseFloat(parseInt(value.quantity_ordered) * parseFloat(value.retail_price)).toFixed(2)
    value.total_price = tot
    var arr = []
    for (var key in this.actual_orders) {
        arr.push(this.actual_orders[key])
    }
    window.localStorage.setItem('cart', JSON.stringify(arr))
    // this.$store.dispatch('cart_details/setCart')
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

export default {
    // ===Component name
    name: "Checkout",
    // ===Props passed to component
    // props: ['order'],
    // ===Components used by this component
    components: {
        SmallLoader
    },
    middleware: 'auth',
    // ====component Data properties
    data(){
        return{
            order: null,
            actual_orders: null,
            po_number: '',
            selectedAddress: null,
            in_hands_date: '',
            checkoutLoading: false,
            newAddress: false,
            email: 'accountspayable@bandondunesgolf.com',
            typeAddress: {
                ship_to: '',
                address: '',
                city: '',
                state: '',
                zip_code: ''
            },
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
        if (window.localStorage.getItem('cart')) {
            this.order = JSON.parse(window.localStorage.getItem('cart'))
            this.actual_orders = []
            var that = this
            var obj = {}
            var same = false
            this.order.forEach(function (val) {
                if (!obj[val.sku]) {
                    var totalPrice = parseFloat(parseInt(val.quantity_ordered) * parseFloat(val.retail_price)).toFixed(2)
                    obj[val.customer_style] = {
                        booking_style: val.booking_style,
                        pai_color: val.pai_color,
                        booking_color: val.booking_color,
                        customer_style: val.customer_style,
                        customer_color: val.customer_color,
                        size: val.size,
                        retail_price: val.retail_price,
                        our_price: val.our_price,
                        quantity_ordered: val.quantity_ordered,
                        available_units: val.available_units,
                        total_price: totalPrice
                    }
                } else {
                    obj[val.customer_style].quantity_ordered += val.quantity_ordered
                    if (parseInt(obj[val.customer_style].quantity_ordered) > parseInt(obj[val.customer_style].available_units)) {
                        obj[val.customer_style].quantity_ordered = obj[val.customer_style].available_units
                    }
                    var totalPrice = parseFloat(parseInt(val.quantity_ordered) * parseFloat(val.retail_price)).toFixed(2)
                    obj[val.customer_style].total_price = totalPrice
                    same = true
                }
                
                // var obj = {
                    
                // }
                // that.actual_orders.push(obj)
            })
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

        &:hover {
            background-color:#a91d21;
        }
    }
    /*width:100%;
    height:100%;
    background-color: #fff;*/
}
</style>
