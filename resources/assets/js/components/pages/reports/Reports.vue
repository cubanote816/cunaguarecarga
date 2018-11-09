<template>
  <div class="container" id="reports">
  <div class="col-sm-2">
    <ul class="nav nav-pills nav-stacked">
      <router-link tag="li" to="#" active-class="active"><a>Vendedores</a></router-link>

      </router-link>
    </ul>
  </div>
  <div class="col-sm-10">
    <h3>Reportes</h3>

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
        <div class="col-sm-6 text-right">
          <span class="page-info">Page {{reports.reports.current_page }} of  {{ reports.reports.last_page }}</span>
        </div>
      </div>

    </div>

<hr>
    <div class="col-xs-12">
      <div class="col-xs-4">Telefono</div>
      <div class="col-xs-2">Credito</div>
      <div class="col-xs-2">A pagar</div>
      <div class="col-xs-4">Fecha</div>
    </div>
    <div class="col-xs-12" v-for="sale in reports.reports.data">
      <div class="col-xs-4">{{sale.phone}}</div>
      <div class="col-xs-2">{{sale.type}}</div>
      <div class="col-xs-2">{{sale.cost}}</div>
      <div class="col-xs-4">{{sale.created_at}}</div>
    </div>
    <div>A pagar: {{reports.total_pay}}</div>


    <div class="text-right" v-if="reports.reports.last_page > 1">
      <ul class="pagination marginpulltop15">
        <li v-for="page in range(1, reports.reports.last_page)" :key="page" :class="{active: page == reports.reports.current_page}">
          <a href="#" @click.prevent="onLoadReport(page)">{{ page }}</a>
        </li>
      </ul>
    </div>

    </div>
  </div>
</template>

<script>
  import { mapActions, mapState } from 'vuex'

  export default {

    data () {
      return {
        dateFrom: null,
        dateTo: null,
      }
    },

    mounted () {
      this.reportsList(this.params)
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        reports: state => state.report.reports,
      }),

      params () {
        return {
          page: this.reports.current_page,
          dateFrom: this.dateFrom,
          dateTo: this.dateTo,
        }
      },
    },

    methods: {
      ...mapActions([
        'reportsList',
      ]),

      onLoadReport (page) {
        this.reportsList({...this.params, page})
      },

      onFilter () {
        this.reportsList({...this.params, page: 1})
      },

      onFilterClear () {
        this.dateFrom = null
        this.dateTo = null
        this.reportsList(this.params)
      },
    }
  }
</script>
