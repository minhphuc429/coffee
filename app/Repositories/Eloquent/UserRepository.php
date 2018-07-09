<?php
/**
 * Created by PhpStorm.
 * User: minhphuc429
 * Date: 6/21/18
 * Time: 15:50
 */

namespace App\Repositories\Eloquent;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     */
    function model()
    {
        return 'App\Models\User';
    }
}