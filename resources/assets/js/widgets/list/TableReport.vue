<template>
  <v-layout row wrap>
      <v-flex xs12>
        <h3 class="flex text-xs-left primary--text">Reportes</h3>
      </v-flex>

      <v-flex xs12 sm6 md3>
        <v-select
            v-model="seller"
            :items="sellers.hired"
            item-text="name"
            item-value="id"
            label="Vendedor"
          ></v-select>
      </v-flex>
      <v-spacer></v-spacer>
      <v-flex xs12 sm4 md3>
        <v-menu
          :close-on-content-click="false"
          v-model="dateFromMenu"
          :nudge-right="40"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
        >
          <v-text-field
            slot="activator"
            v-model="dateFrom"
            label="Desde"
            prepend-icon="event"
            readonly
          ></v-text-field>
          <v-date-picker v-model="dateFrom" @input="dateFromMenu = false"></v-date-picker>
        </v-menu>
      </v-flex>
      <v-flex xs12 sm4 md3>
        <v-menu
          :close-on-content-click="false"
          v-model="dateToMenu"
          :nudge-right="40"
          lazy
          transition="scale-transition"
          offset-y
          full-width
          min-width="290px"
        >
          <v-text-field
            slot="activator"
            v-model="dateTo"
            label="Hasta"
            prepend-icon="event"
            readonly
          ></v-text-field>
          <v-date-picker v-model="dateTo" @input="dateToMenu = false"></v-date-picker>
        </v-menu>
      </v-flex>
      <v-spacer></v-spacer>
      <v-flex>
        <v-btn @click="onFilter">Buscar</v-btn>
      </v-flex>
      <v-flex>
        <v-btn @click="onFilterClear">Reset</v-btn>
      </v-flex>
      
      <v-spacer></v-spacer>
      <v-flex xs12>
        <v-data-table
          :headers="headers"
          :items="reports"
          :search="search"
          :pagination.sync="pagination"
          class="elevation-1"
        >
          <template slot="headerCell" slot-scope="props">
            <v-tooltip bottom>
              <span slot="activator">
                {{ props.header.text }}
              </span>
              <span>
                {{ props.header.text }}
              </span>
            </v-tooltip>
          </template>
          <template slot="items" slot-scope="props">
            <td class="text-xs-left">{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-left">{{ props.item.type }}</td>
            <td class="text-xs-left">{{ props.item.cost }}</td>
            <td class="text-xs-left">{{ props.item.created_at }}</td>
          </template>
          <template slot="pageText" slot-scope="props">
            Pagina {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }} 
          </template>
          <template slot="footer">
            <td class="text-xs-left">
              <strong>Total a pagar: </strong>{{reports_detail}}
            </td>
            <td class="text-xs-left">
              <strong>Total de recarga: </strong>{{reports.length}}
            </td>
            <td></td>
            <td></td>
            <td></td>
          </template>
        </v-data-table>
  </v-flex>
</v-layout>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  export default {
    data () {
      return {
        search: '',
        pagination: {},
        selected: [],
        headers: [
          {
            text: 'Id',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Telefono', value: 'phone' },
          { text: 'Credito depositado', value: 'type' },
          { text: 'Costo', value: 'cost' },
          { text: 'Creado a', value: 'created_at' },
        ],
        dateFrom: null,
        dateTo: null,
        seller: null,
        date: new Date().toISOString().substr(0, 10),
        dateFromMenu: false,
        dateToMenu: false,
        itemsSales: null
      }
    },
    mounted () {
      this.reportsList(this.params)
      this.sellersList()
      this.itemsSales = this.reports.length
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        reports: state => state.report.reports,
        sellers: state => state.seller.sellers,
        reports_detail: state => state.report.reports_detail,
      }),
      params () {
        return {
          dateFrom: this.dateFrom,
          dateTo: this.dateTo,
          seller: this.seller,
        }
      },
      pages () {
        if (this.pagination.rowsPerPage == null ||
          this.pagination.totalItems == null
        ) return 0

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      }
    },
    methods: {
      ...mapActions([
        'sellersList',
        'reportsList',
      ]),

      onLoadReport (page) {
        this.reportsList({...this.params})
      },

      onFilter () {
        this.reportsList({...this.params})
      },

      onFilterClear () {
        this.dateFrom = null
        this.dateTo = null
        this.seller = null
        this.reportsList(this.params)
      },
    }
  }
</script>
