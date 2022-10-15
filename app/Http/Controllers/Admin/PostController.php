<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'tags' => 'exists:tags,id',
            'img_path' => 'nullable|image'

        ]);

        $data = $request->all();

        if (array_key_exists('img_path', $data)) {
        //* solo se 'img_path' è definito nell'array 'data'
        // evita "undefined index img_path"
            $img = Storage::put('img', $data['img_path']);
            //upload dell'immagine
            $data['img_path'] = $img;
        }

        $newPost = new Post();
        $newPost->fill($data);
        
        $slug = $this->getSlug($newPost->title);
        $newPost->slug = $slug;
        
        $newPost->save();

        //*solo dopo aver salvato il nuovo post
        //*aggiungo i record alla tabella pivot

        if (array_key_exists('tags', $data)) {
            //* solo se 'tags' è definito nell'array 'data'
            // se nessuna checkbox viene selezionata non sarà presente un valore di ritorno, di conseguenza otterremmo un errore. Per ovviare utilizziamo la condizione per eseguire il codice solo se $data['tags] è definito.
            
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
        $tags = Tag::all();

        return view('posts.edit', ['post' => $post, 'categories' => $categories, 'tags' => $tags]);
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
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'exists:tags,id',
            'img_path' => 'nullable|image'
        ]);

        $data = $request->all();

        if ($post->title !== $data['title']) {
            $data['slug'] = $this->getSlug($data['title']);
        }

       if (array_key_exists('img_path', $data)) {
        //* solo se 'img_path' è definito nell'array 'data'
        // evita "undefined index img_path"
            if ($post->img_path) {
                //se il post aveva un immagine
                Storage::delete($post->img_path);
            }
            //update immagine
            $img = Storage::put('img', $data['img_path']);
            $data['img_path'] = $img;
       }

        $post->update($data);

        if (array_key_exists('tags', $data)) {
            //* solo se 'tags' è definito nell'array 'data'
            // se nessuna checkbox viene selezionata il valore di ritorno è nullo e necessita di una condizione per evitare un errore
            
            $post->tags()->sync($data['tags']);
        } else {
            //* In caso di update con rimozione di tutti i tag
            // se nessun tag viene selezionato il valore di ritorno sarà nullo. Di conseguenza non si verificherebbe la condizione dell'if e le modifiche non verrebbero registrate. Dato che in questo caso avverrebbe una rimozione di tutti i tag utilizziamo una detach() per ottenere il risultato sperato
            
            $post->tags()->detach();
        }

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
