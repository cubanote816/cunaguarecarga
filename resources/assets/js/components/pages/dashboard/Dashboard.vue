<template>
  <div class="container" id="dashboard">
    <h3>Dashboard</h3>
    <hr>


  </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {

    components: {
    },

    data () {
      return {
        errors: {},
        form: {
        },
      }
    },

    mounted () {
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
      }),
    },

    methods: {
      ...mapActions([
      ]),

    }
  }
</script>
