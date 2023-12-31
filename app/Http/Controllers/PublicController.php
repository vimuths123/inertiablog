<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Repositories\BlogRepositoryInterface;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

class PublicController extends Controller
{

    protected $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function index()
    {
        $perPage = 10;
        $blogs = $this->blogRepository->all($perPage);

        return Inertia::render(
            'Home',
            [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'blogs' => $blogs,
                'filters' => request()->only('search'),
            ]
        );
    }

    public function show(Blog $blog)
    {

        $latestBlogs = $this->blogRepository->latestExceptCurrent($blog, 4);

        return Inertia::render(
            'Blogitem',
            [
                'blog' => $blog,
                'latestBlogs' => $latestBlogs
            ]
        );
    }
}
