<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model {
    use HasFactory;
    protected $fillable = ['name','price','description','is_active'];
    public function images(){ 
        return $this->hasMany(ProductImage::class); 
    }
}
