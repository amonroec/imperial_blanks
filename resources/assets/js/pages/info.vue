<template>
    <div id="info">
        <card>
            <h3>INFO PAGE</h3>
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
