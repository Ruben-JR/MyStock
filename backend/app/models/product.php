<?php
    namespace Product\Models;

    use Illuminate\Database\Eloquent\Model;

    class Product extends Model
    {
        // Define the properties (columns) that can be mass-assigned
        protected $fillable = ['name', 'price', 'description'];

        // Additional model-specific methods or properties can be defined here
    }
?>
