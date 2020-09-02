<template>
    <div class="col-12 float-left pt-3">
        <card>
            <div class="col-12 float-left text-center p-3">
                <select style="width:200px;margin-left:auto;margin-right:auto;" @change="getOrders()" class="form-control" v-model="filter">
                    <option value="All">All</option>
                    <option value="needs_entered">Needs Entered</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <table class="table" v-if="data">
                <thead>
                    <tr>
                        <th>Order#</th>
                        <th>Cust#</th>
                        <th>PO</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="value in data" @click="$router.push('/order_display/' + value.token)">
                        <td>{{value.id}}</td>
                        <td>{{value.customer_number}}</td>
                        <td>{{value.po_number}}</td>
                        <td>{{value.user_name}}</td>
                        <td>{{value.email}}</td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
var methods = {}

methods.getOrders = function () {
    const postData = {
        filter: this.filter
    }
    axios.post('/api/getOrders', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            this.data = response.data
        }
    })
}

export default {
    name: "OrdersTable",
    middleware: 'admin',
    data: function () {
    	return {
            data: null,
            filter: 'All'
    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
        this.getOrders()
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
