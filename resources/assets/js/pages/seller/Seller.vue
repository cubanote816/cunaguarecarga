<template>
  <v-container grid-list-md text-xs-center>
    <table-sellers></table-sellers>
  </v-container>
</template>

<script>

  import TableSellers from '../../widgets/list/TableSellers'
  import { mapActions, mapState } from 'vuex'
  export default {
    components: {
      TableSellers,
    },

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
  }
</script>

<style scoped>

</style>
