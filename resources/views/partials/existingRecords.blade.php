@foreach($peoples as $people)
    <tr>
        <td><input type="text" name="firstname" value="{{$people->firstname}}" /></td>
        <td><input type="text" name="lastname" value="{{$people->lastname}}" /></td>
        <td><input type="text" name="email" value="{{$people->email}}" /></td>
        <td><input type="text" name="job_role" value="{{$people->job_role}}" /></td>
        <td><input type="checkbox" id="{{$people->id}}" value="1" /></td>
    </tr>
@endforeach
