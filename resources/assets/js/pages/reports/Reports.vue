<template>
  <v-container grid-list-md text-xs-center>
        <table-report></table-report>
  </v-container>
</template>

<script>
  import TableReport from '../../widgets/list/TableReport'
  import { mapActions, mapState } from 'vuex'
  export default {
    components: {
      TableReport,
    },
    created () {
      this.reportsList()
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        reports: state => state.report.reports,
        reports_detail: state => state.report.reports_detail,
      }),
    },
    methods: {
      ...mapActions([
        'reportsList',
      ]),
    }
  }
</script>
