<?php
/**
 * Created by PhpStorm.
 * User: minhphuc429
 * Date: 6/21/18
 * Time: 16:28
 */

namespace App\Repositories\Eloquent;


class CartRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    function model()
    {
        return 'App\Models\Cart';
    }
}