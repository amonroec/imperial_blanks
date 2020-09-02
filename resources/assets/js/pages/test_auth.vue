<template>
    <div>
        TESTING
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
var methods = {}

export default {
    name: "blank",
    middleware: 'auth',
    props: ['code'],
    data: function () {
    	return {

    	}
    },
    computed: mapGetters({
        user: 'auth/user',
    }),
    mounted: function() {
        console.log(this.code)
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
