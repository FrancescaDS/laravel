<div class="row">
<div class="col-md-10 mt-2">
    <form id="manageCategoryForm" action="{{$category->category_name?route('categories.update', $category->id): route('categories.store')}}" method="POST"  class="form-inline">
    {{csrf_field()}}
    {{$category->category_name? method_field('PATCH'):''}}
    <div class="form-group">

        <input value="{{$category->category_name}}" required name="category_name" id="category_name" class="form-control">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" title="Save category"><span class="fa fa-save"></span></button>
    </div>
</form>
</div>
<div class="col-md-2">
@if($category->category_name)
    <form method="post" action="{{route('categories.destroy',$category->id)}}" class="form-inline">
        {{method_field('DELETE')}}
        {{csrf_field()}}
        <button class="btn btn-danger" title="Delete category"><span class="fa fa-minus"></span></button>
    </form>
@endif
</div>
</div>