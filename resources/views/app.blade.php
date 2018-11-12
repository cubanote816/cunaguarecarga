@extends('layouts.app')

@section('content')
	<div id="app">
		<v-app id="inspire" class="app">
	    	<spinner></spinner>
	    	<toast position="nw"></toast>

	    	<navbar></navbar>
	    	<sidebar></sidebar>
	    	<v-content>
		      <v-container fluid fill-height>
		        <v-layout>
		          <transition name="fade" mode="out-in">
		      		<div class="page-wrapper">
		        		<router-view style="padding-top: 60px"></router-view>
		        	</div> 
		      	</transition>
		        </v-layout>
		      </v-container>
		    </v-content>
	  	</v-app>	
   </div>
@endsection
