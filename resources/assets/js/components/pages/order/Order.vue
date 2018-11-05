<template>
    <div class="container" id="reseller">
        <h3>Orden</h3>
        <hr>
        <div class="row">
            <form class="form-horizontal row" role="form" @submit.prevent="calc">
                <div>Credito: {{balance}}</div>
                <div>Costo: {{price}}</div>
                <div class="col-xs-12">
                    <div class="col-xs-5">
                        <div class="form-group" :class="{ 'has-error': errors.cant }">
                            <label for="credit" class="col-xs-6 control-label">Saldo para el movil</label>
                            <div class="col-xs-6">
                                <select id="credit" class="form-control" v-model="form.credit">
                                    <option value="">--Please choose an option--</option>
                                    <option value="1.5">15</option>
                                    <option value="2">20</option>
                                    <option value="3">30</option>
                                    <option value="5">50</option>
                                </select>

                                <div class="help-block" v-if="errors.credit">
                                    <div v-for="error in errors.credit"><strong>{{ error }}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="form-group">
                            <label for="phone" class="col-xs-4 control-label">Numero</label>
                            <div class="input-group col-xs-8">
                                <span class="input-group-addon" id="basic-addon1">+53</span>
                                <input type="text" id="phone" v-model="form.phone" class="form-control" placeholder="5xxxxxxx" required aria-describedby="basic-addon1">
                            </div>

                                <div class="help-block" v-if="errors.phone">
                                    <div v-for="error in errors.phone"><strong>{{ error }}</strong></div>
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <hr>
            <div class="col-xs-4">Numero</div>
            <div class="col-xs-2">Saldo a depositar</div>
            <div class="col-xs-4">Costo</div>
            <div class="col-xs-2"></div>

            <div v-for="(item, index) in items" v-on:remove="items.splice(index, 1)">
                <div class="col-xs-4">{{item.phone}}</div>
                <div class="col-xs-2">{{item.credit}}</div>
                <div class="col-xs-4">{{item.cost}}</div>
                <div class="col-xs-2">
                    <button @click="remove(index)"> X</button>
                </div>
            </div>
            <hr>
            <div class="col-md-2 col-md-offset-10">Sub total: {{subtotal}}</div>
            <div class="col-md-2 col-md-offset-10" v-if="items">
                <button type="button" @click="save(items)">Confirmar</button>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapActions, mapState } from 'vuex'
  export default {
    name: 'Sale',
    data () {
      return {
        items: [],
        balance: '',
        price: '',
        test: '',
        subtotal: '0.00',
        form: {
          credit: '',
          phone: '',
          cost: '',
        },
        errors: {}
      }
    },
    mounted () {
      // this.managerUser()
      this.balance = 1000
      this.price = this.contractor.agreement
      this.subtotal = 0.00
      this.getContractor()
    },
    computed: {
      ...mapState({
        me: state => state.auth.me,
        // userManager: state => state.users.userManager,
        contractor: state => state.contract.contractor,
      })
    },

    methods: {
      ...mapActions([
        'managerUser',
        'getContractor',
        'setOrder',
        'addToastMessage',
      ]),
      remove (index) { // TODO
        // this.balance = this.balance + index.
        this.items.splice(index, 1) // why is this removing only the last row?
      },
      calc () {
        // if (cant) {
        // this.subtotal = this.price * this.form.cant + this.subtotal
        // this.cost = this.price * this.form.cant
        // this.balance = this.balance - this.cost
        this.form.cost = (this.price / 2) * this.form.credit
        this.subtotal = this.form.cost + this.subtotal
        this.balance = this.balance - this.subtotal
        switch (this.form.credit) {
          case '1.5': {
            this.form.credit = '15'
            break
          }
          case '2': {
            this.form.credit = '20'
            break
          }
          case '3': {
            this.form.credit = '30'
            break
          }
          case '5': {
            this.form.credit = '50'
            break
          }
        }
        this.items.push({ credit: this.form.credit, phone: this.form.phone, cost: this.form.cost }) // what to push unto the rows array?
        this.form.credit = ''
        this.form.phone = ''
        // } else {
        //   this.
        // }
      },
      save (items) {
        this.errors = {}
        this.setOrder(items)
          .then(() => {
            this.items = ''
            this.subtotal = '0.00'
            this.addToastMessage({
              text: 'Operacion satisfactoria',
              type: 'success'
            })
          })
          .catch((data) => {
            this.errors = data.errors || {}
          })
      },

    }
  }
</script>

<style scoped>

</style>