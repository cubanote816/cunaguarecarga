<template>
        <v-data-table
          :headers="headers"
          :items="$props.data"
          :pagination.sync="pagination"
          :loading="loading"
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
            <td class="text-xs-left">{{ props.item.name }}</td>
            <td class="text-xs-center">{{ props.item.email }}</td>
            <td class="text-xs-center hidden-sm-and-down">{{ props.item.cost }}</td>
          </template>
          <template slot="pageText" slot-scope="props">
            Pagina {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }} 
          </template>
        </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      pagination: {
        sortBy: 'phone'
      },
      selected: [],
      headers: [
        {
          text: 'Nombre',
          align: 'left',
          value: 'name'
        },
        {
          text: 'Correo',
          align: 'center',
          value: 'email'
        },
        {
          text: 'A pagar o cobrar',
          align: 'left',
          value: 'cost'
        },
      ],
      loading: false
    }),
    props: {
      data: {
        type: Array,
        required: true
      }
    },
    filters: {
      /**
       * Format a timestamp into a d/m/yyy (because spanish format).
       *
       * @param value
       * @returns {string}
       */
      formatDate: function (value) {
        if (! value) return ''
        return new Date(value).toLocaleDateString('es-ES')
      }
    }
  }
</script>
<style lang="scss">

</style>
