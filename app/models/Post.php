<?php
// app/models/Post.php
namespace App\Models;

use Core\Model;
use App\Models\User;

class Post extends Model
{
    // Table name
    protected string $table = 'posts';
    // Primary key
    protected string $primaryKey = 'id';
    // Fillable fields for mass assignment
    protected array $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'published_at',
        'created_at',
        'updated_at',
    ];

    // Optionally, you can add validation rules or helper methods here
    // Example: get the author (user) of the post
    public function user()
    {
        return User::find($this->user_id);
    }
}
