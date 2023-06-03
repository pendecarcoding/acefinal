<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Handbook;
use Artisan;
use DB;
use File;

class FileStaffController extends Controller
{

    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_filestaff'])->only('index');
        $this->middleware(['permission:add_filestaff'])->only('create');
        $this->middleware(['permission:edit_filestaff'])->only('edit');
        $this->middleware(['permission:delete_filestaff'])->only('destroy');
        $this->middleware(['permission:publish_filestaff'])->only('change_status');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('handbook')->get();
        return view('backend.filestaff.handbook.index',compact('data'));
    }

    function change_status(request $request){
        $data = DB::table('handbook')->where('id',$request->id)->first();
        try {
            DB::table('handbook')->where('id',$request->id)->update(['published'=>$request->status]);
            return 1;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }
    function create(){
        return view('backend.filestaff.handbook.create');
    }

    function storehandbook(Request $request){
        $request->validate([
            'file' => 'required|mimes:pdf'
           ]);
           if($request->hasFile('file')) {
               $uploadPath = public_path('handbook');
                 if(!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                 }
                 $file = $request->file('file');
                 $explode = explode('.', $file->getClientOriginalName());
                 $originalName = $explode[0];
                 $extension = $file->getClientOriginalExtension();
                 $rename = 'file_' . date('YmdHis') . '.' . $extension;
                 $mime = $file->getClientMimeType();
                 $filesize = $file->getSize();
                 if($file->move($uploadPath, $rename)) {
                       try {
                        $data=[
                            'version'=>$request->version,
                            'name'=>$request->name,
                            'file'=>$rename,
                            'effective'=>$request->date,
                            'published'=>1,
                        ];
                        DB::table('handbook')->insert($data);
                        flash(translate('Handbook has been save successfully'))->success();
                        return redirect()->route('handbook.staff');

                       } catch (\Throwable $th) {
                        flash(translate($th->getMessage()))->warning();
                        return back();
                       }

                   }
           }else{

           }

    }

    function handbookedit($id){
        $data = DB::table('handbook')->where('id',base64_decode($id))->first();
        return view('backend.filestaff.handbook.edit',compact('data'));
    }

    function updatehandbook(Request $request){
        try {
            if($request->hasFile('file')) {
                $uploadPath = public_path('handbook');
                  if(!File::isDirectory($uploadPath)) {
                     File::makeDirectory($uploadPath, 0755, true, true);
                  }
                  $file = $request->file('file');
                  $explode = explode('.', $file->getClientOriginalName());
                  $originalName = $explode[0];
                  $extension = $file->getClientOriginalExtension();
                  $rename = 'file_' . date('YmdHis') . '.' . $extension;
                  $mime = $file->getClientMimeType();
                  $filesize = $file->getSize();
                  if($file->move($uploadPath, $rename)) {
                    if(File::exists(public_path('handbook' . $request->fileold))) {
                        File::delete(public_path('handbook' . $request->fileold));
                    }
                        try {
                         $data=[
                             'version'=>$request->version,
                             'name'=>$request->name,
                             'file'=>$rename,
                             'effective'=>$request->date,
                         ];
                         DB::table('handbook')->where('id',$request->id)->update($data);
                         flash(translate('Handbook has been save successfully'))->success();
                         return redirect()->route('handbook.staff');

                        } catch (\Throwable $th) {
                         flash(translate($th->getMessage()))->warning();
                         return back();
                        }

                    }
            }else{

                try {
                    $data=[
                        'version'=>$request->version,
                        'name'=>$request->name,
                        'effective'=>$request->date,
                    ];
                    DB::table('handbook')->where('id',$request->id)->update($data);
                    flash(translate('Handbook has been save successfully'))->success();
                    return redirect()->route('handbook.staff');

                   } catch (\Throwable $th) {
                    flash(translate($th->getMessage()))->warning();
                    return back();
                   }

            }
        } catch (\Throwable $th) {
            flash(translate($th->getMessage()))->warning();
                    return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updater(Request $request)
    {
       try {
        foreach ($request->types as $key => $type) {
            overWriteEnvFile($type, $request[$type]);
            //print $type;
        }
        Artisan::call('cache:clear');
        flash(translate('Slider has been updated successfully'))->success();
        return redirect()->route('about.index');
       } catch (\Throwable $th) {
        print $th->getmessage();
        // flash(translate('Slider has been updated successfully'))->success();
        // return redirect()->route('about.index');
       }

    }

    public function destroyhandbook($id)
    {
        $data = DB::table('handbook')->where('id',base64_decode($id))->first();
        if(DB::table('handbook')->where('id',base64_decode($id))->delete()){
            if(File::exists(public_path('handbook/' . $data->file))) {
                File::delete(public_path('handbook/' . $data->file));
            }
            flash(translate('Handbook has been deleted successfully'))->success();
        }
        else{
            flash(translate('Handbook went wrong'))->error();
        }
        return redirect()->route('handbook.staff');
    }


}
