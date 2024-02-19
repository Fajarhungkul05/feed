@extends('template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a class="btn btn-primary my-5" href="{{ route('vidio.create') }}">
                    <i class="bi bi-plus"></i> Tambah Vidio
                </a>
            </div>

            @foreach ($videos as $video)
            <div class="card mb-4">
                <div class="card-body">
                    <video controls class="img-thumbnail" style="width: 100%">
                        <source src="{{ asset('/video/' . $video->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="d-flex mb-3">
                        <form action="{{ route('vidio.destroy',$video->id) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash3-fill"></i> 
                            </button>
                        </form>
                    </div> 
                    <div class="mt-2">
                        <strong>{{ $video->created_by }}</strong>
                    </div>
                    <div>{{ $video->caption }}</div>
                    <div>{{ $video->created_at }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Navigasi Pagination -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $videos->previousPageUrl() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $videos->previousPageUrl() }}">Previous</a>
                    </li>
                    @foreach ($videos->getUrlRange(1, $videos->lastPage()) as $page => $url)
                        <li class="page-item {{ $loop->first ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item {{ $videos->nextPageUrl() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $videos->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
