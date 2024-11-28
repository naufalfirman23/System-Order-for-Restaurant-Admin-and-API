@extends('admin.main')

@section('content')
<div id="layoutSidenav_content">
    <div class="container p-4">
        <h2>Edit Kategori</h2>
        @if(session('success'))
            <div id="alert" class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div id="alert" class="alert alert-error">{{ session('error') }}</div>
        @endif
    
        <!-- Form untuk edit kategori -->
        <form action="{{ route('admin.kategori.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')  
            
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $category->nama) }}" required>
            </div>
    
            <button type="submit" class="btn btn-primary">Perbarui Kategori</button>
        </form>
    </div>
</div>
@endsection
