@extends('layout')

@section('title', 'Form')

@section('content')
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
           $('input[type="checkbox"]').change(function() {
               var checkedItem = $(this);
               deletePerson(checkedItem);
           });

            $('#addNew').click(function() {
                createNewPerson();
            });



        });

        function createNewPerson() {
            var inputKeyValueString='{';
            $("input#new").each(function () {
                var element = $(this);
                inputKeyValueString += '"'+element.prop('name')+'":"'+element.val()+'",';
            });
            inputKeyValueString = inputKeyValueString.substring(0, inputKeyValueString.length - 1);
            inputKeyValueString+="}";

            var data = JSON.parse(inputKeyValueString);
            ajaxCall('POST', 'people',data);


        }


        function updatePerson() {

        }

        function deletePerson(checkedItem) {
            if(checkedItem.prop('checked')){
                $.confirm({
                    title: 'Hiya!',
                    content: 'Do you really want to delete this record?',
                    draggable: true,
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
                error: function() {
                    $.alert('error');
                },
                success: function(data) {
                    $.confirm({
                        title: 'Message',
                        content: data.message,
                        buttons: {
                            Ok: function () {
                                location.reload();
                            },
                        }
                    });
                },
                type: type,
            });
        }

    </script>
@endsection