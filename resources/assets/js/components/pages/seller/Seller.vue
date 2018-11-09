<template>
    <div class="container" id="reseller">
        <h3>Revendedores</h3>
        <div class="row">
            <div class="col-xs-12">
            <router-link :to="'/register'" active-class="active"><a class="btn btn-primary">Addicionar vendedor</a></router-link>


            </div>
        </div>
        <hr>
        <div class="row marginbot10">
          <div class="col-sm-6 text-right">
            <span class="page-info">Page {{ sellers.current_page }} of {{ sellers.last_page }}</span>
          </div>
        </div>

            <div class="panel panel-default">
                <div class="table table-bordered row">
                    <div class="col-xs-12">
                        <div class="col-xs-4">Nombre</div>
                        <div class="col-xs-5">Email</div>
                        <div class="col-xs-1">Activos</div>
                        <div class="col-xs-1">Acuerdo</div>
                        <div class="col-xs-1"></div>
                    </div>
                    <div class="col-xs-12" v-for="seller in sellers.data">
                        <div class="col-xs-4">{{seller.hired.name}}</div>
                        <div class="col-xs-5">{{seller.hired.email}}</div>
                        <div class="col-xs-1">{{(seller.hired.active == 1) ? 'Activado' : 'Desactivado'}}</div>
                        <div class="col-xs-1">{{seller.agreement}}</div>
                        <div class="col-xs-1"></div>
                    </div>
                </div>
            </div>
            <div class="text-right" v-if="sellers.last_page > 1">
              <ul class="pagination marginpulltop15">
                <li v-for="page in range(1, sellers.last_page)" :key="page" :class="{active: page == sellers.current_page}">
                  <a href="#" @click.prevent="onLoadSellers(page)">{{ page }}</a>
                </li>
              </ul>
            </div>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {

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
