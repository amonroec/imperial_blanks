<template>
  <div class="col-12 float-left text-center">
    <!-- <leaderboard></leaderboard> -->
    <!-- <got></got> -->
    <div class="card bg-info-card mt-3" style="margin-bottom:30px;">
      <div class="card-body">
        <h4 class="card-title">New Entry</h4>
        <form method="POST" v-on:submit.prevent="submitForm()">
          <div class="col-sm-12 col-md-6 float-left">
            <label class="inputLabel">Name of Match</label>
            <input type="text" required class="form-control" v-model="form.name" />
          </div>
          <div class="col-sm-12 col-md-6 float-left text-center">
            <label class="inputLabel">Course</label>
            <div v-if="courses.length" style="width:100%;float:left;">
              <!-- <a class="btn-sm btn-secondary" :class="form.course === 'Sullivan' ? 'btn-success' : ''" @click="form.course = 'Sullivan', otherCourse = false, form.holes = sullivanHoles">Sullivan</a>
              <a class="btn-sm btn-secondary" :class="otherCourse ? 'btn-success' : ''" @click="otherCourse = true, form.course = '', form.holes = defaultHoles">Other</a> -->
              <select class="form-control" @change="courseChanged()" v-model="form.course">
                <option value="" disabled>Select Course</option>
                <option v-for="val in courses" :value="val">{{val.name}}</option>
                <!-- <option value="Other">Other</option> -->
              </select>
              <input v-if="form.course.name === 'Other'" required type="text" style="margin-top:5px;" class="form-control" v-model="form.other_course" placeholder="Course Name..." />
            </div>
          </div>
          <!-- <div class="col-sm-12 col-md-6 float-left">
            <label class="inputLabel">Type Of Game</label>
            <select class="form-control" v-model="form.type_of_game">
              <option value="">Select Game</option>
              <option value="Best Ball">Best Ball</option>
              <option value="Match Play">Match Play</option>
              <option value="Match Play">Match Play</option>
              <option value="Scramble">Scramble</option>
              <option value="Stroke Play">Stroke Play</option>
            </select>
          </div> -->
          <div class="col-12 float-left text-center" style="margin-top:15px;">
            <table class="table">
              <thead>
                <tr>
                  <th>Hole</th>
                  <th>Par</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(val, key) in form.holes">
                  <td>
                    {{key}}
                  </td>
                  <td>
                    <input type="text" :disabled="form.course.name !== 'Other'" required class="form-control text-center" v-model="form.holes[key]" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 float-left" style="background-color:#f1f1f1;">
            <h4 class="card-title" style="margin-top:10px;">Teams</h4>
            <table class="table">
              <thead>
                <tr>
                  <th>Team Name</th>
                  <th>Players</th>
                  <th>Strokes Given</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(val, index) in form.teams">
                  <td>
                    <!-- <input type="text" required class="form-control text-center" v-model="val.team_name" /> -->
                    {{val.team_name}}
                  </td>
                  <td>
                    <div style="width:100%;float:left;" v-for="(player, i) in val.players">
                      <!-- <input type="text" required class="form-control text-center" v-model="val.players[i]" /> -->
                      {{val.players[i]}}
                    </div>
                    <!-- <div style="width:100%;float:left;" class="text-center">
                      <a class="btn-sm btn-info" @click="val.players.push('')">Add Player</a>
                    </div> -->
                  </td>
                  <td>
                    <!-- <input type="text" required class="form-control text-center" v-model="val.strokes_given" /> -->
                    {{val.strokes_given}}
                  </td>
                  <td class="text-center" style="line-height: 30px;">
                    <i class="fa fa-minus" v-if="form.teams.length > 1" style="color:red;" @click="removeTeam(index)"></i>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="text-center">
                    <a class="btn-sm btn-info" @click="addTeam()">Add Team!</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 float-left text-center" style="margin-top:15px;margin-bottom:15px;">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>

    <div id="teamModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="margin-left:auto;margin-right:auto;">
          <div class="modal-header">
            <h4 class="modal-title float-left">Add Team</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body" style="width:100%;">
            <div style="padding:5px;" class="col-sm-12 col-md-6 float-left">Team Name</div>
            <div style="padding:5px;" class="col-sm-12 col-md-6 float-left">
              <input type="text" class="form-control float-left" v-model="newTeam.team_name" />
            </div>

            <div style="padding:5px;" class="col-sm-12 col-md-6 float-left">Strokes Given</div>
            <div style="padding:5px;" class="col-sm-12 col-md-6 float-left">
              <input type="text" class="form-control float-left" v-model="newTeam.strokes_given" />
            </div>

            <div style="padding:5px;" class="col-sm-12 col-md-6 float-left">Players</div>
            <div style="padding:5px;" class="col-sm-12 col-md-6 float-left">
              <div style="width:100%;float:left;" v-for="(val, index) in newTeam.players">
                <input type="text" class="form-control float-left" placeholder="First & Last Name.." v-model="newTeam.players[index]" />
              </div>
              <div style="width:100%;float:left;margin-top:10px;" class="text-center">
                <a class="btn-sm btn-info" @click="newTeam.players.push('')">Add Player</a>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="finalAdd()">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelPopup()">Cancel</button>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>
