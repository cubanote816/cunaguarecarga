<template>
  <v-layout row wrap>
    <v-flex xs12>
        <h3 class="flex text-xs-left primary--text">Vendedores</h3>
      </v-flex>
      <v-flex xs12 text-xs-right>
        <router-link :to="'/register'" active-class="active"><v-btn primary>Addicionar vendedor</v-btn></router-link>
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
        :items="sellers"
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
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  export default {
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'id',
            align: 'left',
            sortable: false,
            value: 'id'
          },
          { text: 'Nombre', value: 'hired.name' },
          { text: 'Email', value: 'hired.email' },
          { text: 'Activo', value: 'hired.active' },
          { text: 'Acuerdo', value: 'agreement' },
          { text: '', value: '', sortable: false }
        ],
      }
    },
    mounted () {
      this.sellersList()
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
    }
  }
</script>
