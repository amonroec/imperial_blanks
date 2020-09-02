<template>
  <!-- <card :title="$t('home')">
    {{ $t('you_are_logged_in') }}
  </card> -->
  <div>
    <!-- Image transitioner -->
    <!-- <div class="col-12">
      <card style="background-color:grey;margin-top:15px;">
        <h1 style="width:100%;text-align:center;color:#fff;">Welcome to Bass Believe It!</h1>
        <h3 style="width:100%;text-align:center;color:#fff;">Site is still in progress...</h3>

        <div class="col-12 text-center">
          <img src="./../../images/bass_believe_it_logo.png" />
        </div>
      </card>

      
    </div> -->

    <!-- <div class="strip float-left">
      <card>
        <div style="width:30%;float:left;text-align:center;" class="container1">
          <img src="./../../images/ac_two_bass.png" style="width:300px;" />
        </div>
        <div id="bbiLogo" style="width:40%;float:left;text-align:center;">
          <img style="width:400px;" src="./../../images/bbi_logo.png" />
        </div>
        <div style="width:30%;float:left;text-align:center;" class="container1">
          <img src="./../../images/ac_two_bass.png" style="width:300px;" />
        </div>
      </card>
    </div> -->

    <!-- <div id="bbiTop" class="strip float-left" style="position:relative;padding-bottom:20px;float:left;">
      <div class="background"></div>
      <div class="col-12 float-left" style="width:100%;">
        <h2>Learn what to fish & where to fish from your local pros!</h2>
        <h3>Pick & choose the people you want to learn from.</h3>
      </div>
    </div>

    <div class="strip" style="float:left;background-color:#000;text-align:center;color:#e0e0e0;padding:50px;padding-top:70px;padding-bottom:70px;">
      <label id="learn" style="font-size:30px;font-family:courier;">Want to make money while doing what you love?</label> <br />
      <hr style="width:100px;height:2px;background-color:#e0e0e0;" />
      <label id="pick" style="font-size:30px;font-family:courier;">The bass believe it, why wouldn't you?</label>
      <div class="col-12 float-left text-center mt-3">
          <button class="btn btn-outline-success" @click="goToInformation()">Click For More Information</button>
        </div>
    </div> -->

  </div>
</template>
<script>
var methods = {}

methods.goToInformation = function () {
  this.$router.push('/info')
}

methods.showPosition = function (position) {
  console.log(position)
}

export default {
  middleware: 'confirmed',

  metaInfo() {
    return { title: this.$t('home') }
  },
  // middleware: 'auth',

  data: function() {
    return {

    }
  },
  components: {

  },
  mounted: function() {
    // this.startInterval()
    // this.$store.dispatch('auth/fetchUser')
    if (navigator.geolocation) {
      var nav = navigator.geolocation.getCurrentPosition(showPosition);
      console.log(nav)
    } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
    }

    function showPosition(position) {
      console.log(position)
    }
  },
  methods: methods
}

</script>
<style lang="scss" scoped>
.transition-images {
  position: relative;
  height: calc(100vh - 100px);
  min-width: 100%;
  float: left;
  background-color: black;
  overflow: hidden;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;

  img {
    width: 100%;
    position: relative;
  }

  #overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    z-index: 1;
  }
}


.background {
    position:absolute;
    top:0;left: 0;right:0;bottom:0;
    width:100%;
    height:100%;
    // background: url('./../../images/lake_background.jpg');
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-position: center;
    opacity: 0.7;

    // background-attachment: fixed;
  }

#lake {
  background-color:#000;
  padding-bottom:25px;

  .background {
    background-attachment: fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-position: center;
  }
}

#bbiTop {
  background-color: #404040;
  padding-top:25px;

  h2 {
    font-family: comic sans ms;
    margin-top:20px;
    font-size: 60px;
    text-shadow: 3px 3px #3ab54a;
    color: #fff;
    text-align:center;
  }

  h3 {
    font-family: comic sans ms;
    font-size: 35px;
    margin-top: 35px;
    text-shadow: 2px 2px #fff;
    color: #3ab54a;
    text-transform: uppercase;
    font-style: italic;
    text-align:center;
  }

  .background {
    // background-attachment: fixed;
  }
}

#infoDiv {
  background-color:#000;

  .background {
    // opacity: .3 !important;
    background-attachment: fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-position: center;
  }

  .floatingBox {
    background-image: linear-gradient(to bottom right, #e0e0e0, #3ab54a);
    min-height:315px;
  }
}

