<template>
    <div>
        <div class="d-block d-lg-none" style="position:fixed;bottom:25px;left:25px;z-index:99999;" @click="popupFilter()">
            <span class="fa-stack fa-2x">
                <i class="fas fa-circle fa-stack-2x" style="height:40px;"></i>
                <i class="fas fa-filter fa-stack-1x fa-inverse" style="height:40px;"></i>
            </span>
        </div>
        <div class="d-none d-md-none d-lg-block" id="buttonWrapper">
            <div class="bandonHeader float-left">
                <div class="switchWrap" style="margin-left:15px;">
                    <a style="margin-right:5px;">Show All</a>
                    <label class="switch" for="checkbox">
                        <input type="checkbox" id="checkbox" v-model="hideZero"/>
                        <div class="slider round"></div>
                    </label>
                    <a style="margin-left:5px;">Hide Out of Stock</a>
                </div>
                <div class="searchBar" style="margin-bottom:10px;margin-top:15px;margin-left:15px;">
                    <input type="input" class="form-control" style="padding-right:50px;" id="search" v-model="searchValue" placeholder="Find Style...">
                    <button type="button" @click="searchFunction()"  class="impButton impButtonColors btn" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fas fa-search"></i></button>
                </div>
                <!-- <v-select v-if="pai_styles" multiple style="margin-bottom:10px;width:246px;float:left;margin-top:15px;background-color:white;margin-left:15px;" placeholder="Filter By PAi Blank..." v-model="styleFilter" :options="pai_styles"></v-select> -->
                <v-select v-if="color_options" multiple style="margin-bottom:10px;width:246px;float:left;margin-top:15px;margin-left:15px;background-color:white;" placeholder="Filter By Color..." v-model="colorFilter" :options="color_options"></v-select>
                <!-- <div style="width:100%;float:left;">
                    <label>Tags</label>
                    <button
                        class="btn btn-sm"
                        :class="tags.indexOf(val) > -1 ? 'btn-danger' : 'btn-default'"
                        @click="tagClicked(val)"
                        v-for="val in tags">{{val}}</button>
                </div> -->
                <v-select v-if="tags" multiple style="margin-bottom:10px;width:246px;float:left;margin-top:15px;background-color:white;margin-left:15px;" placeholder="Filter By Tags..." v-model="tagFilter" :options="tags"></v-select>
                <!-- <a>Showing items 1- of </a> -->
            </div>
        </div>
        <div class="d-block d-md-none" id="smallButtonWrapper"></div>
        <div id="bottomSection" class="d-none d-lg-block">
            <div v-for="value in filterData" @click="orderShow(value)" v-if="!loading && (computeTotalQuantity(value)>0 && hideZero || !hideZero)" style="cursor:pointer;" class="item col-sm-6 col-md-4 col-lg-3 float-left">
                <card class="itemWrap">
                    <!-- <div class="topData">
                        <span> STYLE: <b>{{value[0].style}}</b> </span></br>
                        <div style="width:100%;float:left;">
                            <div style="width:20px;height:20px;float:left;margin:2px;" :style="'background-color:' + val.color + ';'" v-for="val in value" :title="val.color">
                            </div>
                        </div>
                    </div> -->
                    <div style="padding-top:100%;"></div>
                    <div class="imgContainer">
                        <img src="/storage/blank_default.jpg"></img>
                    </div>
                    <div class="price">
                        STYLE: <b style="border-bottom:2px solid #C92227;">{{value[0].style}}</b></br>
                        Total Quantity: <b>{{computeTotalQuantity(value)}}</b></br>
                        <!-- Stock: <b>{{value.quantity}}</b> -->
                    </div>
                </card>
            </div>
            <div v-show="loading || otherLoading" id="loader" style="float:left;width:100%;text-align:center;">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Loading ...
            </div>
            <div class="col-12 text-center float-left pb-5" v-if="!loading">
                <button class="btn btn-sm loadButton impButtonColors" @click="loadMore()">Load More</button>
            </div>
        </div>
        <div id="bottomSmallSection" class="d-block d-lg-none">
            <div v-for="value in filterData" @click="orderShow(value)" v-if="!loading && (computeTotalQuantity(value)>0 && hideZero || !hideZero)" style="cursor:pointer;" class="item col-sm-6 col-md-4 col-lg-3 float-left">
                <card class="itemWrap">
                    <div class="topData">
                        <span> SKU: <b>{{value[0].style}}</b> </span></br>
                        <!-- <span> Color: <b>{{value.color}} ({{value.color_code}})</b> </span></br> -->
                        <!-- <span> Size: <b>{{value.size}}</b> </span> -->
                    </div>
                    <div style="padding-top:100%;"></div>
                    <div class="imgContainer">
                        <img :src="'/storage/hat_images/' + value[0].customer_style + '.jpg'"></img>
                    </div>
                    <div class="price">
                        Retail Price: ${{value[0].retail_price}}</br>
                        Our Price: <b style="border-bottom:2px solid #C92227;">${{value[0].retail_price}}</b></br>
                        <!-- Stock: <b>{{value.quantity}}</b> -->
                    </div>
                </card>
            </div>
            <div v-show="loading || otherLoading" id="loader" style="float:left;width:100%;text-align:center;">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              Loading ...
            </div>
            <div class="col-12 text-center float-left pb-5" v-if="!loading">
                <button class="btn btn-sm loadButton impButtonColors" @click="loadMore()">Load More</button>
            </div>
        </div>
        <div id="orderModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div v-if="order_options" class="modal-content modal-lg">
              <div class="modal-header">
                <h4 class="modal-title float-left">{{currentOrder.style}}</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times" style="color:#000;line-height:36px;height:36px;"></i></button>
              </div>
              <div class="modal-body" style="width:100%;">
                <div class="col-12 float-left text-center">
                    <img style="max-height:300px;max-width:100%;" src="/storage/blank_default.jpg">
                </div>
                <div style="width:100%;float:left;padding:5px;">
                    <div style="width:50%;padding-right:5px;" class="float-left text-right">
                        Color:
                    </div>
                    <div style="width:50%;padding-left:5px;" class="float-left text-left">
                        <select v-if="colorOptions" @change="colorChanged()" v-model="currentOrder.color_selected" class="form-control">
                            <option value="">Select Color</option>
                            <option :value="val" v-for="val in colorOptions">{{val.color}} (val.color_code)</option>
                        </select>
                    </div>
                </div>
                <div style="width:100%;float:left;padding:5px;">
                    <div style="width:50%;padding-right:5px;" class="float-left text-right">
                        Size:
                    </div>
                    <div style="width:50%;padding-left:5px;" class="float-left text-left">
                        <select v-if="sizeOptions" @change="sizeChanged()" v-model="currentOrder.size" class="form-control">
                            <option value="">Select Size</option>
                            <option :value="val" v-for="val in sizeOptions">{{val}}</option>
                        </select>
                    </div>
                </div>
                <div style="width:100%;float:left;padding:5px;">
                    <div style="width:50%;padding-right:5px;" class="float-left text-right">
                        Available Units:
                    </div>
                    <div style="width:50%;padding-left:5px;" class="float-left text-left">
                        {{currentOrder.quantity}}
                    </div>
                </div>
                <div v-if="currentOrder.quantity" style="width:100%;margin-top:15px;float:left;text-align:center;">
                    <div style="width:50%;padding-right:5px;" class="float-left text-right">
                        Order Quantity:
                    </div>
                    <div style="width:50%;padding-left:5px;" class="float-left text-left">
                        <input type="number" class="form-control" :max="currentOrder.quantity" @keyup="checkQuantity()" placeholder="units" style="width:100px;text-align:left;" v-model="currentOrder.quantity_ordered" />
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                    <button type="button" class="btn btn-success" @click="addToCart()" data-dismiss="modal">Add To Cart</button>
              </div>
            </div>
          </div>
        </div>
        <div id="filterModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title float-left">Filter / Search</h4>
                <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times" style="color:#000;line-height:36px;height:36px;"></i></button>
              </div>
              <div class="modal-body" style="width:276px; margin:auto;">
                <div class="switchWrap">
                    <a style="margin-right:5px;">Show All</a>
                    <label class="switch" for="checkbox">
                        <input type="checkbox" id="checkbox" v-model="hideZero"/>
                        <div class="slider round"></div>
                    </label>
                    <a style="margin-left:5px;">Hide Out of Stock</a>
                </div>
                <div class="searchBar" style="margin-bottom:10px;margin-top:15px;">
                    <input type="input" class="form-control" style="padding-right:50px;" @keyup.enter="searchFunction()" id="search" v-model="searchValue" placeholder="Find Style...">
                    <button type="button" @click="searchFunction()"  class="impButton impButtonColors btn" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fas fa-search"></i></button>
                </div>
                <!-- <v-select v-if="pai_styles" multiple style="margin-bottom:10px;width:246px;float:left;margin-top:15px;background-color:white;" placeholder="Filter By PAi Blank..." v-model="styleFilter" :options="pai_styles"></v-select> -->
                <v-select v-if="color_options" multiple style="margin-bottom:10px;width:246px;float:left;margin-top:15px;background-color:white;margin-bottom:20px;" placeholder="Filter By Color..." v-model="colorFilter" :options="color_options"></v-select>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>
