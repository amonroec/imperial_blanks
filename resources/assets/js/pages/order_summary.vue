<template>
    <div id="orderSummary">
        <!-- <div class="col-12 float-left mt-3">
            <button class="btn btn-danger" @click="$router.push('/')">
                <i class="fa fa-arrow-left"></i> Go To Order Table
            </button>
        </div> -->
        <div class="col-12 float-left mt-2">
            <card header="Order Summary" v-if="data && !noOrder">

                <!-- <progress-bar-customer :data="data"></progress-bar-customer> -->

                <div style="width:100%;float:left;margin-top:15px;">
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">PO#:</label> <label class="valueLabel">{{data.po_number}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Name:</label> <label class="valueLabel">{{data.user_name}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Customer#:</label> <label class="valueLabel">{{data.customer_number}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Email:</label> <label class="valueLabel">{{data.email}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Sold To:</label>
                        <label class="valueLabel">{{data.sold_to.name || ''}}<br />
                        {{data.sold_to.address}}<br />
                        {{data.sold_to.city}}, {{data.sold_to.state}} {{data.sold_to.zip_code}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Ship To:</label>
                        <label class="valueLabel">{{data.ship_to.name || ''}}<br />
                        {{data.ship_to.address}}<br />
                        {{data.ship_to.city}}, {{data.ship_to.state}} {{data.ship_to.zip_code}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Shipping Method:</label><label class="valueLabel">{{data.ship_method}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Shipping Code:</label><label class="valueLabel">{{data.ship_code}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Ship Date:</label> <label class="valueLabel">{{data.ship_date}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;">
                        <label class="labelLabel">Event?:</label><label class="valueLabel">{{data.event}}</label>
                    </div>
                    <div class="labels" style="width:100%;float:left;" v-if="data.event === 'Yes'">
                        <label class="labelLabel">Event Date:</label><label class="valueLabel">{{data.event_date}}</label>
                    </div>
                </div>
                <table id="fanaticsTable" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Style</th>
                            <th>Color</th>
                            <th>Color Code</th>
                            <!-- <th>Size Type</th> -->
                            <th style="text-align:center;">Sizes</th>
                            <!-- <th>Sleeve</th> -->
                            <!-- <th>Shirt</th> -->
                            <!-- <th>Gender</th> -->
                            <th style="text-align:center;">Quantity</th>
                            <th style="text-align:center;">Unit Price</th>
                            <th style="text-align:center;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="val in data.items">
                            <td>{{val.style}}</td>
                            <td>{{val.color}}</td>
                            <td>{{val.color_code}}</td>
                            <!-- <td>{{value.size_type}}</td> -->
                            <td style="text-align: center;">{{val.size}}</td>
                            <!-- <td>{{value.sleeve_type}}</td> -->
                            <!-- <td>{{value.shirt_type}}</td> -->
                            <!-- <td>{{value.gender}}</td> -->
                            <td style="text-align:center;">{{val.quantity_ordered}}</td>
                            <td style="text-align:center;">{{val.unit_price}}</td>
                            <td style="text-align:center;">{{val.total_price}}</td>
                        </tr>
                        <tr>
                                <td>Totals</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">{{configureTotalQuantity()}}</td>
                                <td></td>
                                <td style="text-align:center;">${{configureTotalPrice()}}</td>
                            </tr>
                    </tbody>
                </table>
            </card>
            <div style="width:100%;text-align:center;" v-else-if="noOrder">
                <h3>There is no order in our system with these credentials.</h3>
            </div>
        </div>
    </div>
</template>
<script>
var methods = {}
// import ProgressBarCustomer from './progress_bar_customer'

methods.getOrder = function () {
    const postData = {
        token: this.token
    }
    axios.post('/api/getOrder', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            if (response.data !== 'failed') {
                this.data = response.data
            } else {
                this.noOrder = true
            }
        }
    })
}

methods.configureTotalPrice = function () {
    var total = 0
    this.data.items.forEach(function (val) {
        total += parseFloat(val.total_price)
    })
    return parseFloat(total).toFixed(2)
}

methods.configureTotalQuantity = function () {
    var total = 0
    this.data.items.forEach(function (val) {
        total += parseFloat(val.quantity_ordered)
    })
    return total
}

export default {
    // ===Component name
    name: "OrderSummary",
    // ===Props passed to component
    props: ['token'],
    middleware: 'auth',
    // ===Components used by this component
    components: {

    },
    // ====component Data properties
    data(){
        return{
            data: null,
            noOrder: false
        }
    },
    // ===Code to be executed when Component is mounted
    mounted() {
        console.log(this.token)
        // if (!this.$store.state.user) {
        //     this.$router.push('/login')
        // } else {
            this.getOrder()
        // }

    },
    // ===Computed properties for the component
    computed: {},
    // ===Component methods
    methods: methods
}
</script>
<!-- styles -->
<!-- adding scoped attribute will apply the css to this component only -->
<style scoped lang="scss">
#orderSummary {
    .labels {
        font-size:17px;
        text-align:center;

        .labelLabel {
            font-weight: 900;
            text-align:right;
            width:50%;
            float:left;
            padding-right:5px;
        }
        .valueLabel {
            width:50%;
            float:left;
            text-align:left;
            padding-left:5px;
        }
    }

    .leftLabel {
        text-align:right;
        height:30px;
        line-height: 30px;
        font-weight: 900;
        width:50%;
        float:left;
        padding-right:5px;
        margin-top:10px;
    }
    .rightAnswer {
        width:50%;
        height:30px;
        text-align:left;
        font-size:16px;
        line-height:30px;
        float:left;
        padding-left:5px;
        margin-top:10px;
    }

    .shipped {
        width: 100px;
        float:left;
    }

    #shippedWrapper {
        width: 100px;
        text-align:center;
        float:left;

        i {
            font-size: 25px;
        }
    }
}
</style>
