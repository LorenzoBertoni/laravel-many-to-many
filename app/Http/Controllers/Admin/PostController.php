<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        return view('posts.index', ['posts' => $posts]);
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

        return view('posts.create', ['categories' => $categories, 'tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'exists:tags,id'
        ]);
        $data = $request->all();

        $newPost = new Post();
        $newPost->fill($data);
        
        $slug = $this->getSlug($newPost->title);
        $newPost->slug = $slug;

        $newPost->save();

        //*solo dopo aver salvato il nuovo post
        //*aggiungo i record alla tabella pivot

        if (array_key_exists('tags', $data)) {
            //* solo se 'tags' è definito nell'array 'data'
            
            $newPost->tags()->sync($data['tags']);
        }

        return redirect()->route('admin.posts.index')->with('created', 'Creazione avvenuta con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('posts.edit', ['post' => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);
        $data = $request->all();

        if ($post->title !== $data['title']) {
            $data['slug'] = $this->getSlug($data['title']);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('edited', 'Modifiche apportate correttamente');
    }


    protected function getSlug($title) 
    {
        //**Crea uno slug univoco per ogni titolo */
        $slug = Str::slug($title, '-');
        $checkSlug = Post::where('slug', $slug)->first();
        $counter = 1;

        while($checkSlug) {
            $slug = Str::slug($title . '-' . $counter, '-');
            $counter++;
            $checkSlug = Post::where('slug', $slug)->first();
        }

        return $slug;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return redirect()->route('admin.posts.index')->with('cancelled', 'Eliminazione avvvenuta con successo');
    }

}
