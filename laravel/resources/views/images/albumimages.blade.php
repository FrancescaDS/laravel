@extends('templates.default')
@section('content')
    <h1>Images for {{$album->album_name}}</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif
    <table class="table table-striped">
    <tr>
        <th>CREATED DATE</th>
        <th>TITLE</th>
        <th>ALBUM</th>
        <th colspan="2">THUMBNAIL</th>
    </tr>
    @forelse($images as $image)
        <tr>

            <td>{{$image->created_at->format('d/m/Y H:m')}}</td>
            <td>{{$image->name}}</td>
            <td><a href="{{route('album.edit',$image->album_id)}}">{{$album->album_name}}</a></td>
            <td><img width="120" src="{{asset($image->image_path)}}" /></td>
            <td>
                <a title="Update photo" href="{{route('photos.edit',$image->id)}}" class="btn btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                <a title="Delete photo" href="{{route('photos.destroy',$image->id)}}" class="btn btn-sm btn-danger"><span class="fa fa-minus"></span></a>
            </td>
        </tr>
    @empty
        <tr><td colspan="6">
            No images found
        </td></tr>
    @endforelse

    <tr>
        <td colspan="6" class="text-center">
            <div class="row">
                <div class="col-md-8 push-2">
                    {{$images->links('vendor.pagination.bootstrap-4')}}
                </div>
            </div>
        </td></tr>

</table>
@endsection
@section('footer')
    @parent
    <script>
        $('document').ready(function () {
            //$('div.alert').fadeOut(5000);
            $('table').on('click', 'a.btn-danger',function (ele) {
                ele.preventDefault();
                var urlImg = $(this).attr('href');
                var tr = ele.target.parentNode.parentNode;
                $.ajax(
                    urlImg,
                    {
                        method: 'DELETE',
                        data : {
                            '_token' : '{{csrf_token()}}'
                        },
                        complete : function (resp) {
                            console.log(resp);
                            //alert(resp.responseText);
                            if(resp.responseText == 1){
                                tr.parentNode.removeChild(tr);
                            } else {
                                alert('Problem contacting server');
                            }
                        }
                    }
                )
            });
        });
    </script>
@endsection