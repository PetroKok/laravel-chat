@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach($users as $user)
                        <div class="card-header">{{$user->name}} <a class="create-conversation"
                                                                    data-href="{{route('create.conversation', $user->id)}}">Create
                                conversation</a></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function () {

            setEventListenerForClasses(createConvers, document.getElementsByClassName('create-conversation'));

            function createConvers(e) {
                e.preventDefault();
                let link = this.dataset.href;
                window.axios.post(link)
                    .then(res => {
                        // window.location = res.route;
                    });
            }
        });
    </script>
@endpush
