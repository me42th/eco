<?php 
    function formatPrice(float $vlprice){
        return number_format($vlprice, 2, ',','.');
    }
    function hasCategory($id_category, $categories){
        return in_array($id_category, $categories);
    }
?>