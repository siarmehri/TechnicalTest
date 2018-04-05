@extends('layout')

@section('title', 'Form')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <table>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email Address</th>
                    <th>Job Role</th>
                    @if(count($peoples) > 0)
                        <th>Delete</th>
                    @else
                        <th>Add New</th>
                    @endif

                </tr>
                @includeWhen($peoples->count() > 0, 'partials.existingRecords')
                @includeWhen($peoples->count() < 10, 'partials.createNewRecord')
            </table>
        </div>
    </div>
    <div class="row" id="errorRow">
        <div class="col-md-12 col-sm-12 text-danger"  id="errors">
        </div>
    </div>
</div>
@endsection
@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
@endsection

@section('js')
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <script>
        $(function () {
            var timeoutid;

           $('input[type="checkbox"]').change(function() {
               var checkedItem = $(this);
               deletePerson(checkedItem);
           });

            $('.addNew').click(function() {
                createNewPerson();
            });

            $('input[type="text"]').keyup(function(e) {

                var element = $(this);
                if((!element.hasClass('new'))){
                    var className = element.attr('class');
                    clearTimeout(timeoutid);
                    timeoutid = setTimeout(function () {
                        updatePerson(className);
                    }, 1000);
                }

            });
        });

        function createNewPerson() {
            var inputKeyValueString='{';
            $(".new").each(function () {
                var element = $(this);
                inputKeyValueString += '"'+element.prop('name')+'":"'+element.val()+'",';
            });
            inputKeyValueString = inputKeyValueString.substring(0, inputKeyValueString.length - 1);
            inputKeyValueString+="}";

            var data = JSON.parse(inputKeyValueString);
            ajaxCall('POST', 'people',data);
        }


        function updatePerson(className) {
            var inputKeyValueString='{';
            $("."+className).each(function () {
                var element = $(this);
                inputKeyValueString += '"'+element.prop('name')+'":"'+element.val()+'",';
            });
            inputKeyValueString = inputKeyValueString.substring(0, inputKeyValueString.length - 1);
            inputKeyValueString+="}";

            var data = JSON.parse(inputKeyValueString);
            ajaxCall('PUT', 'people/'+className,data);
        }

        function deletePerson(checkedItem) {
            if(checkedItem.prop('checked')){
                $.confirm({
                    title: 'Hiya!',
                    content: 'Do you really want to delete this record?',
                    draggable: true,
                    type: 'dark',
                    columnClass: 'medium',
                    buttons: {
                        confirm: {
                            btnClass: 'btn-red',
                            action: function(){
                                ajaxCall('DELETE' , 'people/'+checkedItem.prop('id'),{},'Hi');
                            }
                        },
                        cancel: {
                            btnClass: 'btn-blue',
                            action: function(){
                                checkedItem.prop('checked', false);
                            }
                        },
                    }
                });
            }
        }


        function ajaxCall(type, url, formData){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: url,
                data: formData,
                type: type,
                error: function() {
                    $.alert('error');
                },
                success: function(data) {
                    if(data.message){
                        $.confirm({
                            title: 'Message',
                            content: data.message,
                            type: 'dark',
                            draggable: true,
                            columnClass: 'medium',
                            buttons: {
                                Ok: function () {
                                    location.reload();
                                },
                            }
                        });
                    } else if(data.errors){
                        var errors = data.errors;
                        errorHtml = '<ul>';
                        $.each(errors, function (k, v) {
                            if($.isArray(v)){
                                $.each(v, function (i, el) {
                                    errorHtml += '<li>'+el+'</li>';
                                });
                            } else{
                                errorHtml += '<li>'+v+'</li>'
                            }
                        });
                        errorHtml += '</ul>';
                        $('#errorRow').removeClass('hidden');
                        $('#errors').empty().html(errorHtml);
                    }
                }
            });
        }

    </script>
@endsection