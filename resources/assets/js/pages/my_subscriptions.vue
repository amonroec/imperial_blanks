<template>
    <div id="mySubscriptions">
        <div style="width:100%;float:left;" v-if="data && data.length">
            <div class="col-sm-12 col-md-3 float-left pt-3" style="cursor: pointer;" @click="goToUser(value)" v-for="value in data">
                <card>
                    <div v-if="!value.user_pic" style="width:100%;text-align:center;font-size:50px;height:100px;">
                        <i class="fa fa-user"></i>
                    </div>
                    <div style="width:100%;float:left;text-align:center;" v-else>
                        <img :src="value.user_pic" style="height:100px;" />
                    </div>
                    <div style="width:100%;text-align:center;">
                        <h4 style="font-size:1em;">{{value.name}}</h4>
                        <h5 style="font-size:1em;">{{value.username}}</h5>
                        <h5 style="font-size:1em;">{{value.posts}} Posts</h5>
                        <h5 style="font-size:1em;">{{value.subscriptions}} Subscriptions</h5>
                    </div>
                </card>
            </div>
        </div>
        <card v-else>
            <div class="col-12 text-center float-left" style="font-size:20px;">
                You are not subscribed to anyone...<br />
                <button class="btn btn-info" @click="$router.push('/posts_page')">Check Out Posts</button>
            </div>
        </card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
var methods = {}

methods.getMySubscriptions = function () {
    const postData = {
        user_id: this.user.id
    }
    axios.post('/api/getMySubscriptions', postData).then(response => {
        if (response.status === 200 || response.status === 201) {
            console.log(response)
            this.data = response.data
        }
    })
}

methods.goToUser = function (user) {
    this.$router.push('/user_page/' + user.username + '/' + user.user_token)
}

export default {
    name: "MySubscriptions",
    middleware: 'auth',
    data: function () {
    	return {
            data: null
    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
        this.getMySubscriptions()
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
