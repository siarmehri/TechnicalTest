@foreach($peoples as $people)
    <tr>
        <td><input type="text" id="{{$people->id}}" name="firstname" value="{{$people->firstname}}" /></td>
        <td><input type="text" id="{{$people->id}}" name="lastname" value="{{$people->lastname}}" /></td>
        <td><input type="text" id="{{$people->id}}" name="email" value="{{$people->email}}" /></td>
        <td><input type="text" id="{{$people->id}}" name="job_role" value="{{$people->job_role}}" /></td>
        <td><input type="checkbox" id="{{$people->id}}"/></td>
    </tr>
@endforeach
