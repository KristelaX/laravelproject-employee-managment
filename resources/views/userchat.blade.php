@extends('layouts.userLayout')
@section('content')
    <head>
        <title>Chats</title>
        <style>
            #chat-window {
                background-color: #eee;
                width: 500px;
                height: 500px;
                border: 1px dotted black;
                overflow: scroll;
            }
        </style>
    </head>
    <body>

    <div class="col-lg-4 col-lg-offset-4">
        <h1 id="greeting">chat group</h1>

        <div id="chat-window" class="col-lg-12">
            @foreach($mesazhe as $mesazhe)
                <b> {{ $mesazhe->sender }}</b> /  {{ $mesazhe->created_at }} <br>{{ $mesazhe->msg }} <br><br>
            @endforeach
        </div>
        <div class="col-lg-12">
            <div id="typingStatus" class="col-lg-12" style="padding: 15px"></div>
            <input type="text" id="text" class="form-control col-lg-12" autofocus="" >
            @foreach($chatuser as $chatuser)
                <input type="hidden" id="user_id" value="{{ $chatuser->id }}" >
                <input type="hidden" id="user_name" value="{{ $chatuser->name }}" >
            @endforeach
            <button  class="btn btn-primary" onclick="sendMessage()">
                {{ __('Send') }}
            </button>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            pullData();
        });

        function pullData()
        {
            retrieveChatMessages();
            setTimeout(pullData,3000);
        }
        function retrieveChatMessages()
        {
            var user_id = $('#user_id').val();
            $.ajax({
                url: "{{ url('chat/messages') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method:'POST',
                dataType: "JSON",
                data:{  _token:"{{ csrf_token() }}",
                    id: user_id,},
                success:function(data)
                {
                    //if(data.length>0) {
                    $('#chat-window').append('<br><b>'+data.sender+"</b>   /" +data.created_at+'<br>'+data.msg);
                    //}
                }
            });
        }

        function sendMessage() {
            var user_id = $('#user_id').val();
            var name1= $('#user_name').val();
            var text = $('#text').val();

            if (text.length > 0) {
                $.ajax({
                    url: "{{ url('sent/chat/messages') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    dataType: "JSON",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: user_id,
                        msg: text,
                        name: name1,
                    },

                });
                $('#text').val(' ');
                $('#chat-window').append('<br><b>' + name1+'</b><br>' +text+'<br>');
            }
        }

    </script>
    @endsection