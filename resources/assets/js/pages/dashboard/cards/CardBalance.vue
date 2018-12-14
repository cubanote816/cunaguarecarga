<template>
	<v-card>
            <v-card-text class="pa-0">
              <v-container class="pa-0">
                <div class="layout row ma-0">
                  <div class="sm5 xs5 py-3 flex">
                    <div class="layout column ma-0 justify-center align-center bg-aqua" color="primary">
                      <v-icon size="56px" color="success">mdi-square-inc-cash</v-icon>
                    </div>
                  </div>
                  <div class="sm7 xs7 flex text-sm-center py-3 ">
                    <div class="headline">{{$props.balance}}</div>
                    <span class="caption">Balance</span>
                  </div>
                </div>
              </v-container>
            </v-card-text>
          </v-card>
</template>

<script>
  export default {
    props: {
      balance: {
        type: Number,
        required: true
      },
    },
  }
</script>
<style lang="scss">

</style>
