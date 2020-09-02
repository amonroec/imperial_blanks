<template>
    <div id="admin">
        <div class="col-12 float-left">
            <div class="card bg-info-card">
                <div class="card-body">
                    <h4 class="card-title" style="border-bottom: 2px solid #ccc;">Customers
                        <i style="cursor: pointer;" v-if="!customerShow" class="float-right fa fa-chevron-down" @click="customerShow = true"></i>
                        <i style="cursor: pointer;" v-if="customerShow" class="float-right fa fa-chevron-up" @click="customerShow = false"></i>
                    </h4>
                    <div :class="customerShow ? '' : 'collapse '" class="multi-collapse col-12 float-left">
                	   <customers-table v-if="customerShow"></customers-table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 float-left mt-4">
            <div class="card bg-info-card">
                <div class="card-body">
                    <h4 class="card-title" style="border-bottom: 2px solid #ccc;">Users
                        <i style="cursor: pointer;" v-if="!userShow" class="float-right fa fa-chevron-down" @click="userShow = true"></i>
                        <i style="cursor: pointer;" v-if="userShow" class="float-right fa fa-chevron-up" @click="userShow = false"></i>
                    </h4>
                    <div :class="userShow ? '' : 'collapse '" class="multi-collapse col-12 float-left">
                       <users-table v-if="userShow"></users-table>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-12 float-left">
            <div class="card bg-info-card">
                <div class="card-body text-center">
                    <button class="btn btn-danger" @click="logoutEveryone()">Logout Everyone</button>
                </div>
            </div>
        </div> -->
    </div>
</template>
<script>
import CustomersTable from './../customers/customers_table'
import UsersTable from './../users_table'
import swal from 'sweetalert2'
import axios from 'axios'
var methods = {}

methods.logoutEveryone = function () {
    axios.post('/api/logoutEveryone').then(response => {
        console.log(response)
        if (response.status === 200 || response.status === 201) {
            swal('Success!', 'Everyone has been logged out.', 'success')
        }
    })
}

export default {
    name: "Admin",
    data: function () {
    	return {
            customerShow: false,
            userShow: false
    	}
    },
    components: {
    	CustomersTable,
        UsersTable
    },
    methods: methods,
    mounted: function() {

    },
    destroyed: function() {

    }
}
</script>
