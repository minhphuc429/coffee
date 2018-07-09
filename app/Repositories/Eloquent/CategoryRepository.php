<?php
/**
 * Created by PhpStorm.
 * User: minhphuc429
 * Date: 6/18/18
 * Time: 15:54
 */

namespace App\Repositories\Eloquent;


class CategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    function model()
    {
        return 'App\Models\Category';
    }
}