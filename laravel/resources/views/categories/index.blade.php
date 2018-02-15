@extends('templates.default')

@section('content')
    @include('partials.inputerrors')
    <div class="row">
    <div class="col-8">

        <table class="table table-striped" id="categoryList">
            <tr>
                <th>ID</th>
                <th>Category name</th>
                <th>Created date</th>
                <th>Number of albums</th>
                <th>&nbsp;</th>
            </tr>
            @forelse($categories as $categoryI)
                <tr id="tr-{{$categoryI->id}}">
                    <td>{{$categoryI->id}}</td>
                    <td id="catid-{{$categoryI->id}}">{{$categoryI->category_name}}</td>
                    <td>{{$categoryI->created_at->format('d/m/Y')}}</td>
                    <td>{{$categoryI->albums_count}}</td>
                    <td>
                        <form method="post" action="{{route('categories.destroy',$categoryI->id)}}" class="form-inline">
                            {{method_field('DELETE')}}
                            {{csrf_field()}}
                            <button id="btnDelete-{{$categoryI->id}}" class="btn btn-danger" title="Delete category"><span class="fa fa-minus"></span></button>&nbsp;
                            <a id="upd-{{$categoryI->id}}" href="{{route('categories.edit', $categoryI->id)}}" class="btn btn-primary" title="Update categpry"><span class="fa fa-pencil"></span></a>
                        </form>

                    </td>
                </tr>
            @empty
            <tfoot>
            <tr><td colspan="5">No categories</td></tr>
            </tfoot>
            @endforelse

        </table>

        <div class="row">
        <div class="col-md-8 push-2">{{$categories->links('vendor.pagination.bootstrap-4')}}</div>
        </div>

    </div>

        <div class="col-4">
            <h2>Add new category</h2>
            @include('categories.categoryform')
        </div>

    </div>
@endsection
@section('footer')
    @parent
    <script>
        $('document').ready(function(){

            //Listener per Bottone Delete
            $('form .btn-danger').on('click', function(evt){
                //blocca l'azione naturale della chiamata al form
                evt.preventDefault();
                //this e' il pulsante
                var f = this.parentNode; //parent e' il form
                var urlCategory = f.action;
                var categoryId = this.id.replace('btnDelete-','')*1;
                var trId = 'tr-'+categoryId;
                $.ajax(
                    urlCategory,
                    {
                        method : 'DELETE',
                        data : {
                            '_token' : Laravel.csrfToken
                        },
                        complete : function (resp) {
                            var response = JSON.parse(resp.responseText);
                            alert(response.message);
                            $('#'+trId).remove().fadeOut();
                            /*if(response.success){
                                $('#'+trId).remove().fadeOut();
                            } else {
                                alert('Problem contacting server')
                            }*/

                        }
                    }
                );
                return false;
            });


            //Listener per Bottone Add Category
            $('#manageCategoryForm .btn-primary').on('click', function(evt){
                //blocca l'azione naturale della chiamata al form
                evt.preventDefault();
                //f e' il form a destra
                var f = $('#manageCategoryForm');
                //serialize prende tutti i dati del form
                var data = f.serialize();
                //la url e' un attributo del form f
                var urlCategory = f.attr('action');
                $.ajax(
                    urlCategory,
                    {
                        method : 'POST',
                        data : data,
                        complete : function (resp) {
                            var response = JSON.parse(resp.responseText);
                            alert(response.message);
                            f[0].category_name.value = '';
                            f[0].reset();
                            /*if(response.success){
                                f[0].category_name.value = '';
                                f[0].reset();
                            } else {
                                alert('Problem contacting server');
                            }*/
                        }
                    }
                );
            });


            //Listener per Bottone Update
            $('#categoryList a.btn-primary').on('click',function(evt){
                //blocca l'azione naturale della chiamata al form
                evt.preventDefault();
                var categoryId = this.id.replace('upd-','')*1;

                var catRow = $('#tr-'+categoryId);
                $('#categoryList tr').css('border', '0px');
                catRow.css('border', '1px solid red');

                var tdId = 'catid-'+categoryId;

                var tdCat = $('#catid-'+categoryId);
                var categoryName = tdCat.text();

                var urlUpdate  =this.href.replace('/edit','');

                //f e' il form a destra
                var f = $('#manageCategoryForm');
                f.attr('action', urlUpdate);

                //accedo agli elementi del form con f[0].nomeelemento
                f[0].category_name.value = categoryName;
                f[0].category_name.addEventListener('keyup', function(){
                    //console.log(tdCat);
                    //alert(tdId);
                    document.getElementById(tdId).innerHTML = f[0].category_name.value
                    //tdCat.html(f[0].category_name.value);
                });

                //creo un campo in piu' nel form a dx per simulare il metodo PATCH
                var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = '_method';
                    input.value = 'PATCH';
                    f[0].appendChild(input);

            });


        });
    </script>
@endsection