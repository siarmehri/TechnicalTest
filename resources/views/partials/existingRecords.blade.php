@foreach($peoples as $people)
    <tr>
        <td><input type="text" class="{{$people->id}}" maxlength="50" name="firstname" value="{{$people->firstname}}" /></td>
        <td><input type="text" class="{{$people->id}}" maxlength="50" name="lastname" value="{{$people->lastname}}" /></td>
        <td><input type="text" class="{{$people->id}}" maxlength="50" name="email" value="{{$people->email}}" /></td>
        <td><input type="text" class="{{$people->id}}" maxlength="50" name="job_role" value="{{$people->job_role}}" /></td>
        <td><input type="checkbox" id="{{$people->id}}"/></td>
    </tr>
@endforeach
