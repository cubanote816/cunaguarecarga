<template>
  <v-container grid-list-md text-xs-center>
  	<table-history></table-history>
  </v-container>
</template>

<script>
  import TableHistory from '../../widgets/list/TableHistory'
  export default {
    components: {
      TableHistory,
    },
  }
</script>
