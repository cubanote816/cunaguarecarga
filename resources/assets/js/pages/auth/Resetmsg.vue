<template>
  <v-app id="login" class="primary">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
              <v-card-text>
                <div class="layout column align-center">
                  <h1 class="flex my-4 primary--text">Cunagua Recarga</h1>
                </div>                
                <v-form ref="form" lazy-validation @submit.prevent="onSubmit" id="reset-form">
                  <v-text-field append-icon="email" name="email" label="Correo" type="text" v-model="form.email"></v-text-field>
                                   
                  <v-flex xs4>
                    <v-btn color="primary"  type="submit" form="reset-form">Resetear Contrasenna</v-btn>
                  </v-flex>
                </v-form>
              </v-card-text>
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
          email: '',
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
        'reset',
        'addToastMessage',
      ]),

      onSubmit () {
        this.loading = true
        this.errors = {}
        this.reset(this.form)
          .then(() => {
            this.addToastMessage({
              text: 'Revise su correo para completar el cambio de contrasenna!',
              type: 'success'
            })
            this.$router.replace('/resetmsg')
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
