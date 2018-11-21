<template>
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
          <v-list-tile-title active-class="active">
            {{item.text}}
          </v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>


  </v-navigation-drawer>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      drawer: null,
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
    methods: {
      handleClick (e) {
        e.preventDefault()
      }
    }
  }
</script>
