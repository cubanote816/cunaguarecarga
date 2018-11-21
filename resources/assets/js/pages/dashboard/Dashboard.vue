<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <span class="text-xs-left" v-if="me.role != 'admin'">Acuerdo por: {{price}}</span>
        <span class="text-xs-left" v-if="me.role = 'admin'">Balance: {{balance}} {{me.role}}</span>
      </v-flex>
</v-layout>
</v-container>
</template>
<script>
  import { mapState } from 'vuex'
  export default {
    name: 'cunagua-dashboard',
    data () {
      return {
        price: null,
        balance: null
      }
    },
    mounted () {
      this.balance = 1000
      this.price = this.me.agreement[0].agreement
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
      }),
    },
  }
</script>
