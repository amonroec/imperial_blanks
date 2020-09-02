<template>
    <div id="newEntry">

    </div>
</template>
<script>

export default {
    name: "NewEntry",
    middleware: 'auth',
    data: function () {
    	return {

    	}
    },
    components: {
        
    },
    mounted: function() {
        this.$store.dispatch('auth/fetchUser')
    },
    destroyed: function() {

    }
}
</script>
