<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {

        $validated_data = $request->validated();

        $validated_data['slug'] = Post::generateSlug($request->title);

        $checkPost = Post::where('slug', $validated_data['slug'])->first();
        if ($checkPost) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug per questo post, cambia il titolo']);
        }

        //if (array_key_exists('cover_image', $request->all()) {

        //}

        if ($request->hasFile('cover_image')) {
            $path = Storage::put('cover', $request->cover_image);
            $validated_data['cover_image'] = $path;
        }

        $newPost = Post::create($validated_data);

        if ($request->has('tags')) {
            $newPost->tags()->attach($request->tags);
        }

        return redirect()->route('admin.posts.show', ['post' => $newPost->slug])->with('status', 'Post creato con successo!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {

        $validated_data = $request->validated();
        $validated_data['slug'] = Post::generateSlug($request->title);

        $checkPost = Post::where('slug', $validated_data['slug'])->where('id', '<>', $post->id)->first();

        if ($checkPost) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug']);
        }


        if ($request->hasFile('cover_image')) {

            if ($post->cover_image) {
                Storage::delete($post->cover_image);
            }

            $path = Storage::put('cover', $request->cover_image);
            $validated_data['cover_image'] = $path;

        }


        $post->tags()->sync($request->tags);

        $post->update($validated_data);


        return redirect()->route('admin.posts.show', ['post' => $post->slug])->with('status', 'Post modificato con successo!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if ($post->cover_image) {
            Storage::delete($post->cover_image);
        }

        $post->delete();
        return redirect()->route('admin.posts.index');
    }


    public function deleteImage($slug) {

        $post = Post::where('slug', $slug)->firstOrFail();

        if ($post->cover_image) {
            Storage::delete($post->cover_image);
            $post->cover_image = null;
            $post->save();
        }

        return redirect()->route('admin.posts.edit', $post->slug);

    }
}
