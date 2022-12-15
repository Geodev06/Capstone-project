@extends('admin.manage_establishments')

@section('establishment_upload_images')
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
        <form method="POST" id="establishment-upload" enctype="multipart/form-data" class="mt-5 w-50 mx-auto " action="{{ route('establishment.store_image', $establishments[0]->id) }}">
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

            @csrf
            <div class="justify-content-center">
                <label for="file-input" class="my-file">
                    <i class="bx bx-cloud-upload fs-1 "></i>
                    Upload images here.
                </label>
                <input multiple accept="image/png, image/jpeg, image/gif, image/jpg" id="file-input" name="image[]" type="file" />
            </div>
        </form>
        <div class="d-flex justify-content-center mt-3 flex-column text-center">
            <h4>Upload images for {{ $establishments[0]->establishment_name}}</h4>
            <p>You can upload multiple images at the same time. accepted format(.png, .jpeg, .jpg, .gif,).</p>
            @if(count($images) > 0)
            <button id="btn-delete-images" class="mt-4 mb-4 btn btn-sm btn-danger mx-auto">Delete all images</button>
            <script>
                $(document).ready(function() {

                    $('#btn-delete-images').on('click', function() {
                        Swal.fire({
                            type: 'question',
                            title: 'Are you sure?',
                            text: 'Do you want to delete images for ' + "{{ $establishments[0]->establishment_name }}",
                            showCancelButton: true,
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.value) {
                                window.location.replace("{{ route('establishment.delete_images',$establishments[0]->id) }}")
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
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4 ">
                <div class="h-100">
                    <div class="img-container d-flex justify-content-between">
                        <img class="image-del " data-id="{{ $image->id }}" src="{{ asset($image->image)}}" alt="{{ asset($image->image)}} " height="120px" width="100%" />
                    </div>
                </div>
            </div>
            @endforeach

            <script>
                $(document).ready(function() {

                    $('.img-container').on('click', '.image-del', function() {

                        var img_id = $(this)[0].dataset.id
                        Swal.fire({
                            type: 'question',
                            title: 'Are you sure?',
                            text: 'Do you want to delete this image?',
                            showCancelButton: true,
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.value) {
                                var url = "{{ route('establishment.delete_image',':id') }}"
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

            $('#establishment-upload').submit()
        })
    })
</script>

@endsection