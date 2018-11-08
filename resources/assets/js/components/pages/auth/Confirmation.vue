<template>
  <div class="container">
    <h3>Finalizar registro</h3>
    <hr>

    <form class="form-horizontal" role="form" @submit.prevent="onSubmit">

      <div class="form-group" :class="{ 'has-error': errors.name }">
        <label for="name" class="col-md-4 control-label">Name</label>
        <div class="col-md-6">
          <input id="name" type="text" class="form-control" v-model="form.name" required autofocus>
          <div class="help-block" v-if="errors.name">
            <div v-for="error in errors.name"><strong>{{ error }}</strong></div>
          </div>
        </div>
      </div>

      <div class="form-group" :class="{ 'has-error': errors.password }">
        <label for="password" class="col-md-4 control-label">Password</label>

        <div class="col-md-6">
          <input id="password" type="password" class="form-control" v-model="form.password">
          <div class="help-block" v-if="errors.password">
            <div v-for="error in errors.password"><strong>{{ error }}</strong></div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
        <div class="col-md-6">
          <input id="password-confirm" type="password" class="form-control" v-model="form.password_confirmation">
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <button type="submit" class="btn btn-primary">
            Submit
          </button>
        </div>
      </div>
    </form>

  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {

    data () {
      return {
        test: '',
        form: {
          name: '',
          password: '',
          password_confirmation: '',
        },
        errors: {}
      }
    },

    computed: {
      ...mapState({
        member: state => state.auth.member,
      }),

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
      },

    }

  }
</script>
