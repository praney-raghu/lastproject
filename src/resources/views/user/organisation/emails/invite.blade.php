You have been invited to join organisation {{$organisation->name}}.<br>
Click here to join: <a href="{{route('organisation.accept_invite', $invite->accept_token)}}">{{route('organisation.accept_invite', $invite->accept_token)}}</a>
