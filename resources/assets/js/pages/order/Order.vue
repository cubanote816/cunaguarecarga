<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex xs12>
        <h3 class="flex my-2 text-xs-left primary--text">Ordenar</h3>
        <span class="flex my-2 text-xs-left order-warning">Si deseas realizar más de una recarga al mismo número, debes realizar una por operación.</span>
      </v-flex>
      <v-flex xs12>
        <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="calc" id="order-form">
          <v-container grid-list-md text-xs-center>
            <v-layout row wrap>
              <v-flex xs12 md5>
                <v-text-field
                  v-model="form.phone"
                  :rules="phoneRules"
                  label="Teléfono"
                  autofocus
                  required
                ></v-text-field>
              </v-flex>
              <v-flex xs12 md5>
                <v-select
                  v-model="form.credit"
                  :items="plans"
                  item-text="text"
                  item-value="value"
                  :rules="creditRules"
                  label="Credito"
                  required
                ></v-select>
              </v-flex>
              <v-flex xs12 md2>
                <v-btn color="primary" :disabled="! valid" type="submit" form="order-form">Agregar</v-btn>
              </v-flex>
            </v-layout>
          </v-container>
        </v-form>
      </v-flex>
      <v-flex xs12 v-if="items.length != 0">
          <v-data-table
            :headers="headers"
            :items="indexItems"
            hide-actions
            item-key="id"
            class="elevation-0"
          >
            <template slot="items" slot-scope="props">
              <td class="text-xs-left">{{ props.item.phone }}</td>
              <td class="text-xs-left">{{ props.item.credit }}</td>
              <td class="text-xs-left">{{ props.item.cost }}</td>
              <td class="text-xs-right">
                <v-btn @click="remove(props.item.id)" flat icon color="red">
                  <v-icon>delete</v-icon>
                </v-btn>
              </td>
            </template>
          </v-data-table>
        <v-divider></v-divider>
      </v-flex>      
      <v-spacer></v-spacer>
      <v-flex xs12 class="text-xs-right" v-if="items.length != 0">
          Sub total: {{subtotal}}
      </v-flex>
        <v-flex xs12 class="text-xs-right" v-if="items.length != 0">
          <v-btn color="success" type="button" @click="save(items)">Confirmar</v-btn>
        </v-flex>
    </v-layout>
  </v-container>    
</template>

<script>
  import { mapState, mapActions } from 'vuex'

  export default {

    data () {
      return {
        valid: true,
        phone: '',
        phoneRules: [
          v => ! ! v || 'N&uacute;mero de tel&eacute;fono es requerido.',
          v => /^[0-9]*$/.test(v) || 'El n&uacute;mero de tel&eacute;fono debe ser valido.',
          v => (v && v.length <= 8) || 'El n&uacute;mero de tel&eacute;fono debe tener 8 caracteres.',
          v => (v && v.length >= 8) || 'El n&uacute;mero de tel&eacute;fono debe tener 8 caracteres.',
        ],
        credit: '',
        creditRules: [
          v => ! ! v || 'Credito es requerido.'
        ],
        plans: [
          { text: '15', value: 1.5 },
          { text: '20', value: 2 },
          { text: '30', value: 3 },
          { text: '50', value: 5 },
        ],
        items: [],
        saleItem: [],
        headers: [
          {
            text: 'Tel&etilde;fono',
            align: 'left',
            value: 'phone',
            sortable: false
          },
          { text: 'Credito', value: 'credit', sortable: false },
          { text: 'Costo', value: 'cost', sortable: false },
          { text: '', value: 'action', align: 'right', sortable: false },

        ],
        balance: '',
        price: '',
        subtotal: '0.0000',
        form: {
          credit: null,
          phone: '',
          cost: null,
        },
        errors: {},
        agreement: '',
        x: null
      }
    },
    mounted () {
      this.balance = 1000
      this.subtotal = 0.00
      if (this.me.role === 'admin') {
        this.price = 18
      } else {
        this.price = this.me.agreement.agreement
      }
      // for (this.x in this.me.agreement) {
      //   this.price += this.me.agreement[x]
      //   this.agreement += this.me.agreement[x]
      // }
    },

    computed: {
      ...mapState({
        me: state => state.auth.me,
      }),
      indexItems () {
        return this.items.map((item, index) => ({
          id: index,
          ...item
        }))
      },
    },

    methods: {
      ...mapActions([
        'managerUser',
        'setOrder',
        'addToastMessage',
      ]),
      remove (index) { // TODO
        this.saleItem = this.items[index]
        this.subtotal = this.subtotal - this.saleItem.cost
        this.items.splice(index, 1) // why is this removing only the last row?
      },
      calc () {
        if (this.$refs.form.validate()) {
          let item = this.items.map((item, index) => ({
            id: index,
            ...item
          }))
          // console.log('Phone: ' + item.phone.includes(12345678))
          let check
          for (var i = 0; i < item.length; i++) {
            check = item[i].phone.includes(this.form.phone)
          }
          if (check) {
            this.$swal({
              title: 'El número ya ha sido agregado',
              text: 'Si deseas realizar más de una recarga al mismo número debes realizar una por operación',
              type: 'warning',
              showCancelButton: true,
              showConfirmButton: false,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#3085d6',
              cancelButtonText: 'Entendido',
              buttonsStyling: true
            })
          } else {
            this.errors = {}
            this.form.cost = (this.price / 2) * this.form.credit
            this.subtotal = this.form.cost + this.subtotal
            switch (this.form.credit) {
              case 1.5: {
                this.form.credit = '15'
                break
              }
              case 2: {
                this.form.credit = '20'
                break
              }
              case 3: {
                this.form.credit = '30'
                break
              }
              case 5: {
                this.form.credit = '50'
                break
              }
            }

            this.items.push({ credit: this.form.credit, phone: this.form.phone, cost: this.form.cost }) // what to push unto the rows array?
            this.form.phone = ''
            this.form.credit = null
          }
        }
      },
      save (items) {
        this.errors = {}
        this.setOrder(items)
          .then(() => {
            this.$router.replace('/reports')
            this.addToastMessage({
              text: 'Operacion satisfactoria',
              type: 'success'
            })
          })
          .catch((data) => {
            this.errors = data.errors || {}
          })
      }
    }
  }
</script>
<style scoped="">
  .order-warning {
    color: #8a8883;
  }
</style>
