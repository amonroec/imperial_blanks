<template>
    <div class="col-12 text-center" style="float:left;padding-top:20px;">
        <card>
            <div class="col-12 float-left text-center">
                Thanks for registering! <br /><br />
                Someone on our team will approve your account as soon as possible and you will receive a confirmation email when complete.
            </div>
        </card>
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
var methods = {}

export default {
    name: "blank",
    middleware: 'auth',
    data: function () {
    	return {

    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {

    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
