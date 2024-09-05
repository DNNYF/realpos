@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Manage QR Codes</h1>

    <!-- Button to open modal for adding QR Code -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addQRCodeModal">
        Add QR Code
    </button>

    <!-- QR Code List -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>QR Code Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($qrcodes as $qrcode)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ asset('storage/' . $qrcode->image_path) }}" alt="QR Code" width="100"></td>

                    <td>
                        <!-- Edit button -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#editQRCodeModal{{ $qrcode->id }}">
                            Edit
                        </button>

                        <!-- Delete button -->
                        <form action="{{ route('qrcode.destroy', $qrcode->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editQRCodeModal{{ $qrcode->id }}" tabindex="-1" role="dialog" aria-labelledby="editQRCodeModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit QR Code</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('qrcode.update', $qrcode->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="qrcodeImage">QR Code Image</label>
                                        <input type="file" name="qrcode_image" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Add Modal -->
    <div class="modal fade" id="addQRCodeModal" tabindex="-1" role="dialog" aria-labelledby="addQRCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('qrcode.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="qrcodeImage">QR Code Image</label>
                            <input type="file" name="qrcode_image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add QR Code</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection