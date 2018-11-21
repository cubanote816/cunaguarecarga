<template>
  <v-container grid-list-md>
    <v-layout row wrap align-center justify-center>
      <v-flex xs12>
        <h3 class="flex my-2 text-xs-left primary--text">Perfil</h3>
      </v-flex>

      <v-flex xs12 sm8>
        <v-card class="elevation-12">
          <form @submit.prevent="onSubmit" id="profile-form">
            <v-card-text>
              <v-text-field
                v-model="form.name"
                :error-messages="nameErrors"
                label="Nombre"
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
               <v-btn color="primary" type="submit" form="profile-form">Guardar</v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
  // import { validationMixin } from 'vuelidate'
  // import { required, sameAs, minLength, maxLength } from 'vuelidate/lib/validators'
  import { mapState, mapActions } from 'vuex'

  export default {
    // mixins: [validationMixin],

    data () {
      return {
        form: {
          name: '',
          password: null,
          repeatPassword: null
        },
        errors: {}
      }
    },
    // validations: {
    //   form: {
    //     name: { required, maxLength: maxLength(10) },
    //     password: { required, minLength: minLength(6) },
    //     repeatPassword: { sameAsPassword: sameAs('password') },
    //   }
    // },
    computed: {
      ...mapState({
        me: state => state.auth.me,
      }),
      // repeatPasswordErrors () {
      //   const errors = []
      //   if (! this.$v.form.repeatPassword.$dirty) return errors
      //   ! this.$v.form.repeatPassword.sameAsPassword && errors.push('Las contrasenas deben ser identicas.')
      //   return errors
      // },
      // nameErrors () {
      //   const errors = []
      //   if (! this.$v.form.name.$dirty) return errors
      //   ! this.$v.form.name.maxLength && errors.push('El nombre no debe tener mas de 10 caracteres.')
      //   ! this.$v.form.name.required && errors.push('El nombre es requerido.')
      //   return errors
      // },
      // passwordErrors () {
      //   const errors = []
      //   if (! this.$v.form.password.$dirty) return errors
      //   ! this.$v.form.password.minLength && errors.push('Su contrasena no debe ser menor de 6 caractares.')
      //   ! this.$v.form.password.required && errors.push('Las contrasena es requerida.')
      //   return errors
      // },
    },

    mounted () {
      this.form.name = this.me.name
    },

    methods: {

      ...mapActions([
        'updateProfile',
        'addToastMessage',
      ]),

      onSubmit () {
        // this.$v.$touch()
        this.errors = {}
        this.updateProfile({id: this.me.id, form: this.form})
          .then(() => {
            this.addToastMessage({
              text: 'Your profile was updated!',
              type: 'success'
            })
          })
          .catch((data) => {
            this.errors = data.errors || {}
          })
      },

    }

  }
</script>
