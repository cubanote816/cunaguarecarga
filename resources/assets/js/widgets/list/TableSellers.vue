<template>
  <v-layout row wrap>
    <v-flex xs12>
        <h3 class="flex text-xs-left primary--text">Vendedores</h3>
      </v-flex>
    <v-toolbar flat color="white">
      <v-toolbar-title class="xs12 sm4">
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Buscar"
        single-line
        hide-details
      ></v-text-field>
    </v-toolbar-title>
      <v-divider
        class="mx-2 hidden-xs-and-down"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <v-btn slot="activator" color="primary" dark class="mb-2">Addicionar vendedor</v-btn>
        <v-card>
          <form @submit.prevent="save" id="register-form">

          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md4 v-if="formTitle === 'Nuevo Vendedor'">
                  <v-text-field
                    v-model="form.email"
                    :error-messages="emailErrors"
                    label="E-mail"
                    focus
                    @input="$v.form.email.$touch()"
                    @blur="$v.form.email.$touch()"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md4>
                  <v-text-field
                    v-model="form.agreement"
                    :error-messages="agreementErrors"
                    label="Contrato"
                    @input="$v.form.agreement.$touch()"
                    @blur="$v.form.agreement.$touch()"
                  ></v-text-field>
              
                </v-flex>
                <v-flex xs12 sm6 md4 v-if="formTitle === 'Nuevo Vendedor'">
                  <v-select
                    v-model="form.role"
                    :items="roleItems"
                    item-text="text"
                    item-value="value"
                    :error-messages="roleErrors"
                    label="Tipo de vendedor"
                    required
                    @change="$v.form.role.$touch()"
                    @blur="$v.form.role.$touch()"
                  ></v-select>
                </v-flex>
                <v-flex xs12 sm6 md4 v-if="formTitle === 'Editar Vendedor' && form.role === 'seller'">
                  <v-select
                    v-model="form.role"
                    :items="roleItems"
                    item-text="text"
                    item-value="value"
                    :error-messages="roleErrors"
                    label="Tipo de vendedor"
                    required
                    @change="$v.form.role.$touch()"
                    @blur="$v.form.role.$touch()"
                  ></v-select>
                </v-flex>
                
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="blue darken-1" flat @click.native="close">Cancel</v-btn>
            <v-btn color="blue darken-1" flat :disabled="$v.$invalid" type="submit" form="register-form">Guardar</v-btn>

          </v-card-actions>
          </form>

        </v-card>
      </v-dialog>
    </v-toolbar>
    
      <v-flex xs12>
        <v-data-table
          :headers="headers"
          :items="sellers.data"
          :search="search"
          :pagination.sync="pagination"
          :loading="loading"
          class="elevation-1"
        >
          <template slot="headerCell" slot-scope="props">
            <v-tooltip bottom>
              <span slot="activator">
                {{ props.header.text }}
              </span>
              <span>
                {{ props.header.text }}
              </span>
            </v-tooltip>
          </template>
          <template slot="items" slot-scope="props">
            <td class="text-xs-left" style="width: 25%;">{{ props.item.name }}</td>
        <td class="text-xs-left hidden-sm-and-down" style="width: 25%;">{{ props.item.email }}</td>
        <td class="text-xs-center" style="width: 10%;">
          <toggle-button
            :value="props.item.active"
            :sync="true"
            :labels="{checked: 'Activo', unchecked: 'Inactivo'}"
            :key="i"
            :width="70"
            @change="updateItemValue(props.item.id, $event.value)"/>
       </td>
        <td class="text-xs-center hidden-sm-and-down" style="width: 10%;">{{ props.item.role }}</td>
        <td class="text-xs-center" style="width: 10%;">{{ props.item.agreement }}</td>
        <td class="justify-center layout px-0">
          <v-btn @click="viewItem(props.item.id)" flat icon color="primary">
                  <v-icon>mdi-eye</v-icon>
                </v-btn>
          <v-btn @click="editItem(props.item)" flat icon color="success">
                  <v-icon>mdi-square-edit-outline</v-icon>
                </v-btn>
          <v-btn @click="onDelete(props.item, props.item.id, props.item.name)" flat icon color="red">
                  <v-icon>mdi-delete-empty</v-icon>
                </v-btn>
        </td>
          </template>
          <template slot="pageText" slot-scope="props">
            Pagina {{ props.pageStart }} - {{ props.pageStop }} de {{ props.itemsLength }} 
          </template>
        </v-data-table>
  </v-flex>
  </v-layout>

</template>

