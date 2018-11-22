<template>
  <v-layout row wrap>
      <v-flex xs12>
<<<<<<< HEAD
        <h3 class="flex text-xs-left primary--text">Reportes{{payTotal}}</h3>
      </v-flex>
      <v-flex xs12 sm4 md3 v-if="me.role !== 'seller'">
        <v-select
            v-model="seller"
            :items="sellers_list"
            item-text="name"
            item-value="id"
=======
        <h3 class="flex text-xs-left primary--text">Reportes</h3>
      </v-flex>
      <v-flex xs12 sm6 md3>
        <v-select
            v-model="seller"
            :items="sellers_list.hired"
            item-text="name"
            item-value="user_id"
>>>>>>> reports
            label="Vendedor"
          ></v-select>
      </v-flex>
      <v-spacer></v-spacer>
<<<<<<< HEAD
      <v-flex xs12 sm2 md3>
=======
      <v-flex xs12 sm4 md3>
>>>>>>> reports
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
<<<<<<< HEAD
      <v-flex xs12 sm2 md3>
=======
      <v-flex xs12 sm4 md3>
>>>>>>> reports
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
<<<<<<< HEAD
      <v-flex text-xs-right>
        <v-btn @click="onFilter" color="primary">Buscar</v-btn>
      </v-flex>
      <v-flex text-xs-right>
        <v-btn @click="onFilterClear" color="error">Reset</v-btn>
=======
      <v-flex>
        <v-btn @click="onFilter">Buscar</v-btn>
      </v-flex>
      <v-flex>
        <v-btn @click="onFilterClear">Reset</v-btn>
>>>>>>> reports
      </v-flex>
      
      <v-spacer></v-spacer>
      <v-flex xs12>
        <v-data-table
          :headers="headers"
<<<<<<< HEAD
          :items="reports.data"
          :search="search"
          :loading="loading"
          :pagination.sync="pagination"
          prev-icon="mdi-menu-left"
    next-icon="mdi-menu-right"
    sort-icon="mdi-menu-down"
=======
          :items="reports"
          :search="search"
          :pagination.sync="pagination"
>>>>>>> reports
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
<<<<<<< HEAD
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-center">
                <v-chip v-if="props.item.status === 'pending'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Pendiente</v-chip>
                <v-chip v-if="props.item.status === 'deny'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Denegado</v-chip>
                <v-chip v-if="props.item.status === 'complete'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Completado</v-chip>
            </td>
            <td class="text-xs-center">{{ props.item.type }}</td>
            <td class="text-xs-center hidden-sm-and-down">{{ props.item.cost }}</td>
            <td class="text-xs-right">{{ props.item.createdAt }}</td>
=======
            <td class="text-xs-left">{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-left">{{ props.item.type }}</td>
            <td class="text-xs-left">{{ props.item.cost }}</td>
            <td class="text-xs-left">{{ props.item.created_at }}</td>
>>>>>>> reports
          </template>
          <template slot="pageText" slot-scope="props">
            Pagina {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }} 
          </template>
          <template slot="footer">
<<<<<<< HEAD
            <tr>
            <td class="text-xs-left" colspan="100%">
              <strong>Total a pagar: </strong>{{reports_detail}} <strong>Total de recarga: </strong>{{reports.data.length}}
            </td>
          </tr>
=======
            <td class="text-xs-left">
              <strong>Total a pagar: </strong>{{reports_detail}}
            </td>
            <td class="text-xs-left">
              <strong>Total de recarga: </strong>{{reports.length}}
            </td>
            <td></td>
            <td></td>
            <td></td>
>>>>>>> reports
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
<<<<<<< HEAD
          { text: 'Teléfono', value: 'phone', align: 'left' },
          { text: 'Estado', value: 'status', align: 'center' },
          { text: 'Credito depositado', value: 'type', align: 'center', class: 'hidden-sm-and-down' },
          { text: 'Costo', value: 'cost', align: 'center' },
          { text: 'Creado a', value: 'created_at', align: 'right' },
=======
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
>>>>>>> reports
        ],
        dateFrom: null,
        dateTo: null,
        seller: null,
        date: new Date().toISOString().substr(0, 10),
        dateFromMenu: false,
        dateToMenu: false,
<<<<<<< HEAD
        itemsSales: null,
        loading: false,
        colors: {
          pending: 'blue',
          deny: 'red',
          complete: 'green'
        },
        toPay: 0.0000
      }
    },
    mounted () {
      this.loading = true
      this.reportsList(this.params)
        .then(result => {
          this.loading = false
        })
      this.loadSeller()
      // this.sellersList()
      this.toPay = this.reports_detail
      this.itemsSales = this.reports.data.length
=======
        itemsSales: null
      }
    },
    mounted () {
      this.reportsList(this.params)
      this.loadSeller()
      // this.sellersList()
      this.itemsSales = this.reports.length
>>>>>>> reports
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        reports: state => state.report.reports,
        // sellers: state => state.seller.sellers,
        sellers_list: state => state.seller.sellers_list,
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
<<<<<<< HEAD
      },
      payTotal () {
        this.toPay = this.reports_detail.last30Days
        return this.toPay
      },
=======
      }
>>>>>>> reports
    },
    methods: {
      ...mapActions([
        // 'sellersList',
        'loadSeller',
        'reportsList',
      ]),

<<<<<<< HEAD
      getColorByStatus (status) {
        return this.colors[status]
      },

=======
>>>>>>> reports
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
