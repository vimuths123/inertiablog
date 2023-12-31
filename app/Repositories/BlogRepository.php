<?php

namespace App\Repositories;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogRepository implements BlogRepositoryInterface
{
    public function all(int $perPage = 10)
    {
        // Fetch blogs with published_date not null
        $blogs = Blog::latest()
            ->whereNotNull('published_date')
            ->paginate($perPage);

        return $blogs;
    }

    public function find($id)
    {
        return Blog::findOrFail($id);
    }

    public function latestExceptCurrent($currentBlog, $count = 4)
    {
        return Blog::where('id', '!=', $currentBlog->id)
            ->latest()
            ->whereNotNull('published_date')
            ->take($count)
            ->get();
    }

    public function create(array $data)
    {
        return Blog::create(array_merge($data, ['user_id' => auth()->id()]));
    }

    public function getUserBlogs($userId, int $perPage = 10)
    {
        return Blog::where('user_id', $userId)
            ->paginate($perPage);
    }

    public function update($id, array $data)
    {
        $blog = Blog::findOrFail($id);
        $blog->update($data);

        return $blog;
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return;
    }
}
