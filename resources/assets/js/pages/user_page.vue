<template>
    <div id="userPage">
        <!-- USER CARD -->
        <div class="col-sm-12 col-md-4 mt-3 float-left" v-if="data">
            <user-card :user_id="data.id"></user-card>
            <user-reviews :user_id="data.id"></user-reviews>
        </div>


        <!-- <div class="col-sm-12 col-md-3 float-left mt-3" v-if="data">
            <card title="User Info">
                <div style="width:100%;float:left;text-align:center;">
                    <div style="min-height:200px;width:100%;" v-if="data.user_pic">
                        <img :src="data.user_pic" style="width:80%;" />
                    </div>
                    <div style="height:200px;" v-else>
                        <i class="fa fa-user" style="font-size:55px;"></i>
                    </div>
                </div>
                <h3 style="width:100%;float:left;text-align:center;">{{data.name}}</h3>
                <h4 style="width:100%;float:left;text-align:center;">{{data.username}}</h4>
                <h5 style="width:100%;float:left;text-align:center;">{{data.posts.length}} Posts</h5>
                <h5 style="width:100%;float:left;text-align:center;">{{data.subscriptions}} Subscribers</h5>
                <div style="width:100%;float:left;text-align:center;">
                    <button class="btn btn-success" @click="rateUser('like')"><i class="fa fa-thumbs-up"></i> Like</button>
                    <button class="btn btn-danger" @click="rateUser('dislike')"><i class="fa fa-thumbs-down"></i> Dislike</button>
                </div>
            </card>
        </div> -->

        <!-- POSTS -->
        <div class="col-sm-12 col-md-8 float-left mt-3" v-if="posts">
            <card>
                <h3 class="posts" v-if="posts.length" style="width:100%;float:left;text-align:center;color:#000;">Posts</h3>
                <posts-container :posts="posts"></posts-container>
                <h4 class="link seeMore"  @click="loadMore()">See More</h4>
                <h3 class="posts" v-if="!posts.length" style="width:100%;text-align:center;">No Posts</h3>
            </card>
        </div>
    </div>
</template>
<script>
import PostsContainer from './../components/posts_container'
import UserCard from '~/components/user_card'
import UserReviews from '~/components/user_reviews'
var methods = {}

// Getting User Data to display
methods.getUserData = function () {
    const postData = {
        username: this.username,
        user_token: this.user_token,
        num: this.num
    }
    axios.post('/api/getUserData', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            console.log(this.data)
            if (this.num === 0) {
                this.data = response.data
                this.posts = response.data.posts
            } else {
                this.posts = this.posts.concat(response.data.posts)
            }
        }
    })
}

methods.loadMore = function () {
    this.num += 10
    this.getUserData()
}

methods.rateUser = function (type) {
    const postData = {
        type: type,
        id: this.data.id
    }
    axios.post("/api/rateUser", postData).then(response => {
        if (response.status === 200) {

        }
    })
}

export default {
    name: "UserPage",
    props: ['username', 'user_token'],
    data: function () {
    	return {
            data: null,
            posts: null,
            num: 0
    	}
    },
    components: {
        PostsContainer,
        UserCard,
        UserReviews
    },
    mounted: function() {
        console.log(this.username)
        this.getUserData()
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
<style lang="scss" scoped>
#userPage {
    .posts {
        font-family: comic sans ms;
        margin-top:20px;
        font-size: 60px;
        text-shadow: 3px 3px #3ab54a;
        color: #000;
        text-align:center;
      }
    .seeMore {
        cursor: pointer;
        color: #3293a8;
        width:100%;
        text-align:center;
        margin-top:15px;
        float:left;
    }
}
</style>
