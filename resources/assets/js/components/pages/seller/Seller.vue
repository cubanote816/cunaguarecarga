<template>
    <div class="container" id="reseller">
        <h3>Revendedores</h3>
        <div class="row">
            <div class="col-xs-12">
            <router-link :to="'/register'" active-class="active"><a class="btn btn-primary">Addicionar vendedor</a></router-link>


            </div>
        </div>
        <hr>
        <div class="row">
            <div class="panel panel-default">
                <div class="table table-bordered row">
                    <div class="col-xs-12">
                        <div class="col-xs-4">Nombre</div>
                        <div class="col-xs-5">Email</div>
                        <div class="col-xs-1">Activos</div>
                        <div class="col-xs-1">Acuerdo</div>
                        <div class="col-xs-1"></div>
                    </div>
                    <div class="col-xs-12" v-for="seller in sellers.sellers">
                        <div class="col-xs-4">{{seller.hired.name}}</div>
                        <div class="col-xs-5">{{seller.hired.email}}</div>
                        <div class="col-xs-1">{{seller.agreement}}</div>
                        <div class="col-xs-1">Ver detalles</div>
                        <div class="col-xs-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {

  data () {
    return {
      dateFrom: null,
      dateTo: null
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
        dateFrom: this.dateFrom,
        dateTo: this.dateTo,
      }
    },
  },

  methods: {
    ...mapActions([
      'sellersList',
    ]),

    onLoadReport (page) {
      this.sellersList({...this.params, page})
    },

    onFilter () {
      this.sellersList({...this.params, page: 1})
    },

    onFilterClear () {
      this.dateFrom = null
      this.dateTo = null
      this.sellersList(this.params)
    },
  }
}
</script>

<style scoped>

</style>
