@extends('layout')

@section('title', 'Form')

@section('content')
    <table>
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email Address</th>
            <th>Job Role</th>
            <th>Delete</th>
        </tr>
        @includeWhen($peoples->count() > 0, 'partials.existingRecords')
        @includeWhen($peoples->count() < 10, 'partials.createNewRecord')

    </table>
@endsection