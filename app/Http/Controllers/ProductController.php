<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        //Get all data from database
        $products = Product::all();

        return response()->json($products);
    }
    public function store(Request $request)
    {
        //Post data to DB from user

        //Validation
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);

        $product = new Product();

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowfileExtension = ['jpg', 'png', 'jpeg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowfileExtension);

            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return response()->json($product);
    }

    public function show($id)
    {
        //Give 1 item from products table
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        //Update product by Id
        $this->validate($request,[
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);

        $product = Product::find($id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $allowfileExtension = ['jpg', 'png', 'jpeg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowfileExtension);

            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
        }

        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return response()->json($product);
    }

    public function destroy($id)
    {
        //Delete product by Id
        $product = Product::find($id);
        $product->delete();
        return response()->json('Product successfully deleted!');
    }
}