<script>
var methods = {}
import swal from 'sweetalert2'
import AppImg from './app_img'
import { mapGetters } from 'vuex'

methods.getInventory = function() {
    const postData = {
        user: this.user,
        offset: this.offset,
        limit: this.limit,
        styles: this.styleFilter,
        colors: this.colorFilter,
        tagFilter: this.tagFilter
    }
    console.log(postData)
    axios.post('api/getNewInventory', postData).then(response => {
        console.log(this.user)
        console.log(response);
        // if (!this.data) {
        //     this.data = response.data;
        // } else if (this.oldOffset !== this.offset) {
        //     this.oldOffset = this.offset
        //     this.data = this.data.concat(response.data)
        // } else {
        //     this.data = response.data
        // }
        // this.filterData = this.data
        // var arr = []
        // var obj = {}
        // var colorObj = {}
        // var colorArr = []
        // arr.sort()
        // colorArr.sort()
        var tags = []
        if (!this.data) {
            this.data = []
            var obj = {}
            response.data.forEach(function (val) {
                if (!obj[val.style]) {
                    obj[val.style] = []
                }
                if (val.tags) {
                    val.tags.forEach(function (tag) {
                        if (tags.indexOf(tag) < 0) {
                            tags.push(tag)
                        }
                    })
                }
                obj[val.style].push(val)
            })
            this.tags = tags
            var arr = []
            for (var key in obj) {
                arr.push(obj[key])
            }
            this.data = arr
            console.log(this.data)
        } else if (this.oldOffset !== this.offset) {
            var obj = {}
            response.data.forEach(function (val) {
                if (!obj[val.style]) {
                    obj[val.style] = []
                }
                obj[val.style].push(val)
            })
            var arr = []
            for (var key in obj) {
                arr.push(obj[key])
            }
            this.data = this.data.concat(arr)
        } else {
            var obj = {}
            response.data.forEach(function (val) {
                if (!obj[val.style]) {
                    obj[val.style] = []
                }
                obj[val.style].push(val)
            })
            var arr = []
            for (var key in obj) {
                arr.push(obj[key])
            }
            this.data = obj
        }
        console.log(this.data)
        this.filterData = this.data
        // this.color_options = colorArr
        // this.pai_styles = arr
        this.loading = false
        this.otherLoading = false
    })
}

