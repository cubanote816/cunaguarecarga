<template>
	<v-card>
            <v-card-text class="pa-0">
              <v-container class="pa-0">
                <div class="layout row ma-0">
                  <div class="sm5 xs5 py-3 flex">
                    <div class="layout column ma-0 justify-center align-center bg-aqua">
                      <v-icon size="56px" color="success">mdi-pen</v-icon>
                    </div>
                  </div>
                  <div class="sm7 xs7 flex text-sm-center py-3 ">
                    <div class="headline">{{$props.agreement}} $</div>
                    <span class="caption">Contrato</span>
                  </div>
                </div>
              </v-container>
            </v-card-text>
          </v-card>
</template>

<script>
  export default {
    props: {
      agreement: {
        required: true
      },
    },
  }
</script>
<style lang="scss">

</style>
