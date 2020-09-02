<template>
    <div class="float-left col-12">
        <card style="margin-top:15px;">
            <div style="width:100%;float:left;text-align:right;margin-bottom:15px;">
                <button class="btn btn-sm btn-info" @click="showModal('#addUser')">Add User</button>
            </div>
            <div style="width:100%;float:left;text-align:center;margin-bottom:15px;">
                <select style="margin-left:auto;margin-right:auto;width:250px;" @change="getEmployees()" v-model="filter">
                    <option value="active">Active Users</option>
                    <option value="terminated">Terminated Users</option>
                    <option value="all">All Users</option>
                </select>
            </div>
            <div style="width:100%;float:left;">
                <input type="text" class="form-control" style="width:250px;float:right;" @keyup.enter="searchData()" v-model="search" placeholder="Search...">
            </div>
            <table class="table" v-if="filterData && !loading">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>EmployeeID</th>
                        <th>Dep</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Date Hired</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="value in filterData">
                        <td>{{value.first_name}}</td>
                        <td>{{value.last_name}}</td>
                        <td>{{value.employee_id}}</td>
                        <td>{{value.department}}</td>
                        <td>{{value.age}}</td>
                        <td>{{value.gender}}</td>
                        <td>{{value.date_hired}}</td>
                    </tr>
                </tbody>
            </table>
            <small-loader v-else color="#fff"></small-loader>
        </card>

        <div id="addUser" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div v-if="newUser" class="modal-content modal-lg">
              <div class="modal-header">
                <h4 class="modal-title float-left">New Employee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" style="width:100%;">
                <div class="col-6 float-left text-right pr-1">First Name:</div>
                <div class="col-6 float-left text-left pl-1">
                    <input type="text" class="form-control" v-model="newUser.first_name" />
                </div>

                <div class="col-6 float-left text-right pr-1">Last Name:</div>
                <div class="col-6 float-left text-left pl-1">
                    <input type="text" class="form-control" v-model="newUser.last_name" />
                </div>

                <div class="col-6 float-left text-right pr-1">Employee ID:</div>
                <div class="col-6 float-left text-left pl-1">
                    <input type="text" class="form-control" v-model="newUser.employee_id" />
                </div>

                <div class="col-6 float-left text-right pr-1">Department:</div>
                <div class="col-6 float-left text-left pl-1">
                    <input type="text" class="form-control" v-model="newUser.department" />
                </div>

                <div class="col-6 float-left text-right pr-1">Birthday:</div>
                <div class="col-6 float-left text-left pl-1">
                    <input type="date" class="form-control" v-model="newUser.birthday" />
                </div>

                <div class="col-6 float-left text-right pr-1">Gender:</div>
                <div class="col-6 float-left text-left pl-1">
                    <!-- <input type="text" class="form-control" v-model="newUser.first_name" /> -->
                    <select class="form-control" v-model="newUser.gender">
                        <option value="">Gender...</option>
                        <option value="M">M</option>
                        <option value="F">F</option>
                    </select>
                </div>

                <div class="col-6 float-left text-right pr-1">Date Hired:</div>
                <div class="col-6 float-left text-left pl-1">
                    <input type="date" class="form-control" v-model="newUser.date_hired" />
                </div>

                <div class="col-6 float-left text-right pr-1">Worked Here Before?:</div>
                <div class="col-6 float-left text-left pl-1">
                    <button class="btn btn-sm btn-secondary" :class="newUser.worked_here_before === '1' ? 'btn-success' : ''" @click="newUser.worked_here_before = '1'">Yes</button>
                    <button class="btn btn-sm btn-secondary" :class="newUser.worked_here_before === '0' ? 'btn-success' : ''" @click="newUser.worked_here_before = '0'">No</button>
                </div>

                <div class="col-6 float-left text-right pr-1">Training?:</div>
                <div class="col-6 float-left text-left pl-1">
                    <button class="btn btn-sm btn-secondary" :class="newUser.training === '1' ? 'btn-success' : ''" @click="newUser.training = '1'">Yes</button>
                    <button class="btn btn-sm btn-secondary" :class="newUser.training === '0' ? 'btn-success' : ''" @click="newUser.training = '0'">No</button>
                </div>
              </div>
              <div class="modal-footer">
                <div v-if="newUser">
                    <button type="button" class="btn btn-success" :disabled="checkNewUser()" @click="addNewEmployee()" data-dismiss="modal">Check Off</button>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelPopup()">Cancel</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import SmallLoader from './../components/small_loader'
var methods = {}

methods.getEmployees = function () {
    this.loading = true
    const postData = {
        filter: this.filter
    }
    axios.post('/api/getEmployees', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            this.data = response.data
            this.filterData = this.data
            this.loading = false
        }
    })
}

methods.addNewEmployee = function () {
    const postData = {
        user: this.newUser
    }
    axios.post('/api/addNewEmployee', postData).then(response => {
        if (response.status === 200) {
            $('#addUser').modal('hide')
        }
    })
}

methods.showModal = function (value) {
    // this.newUser = {
    //     first_name: '',
    //     last_name: '',
    //     employee_id: '',
    //     department: '',
    //     birthday: '',
    //     gender: '',
    //     date_hired: '',
    //     worked_here_before: '',
    //     training: ''
    // }
    $(value).modal('show')
}

methods.searchData = function () {
    var arr = []
    var that = this
    if (this.search) {
        var search = this.search.toUpperCase()
        this.data.forEach(function (value) {
            if (value.first_name.toUpperCase().includes(search) || value.last_name.toUpperCase().includes(search) || value.employee_id.toString().includes(search)) {
                arr.push(value)
            }
        })
        this.filterData = arr
    } else {
        this.filterData = this.data
    }
}

methods.checkNewUser = function () {
    var i = 0
    var j = 0
    for (var key in this.newUser) {
        if (this.newUser[key] !== '') {
            i++
        }
        j++
    }
    if (i === j) {
        return false
    } else {
        return true
    }
}

export default {
    name: "EmployeeTable",
    middleware: 'auth',
    data: function () {
    	return {
            data: null,
            filter: 'active',
            loading: true,
            filterData: null,
            search: '',
            newUser: {
        first_name: '',
        last_name: '',
        employee_id: '',
        department: '',
        birthday: '',
        gender: '',
        date_hired: '',
        worked_here_before: '',
        training: ''
    }
    	}
    },
    components: {
        SmallLoader
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
        this.getEmployees()
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
