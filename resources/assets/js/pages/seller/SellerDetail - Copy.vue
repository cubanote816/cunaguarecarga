<template>
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex xs12>
        <v-flex xs12 sm6 offset-sm3>
          <div class="grey--text text-xs-center">{{ user.name }}</div><br>
          <div class="grey--text text-xs-center">{{ user.email }}</div><br>
        </v-flex>
      </v-flex>
      <v-flex xs12 sm3 offset-sm3>
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
      <v-flex xs12 sm3>
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
          :items="seller_detail"
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
              <strong>Total a pagar: </strong>{{seller_detail_pay}}
            </td>
            <td class="text-xs-left">
              <strong>Total de recarga: </strong>{{seller_detail.length}}
            </td>
            <td></td>
            <td></td>
            <td></td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>



<script>
  import { mapActions, mapState } from 'vuex'

  export default {
    name: 'Seller',
    data () {
      return {
        dateFrom: '',
        dateTo: '',
        pagination: {},
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
        date: new Date().toISOString().substr(0, 10),
        dateFromMenu: false,
        dateToMenu: false,
        itemsSales: null
      }
    },
    mounted () {
      this.getSellerDetail(this.params)
      this.loadUser(this.id)
      this.itemsSales = this.seller_detail.length
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        user: state => state.users.user,
        seller_detail: state => state.seller.seller_detail,
        seller_detail_pay: state => state.seller.seller_detail_pay,
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
      pages () {
        if (this.pagination.rowsPerPage == null ||
          this.pagination.totalItems == null
        ) return 0

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      }
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
        this.dateFrom = null
        this.dateTo = null
        this.getSellerDetail(this.params)
      },
    },
  }
</script>

<style scoped>

</style>