methods.tagClicked = function (val) {
    if (this.tags.indexOf(val) > -1) {
        this.tags.splice(this.tags.indexOf(val), 1)
    } else {
        this.tags.push(val)
    }
}

methods.getFilters = function () {
    const postData = {
        user: this.user
    }
    console.log(postData)
    axios.post('/api/getFilters', postData).then(response => {
        if (response.status === 200) {
            console.log(response)
            this.color_options = response.data.colors
            this.pai_styles = response.data.styles
        }
    })
}

methods.computeTotalQuantity = function (value) {
    var total = 0
    value.forEach(function (val) {
        total += parseInt(val.quantity)
    })
    return total
}

methods.orderShow = function (value) {
    var arr = []
    var arr2 = []
    value.forEach(function (val) {
        var obj = {
            color: val.color,
            color_code: val.color_code
        }
        arr.push(obj)
        // arr2.push(val.size)
    })
    this.colorOptions = arr
    // this.sizeOptions = arr2
    var obj = {
        id: '',
        style: value[0].style,
        color_code: '',
        color: '',
        color_selected: '',
        // pai_variation: value.pai_variation,
        // sku: value.sku,
        // customer_color: '',
        size: '',
        // price: value.price,
        // image: value.image,
        quantity: '',
        quantity_ordered: ''
    }
    // obj.quantity_ordered = ''
    this.order_options = value
    this.currentOrder = obj
    // this.$refs.orderModal.show()
    $('#orderModal').modal('show')
}

