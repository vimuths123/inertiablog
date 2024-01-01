<?php

namespace App\Repositories;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogRepository implements BlogRepositoryInterface
{
    public function all(int $perPage = 10)
    {
        $blogs = Blog::query()
            ->when(request()->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->whereNotNull('published_date')
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn($blog) => [
                'id' => $blog->id,
                'title' => $blog->title,
                'content' => $blog->content,
                'published_date' => $blog->published_date,
            ]);

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
        return Blog::query()
            ->when(request()->input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'desc') 
            ->paginate($perPage)
            ->withQueryString()
            ->through(fn($blog) => [
                'id' => $blog->id,
                'title' => $blog->title,
                'content' => $blog->content,
                'published_date' => $blog->published_date,
            ]);
            
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
