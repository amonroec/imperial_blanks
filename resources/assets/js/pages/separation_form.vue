<template>
    <div class="col-12 float-left" style="padding-bottom:15px;">
        <card title="Separation Form" style="margin-top:15px;margin-top:15px;">
            <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Employee:</label>
                    <div class="inputWrapper">
                        <v-select v-if="employees" :options="employees" label="label" v-model="form.employee"></v-select>
                    </div>
                </div>
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Supervisor:</label>
                    <div class="inputWrapper">
                        <v-select v-if="employees" :options="employees" label="label" v-model="form.supervisor"></v-select>
                    </div>
                </div>
            </div>
            <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Department:</label>
                    <div class="inputWrapper" v-if="form.employee" style="float:left;">{{form.employee.department}}</div>
                </div>
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Last Day Worked:</label>
                    <div class="inputWrapper">
                        <input type="date" class="form-control" v-model="form.last_day_worked" />
                    </div>
                </div>
            </div>
            <div style="width:100%;float:left;">
                <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Separation Date:</label>
                    <div class="inputWrapper">
                        <input type="date" class="form-control" v-model="form.separation_date" />
                    </div>
                </div>
                <!-- <div class="topQuestion col-sm-12 col-md-6 float-left">
                    <label>Disciplinary Action?:</label>
                    <div class="inputWrapper">
                        <button class="btn btn-sm btn-secondary" style="width:60px;" :class="form.disciplinary_action === 'Yes' ? 'btn-success' : ''" @click="form.disciplinary_action = 'Yes'">Yes</button>
                        <button class="btn btn-sm btn-secondary" style="width:60px;" :class="form.disciplinary_action === 'No' ? 'btn-success' : ''" @click="form.disciplinary_action = 'No'">No</button>
                    </div>
                </div> -->
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
            <div class="col-12 float-left text-center mt-3">
                <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.quit_terminated === 'Quit' ? 'btn-success' : ''" @click="form.quit_terminated = 'Quit'">Quit</button>
                <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.quit_terminated === 'Terminated' ? 'btn-success' : ''" @click="form.quit_terminated = 'Terminated'">Terminated</button>
            </div>
            <div class="col-12 float-left text-center mt-3" v-if="form.quit_terminated === 'Quit'">
                <button class="btn btn-sm btn-secondary" style="width:175px;" :class="form.type_of_notice === 'With Proper Notice' ? 'btn-success' : ''" @click="form.type_of_notice = 'With Proper Notice'">With Proper Notice</button>
                <button class="btn btn-sm btn-secondary" style="width:175px;" :class="form.type_of_notice === 'Without Proper Notice' ? 'btn-success' : ''" @click="form.type_of_notice = 'Without Proper Notice'">Without Proper Notice</button>
            </div>
            <div class="col-12 float-left text-center mt-3" v-if="form.quit_terminated === 'Quit' && form.type_of_notice === 'With Proper Notice'">
                <v-select style="width:300px;margin-left:auto;margin-right:auto;" placeholder="Select Reason.." v-model="form.reason" :options="with_proper_notice_options"></v-select>
            </div>
            <div class="col-12 float-left text-center mt-3" v-if="form.quit_terminated === 'Quit' && form.type_of_notice === 'Without Proper Notice'">
                <v-select style="width:300px;margin-left:auto;margin-right:auto;" placeholder="Select Reason.." v-model="form.reason" :options="without_proper_notice_options"></v-select>
            </div>
            <div class="col-12 float-left text-center mt-3" v-if="form.quit_terminated === 'Terminated'">
                <v-select style="width:300px;margin-left:auto;margin-right:auto;" placeholder="Select Reason.." v-model="form.reason" :options="terminated_options"></v-select>
            </div>

            <div style="width:100%;float:left;" v-if="form.quit_terminated && form.type_of_notice && form.reason">
                <hr style="width:90%;float:left;margin-left:5%;" />

                <div class="col-sm-12 float-left text-center">
                    <h5 style="width:100%;color:#666;float:left;margin-bottom:15px;text-align:center;">Disciplinary Action?</h5><br />
                    <button class="btn btn-sm btn-secondary" style="width:60px;" :class="form.disciplinary_action === 'Yes' ? 'btn-success' : ''" @click="form.disciplinary_action = 'Yes'">Yes</button>
                    <button class="btn btn-sm btn-secondary" style="width:60px;" :class="form.disciplinary_action === 'No' ? 'btn-success' : ''" @click="form.disciplinary_action = 'No'">No</button>
                </div>

                <div v-if="form.disciplinary_action === 'Yes'" style="width:100%;float:left;margin-top:15px;">
                    <div class="col-sm-12 col-md-12 float-left text-center">
                        <h5 style="width:100%;color:#666;float:left;margin-bottom:15px;text-align:center;">Level of Severity</h5><br />
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === 'Verbal' ? 'btn-success' : ''" @click="form.level_of_severity = 'Verbal'">Verbal</button>
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === '1st Written' ? 'btn-success' : ''" @click="form.level_of_severity = '1st Written'">1st Written</button>
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === '2nd Written' ? 'btn-success' : ''" @click="form.level_of_severity = '2nd Written'">2nd Written</button>
                        <button class="btn btn-sm btn-secondary" style="width:125px;" :class="form.level_of_severity === 'Suspension' ? 'btn-success' : ''" @click="form.level_of_severity = 'Suspension'">Suspension</button>
                    </div>
                </div>

                <div class="col-12 float-left text-center" style="margin-top:15px;">
                    <h5 style="width:100%;color:#666;float:left;margin-bottom:15px;text-align:center;">Notes</h5><br />
                    <textarea class="form-control" col="5" v-model="form.notes"></textarea>

                    <button class="btn btn-sm btn-info" style="margin-top:15px;" @click="submitForm()">Submit</button>
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
    axios.post('/api/submitSeparation', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
        }
    })
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
                supervisor: '',
                last_day_worked: '',
                department: '',
                separation_date: '',
                quit_terminated: '',
                type_of_notice: '',
                termination_type: '',
                disciplinary_action: '',
                level_of_severity: '',
                reason: '',
                notes: ''
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
