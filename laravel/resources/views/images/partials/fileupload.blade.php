<div class="form-group">
            <label for="">Image</label>

    <input type="file" name="image_path" id="image_path" class="form-control" value="{{$photo->image_path}}">

</div>

@if ($photo->image_path)
    <div class="form-group">
        <img src="{{asset($photo->image_path)}}" width="300" alt="{{$photo->name}}" title="{{$photo->name}}" />
    </div>
@endif