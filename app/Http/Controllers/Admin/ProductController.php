<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function __construct(){ $this->middleware(['auth','is_admin']); }


    public function index(){ 
        $products = products::with('images')->latest()->paginate(12); 
        return view('admin.products.index', compact('products')); 
    }

    public function create(){ 
        return view('admin.products.create'); 
    }

    public function store(Request $r){ 
        $r->validate(['name'=>'required','price'=>'required|numeric','images.*'=>'image|max:5120']); 
        $p = products::create($r->only('name','price','description')); 
        if($r->hasFile('images')){
            foreach($r->file('images') as $i=>$file){
                $filename = now()->format('YmdHis').'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('public/products',$filename);
                ProductImage::create([
                    'product_id'=>$p->id,
                    'path'=>str_replace('public/','',$path),
                    'original_name'=>$file->getClientOriginalName(),
                    'is_primary'=>$i===0
                ]);
            }
        } 
        return redirect()->route('admin.products.index')->with('success','Product created'); 
    }

    public function edit(products $product){ $product->load('images'); return view('admin.products.edit', compact('product')); }

    public function update(Request $r, Product $product){
        $product->update($r->only('name','price','description')); 
        if($r->hasFile('images')){
            foreach($r->file('images') as $file){
                $filename = now()->format('YmdHis').'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('public/products',$filename);
                ProductImage::create(['product_id'=>$product->id,'path'=>str_replace('public/','',$path),'original_name'=>$file->getClientOriginalName()]);
            }
        } 
        return redirect()->route('admin.products.index')->with('success','Updated'); 
    }

    public function destroy(products $product){
        foreach($product->images as $img){
            $storagePath = 'public/'.$img->path;
            if(Storage::exists($storagePath)) Storage::delete($storagePath);
        }
        $product->delete();
        return back()->with('success','Deleted');
    }

    public function destroyImage($id){
        $img = ProductImage::findOrFail($id);
        $storagePath = 'public/'.$img->path;
        if(Storage::exists($storagePath)) Storage::delete($storagePath);
        $img->delete();
        return back()->with('success','Image removed');
    }
}
