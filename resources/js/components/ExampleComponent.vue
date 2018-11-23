<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header"><h5>Simple Public Chat <small>({{users - 1}} users online)</small></h5></div>

                    <div class="form-group">
                        <div class="form-group p-2">
                            <label for="nickname">Your nickname:</label>
                            <input type="text" name="nickname" v-model="nickname" class="chat-input nickname" required>
                        </div>
                        <textarea rows="12" readonly="" class="form-control">{{dataMessages.join('\n')}}</textarea>
                        
                        <div class="p-2 message_block">
                        <input type="text" v-model="message" placeholder="Your message" required class="chat-input">
                        <button @click="sendMessage" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
                <div>{{ error }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                dataMessages: [],
                message: "",
                nickname: "",
                users: "",
                error: ""
            }
        },
        mounted() {
            var socket = io.connect('http://localhost:3000');
            socket.on('userCount', function (data) {
                this.users = data.userCount;
            }.bind(this));
            socket.on("news-action:App\\Events\\TestEvent", function(data){
                this.dataMessages.push(data.nickname + ' : ' + data.message);
            }.bind(this));

        },
        methods: {
            sendMessage: function() {
                if (this.message === "" || this.nickname === "") {
                    this.error = 'Type-in your nickname and message then click \'Send\'';
                } else {
                    axios({
                        method: 'get',
                        url: '/chat/send-message',
                        params: {
                            message: this.message,
                            nickname: this.nickname,
                        }
                    })
                    .then((response) => {
                        this.message = "";
                    });
                }
            }
        }
    }
</script>
