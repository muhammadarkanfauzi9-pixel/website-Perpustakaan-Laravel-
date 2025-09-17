@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Publishers</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Add Publisher --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPublisherModal">
        Add Publisher
    </button>

    {{-- Tabel Publisher --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publishers as $publisher)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $publisher->name }}</td>
                    <td>{{ $publisher->address }}</td>
                    <td>{{ $publisher->phone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No publishers found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $publishers->links() }}
</div>

{{-- Modal Add Publisher --}}
<div class="modal fade" id="addPublisherModal" tabindex="-1" aria-labelledby="addPublisherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Publisher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('admin.publishers.store') }}">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="name" class="form-label">Publisher Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
