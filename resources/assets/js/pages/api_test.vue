<template>
    <div class="col-12 float-left text-center">
        <button class="btn btn-sm btn-info mt-3" @click="testApi()">Test API</button>

        <div v-if="data" style="width:100%;float:left;">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Sku</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>DN Sku ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="value in data.inventories">
                            <td>{{value.product_code}}</td>
                            <td>{{value.sku}}</td>
                            <td>{{value.product_color.name}}</td>
                            <td>{{value.product_size.name}}</td>
                            <td>{{value.dn_sku_id}}</td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</template>
<script>
var methods = {}

methods.testApi = function () {
    var arr = [
        '1056',
        '1371',
        '1981',
        '1986',
        '1987',
        '3161',
        '5054',
        '6006',
        'DNA001',
        'DNA002',
        'DNA004',
        'DNA005',
        'DNA006',
        'IMP4',
        'X110B',
        'X210B',
        'X210P',
        'X210SM',
        'X231'
    ]

    const postData = {
        style: arr[this.val]
    }
    console.log(postData)
    axios.post('/api/testApi', postData).then(response => {
        console.log(response)
        this.data = JSON.parse(response.data.result)
        console.log(this.data)
        this.val++
    })
}

export default {
    // ===Component name
    name: "TestApi",
    // ===Props passed to component
    props: {},
    // ===Components used by this component
    components: {

    },
    // ====component Data properties
    data(){
        return{
            data: null,
            val: 0
        }
    },
    // ===Code to be executed when Component is mounted
    mounted() {

    },
    // ===Computed properties for the component
    computed: {},
    // ===Component methods
    methods: methods
}
</script>
<!-- styles -->
<!-- adding scoped attribute will apply the css to this component only -->
<style scoped></style>