methods.sizeChanged = function () {
    var that = this
    this.currentOrder.quantity = ''
    this.order_options.forEach(function (val) {
        if (val.color === that.currentOrder.color_selected.color && val.size === that.currentOrder.size) {
            that.currentOrder.quantity = val.quantity
            that.currentOrder.id = val.id
        }
    })
}

methods.colorChanged = function () {
    var arr = []
    var that = this
    this.currentOrder.size = ''
    this.currentOrder.quantity = ''
    this.order_options.forEach(function (val) {
        if (val.color === that.currentOrder.color_selected.color) {
            arr.push(val.size)
        }
    })
    this.sizeOptions = arr
}

methods.popupFilter = function () {
    $('#filterModal').modal('show')
}

methods.loadMore = function () {
    this.otherLoading = true
    this.offset += this.limit
    this.getInventory()
}

methods.addToCart = function () {
    if (parseInt(this.currentOrder.quantity_ordered) && parseInt(this.currentOrder.quantity_ordered) > 0) {
        this.currentOrder.color = this.currentOrder.color_selected.color
        this.currentOrder.color_code = this.currentOrder.color_selected.color_code
        if (window.localStorage.getItem('cart')) {
            var cart = JSON.parse(window.localStorage.getItem('cart'))
            cart.push(this.currentOrder)
            window.localStorage.setItem('cart', JSON.stringify(cart))
        } else {
            var cart = [this.currentOrder]
            window.localStorage.setItem('cart', JSON.stringify(cart))        
        }
        this.$store.dispatch('cart_details/setCart')
        swal({
          title: 'Success!',
          text: "You have added the order to your cart.",
          type: 'success',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Go To Checkout',
          cancelButtonText: 'Continue Shopping',
          confirmButtonColor: '#000',
        }).then((result) => {
          if (result.value) {
            this.$router.push('/checkout')
          }
        })
    } else {
        swal('Oops!', 'You need to adjust the quantity in order to add it to your cart.', 'error')
    }
}

methods.checkQuantity = function () {
    if (parseInt(this.currentOrder.quantity_ordered) > parseInt(this.currentOrder.quantity)) {
        this.currentOrder.quantity_ordered = this.currentOrder.quantity
    }
}

methods.order = function () {
    if (parseInt(this.currentOrder.quantity_ordered) <= parseInt(this.currentOrder.available_units)) {
        console.log(this.currentOrder)
    } else {
        var that = this
        swal('Oops!', "You are trying to order more than we have in stock. The quantity will be updated to what we have in inventory.", "error").then(res => {
            that.$refs.orderModal.show()
        })
        this.currentOrder.quantity_ordered = this.currentOrder.available_units
        // this.$refs.orderModal.show()
    }
}

