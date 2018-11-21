<template>
  <v-app id="inspire">

    <v-toolbar color="primary" fixed dark app>
    <v-toolbar-side-icon @click.native.stop="navigations.default.drawer = !navigations.default.drawer"></v-toolbar-side-icon>
    <v-toolbar-title>Title</v-toolbar-title>

    <v-spacer></v-spacer>
    <v-btn icon>
      <v-icon @click.native.stop="navigations.user.drawer = !navigations.user.drawer">more_vert</v-icon>
    </v-btn>
      
      <v-toolbar-items class="hidden-sm-and-down" v-if="me">
        <v-btn flat>
          <router-link tag="li" to="/dashboard" active-class="active"><a>Dashboad</a></router-link>
        </v-btn>
        <v-btn flat>
          <router-link tag="li" to="/order" active-class="active"><a>Ordenar</a></router-link>
          
        </v-btn>
        <v-btn flat>
          <router-link tag="li" to="/order" active-class="active"><a>Ordenar</a></router-link>
          <router-link tag="li" to="/reports" active-class="active"><a>Reportes</a></router-link>
          <router-link tag="li" v-if="me.role != 'seller'" to="/seller" active-class="active"><a>Vendedores</a></router-link>
        </v-btn>
      </v-toolbar-items>

       <v-menu offset-y origin="center center" :nudge-bottom="10" transition="scale-transition">
        <v-btn icon large flat slot="activator">
          <v-avatar size="30px">
            <img src="/static/avatar/man_4.jpg" alt="Michael Wang"/>
          </v-avatar>
        </v-btn>
        <v-list class="pa-0">
          <v-list-tile v-for="(item,index) in items" :to="!item.href ? { name: item.name } : null" :href="item.href" @click="item.click" ripple="ripple" :disabled="item.disabled" :target="item.target" rel="noopener" :key="index">
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
    
  </v-app>
</template>

<script>
  import Util from '../../util'
  // import { mapState } from 'vuex'

  export default {

    data () {
      return {
        items: [
          {
            icon: 'account_circle',
            href: '#',
            title: 'Profile',
            click: (e) => {
              console.log(e)
            }
          },
          {
            icon: 'settings',
            href: '#',
            title: 'Settings',
            click: (e) => {
              console.log(e)
            }
          },
          {
            icon: 'fullscreen_exit',
            href: '#',
            title: 'Logout',
            click: (e) => {
              window.getApp.$emit('APP_LOGOUT')
            }
          }
        ],
        drawer: null,
        navigations:
          {
            default: {
              drawer: false,
              position: null,
              avatar: false,
              items: [
                {title: 'Item title', icon: 'fas fa-home', url: '/'},
                {title: 'Item title', icon: 'fas fa-user-friends', url: '/item-url'},
                {title: 'Item title', icon: 'fas fa-atlas', url: '/item-url'},
                {title: 'Item title', icon: 'fas fa-archway', url: '/item-url'},
                {title: 'Item title', icon: 'fas fa-pencil-alt', url: '/item-url'}
              ]
            },
            user: {
              drawer: false,
              position: 'right',
              avatar: true,
              items: [
                {title: 'Item title', icon: 'dashboard', url: '/item-url'},
                {title: 'Item title', icon: 'fas fa-map-marked-alt', url: '/item-url'},
                {title: 'Item title', icon: 'fas fa-heart', url: '/item-url'},
                {title: 'Item title', icon: 'question_answer', url: '/item-url'}
              ]
            }
          }
      }
    },

    computed: {
      toolbarColor () {
        return this.$vuetify.options.extra.mainNav
      }
    },
    methods: {
      handleDrawerToggle () {
        window.getApp.$emit('APP_DRAWER_TOGGLED')
      },
      handleFullScreen () {
        Util.toggleFullScreen()
      },
      changeDrawerStatus (value) {
        this.drawer = value
      }
    }
  }
</script>
