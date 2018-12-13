<template>
    <v-layout row wrap>
      <v-flex xs12>
        <h3 class="flex text-xs-left primary--text">Historial</h3>
      </v-flex>
        <v-flex xs6 md3>
            <v-text-field
                    append-icon="search"
                    label="Buscar"
                    single-line
                    hide-details
                    @input="filterSearch"
            ></v-text-field>
        </v-flex>
        <v-flex xs6 md3>
            <v-select
                    :items="sellers_list"
          item-text="hired.name"
                    label="Vendedor"
                    @change="filterAuthor"
            ></v-select>
        </v-flex>

        <v-flex xs6 md3>

            <v-menu
                    ref="show_start_date"
                    :close-on-content-click="false"
                    v-model="show_start_date"
                    :nudge-right="40"
                    :return-value.sync="startDate"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
            >
                <v-text-field
                        slot="activator"
                        v-model="startDate"
                        label="Desde"
<<<<<<< HEAD

=======
>>>>>>> Sellers page, Login virification user status, reset password page
                        prepend-icon="event"
                        readonly
                ></v-text-field>
                <v-date-picker
                        v-model="startDate"
                        @input="filterStartDate"
                ></v-date-picker>

            </v-menu>

        </v-flex>

        <v-flex xs6 md3>
            <v-menu
                    ref="show_end_date"
                    :close-on-content-click="false"
                    v-model="show_end_date"
                    :nudge-right="40"
                    :return-value.sync="end_date"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
            >
                <v-text-field
                        slot="activator"
                        v-model="end_date"
                        label="Hasta"
<<<<<<< HEAD

