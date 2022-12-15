@extends('admin.manage_room')

@section('room_form')
<form method="POST" id="add-room" action="{{ route('rooms.store') }}" class="col-md-6 mx-auto">
    <div class="container">
        <div class="row p-5">
            @if($errors->any())
            <div class="alert-container mb-3">
                <div class="alert-header">
                </div>
                <div class="alert-body">
                    <ul>
                        @foreach($errors->all() as $errors)
                        <li>{{ $errors }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <h4>Add Room</h4>
            @csrf
            <div class="col-md-6 mb-3">
                <label for="" class="form-label text-muted">Room no.</label>
                <div class="input-group">
                    <input type="number" value="{{ old('room_no') }}" name="room_no" autocomplete="off" placeholder="Room no" class="form-control" />
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="" class="form-label text-muted">No. of Occupants</label>
                <div class="input-group">
                    <div class="d-flex align-items-center">
                        <div>

                            <input type="number" value="{{ old('min') }}" name="min" autocomplete="off" placeholder="Min." class="form-control" />

                        </div>
                        <span> - </span>
                        <div>

                            <input type="number" value="{{ old('max') }}" name="max" autocomplete="off" placeholder="Max." class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="custom-btn d-flex justify-content-center align-items-center"><i class="bx bx-save"></i>Save</button>
        </div>
    </div>
</form>
@endsection