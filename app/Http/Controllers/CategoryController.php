<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            if (empty($data['status'])) {
                $status = 0;
            }else{
                $status = 1;
            }

            if (empty($data['activate_categories'])) {
                $activate_categories = 0;
            }else{
                $activate_categories = 1;
            }
            $category = new Category;
            $category->category_name=$data['category_name'];
            $category->parent_id=$data['parent_id'];
            $category->description=$data['description'];

            $category->url=$data['url'];
            //Upload Image
            if($request->hasFile('image')){
                //Get file from the browser
               $path= $request->file('image');
                // Resize and encode to required type
               $img = Image::make($path)->encode();
                //Provide the file name with extension
               $filename = time(). '.' .$path->getClientOriginalExtension();
               //Put file with own name
               Storage::put($filename, $img);
               //Move file to your location
               Storage::move($filename, 'public/images/categories/' . $filename);
               //now insert into database
               $category->image = $filename;
           }
            $category->status = $status;
            $category->activate_categories = $activate_categories;
            //echo "<pre>";print_r($category);die;
            $category->save();
            return redirect('/admin/categories/view_category')->with('flash_message_success','Category Added Succesfully!!');
        }
        $levels = Category::where(['parent_id'=>0])->get();
        return view('/admin/categories.add_category')->with(compact('levels'));
    }

    public function editCategory(Request $request, $id=null){

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            if (empty($data['description'])) {
                $data['description'];
            }
            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

            if (empty($data['activate_categories'])) {
                $activate_categories = 0;
            }else{
                $activate_categories = 1;
            }

            //check for current photo
            $currentPhoto = $data['current_image'];
            //Upload Image
            if ($request->image != null && $request->image != $currentPhoto) {
                //delete the image from the folder
                Storage::disk('public')->delete('images/categories/'.$currentPhoto);
                //Get file from the browser
                $path= $request->file('image');
                 // Resize and encode to required type
                $img = Image::make($path)->encode();
                 //Provide the file name with extension
                $filename = time(). '.' .$path->getClientOriginalExtension();
                //Put file with own name
                Storage::put($filename, $img);
                //Move file to your location
                Storage::move($filename, 'public/images/categories/' . $filename);
            }else{
              $storeImage = $data['current_image'];
            }

            Category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'parent_id'=>$data['parent_id'],'description'=>$data['description'],'status'=>$status,'activate_categories'=>$activate_categories, 'image'=>$filename]);

            return redirect('admin/categories/view_category')->with('flash_message_success', 'Category has been Updated Successfully!');

        }

        $categoryDetails = Category::where(['id'=>$id])->first();
        $levels = Category::where(['parent_id'=>0])->get();

        return view('/admin/categories.edit_category')->with(compact('categoryDetails','levels'));
    }

    public function deleteCategory($id = null){
        $category = Category::findOrFail($id);
        //remove the image from the public/images folder
        Storage::disk('public')->delete('storage/images/categories/'.$category->image);
        //delete the categ$category
        $category->delete();
        return redirect()->back()->with('flash_message_success','Category deleted Successfully!');
   }

    public function viewCategories(Request $request){
        $categories = Category::get();
        $categories = json_decode(json_encode($categories));
        return view('/admin/categories.view_categories')->with(compact('categories'));
    }

}
