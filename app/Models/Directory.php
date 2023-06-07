<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;
    protected $fillable = [
        'dir_first_name',
        'dir_middle_name',
        'dir_last_name',
        'dir_post_desi',
        'dir_directory_type',
        'dir_contact_no_1',
        'dir_contact_no_2',
        'dir_contact_no_3',
        'dir_email',
        'dir_facebook',
        ];
}
