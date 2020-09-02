<template>
    <div class="col-12 float-left" style="padding-bottom:15px;">
        <card title="Vacation Request" style="margin-top:15px;margin-top:15px;">
            <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Name:</label>
                    <div class="inputWrapper">
                        <v-select v-if="employees" :options="employees" label="label" v-model="form.employee"></v-select>
                    </div>
                </div>
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Leave Date:</label>
                    <div class="inputWrapper">
                        <!-- <v-select v-if="employees" :options="employees" label="label" v-model="form.supervisor"></v-select> -->
                        <input type="date" v-model="form.leave_date" class="form-control" />
                    </div>
                </div>
            </div>
            <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>AM/PM/All Day:</label>
                    <div class="inputWrapper">
                        <button class="btn btn-sm btn-secondary" :class="form.type_duration === 'AM' ? 'btn-success' : ''" @click="form.type_duration = 'AM'">AM</button>
                        <button class="btn btn-sm btn-secondary" :class="form.type_duration === 'PM' ? 'btn-success' : ''" @click="form.type_duration = 'PM'">PM</button>
                        <button class="btn btn-sm btn-secondary" :class="form.type_duration === 'All Day' ? 'btn-success' : ''" @click="form.type_duration = 'All Day'">All Day</button>
                    </div>
                </div>
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label># of Hours Gone:</label>
                    <div class="inputWrapper">
                        <input type="number" class="form-control" v-model="form.hours_gone" />
                    </div>
                </div>
            </div>
            <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Type of Leave:</label>
                    <div class="inputWrapper">
                        <button class="btn btn-sm btn-secondary" :class="form.type_of_leave === 'Vacation' ? 'btn-success' : ''" @click="form.type_of_leave = 'Vacation'">Vacation</button>
                        <button class="btn btn-sm btn-secondary" :class="form.type_of_leave === 'Personal' ? 'btn-success' : ''" @click="form.type_of_leave = 'Personal'">Personal</button>
                        <button class="btn btn-sm btn-secondary" :class="form.type_of_leave === 'Other' ? 'btn-success' : ''" @click="form.type_of_leave = 'Other'">Other</button>
                    </div>
                </div>
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Description (Optional)</label>
                    <div class="inputWrapper">
                        <input type="text" class="form-control" v-model="form.description" />
                    </div>
                </div>
            </div>
            <!-- <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-12 float-left">
                    <label style="width:20% !important;">Level of Severity:</label>
                    <div style="width:80% !important;" class="inputWrapper">
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === 'Verbal' ? 'btn-success' : ''" @click="form.level_of_severity = 'Verbal'">Verbal</button>
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === '1st Written' ? 'btn-success' : ''" @click="form.level_of_severity = '1st Written'">1st Written</button>
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === '2nd Written' ? 'btn-success' : ''" @click="form.level_of_severity = '2nd Written'">2nd Written</button>
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === 'Suspension' ? 'btn-success' : ''" @click="form.level_of_severity = 'Suspension'">Suspension</button>
                    </div>
                </div>
            </div> -->

            <div style="width:100%;float:left;">

                <div class="col-12 float-left text-center" style="margin-top:15px;">
                    <button class="btn btn-sm btn-info" :disabled="configureForm()" style="margin-top:15px;" @click="submitForm()">Submit</button>
                </div>
            </div>
        </card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
var methods = {}

methods.submitForm = function () {
    console.log(this.form)
    const postData = {
        form: this.form
    }
    axios.post('/api/submitVacation', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
        }
    })
}

methods.configureForm = function () {
    var i = 0
    var j = 0
    for (var key in this.form) {
        if (this.form[key] !== '') {
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

methods.getEmployees = function () {
    axios.post('/api/getEmployees').then(response => {
        if (response.status === 200) {
            console.log(response)
            var arr = []
            response.data.forEach(function (val) {
                var obj = {
                    id: val.id,
                    first_name: val.first_name,
                    last_name: val.last_name,
                    name: val.first_name + ' ' + val.last_name,
                    label: val.first_name + ' ' + val.last_name + ' (' + val.employee_id + ')',
                    age: val.age,
                    gender: val.gender,
                    employee_id: val.employee_id,
                    department: val.department
                }
                arr.push(obj)
            })
            this.employees = arr
        }
    })
}

export default {
    name: "SeparationForm",
    middleware: 'auth',
    data: function () {
    	return {
            employees: null,
            form: {
                employee: '',
                leave_date: '',
                type_duration: '',
                hours_gone: '',
                type_of_leave: '',
                description: ''
            },
            with_proper_notice_options: ['Death', 'Did Not Like Job', 'Health', 'Moved', 'No Return From FMLA', 'Other Employment', 'Personal', 'Retired'],
            without_proper_notice_options: ['3 Day No Call/No Show', 'Fail Tox Screen', 'Gross Misconduct', 'Incarceration', 'Never Reported To Work', 'Non-negotiable Unsafe Act', 'Personal', 'Refused Drug Screen', 'Stealing', 'Walked Out'],
            terminated_options: ['Disciplinary Discharge', 'Insubordination', 'Lay Off', 'Org Restructure', 'Temporary Position', 'Workplace Violence', 'Unsafe Act']
    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
        this.getEmployees()
    },
    watch: {
        'form.quit_terminated': function () {
            this.form.reason = ''
            this.form.type_of_notice = ''
        },
        'form.type_of_notice': function () {
            this.form.reason = ''
        }
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
<style lang="scss" scoped>
.topQuestion {
    margin-top:20px;

    label {
        width:40%;
        float:left;
        text-align:right;
        padding-right:15px;
        letter-spacing: 0;
        color: #666;
    }

    .inputWrapper {
        width:60%;
        float:left;
    }
}
</style>
