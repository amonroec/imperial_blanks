<template>
    <card title="Users Table">
        <div class="col-12" style="overflow-x:scroll;width:100%;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th style="min-width:150px;">Name</th>
                        <th style="min-width:150px;">Email</th>
                        <th style="min-width:150px;">Customer#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="users" v-for="value in users">
                        <td>
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#editUser" @click="editUser = value">Confirm</button>
                        </td>
                        <td>{{value.id}}</td>
                        <td>
                            <input type="text" disabled v-model="value.name" class="form-control" />
                        </td>
                        <td>
                            <input type="text" disabled v-model="value.email" class="form-control" />
                        </td>
                        <td>
                            <input type="text" disabled v-model="value.customer_number" class="form-control" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="editUser" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content modal-lg">
                  <div class="modal-header">
                    <h4 class="modal-title float-left">Edit Customer</h4>
                    <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body modal-lg">
                    <div class="col-12">
                        <div class="col-6 float-left">Name</div>
                        <div class="col-6 float-left">
                            <input type="text" class="form-control" disabled v-model="editUser.name" />
                        </div>
                        <div class="col-6 float-left">Email</div>
                        <div class="col-6 float-left">
                            <input type="text" class="form-control" disabled v-model="editUser.email" />
                        </div>
                        <div class="col-6 float-left">Customer#</div>
                        <div class="col-6 float-left">
                            <input type="text" class="form-control" v-model="editUser.customer_number" />
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success" :disabled="configureDisabled()" data-dismiss="modal" @click="saveUser()">Confirm User & Send Email</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
        </div>
    </card>
</template>
<script>
import { mapGetters } from 'vuex'
import swal from 'sweetalert2'
var methods = {}

methods.getUsers = function () {
    axios.post('/api/getNeedsConfirmed').then(response => {
        console.log(response)
        if (response.status === 200) { 
            this.users = response.data
        } else {
            swal('Error!', 'Something went wrong with pulling customers.', 'error')
        }
    })
}

methods.saveUser = function () {
    const postData = {
        user: this.editUser
    }
    axios.post('/api/confirmUser', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            $('#editUser').hide()
            swal('Success!', 'You have successfully saved this user.', 'success')
        } else {
            swal('Error!', 'Something went wrong with saving this user.', 'error')
        }
    })
}

methods.configureDisabled = function () {
    if (this.editUser.customer_number) {
        return false
    } else {
        return true
    }
}

export default {
    name: "ConfirmUser",
    middleware: 'admin',
    data: function () {
    	return {
            users: null,
            addUser: {
                name: '',
                email: '',
                admin: '',
                customer_number: ''
            },
            editUser: {
                name: '',
                email: '',
                admin: '',
                customer_number: ''
            }
    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
        this.getUsers()
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
