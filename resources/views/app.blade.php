@extends('layouts.app')

@section('content')
	<div id="app">
		<v-app id="inspire" class="app">
	    	<spinner></spinner>
	    	<toast position="nw"></toast>

	    	<navbar></navbar>
	    	<v-content>
		      <transition name="fade" mode="out-in">
		        	<router-view></router-view>
		      </transition>
		    </v-content>
	  	</v-app>
   </div>
@endsection