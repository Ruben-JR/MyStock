<?php
    namespace User\Models;
    use Illuminate\Database\Eloquent\Model;
    class Product extends Model {
        protected $fillable = ['name', 'price', 'description'];
    }
?>
