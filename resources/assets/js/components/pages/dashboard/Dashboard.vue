<template>
  <div class="container" id="dashboard">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">content_copy</i>
              </div>
              <p class="card-category">Balance</p>
              <h3 class="card-title">1000
                <small>$</small>
              </h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons text-danger">warning</i>
                <a href="#pablo">Get More Space...</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Facturado</p>
              <h3 class="card-title">$30000</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">info_outline</i>
              </div>
              <p class="card-category">Vendedores</p>
              <h3 class="card-title">75</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Tracked from Github
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="fa fa-twitter"></i>
              </div>
              <p class="card-category">Followers</p>
              <h3 class="card-title">+245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- mini statistic start -->
      <v-flex lg3 sm6 xs12>
        <mini-statistic
          icon="fa fa-facebook"
          title="100+"
          sub-title="Likes"
          color="indigo"
        >
        </mini-statistic>
      </v-flex>
      <v-flex lg3 sm6 xs12>
        <mini-statistic
          icon="fa fa-google"
          title="150+"
          sub-title="Connections"
          color="red"
        >
        </mini-statistic>
      </v-flex>
      <v-flex lg3 sm6 xs12>
        <mini-statistic
          icon="fa fa-twitter"
          title="200+"
          sub-title="Followers"
          color="light-blue"
        >
        </mini-statistic>
      </v-flex>
      <v-flex lg3 sm6 xs12>
        <mini-statistic
          icon="fa fa-instagramsss"
          title="53+"
          sub-title="Shots"
          color="purple"
        >
        </mini-statistic>
      </v-flex>
      <!-- mini statistic  end -->
    </div>
  </div>
  </div>
</template>

<script>
  import MiniStatistic from '../../widgets/statistic/MiniStatistic'
  import { mapState, mapActions } from 'vuex'

  export default {
    created () {
      this.getContractor()
    },
    components: {
      MiniStatistic,
    },

    data () {
      return {
        errors: {},
        form: {
        },
      }
    },

    mounted () {},

    computed: {
      ...mapState({
        me: state => state.auth.me,
        contractor: state => state.contract.contractor,
      }),
    },

    methods: {

      ...mapActions([
        'getContractor',
      ]),

    }
  }
</script>
