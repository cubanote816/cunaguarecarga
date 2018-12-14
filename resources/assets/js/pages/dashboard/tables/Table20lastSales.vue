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
            <td class="text-xs-left">{{ props.item.phone }}</td>
            <td class="text-xs-center">
            <v-chip v-if="props.item.status === 'pending'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Pendiente</v-chip>
            <v-chip v-if="props.item.status === 'deny'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Denegado</v-chip>
            <v-chip v-if="props.item.status === 'complete'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Completado</v-chip>
            </td>
            <td class="text-xs-center hidden-sm-and-down">{{ props.item.type }}</td>
            <td class="text-xs-right">{{ props.item.createdAt  | formatDate }}</td>
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
      headers: [
        {
          text: 'Teléfono',
          align: 'left',
          value: 'phone'
        },
        {
          text: 'Estado',
          align: 'center',
          value: 'status'
        },
        {
          text: 'Credito depositado',
          align: 'center',
          value: 'type',
          class: 'hidden-sm-and-down'
        },
        {
          text: 'Realizada a',
          align: 'right',
          value: 'createdAt'
        },
      ],
      loading: false,
      colors: {
        pending: 'orange',
        deny: 'red',
        complete: 'green'
      }
    }),

    props: {
      data: {
        required: true
      }
    },

    methods: {
      getColorByStatus (status) {
        return this.colors[status]
      },
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
      },
      capitalize: function (value) {
        if (! value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      }
    }
  }
</script>
<style lang="css">
  /*table.v-table thead th:not(:first-child) {
      padding: 0 10px;
  }*/
</style>