methods.searchFunction = function () {
    var that = this
    if (this.searchValue !== '') {
        var arr = []
        var search = that.searchValue.toUpperCase()
        // console.log(search)
        // this.data.forEach(function (value) {
        //     if (value.sku.includes(search)) {
        //         arr.push(value)
        //     }
        // })
        // this.filterData = arr
        const postData = {
            search: this.searchValue,
            user: this.user
        }
        axios.post('/api/searchSku', postData).then(response => {
            if (response.status === 200) {
                if (response.data.length) {
                    // this.filterData = response.data
                    var obj = {}
                    response.data.forEach(function (val) {
                        if (!obj[val.style]) {
                            obj[val.style] = []
                        }
                        obj[val.style].push(val)
                    })
                    var arr = []
                    for (var key in obj) {
                        arr.push(obj[key])
                    }
                    this.filterData = arr
                } else {
                    swal('Not Found', 'The sku number you are trying to search could not be found.', 'error')
                }
            }
        })
    } else {
        this.filterData = this.data
    }
}

methods.configureBoth = function () {
    var that = this
    var arr = []
    this.loading = true
    this.data.forEach(function (val) {
        if (that.styleFilter.indexOf(val.customer_style) > -1 && that.colorFilter.indexOf(val.customer_color) > -1) {
            arr.push(val)
        }
    })
    this.filterData = arr
    setTimeout(function () {
        that.loading = false
    }, 500)
}

methods.configureStyle = function () {
    var that = this
    var arr = []
    this.loading = true
    this.data.forEach(function (val) {
        if (that.styleFilter.indexOf(val.customer_style) > -1) {
            arr.push(val)
        }
    })
    this.filterData = arr
    setTimeout(function () {
        that.loading = false
    }, 500)
}

methods.configureColor = function () {
    var that = this
    var arr = []
    this.loading = true
    this.data.forEach(function (val) {
        if (that.colorFilter.indexOf(val.customer_color) > -1) {
            arr.push(val)
        }
    })
    this.filterData = arr
    setTimeout(function () {
        that.loading = false
    }, 500)
}

methods.getFilterData = function () {
    // this.searchValue = ''
    if (this.styleFilter.length || this.colorFilter.length) {
        const postData = {
            user: this.user,
            style: this.styleFilter,
            color: this.colorFilter
        }
        console.log(postData)
        axios.post('/api/getFilterData', postData).then(response => {
            if (response.status === 200) {
                console.log(response)
                this.filterData = response.data
            }
        })
    } else {
        this.filterData = this.data
    }
}

