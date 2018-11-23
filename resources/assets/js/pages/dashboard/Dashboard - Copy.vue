<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm6 md3 v-if="me.role == 'admin'">
        <card-balance :balance="balance" />
      </v-flex>

      <v-flex xs12 sm6 md3 v-if="me.role !== 'seller'">
        <card-sales :last30Days="sales_last_30_days.last30Days" :last30DaysSum="sales_last_30_days.last30DaysSum" />
      </v-flex>
      <v-flex xs12 sm6 md6 v-else>
        <card-sales :last30Days="sales_last_30_days.last30Days" :last30DaysSum="sales_last_30_days.last30DaysSum" />
      </v-flex>

      

      <v-flex xs12 sm6 md3 v-if="me.role !== 'seller'">
        <card-seller :sellerCount="countSellers"/>
        
      </v-flex>
      <v-flex xs12 sm6 md3 v-if="me.role !== 'seller'">
        <card-contract :agreement="agreement"/>
      </v-flex>
      <v-flex xs12 sm6 md6 v-else>
        <card-contract :agreement="agreement"/>
      </v-flex>
    <v-flex xs12 sm4>
      <dashboard-doughnut :data="status"></dashboard-doughnut>
    </v-flex>
    <v-flex xs12 sm8>
      <v-subheader>
              Ultimas 20 recargas 
            </v-subheader>
      <table-20last-sales :data="last20_sales.data" />
    </v-flex>

    </v-layout>
  </v-container>
</template>

<script>
  import Table20lastSales from './tables/Table20lastSales'
  import CardBalance from './cards/CardBalance'
  import CardSales from './cards/CardSales'
  import CardSeller from './cards/CardSeller'
  import CardContract from './cards/CardContract'
  import DashboardBar from './charts/DashboardBar'
  import DashboardDoughnut from './charts/DashboardDoughnut'
  import { mapActions, mapState, mapGetters } from 'vuex'

  export default {

    components: {
      CardBalance,
      CardSales,
      CardSeller,
      CardContract,
      Table20lastSales,
      DashboardBar,
      DashboardDoughnut

    },

    data () {
      return {
        errors: {},
        balance: 0,
        agreement: 0.0000,
        last30Days: 0.0000,
        last30DaysSum: 0,
        mySellers: 0,
        salesStatus: [],
      }
    },

    mounted () {
      if (this.me.role === 'admin') {
        this.agreement = 18
        this.balance = 1000
      } else {
        this.agreement = this.me.agreement.agreement
      }
      this.salesLast30Days()
      this.loadSeller()
      this.loadSalesStatus()
      this.loadLast20Sales()
    },

    created () {

    },

    computed: {
      ...mapGetters([
        'countSellers'
      ]),
      ...mapState({
        me: state => state.auth.me,
        sellers_list: state => state.seller.sellers_list,
        sales_last_30_days: state => state.general.sales_last_30_days,
        last20_sales: state => state.report.last20_sales,
        sales_status: state => state.report.sales_status,
        status: state => state.report.status,
      }),

      // sellerCount () {
      //   return this.$store.state.seller.sellers_list.length
      // },
    },

    methods: {
      ...mapActions([
        'loadSeller',
        'salesLast30Days',
        'loadLast20Sales',
        'loadSalesStatus',
      ]),
    }

  }
</script>

<style scoped>

</style>
