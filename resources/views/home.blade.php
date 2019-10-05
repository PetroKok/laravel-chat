@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                @foreach($conversations as $conversation)
                    <div class="card choose-user" data-id="{{$conversation->id}}" data-name="{{$conversation->name}}">
                        <div class="card-header" data-id="{{$conversation->id}}">{{$conversation->name}}</div>
                    </div>
                @endforeach
                <hr>
                @foreach($users as $user)
                    <div class="card">
                        <div class="card-header">{{$user->name}}
                            <a
                                data-href="{{route('create.conversation', $user->id)}}"
                                data-id="{{$user->id}}"
                                data-name="{{$user->name}}"
                                class="create-conversation"
                                href="#">
                                Create conversation
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header" id="user-name">Choose conversation</div>
                    <input type="hidden" id="send-url" value="{{route('send.message')}}">
                    <input type="hidden" id="get-mess-url" value="{{route('message.index')}}">
                    <input type="hidden" id="conversation_id">
                    <input type="hidden" id="auth_id" value="{{auth()->id()}}">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div>
                            <div style="height: 150px; overflow: scroll; overflow-x: hidden">
                                <ul id="chat">
                                    <li> You are logged in!</li>
                                </ul>
                            </div>

                            <input type="text" id="message">
                            <button id="send">Send</button>
                            <p id="whisper"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
