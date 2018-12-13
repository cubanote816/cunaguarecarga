<template>
  <v-container grid-list-md>
    <v-layout row wrap>
<<<<<<< HEAD
<<<<<<< HEAD
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

=======
      <v-flex xs12 sm3 v-if="me.role == 'admin'">
        <v-card>
            <v-card-text class="pa-0">
              <v-container class="pa-0">
                <div class="layout row ma-0">
                  <div class="sm5 xs5 py-3 flex">
                    <div class="layout column ma-0 justify-center align-center bg-aqua">
                      <v-icon size="56px" color="indigo">mdi-square-inc-cash</v-icon>
                    </div>
                  </div>
                  <div class="sm7 xs7 flex text-sm-center py-3 ">
                    <div class="headline">1000</div>
                    <span class="caption">Balance</span>
                  </div>
                </div>
              </v-container>
            </v-card-text>
          </v-card>
=======
      <v-flex xs12 sm6 md3 v-if="me.role == 'admin'">
        <card-balance :balance="balance" />
>>>>>>> dashboard fixes and fixes general
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
<<<<<<< HEAD
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
>>>>>>> Dashborad fixed
=======
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

>>>>>>> dashboard fixes and fixes general
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
<<<<<<< HEAD

=======
>>>>>>> dashboard fixes and fixes general

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> dashboard fixes and fixes general
        balance: 0,
        agreement: 0.0000,
        last30Days: 0.0000,
        last30DaysSum: 0,
        mySellers: 0,
        salesStatus: [],
<<<<<<< HEAD
=======
        agreement: '',
        sales: '',
        complete: [],
        pending: [],
        deny: [],
        total: [],
>>>>>>> Dashborad fixed
=======
>>>>>>> dashboard fixes and fixes general
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> dashboard fixes and fixes general
      this.loadSeller()
      this.loadSellerNumber()
      this.loadSalesStatus()
      this.loadLast20Sales()
      console.log(this.status)
    },

    created () {
<<<<<<< HEAD
=======
      this.statisticSales({id: this.me.id})
      this.$set(this, 'total', [
        {
          subheading: 'Total',
          headline: '',
          caption: 'Recargas',
          percent: 100,
          icon: {
            label: 'mdi-shopify',
            color: 'success'
          },
          linear: {
            value: this.total_sale.totalSales,
            color: 'success'
          }
        }
      ])
      this.$set(this, 'complete', [
        {
          subheading: 'Completadas',
          headline: '',
          caption: 'Recargas',
          percent: 90,
          icon: {
            label: 'mdi-shopify',
            color: 'primary'
          },
          linear: {
            value: this.total_sale.totalSales,
            color: 'primary'
          }
        }
      ])
      this.$set(this, 'pending', [
        {
          subheading: 'Pendientes',
          headline: '',
          caption: 'Recargas',
          percent: 90,
          icon: {
            label: 'mdi-progress-check',
            color: 'primary'
          },
          linear: {
            value: this.total_sale.totalPending,
            color: 'warning'
          }
        }
      ])
      this.$set(this, 'deny', [
        {
          subheading: 'Denegadas',
          headline: '',
          caption: 'Recargas',
          percent: 90,
          icon: {
            label: 'mdi-block-helper',
            color: 'error'
          },
          linear: {
            value: this.total_sale.totalDeny,
            color: 'error'
          }
        }
      ])
      // this.$set(this, 'total', [
      //   {
      //     subheading: 'total modificafo'
      //   }
      // ])
      // this.sale = this.sales_last_30_days
>>>>>>> Dashborad fixed
=======

>>>>>>> dashboard fixes and fixes general
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
