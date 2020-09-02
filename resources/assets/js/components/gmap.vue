<template>
    <div style="width:100%;height:100%;">
    </div>
</template>
<script>
import { mapGetters } from 'vuex'
import gmapsInit from './../plugins/gmaps';
var methods = {}

methods.initMap = function (e) {
    console.log(e)
}

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
    async mounted() {
        try {
          const google = await gmapsInit();
          const geocoder = new google.maps.Geocoder();
          const map = new google.maps.Map(this.$el);
          console.log('mapmapmap')
          geocoder.geocode({ address: 'Austria' }, (results, status) => {
            if (status !== 'OK' || !results[0]) {
                console.log(status)
              throw new Error(status);
            }

            map.setCenter(results[0].geometry.location);
            map.fitBounds(results[0].geometry.viewport);
          });
        } catch (error) {
          console.error(error);
        }
    },
    methods: methods,
    destroyed: function() {

    }
}
</script>
