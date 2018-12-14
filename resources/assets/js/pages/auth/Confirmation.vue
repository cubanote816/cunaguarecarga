<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>

      <v-flex xs12 sm8 md4>
        <div class="layout column align-center col-xs-12">
          <h1 class="flex my-4 primary--text">Cunagua Recarga</h1>
        </div> 
        <v-card class="elevation-12">
          <v-toolbar dark color="primary">
            <v-toolbar-title>Finalizar registro</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
        <form @submit.prevent="onSubmit" id="finish-register-form">
          <v-card-text>
            <v-text-field
              v-model="form.name"
              :error-messages="nameErrors"
              :counter="10"
              label="Name"
              required
              @input="$v.form.name.$touch()"
              @blur="$v.form.name.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="form.password"
              :error-messages="passwordErrors"
              label="Contrasena"
              type="password"
              required
              @input="$v.form.password.$touch()"
              @blur="$v.form.password.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="form.repeatPassword"
              :error-messages="repeatPasswordErrors"
              label="Repetir contrasena"
              type="password"
              required
              @change="$v.form.repeatPassword.$touch()"
              @blur="$v.form.repeatPassword.$touch()"
            ></v-text-field>
             </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
               <v-btn color="primary" :disabled="$v.$invalid" type="submit" form="finish-register-form">Guardar</v-btn>
            </v-card-actions>

        </form>
      </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  import { validationMixin } from 'vuelidate'
  import { required, alphaNum, sameAs, minLength, maxLength } from 'vuelidate/lib/validators'
  import { mapState, mapActions } from 'vuex'
  export default {
    mixins: [validationMixin],

    data: () => ({
      form: {
        name: '',
        password: '',
        repeatPassword: ''
      }
    }),
    validations: {
      form: {
        name: { required, alphaNum: alphaNum, maxLength: maxLength(10) },
        password: { required,
          minLength: minLength(8),
          goodPassword: (password) => { // a custom validator!
            return /[a-z]/.test(password) &&
            /[A-Z]/.test(password) &&
            /[0-9]/.test(password)
          }
        },
        repeatPassword: { sameAsPassword: sameAs('password') },
      }
    },
    computed: {
      ...mapState({
        member: state => state.auth.member,
      }),
      nameErrors () {
        const errors = []
        if (! this.$v.form.name.$dirty) return errors
        ! this.$v.form.name.maxLength && errors.push('El nombre no debe tener mas de 10 caracteres.')
        ! this.$v.form.name.required && errors.push('El nombre es requerido.')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (! this.$v.form.password.$dirty) return errors
        ! this.$v.form.password.minLength && errors.push('Su contrasena no debe ser menor de 8 caractares.')
        ! this.$v.form.password.required && errors.push('Las contrasena es requerida.')
        ! this.$v.form.password.goodPassword && errors.push('Las contrasena debe conter numero, mayusculas y minusculas.')
        return errors
      },
      repeatPasswordErrors () {
        const errors = []
        if (! this.$v.form.repeatPassword.$dirty) return errors
        ! this.$v.form.repeatPassword.sameAsPassword && errors.push('Las contrasenas deben ser identicas.')
        return errors
      },
      activationToken () {
        return this.$route.params.id
      },
    },

    mounted () {
      this.loadNewMember(this.activationToken)
    },

    methods: {
      ...mapActions([
        'loadNewMember',
        'finishConfirmation',
        'addToastMessage',
      ]),

      onSubmit () {
        this.$v.$touch()
        if (this.$v.$invalid) {
          alert('All fields are not valid')
        } else {
          this.errors = {}
          this.finishConfirmation({id: this.activationToken, form: this.form})
            .then(() => {
              this.$router.replace('/dashboard')
              this.addToastMessage({
                text: 'Su usuario ha sido activado!',
                type: 'success'
              })
            })
            .catch((data) => {
              this.errors = data.errors || {}
            })
        }
      }
    }
  }
</script>


<style scoped>

</style>
