<template>
    <div class="container" id="seller">
        <div class="row">
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
                <div class="col-xs-12 text-center">
                    {{ user.name }}
                </div>
                <div class="col-xs-12 text-center">{{ user.email }}</div>
            </div>
            <div class="col-xs-4"></div>
        </div>
        <hr>
        <div class="row marginbot10">
            <div class="col-sm-6 filters">
                <div class="input-group">
                    <span class="input-group-addon">From:</span>
                    <input type="date" class="form-control date-filter" v-model="dateFrom" placeholder="Date from">
                    <span class="input-group-addon">To:</span>
                    <input type="date" class="form-control date-filter" v-model="dateTo" placeholder="Date to">
                    <span class="input-group-btn">
            <button class="btn btn-primary" @click="onFilter">Filter</button>
          </span>
                    <span class="input-group-btn">
            <button class="btn btn-default" @click="onFilterClear">Clear</button>
          </span>
                </div>
            </div>
            <div class="col-sm-6 text-right">
                <span class="page-info">Page {{ seller_detail.seller_detail.current_page }} of  {{ seller_detail.seller_detail.last_page }}</span>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-4">Telefono</div>
                <div class="col-xs-2">Credito</div>
                <div class="col-xs-2">A pagar</div>
                <div class="col-xs-4">Fecha</div>
            </div>
            <div class="col-xs-12" v-for="sale in seller_detail.seller_detail.data">
                <div class="col-xs-4">{{sale.phone}}</div>
                <div class="col-xs-2">{{sale.type}}</div>
                <div class="col-xs-2">{{sale.cost}}</div>
                <div class="col-xs-4">{{sale.created_at}}</div>
            </div>
        </div>

        <div>A pagar: {{seller_detail.total_pay}}</div>

        <div class="text-right" v-if="seller_detail.last_page > 1">
            <ul class="pagination marginpulltop15">
                <li v-for="page in range(1, seller_detail.seller_detail.last_page)" :key="page" :class="{active: page == seller_detail.seller_detail.current_page}">
                    <a href="#" @click.prevent="onLoadSales(page)">{{ page }}</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
  import { mapActions, mapState } from 'vuex'

  export default {
    name: 'Seller',
    data () {
      return {
        dateFrom: '',
        dateTo: '',
      }
    },
    mounted () {
      this.getSellerDetail(this.params)
      this.loadUser(this.id)
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        user: state => state.users.user,
        seller_detail: state => state.seller.seller_detail,
      }),
      id () {
        return this.$route.params.id
      },
      params () {
        return {
          id: this.$route.params.id,
          page: this.seller_detail.current_page,
          dateFrom: this.dateFrom,
          dateTo: this.dateTo,
        }
      },
    },
    methods: {
      ...mapActions([
        'getSellerDetail',
        'loadUser',
      ]),
      onLoadSales (page) {
        this.getSellerDetail({...this.params, page})
      },

      onFilter () {
        this.getSellerDetail({...this.params, page: 1})
      },

      onFilterClear () {
        this.dateFrom = ''
        this.dateTo = ''
        this.getSellerDetail(this.params)
      },
    },
  }
</script>

<style scoped>

</style>
