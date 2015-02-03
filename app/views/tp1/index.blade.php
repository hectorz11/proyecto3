@extends('frontend_master')

@section('content')

	{{Form::open(array('url'=>'/','files'=>true))}}
	{{Form::text('title','',array('placeholder'=>'Please insert the title here'))}}
	{{Form::file('image')}}
	{{Form::submit('save!',array('name'=>'send'))}}
	{{Form::close()}}

@stop