export default {
    // ===Component name
    name: "BandonDunes",
    // ===Props passed to component
    props: {
        
    },
    middleware: 'confirmed',
    // ===Components used by this component
    components: {
        AppImg
    },
    computed: mapGetters({
        user: 'auth/user'
    }),
    // ====component Data properties
    data: function (){
        return {
            data: null,
            hideZero: 1,
            order_options: null,
            searchValue: '',
            styleFilter: [],
            colorFilter: [],
            current_color: '',
            current_size: '',
            filterData: null,
            loadedItems:0,
            totalItems:0,
            loading: true,
            currentOrder: null,
            pai_styles: [],
            styleFilter: [],
            colorFilter: [],
            color_options: [],
            offset: 0,
            oldOffset: 0,
            limit: 25,
            otherLoading: true,
            colorOptions: null,
            sizeOptions: null,
            tags: [],
            tagFilter: []
        }
    },
    watch: {
        'searchValue': function () {
            if (this.searchValue === '') {
                this.filterData = this.data
            }
        },
        'tagFilter': function () {
            // if (this.tags.length) {
                this.offset = 0
                this.limit = 25
                this.getInventory()
            // }
        },
        'styleFilter': function () {
            // var arr = []
            // if (this.styleFilter === '' || this.styleFilter === null || !this.styleFilter.length) {
            //     if (!this.colorFilter.length) {
            //         this.filterData = this.data
            //     } else {
            //         this.configureColor()
            //     }
            // } else {
            //     if (!this.colorFilter.length) {
            //         this.configureStyle()
            //     } else {
            //         this.configureBoth()
            //     }
            // }
            this.offset = 0
            this.limit = 25
            this.getInventory()
        },
        // 'hideZero': function () {
        //     var obj = {}
        //     var arr = []
        //     var that = this
        //     if (this.hideZero) {
        //         this.data.forEach(function (val) {
        //             // if (!obj[val.customer_style] && val.available_units > 0) {
        //             //     obj[val.customer_style] = val.customer_style
        //             //     arr.push(val.customer_style)
        //             // }
        //             if (that.computeTotalQuantity(val) > 0) {
        //                 arr.push(val[0].style)
        //             }
        //         })
        //     } else {
        //         this.data.forEach(function (val) {
        //             // if (!obj[val.customer_style]) {
        //             //     obj[val.customer_style] = val.customer_style
        //             //     arr.push(val.customer_style)
        //             // }
        //             arr.push(val[0].style)
        //         })
        //     }
        //     arr.sort()
        //     this.pai_styles = arr
        // },
        'colorFilter': function () {
            // var arr = []
            // if (this.colorFilter === '' || this.colorFilter === null || !this.colorFilter.length) {
            //     if (!this.styleFilter.length) {
            //         this.filterData = this.data
            //     } else {
            //         this.configureStyle()
            //     }
            // } else {
            //     if (!this.styleFilter.length) {
            //         this.configureColor()
            //     } else {
            //         this.configureBoth()
            //     }
            // }

            this.offset = 0
            this.limit = 25
            this.getInventory()
        }
    },
    // ===Code to be executed when Component is mounted
    mounted() {
        this.getInventory()
        this.getFilters()
    },
    // ===Component methods
    methods: methods
}
</script>
<!-- styles -->
<!-- adding scoped attribute will apply the css to this component only -->
<style scoped lang="scss">



#loader{
  width: 150px;
  height: 40px;
  border-radius: 100%;
  position: relative;
  margin: 40px auto;
  text-align:center;
  font-weight:bold;
  font-family: helvetica;
}

#loader span{
  display: inline-block;
  width: 20px;
  height: 20px;
  border-radius: 100%;
}

#loader span:nth-child(1){
  animation: bounce 1s ease-in-out infinite,pulse 2s infinite alternate;
}
#loader span:nth-child(2){
  animation: bounce 1s ease-in-out 0.2s infinite,pulse 2s infinite alternate;
}
#loader span:nth-child(3){
  animation: bounce 1s ease-in-out 0.4s infinite,pulse 2s infinite alternate;
}
#loader span:nth-child(4){
  animation: bounce 1s ease-in-out 0.6s infinite,pulse 2s infinite alternate;
}
#loader span:nth-child(5){
  animation: bounce 1s ease-in-out 0.8s infinite,pulse 2s infinite alternate;
}
#loader span:nth-child(6){
  animation: bounce 1s ease-in-out 1s infinite,pulse 2s infinite alternate;
}

