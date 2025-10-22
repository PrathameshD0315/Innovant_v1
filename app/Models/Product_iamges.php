<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product_iamges extends Model {
    use HasFactory;
    protected $fillable = ['product_id','path','original_name','is_primary'];
    protected $appends = ['url'];
    public function product(){ 
        return $this->belongsTo(Product::class); 
    }
    public function getUrlAttribute(){ 
        return Storage::url($this->path); 
    }
}
