<?php

// public $restful = true;

class ImageController extends BaseController{

	public function getIndex(){

		//vamos a cargar la vista del formulario
		return View::make('tp1.index');
	}

	public function postIndex(){

		$validation = Validator::make(Input::all(),Photo::$upload_rules);

		if($validation->fails()){
			return Redirect::to('/')
			->withInput()
			->withErrors($validation);
		}else{
			$image = Input::file('image');
			$filename = $image->getClientOriginalName();
			$filename = pathinfo($filename, PATHINFO_FILENAME);

			$fullname = Str::slug(Str::random(8).$filename).'.'.$image->getClientOriginalExtension();

			$upload = $image->move(Config::get('image.upload_folder'),$fullname);

			Image::make(Config::get('image.upload_folder').'/'.$fullname)
			->resize(Config::get('image.thumb_width'),Config::get('image.thumb_height'))
			->save(Config::get('image.thumb_folder'.'/'.$fullname));

			if($upload){
				$insert_id = DB::table('photos')->insertGetId(
					array(
						'title' => Input::get('title'),
						'image' => $fullname
					)
				);
				return Redirect::to(URL::to('snatch/'.$insert_id))
				->with('success','Your image is uploaded successfully!');
			}else{
				return Redirect::to('/')->withInput()
				->with('error','Sorry, the image could not be upload, please try again later');
			}
		}
	}

	public function getSnatch($id){

		$image = Photo::find($id);

		if($image){
			return View::make('tp1.permalink')->with('image',$image);
		}else{
			return Redirect::to('/')->with('error','Image not found');
		}
	}

	public function getAll(){

		$all_images = DB::table('photos')->orderBy('id','desc')->paginate(6);
		return View::make('tp1.all_images')->with('images',$all_images);
	}

	public function getDelete($id){
		$image = Photo::find($id);

		if($image){
			File::delete(Config::get('image.upload_folder').'/'.$image->image);
			File::delete(Config::get('image.thumbs_folder').'/'.$image->image);		

			$image->delete();
			return Redirect::to('/')->with('success','Image deleted successfully');
		}else{
			return Redirect::to('/')->with('error','No image with given ID found');
		}
	}
}