@keyframes pulse {
  0% {background-color: #FFAC5E;}
  20% {background-color: #E83895;}
  40% {background-color: #564AFF;}
  60% {background-color: #38E8D8;}
  80% {background-color: #8CFF3D;}
  100% {background-color: #FFAC5E;}
}

@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-20px);
    -ms-transform: translateY(-20px);
    -o-transform: translateY(-20px);
    transform: translateY(-20px);
  }
}

    .item {
        max-height:325px;
        height:325px;
        min-height:325px;
        margin-bottom:15px;
        padding:0 8px;
    }
    .itemWrap {
        min-height:325px;
        max-height:325px;
        height:325px;
        margin-bottom:0px;

        .card {
            height:100%;
        }
    }
    .card-body {
        margin:15px !important;
        padding:0px !important;
    }
    .price {
        position:absolute;
        bottom:0;
        right:0;
        height: 60px;
        text-align:center;
        line-height:25px;
        width:150px;
        border-top-left-radius:5px;
        border-top:1px solid #efefef;
        border-left:1px solid #efefef;
        // border-bottom-right-radius: 3px;
        // background-color:#C92227;
        background-color: #f4f4f4;
    }
    .topData {
        position:absolute;
        top:5px;
        left:5px;

        span {
            padding:0 3px;
            background-color:#fff;
        }
    }
    .switch {
      display: inline-block;
      height: 17px;
      position: relative;
      width: 30px;
      float:left;
    }

    .switch input {
      display:none;
    }

    .slider {
      background-color: #23201F;
      bottom: 0;
      cursor: pointer;
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      transition: .4s;
    }

    .slider:before {
      background-color: #fff;
      bottom: 2px;
      content: "";
      height: 13px;
      left: 2px;
      position: absolute;
      transition: .4s;
      width: 13px;
    }

    input:checked + .slider {
      background-color: #C92227;
    }

    input:checked + .slider:before {
      transform: translateX(13px);
    }

    .slider.round {
      border-radius: 17px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    .switchWrap {
        width:220px;
        position:relative;
        float:left;
        margin-top:21px;
        
        a {
            height:20px;
            line-height:17px;
            float:left;
            font-size:.9em
        }
    }
    .searchBar {
        position:relative;
        float:left;
        margin:12px 0px;
        height:34px !important;

        input {
            float:left;
            position:relative;
            height:34px;
            width:246px;
            border-color:#D1D1D1;
        }

        div {
            position:relative;
            float:left;
        }
        button {
            position:relative;
            float:left;
            border-top-right-radius:3px;
            border-bottom-right-radius:3px;
            font-size:.9em;
            line-height: 20px;
        }
    }
    .loadButton {
        width:150px;
        border-radius:5px;
        margin-bottom:25px;
        color:white;
        font-weight:bold;
    }
    .bandonHeader {
        background-color:#f2f2f2;
        width:100vw;
        // margin-bottom:15px;
        position:fixed;
        top:50;left:0;right:0;
        z-index:5;
        box-shadow: 0 0 10px #ccc;
        height:59px;

        .imagesWrap {
            position:relative;
            float:left;
            width:175px;
        }

        .everythingElse {
            position:relative;
            float:left;
            padding-top:10px;
            padding-left:20px;

            h2 {
                margin-bottom:25px;
            }
        }

        #filterDiv {
            float:left;
            margin-top:10px;
            padding-left: 25px;
            width: calc(100% - 615px);
        }
    }

    #bottomSection {
        width:100%;float:left;margin-top:57.25px;
        padding-top:15px;
        height: calc(100vh - 112.25px);
        overflow-y: scroll;
        background-color: #232323;
    }

    #bottomSmallSection {
        width:100%;
        float:left;
        // margin-top:48px;
        padding-top:15px;
        height: calc(100vh - 48px);
        overflow-y: scroll;
        background-color: #232323;
    }
    .impButton {
        height:34px;
        margin-left:-48px;
        width:48px;
        color:white;
        font-weight:bold;
        background-color:blue;
    }
    .impButtonColors {
        background-color:#C92227;
        border-color:#CED4DA;

        &:hover {
            background-color:#a91d21;
        }
    }

    .btn-black {
        background-color:#000 !important;
        color: #fff !important;
    }
    .imgContainer {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        text-align:center; /* Align center inline elements */
        font: 0/0 a;
    }

    .imgContainer:before {
        content: ' ';
        display: inline-block;
        vertical-align: middle;
        height: 100%;
    }

    .imgContainer > img {
        vertical-align: middle;
        display: inline-block;
        max-height:293px !important;
        max-width:100% !important;
        z-index:9;
    }
    .modal-content {
        margin:auto;
    }

    .vs__dropdown-menu {
        z-index:1000 !important;
    }

</style>
