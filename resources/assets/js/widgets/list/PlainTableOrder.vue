<template>
  <v-card>
    <v-toolbar card dense color="transparent">
      <v-toolbar-title><h4>Order</h4></v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>more_vert</v-icon>
      </v-btn>      
    </v-toolbar>
    <v-divider></v-divider>
    <v-card-text class="pa-0">
      <template>
        <v-data-table
          :headers="headers"
          :items="reports.data"
          :search="search"
          :pagination.sync="pagination"
          hide-actions
          class="elevation-0 table-striped"
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
            <td>{{ props.item.id }}</td>
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-left">{{ props.item.type }}</td>
            <td class="text-xs-left">{{ props.item.cost }}</td>
            <td class="text-xs-left">{{ props.item.created_at }}</td>
          </template>
        </v-data-table>
        <div class="text-xs-center pt-2">
          <v-pagination v-model="pagination.page" :length="pages"></v-pagination>
        </div>
      </template>
      <v-divider></v-divider>
    </v-card-text>
  </v-card>
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
          text: '#',
          align: 'left',
          sortable: false,
          value: 'id'
        },
        { text: 'Telefono', value: 'phone' },
        { text: 'Credito depositado', value: 'type' },
        { text: 'Costo', value: 'cost' },
        { text: 'Creado a', value: 'created_at' },
      ],
      colors: {
        processing: 'blue',
        sent: 'red',
        delivered: 'green'
      },
    }
  },
  mounted () {
    this.reportsList()
  },
  computed: {
    ...mapState({
      me: state => state.auth.me,
      reports: state => state.report.reports,
    }),
    randomColor () {
      let item = Math.floor(Math.random() * this.colors.length)
      return this.colors[item]
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
      'reportsList',
    ]),
    getColorByStatus (status) {
      return this.colors[status]
    },
  }
}
</script>
