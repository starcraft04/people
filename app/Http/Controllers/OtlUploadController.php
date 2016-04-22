<?php 

namespace App\Http\Controllers;

use App\Http\Requests\OtlUploadRequest;

class OtlUploadController extends Controller 
{

    public function getForm()
	{
		return view('otlupload');
	}

	public function postForm(OtlUploadRequest $request)
	{
		$file = $request->file('uploadfile');

		if($file->isValid())
		{
			$chemin = config('upload.otlPath');

			$extension = $file->getClientOriginalExtension();

			$nom = $request->input('year').$request->input('month'). '.' . $extension;

			$file->move($chemin, $nom);
            
            \Excel::load($chemin.'/'.$nom, function($reader) {
                $reader->each(function($sheet) {
                    // Loop through all rows
                    $sheet->each(function($row) {
                        echo $row->manager_name.'<BR/>';
                    });
                });    
            });
            die();
            return redirect('otlupload/form')->withOk('File uploaded !');
		}

		return redirect('otlupload/form')
			->with('error','Sorry, your file cannot be uploaded !');
	}

}