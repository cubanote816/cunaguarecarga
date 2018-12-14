<template>
	<v-card>
	    <v-card-text class="pa-0" color="secondary">
	        <v-container class="pa-0">
	            <div class="layout row ma-0">
	                <div class="sm5 xs5 py-3 flex">
	                    <div class="layout column ma-0 justify-center align-center bg-aqua ">
	                      <v-icon size="56px" color="indigo">mdi-cart-plus</v-icon>
	                    </div>
	                </div>
		            <div class="sm7 xs7 flex text-sm-center py-3">
		            	<div class="headline">{{$props.last30Days}} $ / {{$props.last30DaysSum}}</div>
		            	<div class="">
	                		<span class="caption">Ultimos 30 D&iacute;as</span>
	            </div>
	            	</div>
	            </div>
	            
	        </v-container>
	    </v-card-text>
	</v-card>
</template>

<script>
  export default {
    props: {
      last30Days: {
        // type: String,
        required: true
      },
      last30DaysSum: {
        // type: Number,
        required: true
      },
    },
  }
</script>
<style lang="scss">

</style>
