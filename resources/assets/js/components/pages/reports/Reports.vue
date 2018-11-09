<template>
  <div class="container" id="reports">
    <h3>Front page</h3>
    <hr>
    <p>Reportes</p>
    <pre>{{reports}}</pre>
    <div v-for="report in reports">
      <div>{{report.phone}}</div>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapState } from 'vuex'

  export default {

    data () {
      return {}
    },

    mounted () {
      this.reportsList()
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        reports: state => state.report.reports,
      })
    },

    methods: {
      ...mapActions([
        'reportsList',
      ]),
    }
  }
</script>
