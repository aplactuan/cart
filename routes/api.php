<?php

Route::get('/', function() {
   $categories = \App\Models\Category::parents()->ordered()->get();

   return $categories;
});
