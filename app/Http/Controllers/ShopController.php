<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller {
    public function index(){ 
        $products = products::with('images')->paginate(12);  
        return view('shop.index', compact('products')); 
    }

    public function addToCart($id){ 
        $user = Auth::user();
        $uid = $user ? $user->id : 1;
        $cart = Cart::where('user_id',$uid)->where('product_id',$id)->first();
        if($cart) $cart->increment('quantity');
        else Cart::create(['user_id'=>$uid,'product_id'=>$id,'quantity'=>1]);
        return redirect()->back()->with('success','Added to cart'); 
    }

    public function viewCart(){ 
        $uid = Auth::id() ?? 1;
        $items = Cart::with('product.images')->where('user_id',$uid)->get(); 
        return view('shop.cart', compact('items')); 
    }
}
