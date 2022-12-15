@extends('admin.manage_room')

@section('room_images')

<style>
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus {
        border: 1px solid gray;
        outline: 0 none;
        box-shadow: none;
    }

    input[type="file"] {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-5 col-lg-5  mb-3">
        <form method="POST" id="room-upload" action="{{ route('room_images.upload',$rooms[0]->room_no)}}" enctype="multipart/form-data" class="mt-5 w-50 mx-auto ">
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

            @if(Session::has('success'))
            <script>
                $(document).ready(function() {
                    Swal.fire(
                        'Success',
                        "{{ Session::get('success')}}",
                        'success'
                    )
                })
            </script>
            @endif

            @if(Session::has('error'))
            <script>
                $(document).ready(function() {
                    Swal.fire(
                        'Failed to upload',
                        "{{ Session::get('error')}}",
                        'error'
                    )
                })
            </script>
            @endif

            @csrf
            <div class="justify-content-center">
                <label for="file-input" class="my-file">
                    <i class="bx bx-cloud-upload fs-1 "></i>
                    Upload images here.
                </label>
                <input type="hidden" value="{{ $rooms[0]->room_no }}" name="room_no" />
                <input multiple accept="image/png, image/jpeg, image/gif, image/jpg" id="file-input" name="image[]" type="file" />
            </div>
        </form>
        <div class="d-flex justify-content-center mt-3 flex-column text-center">
            <h4>Upload 4 images for Room no.{{ $rooms[0]->room_no}}</h4>
            <p>You can upload multiple images at the same time. accepted format(.png, .jpeg, .jpg, .gif,).</p>
            @if(count($images) > 0)
            <button id="btn-delete-images" class="mt-4 mb-4 btn btn-sm btn-danger mx-auto">Delete all images</button>
            <script>
                $(document).ready(function() {

                    $('#btn-delete-images').on('click', function() {
                        Swal.fire({
                            type: 'question',
                            title: 'Are you sure?',
                            text: 'Do you want to delete images for Room no' + "{{ $rooms[0]->room_no}}",
                            showCancelButton: true,
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.value) {
                                window.location.replace("{{ route('rooms.delete_all',$rooms[0]->room_no) }}")
                            }
                        })
                    })
                })
            </script>
            @endif
        </div>
    </div>

    <div class="col-md-7 col-lg-7">
        <div class="row">
            @if(count($images) > 0)
            @foreach($images as $image)
            <div class="col-sm-6 mb-4 ">
                <div class="img-container">
                    <img class="image-del" data-id="{{ $image->id }}" src="{{ asset($image->image)}}" height="200px" width="100%" />
                </div>
            </div>
            @endforeach

            <script>
                $(document).ready(function() {

                    $('.img-container').on('click', 'img', function() {
                        var img_id = $(this)[0].dataset.id
                        console.log(img_id)
                        Swal.fire({
                            type: 'question',
                            title: 'Are you sure?',
                            text: 'Do you want to delete this image?',
                            showCancelButton: true,
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.value) {
                                var url = "{{ route('rooms.image_delete',':id') }}"
                                window.location.replace(url.replace(':id', img_id))
                            }
                        })
                    })
                })
            </script>
            @else
            <p class="text-center">No images.</p>
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#file-input').on('change', function() {
            $('#room-upload').submit()
        })
    })
</script>

@endsection