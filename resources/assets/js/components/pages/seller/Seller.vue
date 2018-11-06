<template>
    <div class="container" id="seller">
        <div class="row">
            <div class="col-xs-12">
            <button>Addicionar vendedor</button>
            </div>
        </div>
        <div class="col-sm-6 text-right">
            <span class="page-info">Page {{ sellers.current_page }} of  {{ sellers.last_page }}</span>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-4">Nombre</div>
                <div class="col-xs-2">Email</div>
                <div class="col-xs-2">Contracto</div>
                <div class="col-xs-4"></div>
            </div>
            <div class="col-xs-12" v-for="saller in sellers">
                <router-link :to="'/seller/deatil/' + seller.id">{{ seller.name }}</router-link>
                <div class="col-xs-2">{{saller.email}}</div>
                <div class="col-xs-2">{{saller.agreement}}</div>
                <div class="col-xs-4">
                <router-link :to="'/seller/detail/' + seller.id">Ver Detalles</router-link>
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
    name: 'Seller',
    data () {
      return {}
    },
    mounted () {
      this.getSellers()
    },
    computed: {
      ...mapState({
        sellers: state => state.sellers.sellers,
      }),

      params () {
        return {
          page: this.sellers.current_page,
        }
      },
    },
    methods: {
      ...mapActions([
        'getSellers',
      ]),
      onLoadSellers (page) {
        this.getSellers({...this.params, page})
      },
    },
  }
</script>

<style scoped>

</style>
