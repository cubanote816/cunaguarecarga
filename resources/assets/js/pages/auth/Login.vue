<template>
  <v-app id="login" class="primary">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
              <v-form ref="form" lazy-validation @submit.prevent="onSubmit" id="login-form">
              <v-card-text>
                <div class="layout column align-center">
                  <h1 class="flex my-4 primary--text text-xs-center">Cunagua Recarga</h1>
                </div>                
                  <v-text-field append-icon="person" name="login" label="Login" type="text" v-model="form.email"></v-text-field>
                  <v-text-field append-icon="lock" name="password" label="Password" id="password" type="password" v-model="form.password"></v-text-field>
                  
              </v-card-text>
              <v-card-actions>
                <v-flex xs8 px-2>
                    <router-link :to="'/password/reset'" active-class="active"><a>Olvide la contrase&ntilde;a</a></router-link>
                </v-flex>
                <v-flex xs4 text-xs-right>
                  <v-btn color="primary" type="submit" form="login-form">Login</v-btn>
                </v-flex>
              </v-card-actions>
             </v-form>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>


<script>
  import { mapState, mapActions } from 'vuex'

  export default {

    data () {
      return {
        loading: false,
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
        total_sale: state => state.general.total_sale,
        sales_last_30_days: state => state.general.sales_last_30_days,
      })
    },

    methods: {

      ...mapActions([
        'login',
        'salesLast30Days',
        'statisticSales',
        'addToastMessage',
      ]),

      onSubmit () {
        this.loading = true
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
