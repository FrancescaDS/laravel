<div class="form-group">
            <label for="">Thumbnail</label>
            <input type="file"  name="album_thumb" id="album_thumb" class="form-control">
        </div>

@if ($album->album_thumb)
    <div class="form-group">
        <img src="{{asset($album->path)}}" width="300" alt="{{$album->album_name}}" title="{{$album->album_name}}" />
    </div>
@endif