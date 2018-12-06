<template>
<<<<<<< HEAD
  <v-card>
    <v-card-title>
      Vendedores
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="desserts"
      :search="search"
      :pagination.sync="pagination"
      :total-items="totalDesserts"
      :loading="loading"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.id }}</td>
        <td class="text-xs-right">{{ props.item.hired.name }}</td>
        <td class="text-xs-right">{{ props.item.hired.email }}</td>
        <td class="text-xs-right">{{ props.item.hired.active }}</td>
        <td class="text-xs-right">{{ props.item.agreement }}</td>
      </template>
    </v-data-table>
  </v-card>
=======
  <v-layout row wrap>
    <v-flex xs12>
        <h3 class="flex text-xs-left primary--text">Vendedores</h3>
      </v-flex>
      <v-flex xs12 text-xs-right>
        <router-link :to="'/register'" active-class="active"><v-btn success>Addicionar vendedor</v-btn></router-link>
      </v-flex>
      <v-flex xs4 offset-sm8 text-xs-right>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
        ></v-text-field>
      </v-flex>
    <v-flex xs12>
      <v-data-table
        :headers="headers"
        :items="sellers_list"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td class="text-xs-left">{{ props.item.id }}</td>
          <td class="text-xs-left">{{ props.item.hired.name }}</td>
          <td class="text-xs-left">{{ props.item.hired.email }}</td>
          <td class="text-xs-center">{{ props.item.hired.active }}</td>
          <td class="text-xs-center">{{ props.item.agreement }}</td>
          <td class="text-xs-center">
            <router-link :to="'/seller/detail/' + props.item.hired.id"><a>Ver detalles</a></router-link>
          </td>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
          Su busqueda por "{{ search }}" no ha encntrado coincidencia.
        </v-alert>
      </v-data-table>
    </v-flex>
  </v-layout>  
>>>>>>> Sellers page, Login virification user status, reset password page
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  export default {
    data () {
      return {
<<<<<<< HEAD
        totalDesserts: 0,
        desserts: [],
        loading: true,
        pagination: {},
=======
>>>>>>> Sellers page, Login virification user status, reset password page
        search: '',
        headers: [
          {
            text: 'id',
            align: 'left',
            sortable: false,
            value: 'id'
          },
<<<<<<< HEAD
          { text: 'Nombre', value: 'name' },
          { text: 'Email', value: 'email' },
          { text: 'Activo', value: 'active' },
          { text: 'Acuerdo', value: 'agreement' }
        ]
      }
    },
    watch: {
      pagination: {
        handler () {
          this.getDataFromApi()
            .then(data => {
              this.desserts = data.items
              this.totalDesserts = data.total
            })
        },
        deep: true
      }
    },
    mounted () {
      this.getDataFromApi()
        .then(data => {
          this.desserts = data.items
          this.totalDesserts = data.total
        })
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        sellers: state => state.seller.sellers,
      })
    },
    methods: {
      ...mapActions([
        'sellersList',
      ]),
      getDataFromApi () {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page, rowsPerPage } = this.pagination

          let items = this.sellers
          const total = items.length

          if (this.pagination.sortBy) {
            items = items.sort((a, b) => {
              const sortA = a[sortBy]
              const sortB = b[sortBy]

              if (descending) {
                if (sortA < sortB) return 1
                if (sortA > sortB) return - 1
                return 0
              } else {
                if (sortA < sortB) return - 1
                if (sortA > sortB) return 1
                return 0
              }
            })
          }

          if (rowsPerPage > 0) {
            items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
          }

          setTimeout(() => {
            this.loading = false
            resolve({
              items,
              total
            })
          }, 1000)
        })
      },
      getDesserts () {
        this.sellersList()
      }
=======
          { text: 'Nombre', value: 'hired.name' },
          { text: 'Email', value: 'hired.email' },
          { text: 'Activo', value: 'hired.active' },
          { text: 'Acuerdo', value: 'agreement' },
          { text: '', value: '', sortable: false }
        ],
      }
    },
    mounted () {
      this.loadSeller()
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        sellers_list: state => state.seller.sellers_list,
      })
    },

    methods: {
      ...mapActions([
        'loadSeller',
      ]),
>>>>>>> Sellers page, Login virification user status, reset password page
    }
  }
</script>
