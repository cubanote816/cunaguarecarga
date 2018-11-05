<template>
  <div class="container">
    <h3>Registration</h3>
    <hr>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Registration</div>
          <div class="panel-body">
            <form class="form-horizontal" id="register_form" role="form" @submit.prevent="onSubmit">

              <div class="form-group" :class="{ 'has-error': errors.email }">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" v-model="form.email" required>
                  <div class="help-block" v-if="errors.email">
                    <div v-for="error in errors.email"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group" :class="{ 'has-error': errors.agreement }">
                <label for="agreement" class="col-md-4 control-label">Agreement</label>

                <div class="col-md-6">
                  <input id="agreement" type="input" class="form-control" v-model="form.agreement" required>
                  <div class="help-block" v-if="errors.agreement">
                    <div v-for="error in errors.agreement"><strong>{{ error }}</strong></div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Register
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {

    data () {
      return {
        form: {
          email: '',
          agreement: '',
        },
        errors: {}
      }
    },

    methods: {

      ...mapActions([
        'register',
        'addToastMessage',
      ]),

      onSubmit () {
        this.errors = {}
        this.register(this.form)
          .then(() => {
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
