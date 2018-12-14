<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12 sm6 md3 v-if="me.role == 'admin'">
        <card-balance :balance="balance" />
      </v-flex>

      <v-flex xs12 sm6 md3 v-if="me.role !== 'seller'">
        <card-sales :last30Days="salesTotal" :last30DaysSum="salesUnitTotal" />
      </v-flex>
      <v-flex xs12 sm6 md6 v-else>
        <card-sales :last30Days="salesTotal" :last30DaysSum="salesUnitTotal" />
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
    <v-flex xs12 sm4 v-if="status !== null">
      <dashboard-doughnut :chart-data="datasetsfull"></dashboard-doughnut>
    </v-flex>
    <v-flex xs12 sm8>
      <v-subheader>
              Ultimas 20 recargas 
            </v-subheader>
      <table-20last-sales :data="last20_sales.data" />
    </v-flex>

      </v-flex>

    <v-flex xs12></v-flex>
    <v-flex lg3 sm12 xs12 v-for="(item,index) in complete" :key="'c-complete'+index">
          <circle-statistic
            :title="item.subheading"
            :sub-title="item.headline"
            :caption="item.caption"
            :icon="item.icon.label"
            :color="item.linear.color"
            :value="total_sale.totalComplete ? total_sale.totalComplete : 0"
          >
          </circle-statistic>            
        </v-flex>
    <v-flex lg3 sm12 xs12 v-for="(item,index) in pending" :key="'c-pending'+index">
          <circle-statistic
            :title="item.subheading"
            :sub-title="item.headline"
            :caption="item.caption"
            :icon="item.icon.label"
            :color="item.linear.color"
            percent="total_sale.totalPercentSales"
            :value="total_sale.totalPending ? total_sale.totalPending : 0"
          >
          </circle-statistic>            
        </v-flex>
        <v-flex lg3 sm12 xs12 v-for="(item,index) in deny" :key="'c-deny'+index">
          <circle-statistic
            :title="item.subheading"
            :sub-title="item.headline"
            :caption="item.caption"
            :icon="item.icon.label"
            :color="item.linear.color"
            :value="total_sale.totalDeny ? total_sale.totalDeny : 0"
          >
          </circle-statistic>            
        </v-flex>
        <v-flex lg3 sm12 xs12 v-for="(item,index) in total" :key="'c-total'+index">
          <circle-statistic
            :title="item.subheading"
            :sub-title="item.headline"
            :caption="item.caption"
            :icon="item.icon.label"
            :color="item.linear.color"
            percent=100
            :value="total_sale.totalSales ? total_sale.totalSales : 0"
          >
          </circle-statistic>            
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
      this.loadSellerNumber()
      this.loadSalesStatus()
      this.loadLast20Sales()
      console.log(this.status)
    },

    created () {
    },

    computed: {
      salesTotal () {
        this.last30Days = this.salesTotalSeller.last30Days
        return this.last30Days
      },
      salesUnitTotal () {
        this.last30DaysSum = this.salesTotalSeller.last30DaysSum
        return this.last30DaysSum
      },
      datasetsfull () {
        return {
          labels: ['Completadas', 'Pendientes', 'Denegadas'],
          datasets: [
            {
              height: 250,
              data: this.status,
              backgroundColor: [
                'green',
                'orange',
                'red'
              ],
              hoverBackgroundColor: [
                '#036103',
                '#c17f05',
                '#bb0000'
              ]
            }
          ],
        }
      },
      ...mapGetters([
        'countSellers',
        'status',
        'salesTotalSeller',
      ]),
      ...mapState({
        me: state => state.auth.me,
        sellers_list: state => state.seller.sellers_list,
        sellers_number: state => state.seller.sellers_number,
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
        'loadSellerNumber',
        'salesLast30Days',
        'loadLast20Sales',
        'loadSalesStatus',
      ]),
    }

  }
</script>

<style scoped>

</style>
