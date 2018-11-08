<template>
  <nav class="navbar navbar-default navbar-fixed-top nav-style">
    <div class="container">
      <div class="navbar-header">

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <!-- Branding Image -->
        <router-link class="navbar-brand" to="/">Cunagua Recarga</router-link>
      </div>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
          &nbsp;
        </ul>


        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right" v-if="me">
          <!-- Authentication Links -->
          <router-link tag="li" to="/dashboard" active-class="active"><a>Dashboad</a></router-link>
          <router-link tag="li" to="/order" active-class="active"><a>Ordenar</a></router-link>
          <router-link tag="li" to="/reports" active-class="active"><a>Reportes</a></router-link>
          <router-link tag="li" v-if="me.role != 'seller'" to="/seller" active-class="active"><a>Vendedores</a></router-link>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              {{ me.name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
              <router-link tag="li" to="/profile" active-class="active"><a>Profile</a></router-link>
              <router-link tag="li" to="/logout" active-class="active"><a>Logout</a></router-link>
            </ul>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->

      </div>
    </div>
  </nav>
</template>

<script>
  import { mapState } from 'vuex'

  export default {

    data () {
      return {}
    },

    mounted () {
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        route: state => state.route,
      })
    },

    watch: {
      route () {
        this.$forceUpdate() // Tempopary fix for wrong router navigation after login
      }
    },

    methods: {
    },
  }
</script>
<style scoped>
.nav-style {
-webkit-transition: none;
    transition: none;
    -webkit-box-shadow: 0px 2px 4px -1px rgba(0,0,0,0.2), 0px 4px 5px 0px rgba(0,0,0,0.14), 0px 1px 10px 0px rgba(0,0,0,0.12);
    box-shadow: 0px 2px 4px -1px rgba(0,0,0,0.2), 0px 4px 5px 0px rgba(0,0,0,0.14), 0px 1px 10px 0px rgba(0,0,0,0.12);
    width: 100%;
    will-change: padding-left, padding-right;
    background-color: #3f51b5 !important;
border-color: #3f51b5 !important;
}
.navbar-brand {
    color: #fff !important;
}
.navbar-nav > li > a {
    color: #fff !important;
    background-color: transparent;

}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: #000 !important;
background-color: transparent !important;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
background-color: transparent;

    color: #000 !important;
}
.dropdown-menu {
    background-color: #3f51b5;
}
.dropdown-menu > li > a {
    color: #fff;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
    background-color: transparent;
    color: #fff;
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
    color: #000 !important;
    background-color: transparent;
}
.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
    text-decoration: none;
    color: #262626 !important;
    background-color: transparent;
}
</style>
