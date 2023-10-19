{{-- Mengambil apa yang ada di dalam main.blade.php --}}
@extends('layouts.main')

{{-- Isi nya @yield('container') --}}       
@section('container')
<h1 class="mb-5 text-center">{{ $title }}</h1>

<div class="row justify-content-center mb-3">
  <div class="col-md-13">
    <form action="/posts">
              @if(request('category'))
              <input type="hidden" name="category" value="{{ request('category') }}">
              @endif
              @if(request('author'))
              <input type="hidden" name="author" value="{{ request('author') }}">
              @endif

              {{-- search --}}
              <div class="input-group mb-4">
                <input type="text" class="form-control fs-5" placeholder="Cari..." name="search" value="{{ request('search')}}">
                <button class="btn btn-outline-primary col-md-2" type="submit">Cari</button>
              </div>
            </form>
          </div>
        </div>

        
        @if($posts->count())

{{-- membuat foto (kartu) --}}
<div class="card mb-3">
  @if($posts[0]->image)
    <div style="max-height: 400px; overflow:hidden; ">
      <img src="{{ asset('storage/' . $posts[0]->image) }}" alt="{{ $posts[0]->category->name }}" class="img-fluid">
    </div>
  @else
  {{-- API UNTUK FOTO AGAR OTOMATIS --}}
    <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">
    @endif()
    <div class="card-body text-center">
        {{-- mengarahkan ke posts slug & mengambil dari posts title --}}
      <h3 class="card-title"><a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
      <p>
        <small class="text-muted">
          {{-- mmemasuki link posts author username --}}
            By : <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">
              {{-- mengambil nama author dari posts author --}}
            {{$posts[0]->author->name}}</a>
            {{-- memasuki link posts category slug --}}
            in <a href="/posts?category={{$posts[0]->category->slug}}
             {{-- mengambil posts category name --}}
             "class="text-decoration-none">{{ $posts[0]->category->name }}</a>
             {{-- postingan terakhir pada waktu ... --}}
             {{ $posts[0]->created_at->diffForHumans() }}</small></p>
      <p class="card-text">{{ $posts[0]->excerpt }}</p>
    
      <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-success">Lihat Lebih Lanjut</a>


    </div>
    


<div class="container">
    <div class="row">
        @foreach ($posts->skip(1) as $post)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="position-absolute px-3 py-2 fs-6" style="background-color: rgba(102, 94, 94, 0.7)"><a href="/posts?category={{$post->category->slug}}" class="text-white text-decoration-none">{{ $post->category->name }}</a></div>

                @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">                
                @else
                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}">
                @endif()

                
                <div class="card-body">
                  <h5 class="card-title">{{ $post->title }}</h5>
                  <p>
                    <small class="text-muted">
                        By : <a href="/posts?category={{ $post->author->username }}" class="text-decoration-none">
                        {{$post->author->name}}</a> {{ $post->created_at->diffForHumans() }}</small></p>
                  <p class="card-text">{{ $post->excerpt }}</p>
                  <a href="/posts/{{ $post->slug }}" class="btn btn-success">Lihat Lebih Lanjut</a>
                </div>
              </div>
            </div>
        @endforeach
    </div>
</div>

@else
    <p class="text-center fs-4">Tidak Ada Postingan.</p>
@endif

{{-- link ke selanjutnya --}}
<div class="d-flex justify-content-center">
  {{ $posts->links() }}
</div>
@endsection
