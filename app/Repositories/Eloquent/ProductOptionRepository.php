<?php
/**
 * Created by PhpStorm.
 * User: minhphuc429
 * Date: 6/28/18
 * Time: 16:08
 */

namespace App\Repositories\Eloquent;

class ProductOptionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    function model()
    {
        return 'App\Models\ProductOption';
    }
}