<script>
  import { validationMixin } from 'vuelidate'
  import { required, email, decimal } from 'vuelidate/lib/validators'
  import Toggle from '../../components/toggle'
  import { mapActions, mapState } from 'vuex'
  export default {
    mixins: [validationMixin],
    validations: {
      form: {
        email: { required, email },
        role: { required },
        agreement: { required, decimal },
      }
    },
    components: {
      Toggle,
    },
    data: () => ({
      dialog: false,
      search: '',
      pagination: {},
      loading: false,
      selected: [],
      headers: [
        { text: 'Nombre', value: 'hired.name' },
        { text: 'Email', value: 'hired.email', class: 'hidden-sm-and-down' },
        { text: 'Estado', value: 'hired.status', align: 'center' },
        { text: 'Tipo de vendedor', value: 'role', align: 'center', class: 'hidden-sm-and-down' },
        { text: 'Acuerdo', value: 'agreement', align: 'center' },
        { text: '', value: 'name', sortable: false }
      ],
      editedIndex: - 1,
      form: {
        email: '',
        agreement: '',
        role: null,
        active: null
      },
      roleItems: [],
      defaultItem: {
        email: '',
        agreement: '',
        role: null,
      },
      toggled: false,
    }),

    mounted () {
      switch (this.me.role) {
        case 'admin': {
          this.roleItems = [{ text: 'Administrador', value: 'manager' }, { text: 'Vendedor', value: 'seller' }]
          break
        }
        case 'manager': {
          this.roleItems = [{ text: 'Revendedor', value: 'reseller' }, { text: 'Vendedor', value: 'seller' }]
          break
        }
        case 'reseller': {
          this.roleItems = [{ text: 'Vendedor', value: 'seller' }]
          break
        }
        case 'seller': {
          this.roleItems = [{ text: 'Vendedor', value: 'seller' }]
          break
        }
      }
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
        sellers: state => state.seller.sellers,
        users: state => state.users.users,
        agreement: state => state.contract.agreement,
      }),
      formTitle () {
        return this.editedIndex === - 1 ? 'Nuevo Vendedor' : 'Editar Vendedor'
      },
      roleErrors () {
        const errors = []
        if (! this.$v.form.role.$dirty) return errors
        ! this.$v.form.role.required && errors.push('Tipo de usuario es requerido.')
        return errors
      },
      agreementErrors () {
        const errors = []
        if (! this.$v.form.agreement.$dirty) return errors
        ! this.$v.form.agreement.decimal && errors.push('Entre un numero valido.')
        ! this.$v.form.agreement.required && errors.push('Acuerdo requerido.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (! this.$v.form.email.$dirty) return errors
        ! this.$v.form.email.email && errors.push('Debe ser un e-mail valido.')
        ! this.$v.form.email.required && errors.push('E-mail es requerido.')
        return errors
      }
    },

    watch: {
      dialog (val) {
        val || this.close()
      }
    },

    created () {
      // this.initialize()
      this.loading = true
      this.sellersList()
        .then(result => {
          this.loading = false
        })
    },

    methods: {
      ...mapActions([
        'sellersList',
        'register',
        'deleteUser',
        'statusUser',
        'updateAgreement',
        'addToastMessage',
      ]),
      // updateItemValue (index) {
      //   this.items[index].value = ! this.items[index].value
      // },
      updateItemValue (id, active) {
        // this.items[index].value = ! this.items[index].value
        // alert(id + 'act = ' + active)
        this.loading = true
        // this.form.active = ! active
        this.statusUser({id, active: active})
          .then(() => {
            this.loading = false
            // this.form.active = null
          })
          .catch((data) => {
            this.errors = data.errors || {}
          })
      },

      viewItem (item) {
        this.$router.replace('/seller/detail/' + item)
      },

      editItem (item) {
        this.editedIndex = this.sellers.data.indexOf(item)
        this.form = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.sellers.data.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.sellers.data.splice(index, 1)
      },
      onDelete (item, id, name) {
        const index = this.sellers.data.indexOf(item)
        let inst = this
        this.$swal({
          title: 'Se borrara al vendedor ' + name + '.',
          text: 'Estas seguro?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, borralo!',
          cancelButtonText: 'No, cancelar!',
          buttonsStyling: true
        }).then(function (isConfirm) {
          if (isConfirm.value === true) {
            inst.loading = true
            inst.deleteUser(id).then(() => {
              inst.loading = false
              inst.sellers.data.splice(index, 1)
              inst.addToastMessage({
                text: 'Vendedor elimindo!',
                type: 'success'
              })
            })
          }
        })
      },
      close () {
        this.dialog = false
        setTimeout(() => {
          this.form = Object.assign({}, this.defaultItem)
          this.editedIndex = - 1
        }, 300)
      },

      save () {
        this.$v.$touch()
        // Object.assign(this.sellers.data[this.editedIndex], this.form) // no funciona dentro del metodo
        if (this.editedIndex > - 1) {
          this.loading = true
          if (this.$v.$invalid) {
            alert('Todos los campo deben ser validados')
          } else {
            this.errors = {}
            this.updateAgreement(this.form)
              .then(() => {
                // I need to check if the array is update after submit successfully
                this.loading = false
                this.addToastMessage({
                  text: 'El contracto fue modificado satisfactoriamente!',
                  type: 'success'
                })
              })
              .catch((data) => {
                this.errors = data.errors || {}
              })
          }
        } else {
          if (this.$v.$invalid) {
            alert('All fields are not valid')
          } else {
            this.errors = {}
            this.register(this.form)
              .then(() => {
                // I need to check if the array is update after submit successfully
                this.form.active = false
                this.sellers.data.push(this.form)
                this.form.email = null
                this.form.agreement = null
                this.form.role = null
                this.addToastMessage({
                  text: 'El vendedor fue creado, se le ha enviado un correo a ' + this.form.email + ' para su activacion!',
                  type: 'success'
                })
              })
              .catch((data) => {
                this.errors = data.errors || {}
              })
          }
          this.sellers.data.push(this.form)
        }

        this.close()
      },
    }
  }
</script>
<style lang="scss">
/*#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}*/

.padding {
  padding: 10px;
}

h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}

.vue-js-switch {
  margin: 2px;
}

.vue-js-switch#changed-font {
  font-size: 16px !important;
}
</style>
