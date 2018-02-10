@extends('templates.default')
@section('content')
    <h1>ALBUMS</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif
    <form>
        <input type="hidden" id="_token" id="_token" value="{{csrf_token()}}">
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Album name</th>
                <th>Thumb</th>
                <th>Creator</th>
                <th>Created date</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
           @foreach($albums as $album)
                <tr>
                    <td>({{$album->id}}) {{$album->album_name}}</td>
                    <td>
                        @if ($album->album_thumb)
                            <img src="{{asset($album->path)}}" width="120" alt="{{$album->album_name}}" title="{{$album->album_name}}" />
                        @endif
                        @if ($album->photos_count)
                            <a href="/albums/{{$album->id}}/images" class="btn btn-primary">VIEW IMAGES ({{$album->photos_count}})</a>
                        @endif
                    </td>
                    <td>{{$album->created_at}}</td>
                    <td>
                        <a href="{{route('photos.create')}}?album_id={{$album->id}}" class="btn btn-primary">NEW IMAGE</a>

                                <a href="{{route('album.edit', $album->id)}}" class="btn btn-primary">UPDATE</a>
                            <a href="{{route('album.delete', $album->id)}}" class="btn btn-danger">DELETE</a>

                    </td>
                </tr>
            @endforeach
                <tr>
                    <td class="row" colspan="5">
                        <div class="col-md-8 push-2">
                            {{$albums->links('vendor.pagination.bootstrap-4')}}
                        </div>
                    </td>
                </tr>

        </table>
    </form>
@endsection
@section('footer')
    @parent
    <script>
        $('document').ready(function(){
            $('div.alert').fadeOut(5000);

            $('ul').on('click', 'a.btn-danger', function(ele){
                ele.preventDefault();
                //alert(ele.target.href);
                //$(this).attr('href')
                var urlAlbum = $(this).attr('href');
                //alert(urlAlbum);
                var li = ele.target.parentNode.parentNode.parentNode;
                $.ajax(
                    urlAlbum,
                    {
                        method : 'DELETE',
                        data : {
                            '_token' : $('#_token').val()
                        },
                        complete : function (resp) {
                            console.log(resp);
                            if (resp.responseText == 1){
                                li.parentNode.removeChild(li);
                                //$(li).remove();
                            }else{
                                alert('Problem contacting server');
                            }
                        }
                    }
                )
            })
        })
    </script>
@endsection