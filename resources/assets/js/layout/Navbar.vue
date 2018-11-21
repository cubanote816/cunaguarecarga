<template>
  <div v-if="me">
  <v-navigation-drawer
    :clipped="$vuetify.breakpoint.lgAndUp"
    v-model="drawer"
    fixed
    app
  >
    <v-list dense>
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
        <span class="hidden-sm-and-down">Cunagua Recarga</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <span>{{me.name}} nuestro equipo de recarga te saluda!</span>
      <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
        <v-btn icon large flat slot="activator">
          <v-avatar size="30px">
            <img src="images/avatar//man_4.jpg" :alt="me.name"/>
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
          icon: 'account_circle',
          href: '/profile',
          title: 'Perfil',
        },
        {
          icon: 'fullscreen_exit',
          href: '/logout',
          title: 'Logout',
        }
      ],
      items: [
        { icon: 'contacts', text: 'Dashboard', href: '/dashboard' },
        { icon: 'history', text: 'Ordenes', href: '/order' },
        { icon: 'content_copy', text: 'Reportes', href: '/reports' },
        { icon: 'content_copy', text: 'Vendedores', href: '/seller' },
        { icon: 'settings', text: 'Perfil', href: '/profile' },
        { icon: 'chat_bubble', text: 'Log out', href: '/logout' },
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
  }
</script>