=======
>>>>>>> Sellers page, Login virification user status, reset password page
                        prepend-icon="event"
                        readonly
                ></v-text-field>
                <v-date-picker
                        v-model="end_date"
                        @input="filterEndDate"
                ></v-date-picker>

            </v-menu>
        </v-flex>

        <v-flex xs12>


            <v-data-table
                    :headers="headers"
          :items="history.data"
          :search="filters"
          :custom-filter="customFilter"
          :pagination.sync="pagination"
          :loading="loading"
          class="elevation-1"
            >
                <template slot="headers" slot-scope="props">
                    <tr>
                        <th
                                v-for="header in props.headers"
                                :key="header.text"
                                :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                @click="changeSort(header.value)"
                        >
                            <v-icon small>arrow_upward</v-icon>
                            {{ header.text }}
                        </th>
                    </tr>
                </template>
                <template slot="items" slot-scope="props">
                    <tr>
                        <td class="text-xs-left">{{ props.item.phone }}</td>
                        <td class="text-xs-center">
                          <v-chip v-if="props.item.status === 'pending'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Pendiente</v-chip>
                          <v-chip v-if="props.item.status === 'deny'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Denegado</v-chip>
                          <v-chip v-if="props.item.status === 'complete'" label small :color="getColorByStatus(props.item.status)" text-color="white" >Completado</v-chip>
                        </td>
                        <td class="text-xs-center hidden-sm-and-down">{{ props.item.type }}</td>
                        <td class="text-xs-center">{{ props.item.soldBy }}</td>
                        <td class="text-xs-right">{{ props.item.createdAt  | formatDate }}</td>
                    </tr>
                </template>
                <template slot="pageText" slot-scope="props">
            Pagina {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }} 
          </template>
            </v-data-table>
        </v-flex>

    </v-layout>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  export default {
    data: () => ({
      show_start_date: false,
      startDate: null,

      show_end_date: false,
      end_date: null,

      filters: {
        search: '',
        soldBy: '',
        startDate: null,
        end_date: null,
      },
<<<<<<< HEAD

=======
>>>>>>> dashboard fixes and fixes general
      pagination: {
        sortBy: 'phone'
      },
      selected: [],
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
          text: 'Vendido por',
          value: 'soldBy',
          align: 'center',
        },
        {
          text: 'Realizada a',
          align: 'center',
          value: 'createdAt'
        },
      ],
      loading: false,
      colors: {
        pending: 'blue',
        deny: 'red',
        complete: 'green'
      }
    }),
    mounted () {
      this.loading = true
      this.loadHistory()
        .then(result => {
          this.loading = false
        })
      this.loadSeller()
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        sellers_list: state => state.seller.sellers_list,
        history: state => state.report.history,
      }),
    },
    methods: {
      ...mapActions([
        // 'sellersList',
        'loadSeller',
        'loadHistory',
      ]),
      getColorByStatus (status) {
        return this.colors[status]
      },
      customFilter (items, filters, filter, headers) {
        // Init the filter class.
        const cf = new this.$MultiFilters(items, filters, filter, headers)

        // Use regular function(),
        // arrow functions does not allow context binding.
        // Register the global standard filter.
        cf.registerFilter('search', function (searchWord, items) {
          if (searchWord.trim() === '') return items

          return items.filter(item => {
            return item.phone.toLowerCase().includes(searchWord.toLowerCase())
          }, searchWord)
        })


        // Use regular function(),
        // arrow functions does not allow context binding.
        // Register "soldBy" filter.
        cf.registerFilter('soldBy', function (soldBy, items) {
          // If the filter has not been applied yet
          // just return all available items.
          if (soldBy.trim() === '') return items

          // Compare each item soldBy and just return the matching ones.
          return items.filter(item => {
            return item.soldBy.toLowerCase() === soldBy.toLowerCase()
          }, soldBy)
        })

        // Use regular function(),
        // arrow functions does not allow context binding.
        // Register "startDate" filter.
        cf.registerFilter('startDate', function (startDate, items) {
          // If the filter has not been applied yet
          // just return all available items.
          if (startDate === null) return items

          // Compare each item startDate and just return the matching ones.
          return items.filter(item => {
            return item.createdAt >= startDate
          }, startDate)
        })

        // Use regular function(),
        // arrow functions does not allow context binding.
        // Register "end_date" filter.
        cf.registerFilter('end_date', function (endDate, items) {
          // If the filter has not been applied yet
          // just return all available items.
          if (endDate === null) return items

          // Compare each item end_date and just return the matching ones.
          return items.filter(item => {
            return item.createdAt <= endDate
          }, endDate)
        })

        // Its time to run all created filters.
        // Will be executed in the order thay were defined.
        return cf.runFilters()
      },


      /**
       * Toggle selected items with the master checkbox.
       */
      toggleAll () {
        if (this.selected.length) {
          this.selected = []
        } else {
          this.selected = this.rows.slice()
        }
      },

      /**
       * Column shorting.
       *
       * @param column
       */
      changeSort (column) {
        if (this.pagination.sortBy === column) {
          this.pagination.descending = ! this.pagination.descending
        } else {
          this.pagination.sortBy = column
          this.pagination.descending = false
        }
      },

      /**
       * Handler when user input something at the "Filter" text field.
       */
      filterSearch (val) {
        this.filters = this.$MultiFilters.updateFilters(this.filters, {search: val})
      },

      /**
       * Handler when user  select some author at the "Author" select.
       */
      filterAuthor (val) {
        this.filters = this.$MultiFilters.updateFilters(this.filters, {soldBy: val})
      },

      /**
       * Handler when select a date on "From" date picker.
       */
      filterStartDate (val) {
        // Close the date picker.
        this.$refs.show_start_date.save(val)

        // Convert the value to a timestamp before saving it.
        // const timestamp = new Date(val + 'T00:00:00Z').getTime()
        this.filters = this.$MultiFilters.updateFilters(this.filters, {startDate: val})
      },

      /**
       * Handler when select a date on "To" date picker.
       */
      filterEndDate (val) {
        // Close the date picker.
        this.$refs.show_end_date.save(val)

        // Convert the value to a timestamp before saving it.
        // const timestamp = new Date(val).toLocaleDateString('es-ES')
        // const timestamp = new Date(val + 'T00:00:00Z').getTime()
        this.filters = this.$MultiFilters.updateFilters(this.filters, {end_date: val})
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
      }
    }


  }
</script>
