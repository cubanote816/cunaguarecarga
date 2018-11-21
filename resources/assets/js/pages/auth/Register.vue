<template>
  <v-container grid-list-md>
    <v-layout row wrap align-center justify-center>
      <v-flex xs12>
        <h3 class="flex my-2 text-xs-left primary--text">Registrar vendedor</h3>
      </v-flex>

      <v-flex xs12 sm8>
        <v-card class="elevation-12">
          <form @submit.prevent="onSubmit" id="register-form">
            <v-card-text>
              <v-text-field
                v-model="form.email"
                :error-messages="emailErrors"
                label="E-mail"
                @input="$v.form.email.$touch()"
                @blur="$v.form.email.$touch()"
              ></v-text-field>
              <v-text-field
                v-model="form.agreement"
                :error-messages="agreementErrors"
                label="Contrato"
                @input="$v.form.agreement.$touch()"
                @blur="$v.form.agreement.$touch()"
              ></v-text-field>
              <v-select
                v-model="form.role"
                :items="roleItems"
                item-text="text"
                item-value="value"
                :error-messages="roleErrors"
                label="Tipo de vendedor"
                required
                @change="$v.form.role.$touch()"
                @blur="$v.form.role.$touch()"
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
               <v-btn color="primary" type="submit" form="register-form">Guardar</v-btn>
            </v-card-actions>
          </form>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
 
<script>
  // import { validationMixin } from 'vuelidate'
  // import { required, email, numeric } from 'vuelidate/lib/validators'
  import { mapActions, mapState } from 'vuex'

  export default {
    // mixins: [validationMixin],
    // validations: {
    //   form: {
    //     email: { required, email },
    //     role: { required },
    //     agreement: { required, numeric },
    //   }
    // },
    data () {
      return {
        form: {
          email: '',
          agreement: '',
          role: null,
        },
        roleItems: [{ text: 'Administrador', value: 'manager' }, { text: 'Vendedor', value: 'seller' }],

        errors: {}
      }
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
      }),
      // roleErrors () {
      //   const errors = []
      //   if (! this.$v.form.role.$dirty) return errors
      //   ! this.$v.form.role.required && errors.push('Tipo de usuario es requerido.')
      //   return errors
      // },
      // agreementErrors () {
      //   const errors = []
      //   if (! this.$v.form.agreement.$dirty) return errors
      //   ! this.$v.form.agreement.numeric && errors.push('Entre un numero valido.')
      //   ! this.$v.form.agreement.required && errors.push('Acuerdo requerido.')
      //   return errors
      // },
      // emailErrors () {
      //   const errors = []
      //   if (! this.$v.form.email.$dirty) return errors
      //   ! this.$v.form.email.email && errors.push('Debe ser un e-mail valido.')
      //   ! this.$v.form.email.required && errors.push('E-mail es requerido.')
      //   return errors
      // }
    },
    methods: {

      ...mapActions([
        'register',
        'addToastMessage',
      ]),

      onSubmit () {
        // this.$v.$touch()
        this.errors = {}
        this.register(this.form)
          .then(() => {
            this.form.email = ''
            this.form.agreement = ''
            this.form.role = ''
            this.addToastMessage({
              text: 'El vendedor fue creado, se le ha enviado un correo a ' + this.form.email + ' para su activacion!',
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
