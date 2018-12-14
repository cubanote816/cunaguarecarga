<template>
  <v-container grid-list-md text-xs-center>
        <table-report></table-report>
  </v-container>
</template>

<script>
  import TableReport from '../../widgets/list/TableReport'
  export default {
    components: {
      TableReport,
    },
  }
</script>