.strip {
  width:100%;
  float: left;

  .containerDiv {
    border-radius:5px;

    &:hover {
      background-color:#8a8a8a;
      cursor: pointer;
    }
  }

  .floatingBox {
    width:100%;
    cursor: pointer;
    float:left;
    text-align:center;
    // background-color: rgba(46, 46, 46, 0.7);
    background-image: linear-gradient(to bottom right, #000, #e0e0e0);
    height:300px;
    border-radius: 5px;
    // box-shadow: 2px 2px 1px 1px rgba(255,255,255,.5);
    // border-left: solid 70px transparent; 
    // box-shadow: 0 0 30px #333;
    // border-right: solid 70px transparent; 
    // border-bottom: solid 70px #fff;
    filter: drop-shadow(0 0 2px #fff);

    &:hover {
      filter: drop-shadow(0 0 6px #fff);
      background-image: linear-gradient(to bottom right, #e0e0e0, #000);
    }

    .floatContainer {
      width:100%;
      float:left;
      height:calc(100% - 40px);
      padding:10px;
      text-align:center;

      img {
        height: 100%;
        max-width:100%;
      }
    }

    h4 {
      color:#fff;
      font-family: courier;
    }
  }
}

.footer {
  height: 200px;float:left;
  background-color: #000;
}

#container1 {

    // background: url('./../../images/ac_two_bass.png');
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-position: center;
      
    // @media screen and (max-width: 400px) {
    //   height:400px;
    //   width:100%;
    // }

    // @media screen and (min-width: 800px) {
    //   height:500px;
    // }

    // @media screen and (min-width: 1200px) {
    //   height:600px;
    // }

  // transform: scale(.8);
}

@media screen and (max-width: 400px) {

    .container1 {
      width:100%;float:left;
    }

    #bbiLogo {
      width:100% !important;
      img {
        // width:100%;
      }
    }
  }

@media screen and (max-width: 1080px) {
    #bbiLogo {
      width:100% !important;
      img {
        // height:300px;margin-top:100px;
      }
    }
    .container1 {
      display: none !important;
    }
  }

  @media screen and (min-width: 1200px) {
    #bbiLogo {
      img {
        // height:400px;margin-top:100px;
      }
    }
  }





#buttonWrapper {
  position: absolute;
  width: 500px;
  height: auto;
  bottom: 20%;
  left: 5%;
  z-index: 2;
  padding: 20px;
  background-color: white;
  border-radius: 10px;

  h3 {
    font-size: 35px;
    color: #000;
  }

  h5 {
    font-size: 15px;
    font-weight: bold;
    color: #000;
  }

  .sign-up-button {
    background-color: #D82E20;
    color: darken(#D82E20, 35%);
    font-weight: bold;
  }

  .new-mda-button {
    background-color: #429347;
    color: darken(#429347, 25%);
    font-weight: bold;
    margin-left: 8px;
  }

  button {
    &:hover {
      opacity: .8;
    }
  }
}

#smallButtonWrapper {
  position: absolute;
  width: 90%;
  margin-left: auto;
  margin-right: auto;
  height: auto;
  bottom: 20%;
  left: 5%;
  z-index: 2;
  padding: 20px;
  background-color: white;
  border-radius: 10px;

  h3 {
    font-size: 25px;
    color: #000;
  }

  h5 {
    font-size: 12px;
    font-weight: bold;
    color: #000;
  }

  .sign-up-button {
    background-color: #D82E20;
    color: darken(#D82E20, 35%);
    font-weight: bold;
    font-size: 13px;
    float: left;
  }

  .new-mda-button {
    background-color: #429347;
    color: darken(#429347, 25%);
    font-weight: bold;
    margin-left: 8px;
    font-size: 13px;
    float: left;
  }

  button {
    &:hover {
      opacity: .8;
    }
  }
}

#stateData {
  background-color: #f9f9f9;
  text-align: center;
  float: left;
  height: auto;
  padding-top: 55px;
  padding-bottom: 55px;

  h4 {
    font-weight: bold;
    color: #444444;

    span {
      color: #169540;
    }
  }

  h5 {
    margin-top: 25px;
    color: #777272;
    font-size: 15px;
  }
}

#iconWrapper {
  background-color: #fff;
  // padding-top: 25px;

  .emblemWrapper {
    text-align: center;
    float: left;
    padding: 25px;

    .labels {
      margin-top: 15px;
      font-size: 15px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .info {
      color: #999999;
      font-size: 14px;
    }
  }
}

#enterpriseWrapper {
  // background: url('./../../images/imageedit_2_7172783266.jpg') no-repeat center center;
  text-align: center;
  position: relative;
  min-height: 415px;
  height: auto;
  // padding:25px;
  width: 100%;
  // -webkit-background-size: cover;
  //  -moz-background-size: cover;
  //  -o-background-size: cover;
  //  background-size: cover;

  #imageWrapper {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    z-index: 1;
  }

  #textWrapper {
    position: relative;
    // top:0;right:0;left:0;bottom:0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    z-index: 2;
    padding-top: 80px;
    padding-bottom: 80px;

    #topText {
      color: #B0B0AE;
      font-size: 30px;
      font-style: italic;
    }

    #midText {
      color: #fff;
      font-size: 60px;
    }

    #bottomText {
      color: #fff;
      font-size: 15px;
      width: 60%;
      margin-left: 20%;
    }
  }
}

#storeWrapper {
  float: left;
  padding-top: 40px;
  padding-bottom: 40px;

  .moneyWrapper {
    float: left;
    text-align: center;

    &:hover {
      button {
        background-color: green;
      }

      p {
        color: green;
      }
    }

    button {
      margin-top: 25px;
      margin-bottom: 25px;
    }

    .money {
      margin-top: 45px;
      font-size: 30px;
      font-weight: bold;
    }

    .belowMoney {
      font-size: 12px;
      color: grey;
      margin-bottom: 45px;
    }

    .infoText {
      font-size: 15px;
      color: grey;
      padding: 5px;
    }
  }
}

</style>
