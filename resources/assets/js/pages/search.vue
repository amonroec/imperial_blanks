<template>
    <div id="search">
        <div style="width:100%;float:left;" v-if="data">
            <div class="col-sm-12 col-md-4 float-left pt-3" style="cursor: pointer;" @click="goToUser(value)" v-for="value in data">
                <card>
                    <div v-if="!value.user_pic" style="width:100%;text-align:center;font-size:50px;height:100px;">
                        <i class="fa fa-user"></i>
                    </div>
                    <div style="width:100%;float:left;text-align:center;" v-else>
                        <img :src="value.user_pic" style="height:100px;" />
                    </div>
                    <div style="width:100%;text-align:center;">
                        <h4>{{value.name}}</h4>
                        <h5>{{value.username}}</h5>
                        <h5>{{value.posts}} Posts</h5>
                        <h5>{{value.subscriptions}} Subscriptions</h5>
                    </div>
                </card>
            </div>
        </div>
    </div>
</template>
<script>
var methods = {}

methods.getSearch = function () {
    const postData = {
        search: this.searchValue
    }
    console.log(postData)
    axios.post('/api/getSearch', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            this.data = response.data
        }
    })
}

methods.goToUser = function (user) {
    this.$router.push('/user_page/' + user.username + '/' + user.user_token)
}

export default {
    name: "Search",
    props: ['search_prop'],
    data: function () {
    	return {
            searchValue: '',
            data: null
    	}
    },
    watch: {
        'search_prop': function (newVal, oldVal) {
            console.log(newVal + ' - ' + oldVal)
            this.searchValue = newVal
            this.getSearch()
        }
    },
    mounted: function() {
        console.log(this.search_prop)
        this.searchValue = this.search_prop.replace('_', ' ')
        this.getSearch()
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
