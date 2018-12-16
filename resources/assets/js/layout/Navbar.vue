<template>
  <div v-if="me">
  <v-navigation-drawer
    :clipped="$vuetify.breakpoint.lgAndUp"
    v-model="drawer"
    fixed
    app
  >
    <v-list dense v-if="me.role != 'seller'">
      <v-list-tile v-for="item in items" :key="item.text" :to="item.href" active-class="active">
        <v-list-tile-action>
          <v-icon>{{item.icon}}</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>
            {{item.text}}
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
    <v-list dense v-else>
      <v-list-tile v-for="item in itemsSeller" :key="item.text" :to="item.href" active-class="active">
        <v-list-tile-action>
          <v-icon>{{item.icon}}</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>
            {{item.text}}
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>

  </v-navigation-drawer>
      <v-toolbar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      color="blue darken-3"
      dark
      app
      fixed
    >
      <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <span>Cunagua Recarga</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <span class="hidden-sm-and-down">{{ me.name | capitalize }} nuestro equipo le saluda!</span>
      <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
        <v-btn icon large flat slot="activator">
          <v-avatar 
            size="30px" 
            color="grey lighten-4"
          >
            <img src="images/avatar//avatar.png" :alt="me.name"/>
          </v-avatar>
        </v-btn>
        <v-list class="pa-0">
          <v-list-tile v-for="(item,index) in menuAvatar" :to="item.href" active-class="active" ripple="ripple"  rel="noopener" :key="index">
            <v-list-tile-action v-if="item.icon">
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.title }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>
  </div>
</template>

<script>
  import { mapState } from 'vuex'

  export default {

    data: () => ({
      dialog: false,
      drawer: null,
      menuAvatar: [
        {
          icon: 'mdi-account-circle',
          href: '/profile',
          title: 'Perfil',
        },
        {
          icon: 'mdi-logout',
          href: '/logout',
          title: 'Logout',
        }
      ],
      items: [
        { icon: 'mdi-view-dashboard', text: 'Dashboard', href: '/dashboard' },
        { icon: 'mdi-shopping', text: 'Ordenar', href: '/order' },
        { icon: 'mdi-history', text: 'Historial', href: '/history' },
        { icon: 'mdi-chart-line-variant', text: 'Reportes', href: '/reports' },
        { icon: 'mdi-account-group', text: 'Vendedores', href: '/seller' },
        { icon: 'mdi-account-settings', text: 'Perfil', href: '/profile' },
        { icon: 'mdi-logout', text: 'Log out', href: '/logout' },
      ],
      itemsSeller: [
        { icon: 'mdi-view-dashboard', text: 'Dashboard', href: '/dashboard' },
        { icon: 'mdi-shopping', text: 'Ordenes', href: '/order' },
        { icon: 'mdi-history', text: 'Historial', href: '/history' },
        { icon: 'mdi-chart-line-variant', text: 'Reportes', href: '/reports' },
        { icon: 'mdi-account-settings', text: 'Perfil', href: '/profile' },
        { icon: 'mdi-logout', text: 'Log out', href: '/logout' },
      ]
    }),
    props: {
      source: String
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
    filters: {
      capitalize: function (value) {
        if (! value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      }
    }
  }
</script>
