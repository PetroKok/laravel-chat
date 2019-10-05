$(document).ready(function () {

    //test notify
    // window.Echo.private('App.User.' + document.getElementById('auth_id').value)
    //     .notification((e) => {
    //         console.log(e);
    //     });


    $(document).on('keydown', '#message', function () {
        typingForWhisper();
    });

    document.getElementById('send').addEventListener("click", sendMessage);

    setEventListenerForClasses(setUser, document.getElementsByClassName('choose-user'));
    setEventListenerForClasses(createConversation, document.getElementsByClassName('create-conversation'));

    function openPrivateChannel(channel) {
        let timer;
        let old_channel = document.getElementById('conversation_id').value;
        if (old_channel === channel) {
            return false;
        }
        window.Echo.leave('private.' + old_channel);


/*        window.Echo.private('private.' + channel)
            .listenForWhisper('typing', (e) => {
                document.getElementById('whisper').innerText = e.user;

                clearTimeout(timer);

                timer = setTimeout(function () {
                    document.getElementById('whisper').innerText = '';
                }, 1000);
            })
            .listen('.private-listen', (notification) => {
                insertMessage(notification.data);
            });*/

        window.Echo.join('private.'+ channel)
            .here((e)=>{
                console.log('here: ', e);
            })
            .joining((e)=>{
                console.log('joining: ', e);
            })
            .leaving((e)=>{
                console.log('leaving: ', e);
            })
            .listenForWhisper('typing', (e) => {
                document.getElementById('whisper').innerText = e.user;

                clearTimeout(timer);

                timer = setTimeout(function () {
                    document.getElementById('whisper').innerText = '';
                }, 1000);
            })
            .listen('.private-listen', (notification) => {
                insertMessage(notification.data);
            });

        getMessageByConversation(channel);
    }

    function sendMessage() {
        let link = document.getElementById('send-url').value;
        if (getMessage() === '') return false;
        window.axios
            .post(link, {
                text: getMessage(),
                conversation_id: getConversation()
            })
            .then(res => {
                insertMessage(res.data.data);
                document.getElementById('message').value = "";
            });
    }

    function getMessageByConversation(conversation_id) {
        const link = document.getElementById('get-mess-url').value;

        window.axios.post(link, {
            conversation_id: conversation_id
        })
            .then(res => {
                const messages = res.data.data;
                clearMessageChat();
                messages.forEach(function (message) {
                    insertMessage(message)
                })
            });

    }

    function insertMessage(data) {
        let li = document.createElement('li');
        li.innerText = data.user.name + ": " + data.text;
        document.getElementById('chat').append(li);
        document.getElementById('message').value = '';
    }

    function getMessage() {
        return document.getElementById('message').value;
    }

    function getConversation() {
        return document.getElementById('conversation_id').value;
    }

    function setUser() {
        openPrivateChannel(this.dataset.id);
        document.getElementById('user-name').innerText = this.dataset.name;
        document.getElementById('conversation_id').value = this.dataset.id;
    }

    function createConversation(e) {
        e.preventDefault();
        window.axios.post(this.dataset.href)
            .then(res => console.log("Created or Got conversation with name: " + res.data.name))
    }

    function clearMessageChat() {
        document.getElementById('chat').innerHTML = '';
    }

    function typingForWhisper() {
        const channel = document.getElementById('conversation_id').value;

        setTimeout(() => {
            window.Echo.join('private.' + channel)
                .whisper('typing', {
                    user: 'Guest is typing',
                    typing: true
                })
        }, 300);
    }
});
