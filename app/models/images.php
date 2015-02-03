<?php

class Photo extends Eloquent{

	//la variable que definen el nombre de la tabla
	protected $table = 'photos';

	//la variable que definen las columnas que se pueden editar
	protected $fillable = array('title','image');

	//la variable que activa o desactiva en Laravel la opcion de tiempo
	//por defecto es true, estamos dejando esto asi
	public $timestamps = true;

	public static $upload_rules = array(
		'title' => 'required|min:3',
		'image' => 'required|image'
	);
}