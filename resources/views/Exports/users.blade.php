<table>
    <thead style="background-color: #0b94ea">
    <tr>
        <th>Registered Name</th>
        <th>Profile First Name</th>
        <th>Profile Last Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Registered At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ !empty($user->profile)?$user->profile->first_name:"N/A" }}</td>
            <td>{{ !empty($user->profile)?$user->profile->last_name:"N/A" }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ !empty($user->profile)?$user->profile->address:"N/A" }}</td>
            <td>{{ $user->created_at->format('y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
