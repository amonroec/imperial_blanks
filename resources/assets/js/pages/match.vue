<template>
    <div id="matches" class="col-12 float-left">
    	<!-- <table class="table" v-if="data">
    		<thead>
    			<th style="text-align:center;">Match Name</th>
    			<th style="text-align:center;">Course Name</th>
    			<th style="text-align:center;">Course Par</th>
    			<th style="text-align:center;">Created At</th>
    		</thead>
    		<tbody>
    			<tr style="cursor:pointer;" @click="goToMatch(val)" v-for="val in data" >
    				<td style="text-align:center;">{{val.name}}</td>
    				<td style="text-align:center;">{{val.course}}</td>
    				<td style="text-align:center;">{{configurePar(val)}}</td>
    				<td style="text-align:center;">{{val.created_at}}</td>
    			</tr>
    		</tbody>
    	</table> -->
        
            <card style="margin-top:15px;width:100%;overflow:scroll;height:calc(100% - 16px);" v-if="data">
                <h2 style="width:100%;float:left;text-align:center;">{{data.name}}</h2>
                <h5 style="width:100%;float:left;text-align:center;">@ {{data.course}}</h5>
                <div style="width:100%;float:left;margin-bottom:5px;" class="text-center">
                    <button class="btn-sm btn-info" @click="getMatch()">
                        <i class="fa fa-retweet"></i> Refresh Scores
                    </button>
                </div>
                <div class="col-12 float-left text-center" style="width:100%;overflow:scroll;">
                    <div style="width:100%;float:left;font-size:40px;" v-if="loading">
                        <i class="fa fa-spinner fa-spin fa-pulse"></i>
                    </div>
                    <table class="table table-horizontal mb-4 table-striped" style="min-width:1100px;" v-else-if="data && courseTotal">
                        <thead>
                            <tr>
                                <!-- <th style="min-width:200px !important;">User</th> -->
                                <!-- <th style="min-width:200px !important;padding:0;">Team</th> -->
                                <!-- <th></th> -->
                                <th rowspan="2" style="min-width:175px !important;">Team</th>
                                <th rowspan="2" style="min-width:175px !important;">Players</th>
                                <th>Hole</th>
                                <th v-for="(val, key) in data.par" style="width:86px;">
                                    <!-- <span style="width:100%;">{{character.name}}</span> -->
                                    <!-- <img class="characterImage" :src="getImgUrl(character)" /> -->
                                    {{key}}
                                </th>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Par</th>
                                <th v-for="(val, key) in data.par" style="width:86px;">
                                    {{val}}
                                </th>
                                <th>{{courseTotal}}</th>
                                <th>To Par</th>
                                <th>Handicap</th>
                                <th>Handicap Score</th>
                            </tr>
                        </thead>
                        <tbody v-if="data">
                            <tr v-for="(value, index) in data.teams"><!--Go to Entry -> @click="$router.push('/pick/' + value.id)"-->
                                <!-- <td style="width:200px !important;">{{value.user}}</td> -->
                                <td style="width:200px !important;vertical-align: inherit;">{{value.team_name}}</td>
                                <td style="text-align:center;">
                                    <div style="width:100%;float:left;text-align: center;" v-for="val in value.players">
                                        {{val}}
                                    </div>
                                </td>
                                <td></td>
                                <td v-for="(hole, key) in value.holes" style="width:86px;padding:3px;vertical-align: inherit;">
                                    <!-- <span>{{hole}}</span> -->
                                    <input :class="configureParClass(value.holes, key)" style="padding:0px !important;text-align:center;" type="text" class="form-control" v-model="value.holes[key]" @change="holeChange(value)" />
                                </td>
                                <td style="vertical-align: inherit;">{{configureTotal(value)}}</td>
                                <td :class="configureParClassTotal(value)" style="font-weight:900;vertical-align: inherit;">{{configureToPar(value)}}</td>
                                <td style="vertical-align: inherit;">{{value.strokes_given}}</td>
                                <td :class="configureParClassHandicap(value)" style="vertical-align: inherit;">{{configureHandicapScore(value)}}</td>
                                <!-- <td>{{configurePoints(value)}}</td> -->
                                <!-- <td>{{value.available_points}}</td> -->
                            </tr>
                        </tbody>
                        <!-- <tbody v-else-if="loading">
                            <tr>
                                <td colspan="4" style="text-align:center;font-size:50px;">
                                    <i class="fas fa-spinner"></i>
                                </td>
                            </tr>
                        </tbody> -->
                        <tbody v-else>
                            <tr>
                                <td colspan="4" style="text-align:center;">No Data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 float-left text-center">
                    <i class="fa fa-square eagle" style="margin-right:5px;"> Eagle</i>
                    <i class="fa fa-square birdie" style="margin-right:5px;"> Birdie</i>
                    <i class="fa fa-square bogey" style="margin-right:5px;"> Bogey</i>
                    <i class="fa fa-square double" style="margin-right:5px;"> Double</i>
                </div>
            </card>
    </div>
</template>
<script>
var methods = {}
import axios from 'axios'

methods.getMatch = function () {
    this.loading = true
    const postData = {
        match_id: this.match_id
    }
	axios.post('/api/getMatch', postData).then(response => {
		if (response.status === 200 || response.status === 201) {
			console.log(response)
			this.data = response.data
            var calc = 0
            for (var key in this.data.par) {
                calc += parseInt(this.data.par[key]) || 0
            }
            this.courseTotal = calc
            this.loading = false
		}
	})
}