<script>
var methods = {}
import axios from 'axios'

methods.submitForm = function () {
  const postData = {
    form: this.form,
    holes: this.randomHoles
  }
  axios.post('/api/submitGolfMatch', postData).then(response => {
    if (response.status === 200 || response.status === 201) {
      console.log(response)
      this.$router.push('/match/' + response.data.id)
    }
  })
}

methods.finalAdd = function () {
  this.form.teams.push(this.newTeam)
  this.newTeam = {team_name: '', strokes_given: '', players: ['']}
}

methods.addTeam = function () {
  // this.form.teams.push({team_name: '', strokes_given: '', players: ['']})

  $('#teamModal').modal('show')
}

methods.removeTeam = function (index) {
  this.form.teams.splice(index, 1)
}

methods.cancelPopup = function () {
  // this.form.teams.pop()
  this.newTeam = {team_name: '', strokes_given: '', players: ['']}
}

methods.courseChanged = function () {
  // if (this.form.course.name === 'Other') {
  //   this.form.holes = this.defaultHoles
  // } else {
  //   this.form.holes = 
  // }
  this.form.holes = this.form.course.holes
}

methods.getCourses = function () {
  axios.get('/api/getCourses').then(response => {
    if (response.status === 200 || response.status === 201) {
      console.log(response)
      this.courses = response.data
      this.courses.sort(function (a, b) {
        if(a.name < b.name) { return -1; }
        if(a.name > b.name) { return 1; }
        return 0;
      })
      var obj = {
          name: 'Other',
          holes: {
            '1': '',
            '2': '',
            '3': '',
            '4': '',
            '5': '',
            '6': '',
            '7': '',
            '8': '',
            '9': '',
            '10': '',
            '11': '',
            '12': '',
            '13': '',
            '14': '',
            '15': '',
            '16': '',
            '17': '',
            '18': ''
          }
        }
        this.courses.push(obj)
        console.log(this.courses)
    }
  })
}

export default {
  name: "Entry",
  data: function() {
    return {
      form: {
        name: '',
        course: '',
        holes: {
          '1': '',
          '2': '',
          '3': '',
          '4': '',
          '5': '',
          '6': '',
          '7': '',
          '8': '',
          '9': '',
          '10': '',
          '11': '',
          '12': '',
          '13': '',
          '14': '',
          '15': '',
          '16': '',
          '17': '',
          '18': ''
        },
        other_course: '',
        teams: [
          // {team_name: '', strokes_given: '', players: ['']}
        ]
      },
      courses: [],
      newTeam: {team_name: '', strokes_given: '', players: ['']},
      otherCourse: false,
      sullivanHoles: {
        '1': '4',
        '2': '4',
        '3': '5',
        '4': '4',
        '5': '4',
        '6': '3',
        '7': '4',
        '8': '3',
        '9': '5',
        '10': '4',
        '11': '4',
        '12': '3',
        '13': '4',
        '14': '3',
        '15': '4',
        '16': '3',
        '17': '5',
        '18': '5'
      },
      defaultHoles: {
        '1': '',
        '2': '',
        '3': '',
        '4': '',
        '5': '',
        '6': '',
        '7': '',
        '8': '',
        '9': '',
        '10': '',
        '11': '',
        '12': '',
        '13': '',
        '14': '',
        '15': '',
        '16': '',
        '17': '',
        '18': ''
      },
      randomHoles: {
        '1': '',
        '2': '',
        '3': '',
        '4': '',
        '5': '',
        '6': '',
        '7': '',
        '8': '',
        '9': '',
        '10': '',
        '11': '',
        '12': '',
        '13': '',
        '14': '',
        '15': '',
        '16': '',
        '17': '',
        '18': ''
      }
    }
  },
  methods: methods,
  mounted: function() {
    this.getCourses()
  },
  destroyed: function() {

  }
}

</script>
