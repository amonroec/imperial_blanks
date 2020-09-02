<template>
    <div id="loader">
        <div style="width:100%;text-align:center;font-size:50px;">
            <i :style="'color:' + color + ';'" class="fa fa-spinner fa-spin fa-pulse"></i>
        </div>
    </div>
</template>
<script>
var methods = {}

export default {
    name: "Loader",
    props: {
        color: {
            type: String,
            default: '#000'
        }
    },
    data: function () {
    	return {

    	}
    },
    mounted: function() {

    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
