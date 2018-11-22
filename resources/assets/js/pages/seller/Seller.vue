<template>
  <v-container grid-list-md text-xs-center>
    <table-sellers></table-sellers>
  </v-container>
</template>

<script>
<<<<<<< HEAD
  import TableSellers from '../../widgets/list/TableSellers'
=======

  import TableSellers from '../../widgets/list/TableSellers'
  import { mapActions, mapState } from 'vuex'
>>>>>>> sellers and fix looking for by seller in reports
  export default {
    components: {
      TableSellers,
    },
<<<<<<< HEAD
=======

    data () {
      return {
        search: '',
      }
    },

    mounted () {
      this.sellersList(this.params)
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        sellers: state => state.seller.sellers,
      }),
      params () {
        return {
          page: this.sellers.current_page,
          query: this.search,
        }
      }

    },

    methods: {
      ...mapActions([
        'sellersList',
      ]),

      onLoadSellers (page) {
        this.sellersList({...this.params, page})
      },

      onSearch () {
        this.sellersList({...this.params, page: 1})
      },
    }
>>>>>>> sellers and fix looking for by seller in reports
  }
</script>

<style scoped>

</style>
