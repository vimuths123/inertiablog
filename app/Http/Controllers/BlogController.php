<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogCreateRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Repositories\BlogRepositoryInterface;
use Inertia\Inertia;
use Carbon\Carbon;

class BlogController extends Controller
{

    protected $blogRepository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $userBlogs = $this->blogRepository->getUserBlogs(auth()->id(), $perPage);
        
        return Inertia::render(
            'Blog/Index',
            [
                'blogs' => $userBlogs,
                'filters' => request()->only('search'),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Blog/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request)
    {
        $data = $request->validated();
        $data = $request->only(['title', 'content']);
        $blog = $this->blogRepository->create($data);

        return redirect()->route('blog.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return Inertia::render(
            'Blog/Show',
            [
                'blog' => $blog
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = $this->blogRepository->find($id);
        $this->authorize('update', $blog);

        return Inertia::render(
            'Blog/Edit',[
                'blog' => $blog
            ]
        );

        // return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $blog = $this->blogRepository->update($id, $data);
        $this->authorize('update', $blog);
        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);
        $blog = $this->blogRepository->delete($blog->id);

        return redirect()->route('blog.index');
    }

    public function publish($id)
    {
        $blog = Blog::findOrFail($id);
        $this->authorize('update', $blog);
        $blog->update(['published_date' => Carbon::now()]);

        return redirect()->route('blog.index');
    }

    public function unpublish($id)
    {
        $blog = Blog::findOrFail($id);
        $this->authorize('update', $blog);
        $blog->update(['published_date' => null]);

        return redirect()->route('blog.index');
    }
}
