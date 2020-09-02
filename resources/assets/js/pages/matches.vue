<template>
    <div id="matches" class="col-12 float-left">
    	<card style="margin-top:15px;">
	    	<table class="table" v-if="data">
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
	    	</table>
	    </card>
    </div>
</template>
<script>
var methods = {}
import axios from 'axios'

methods.getMatches = function () {
	axios.get('/api/getMatches').then(response => {
		if (response.status === 200 || response.status === 201) {
			console.log(response)
			this.data = response.data
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
    data: function () {
    	return {
    		data: null
    	}
    },
    methods: methods,
    mounted: function() {
    	this.getMatches()
    },
    destroyed: function() {

    }
}
</script>
