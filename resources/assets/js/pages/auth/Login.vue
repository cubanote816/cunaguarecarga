<template>
<v-app id="login" class="primary">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <img src="/static/m.png" alt="Vue Material Admin" width="120" height="120">
                  <h1 class="flex my-4 primary--text">Material Admin Template</h1>
                </div>                
                <v-form>
                  <v-text-field append-icon="person" name="login" label="Login" type="text" v-model="model.username"></v-text-field>
                  <v-text-field append-icon="lock" name="password" label="Password" id="password" type="password" v-model="model.password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn icon>
                  <v-icon color="blue">fa fa-facebook-square fa-lg</v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon color="red">fa fa-google fa-lg</v-icon>
                </v-btn>
                <v-btn icon>
                  <v-icon color="light-blue">fa fa-twitter fa-lg</v-icon>
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn block color="primary" @click="login" :loading="loading">Login</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  
  <div class="container">
    <h3>Login</h3>
    <hr>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Login</div>
          <div class="panel-body">

            <div class="alert alert-danger" v-if="error">
              {{ error }}
            </div>

            <form id="login_form" class="form-horizontal" role="form" @submit.prevent="onSubmit">

              <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" v-model.trim="form.email" required autofocus>
                  <div class="help-block" v-if="errors.email">
                    <div v-for="error in errors.email"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group" :class="{ 'has-error': errors.password }">
                <label for="password" class="col-md-4 control-label">Password</label>
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" v-model.trim="form.password" required>
                  <div class="help-block" v-if="errors.password">
                    <div v-for="error in errors.password"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </v-app>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {

    data () {
      return {
        form: {
          email: Laravel.demoMode ? 'admin@gmail.com' : '',
          password: Laravel.demoMode ? '123456' : '',
        },
        error: '',
        errors: {},
      }
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
      })
    },

    methods: {

      ...mapActions([
        'login',
        'addToastMessage',
      ]),

      onSubmit () {
        this.errors = {}
        this.login(this.form)
          .then(() => {
            this.addToastMessage({
              text: 'You logged in!',
              type: 'success'
            })
            this.$router.replace('/dashboard')
          })
          .catch((data) => {
            this.error = data.message
            this.errors = data.errors || {}
          })
      },

    }
  }
</script>
<style scoped lang="css">
  #login {
    height: 50%;
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    content: "";
    z-index: 0;
  }
</style>
