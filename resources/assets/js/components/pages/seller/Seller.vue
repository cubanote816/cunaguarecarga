<template>
    <div class="container" id="reseller">
        <h3>Revendedores</h3>
        <div class="row">
            <div class="col-xs-12">
            <button>Addicionar vendedor</button>
            <router-link :to="'/seller/detail/2'">Detalles</router-link>

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
                    <!--<div v-for="(user, index) in sellers">-->
                        <div class="col-xs-12" v-for="(user, index) in sellers">
                            <div class="col-xs-4">
                                <router-link :to="'/manager/user/' + user.hired.id">{{ user.hired.name }}</router-link>
                            </div>
                            <div class="col-xs-5">{{ user.hired.email }}</div>
                            <div class="col-xs-1">{{ user.hired.active === 0 ? 'false' : 'true'}}</div>
                            <div class="col-xs-1">{{ user.agreement }}</div>
                            <div class="col-xs-1">
                                action
                            </div>
                        </div>
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapState, mapActions } from 'vuex'
  export default {
    name: 'seller',
    data () {
      return {}
    },
    mounted () {
      this.getSellers()
    },
    computed: {
      ...mapState({
        sellers: state => state.seller.sellers,
      })
    },
    methods: {

      ...mapActions([
        'getSellers',
      ]),
    }
  }
</script>

<style scoped>

</style>