methods.configureTotal = function (value) {
    var calc = 0
    for (var key in value.holes) {
        calc += parseInt(value.holes[key]) || 0
    }
    return calc
}

methods.configureParClass = function (value, key) {
    // var calc = 0
    // for (var key in this.data.par) {
    //     if (parseInt(this.data.par[key]) === parseInt(value.holes[key])) {
    //         calc += 0
    //     } else if (parseInt(this.data.par[key]) < parseInt(value.holes[key])) {
    //         calc += parseInt(value.holes[key]) - parseInt(this.data.par[key])
    //     } else if (parseInt(this.data.par[key]) > parseInt(value.holes[key])) {
    //         calc -= parseInt(this.data.par[key]) - parseInt(value.holes[key])
    //     }
    // }
    var val = parseInt(value[key])
    var par = parseInt(this.data.par[key])

    if (val < par) {
        if (par - val === 1) {
            return 'birdie'
        } else {
            return 'eagle'
        }
    } else if (val > par) {
        if (val - par === 1) {
            return 'bogey'
        } else {
            return 'double'
        }
    }
}

methods.configureHandicapScore = function (value) {
    var calc = 0
    for (var key in this.data.par) {
        if (parseInt(this.data.par[key]) === parseInt(value.holes[key])) {
            calc += 0
        } else if (parseInt(this.data.par[key]) < parseInt(value.holes[key])) {
            calc += parseInt(value.holes[key]) - parseInt(this.data.par[key])
        } else if (parseInt(this.data.par[key]) > parseInt(value.holes[key])) {
            calc -= parseInt(this.data.par[key]) - parseInt(value.holes[key])
        }
    }
    calc = calc - parseInt(value.strokes_given)
    // if (calc === 0) {
    //     return 'even'
    // } else if (calc < 0) {
    //     return 'under'
    // } else {
    //     return 'over'
    // }
    return calc
}

methods.configureParClassHandicap = function (value) {
    var calc = 0
    for (var key in this.data.par) {
        if (parseInt(this.data.par[key]) === parseInt(value.holes[key])) {
            calc += 0
        } else if (parseInt(this.data.par[key]) < parseInt(value.holes[key])) {
            calc += parseInt(value.holes[key]) - parseInt(this.data.par[key])
        } else if (parseInt(this.data.par[key]) > parseInt(value.holes[key])) {
            calc -= parseInt(this.data.par[key]) - parseInt(value.holes[key])
        }
    }
    calc = calc - parseInt(value.strokes_given)
    if (calc === 0) {
        return 'even'
    } else if (calc < 0) {
        return 'under'
    } else {
        return 'over'
    }
}

methods.configureParClassTotal = function (value) {
    var calc = 0
    for (var key in this.data.par) {
        if (parseInt(this.data.par[key]) === parseInt(value.holes[key])) {
            calc += 0
        } else if (parseInt(this.data.par[key]) < parseInt(value.holes[key])) {
            calc += parseInt(value.holes[key]) - parseInt(this.data.par[key])
        } else if (parseInt(this.data.par[key]) > parseInt(value.holes[key])) {
            calc -= parseInt(this.data.par[key]) - parseInt(value.holes[key])
        }
    }
    if (calc === 0) {
        return 'even'
    } else if (calc < 0) {
        return 'under'
    } else {
        return 'over'
    }
}

methods.configureToPar = function (value) {
    var calc = 0
    for (var key in this.data.par) {
        if (parseInt(this.data.par[key]) === parseInt(value.holes[key])) {
            calc += 0
        } else if (parseInt(this.data.par[key]) < parseInt(value.holes[key])) {
            calc += parseInt(value.holes[key]) - parseInt(this.data.par[key])
        } else if (parseInt(this.data.par[key]) > parseInt(value.holes[key])) {
            calc -= parseInt(this.data.par[key]) - parseInt(value.holes[key])
        }
    }
    if (calc === 0) {
        return 'E'
    } else {
        if (calc < 0) {
            return calc
        } else {
            return '+' + calc
        }
    }
}

methods.holeChange = function (value) {
    const postData = {
        team: value
    }
    axios.post('/api/holeChanged', postData).then(response => {
        if (response.status === 200 || response.status === 201) {
            console.log(response)
        }
    })
}

methods.configurePar = function (val) {
	var calc = 0
	for (var key in val.par) {
		calc += parseInt(val.par[key]) || 0
	}
	return calc
}

methods.goToMatch = function (val) {
	this.$router.push('/match/' + val.id)
}

export default {
    name: "blank",
    props: ['match_id'],
    data: function () {
    	return {
    		data: null,
            courseTotal: null,
            loading: true
    	}
    },
    methods: methods,
    mounted: function() {
    	this.getMatch()
    },
    destroyed: function() {

    }
}
</script>
<style lang="scss" scoped>
input {
    &.birdie {
        background-color: #87C7A1;
    }
    &.eagle {
        background-color: #FECC31;
    }
    &.bogey {
        background-color: #F17681;
    }
    &.double {
        background-color: #7CA8CF;
    }
}

td {
    &.under {
        color: green;
        font-weight: 900;
    }
    &.over {
        color: red;
        font-weight: 900;
    }
}
.fa {
    &.birdie {
        color: #87C7A1;
    }
    &.eagle {
        color: #FECC31;
    }
    &.bogey {
        color: #F17681;
    }
    &.double {
        color: #7CA8CF;
    }
}
</style>
