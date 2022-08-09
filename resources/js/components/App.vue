<template>
    <div class="container mx-auto">
        <div class="min-w-full border rounded lg:grid lg:grid-cols-3 h-screen">
            <div class="border-r border-gray-300 lg:col-span-1">
                <div class="mx-3 my-3">
                    <div class="relative text-gray-600">
              <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     viewBox="0 0 24 24" class="w-6 h-6 text-gray-300">
                  <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
              </span>
                        <input type="search" class="block w-full py-2 pl-10 bg-gray-100 rounded outline-none"
                               name="search" v-model="searchTerm"
                               placeholder="Search" required/>
                    </div>
                </div>

                <ul class="overflow-auto h-full">
                    <div class="flex justify-between items-center">
                        <div class="flex justify-between gap-3">
                            <h2 class="my-2 mb-2 ml-2 text-lg text-gray-600">Groups</h2>
                            <button @click="createChatGroup"
                                    class="text-blue-600 font-bold text-2xl focus:outline-none">
                                +
                            </button>
                            <a href="https://www.github.com/rootcause0/" target="_blank">
                                <svg width="24" height="48" viewBox="0 0 1024 1024" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M8 0C3.58 0 0 3.58 0 8C0 11.54 2.29 14.53 5.47 15.59C5.87 15.66 6.02 15.42 6.02 15.21C6.02 15.02 6.01 14.39 6.01 13.72C4 14.09 3.48 13.23 3.32 12.78C3.23 12.55 2.84 11.84 2.5 11.65C2.22 11.5 1.82 11.13 2.49 11.12C3.12 11.11 3.57 11.7 3.72 11.94C4.44 13.15 5.59 12.81 6.05 12.6C6.12 12.08 6.33 11.73 6.56 11.53C4.78 11.33 2.92 10.64 2.92 7.58C2.92 6.71 3.23 5.99 3.74 5.43C3.66 5.23 3.38 4.41 3.82 3.31C3.82 3.31 4.49 3.1 6.02 4.13C6.66 3.95 7.34 3.86 8.02 3.86C8.7 3.86 9.38 3.95 10.02 4.13C11.55 3.09 12.22 3.31 12.22 3.31C12.66 4.41 12.38 5.23 12.3 5.43C12.81 5.99 13.12 6.7 13.12 7.58C13.12 10.65 11.25 11.33 9.47 11.53C9.76 11.78 10.01 12.26 10.01 13.01C10.01 14.08 10 14.94 10 15.21C10 15.42 10.15 15.67 10.55 15.59C13.71 14.53 16 11.53 16 8C16 3.58 12.42 0 8 0Z"
                                          transform="scale(64)" fill="#1B1F23"/>
                                </svg>
                            </a>
                        </div>
                        <span class="text-gray-500 text-sm pr-2">#user-{{ userId }}</span>
                    </div>
                    <li v-for="chatGroup in filterBySearch" :key="chatGroup.id" v-on:click="setChatGroup(chatGroup)">
                        <GroupCard :name="chatGroup.chatGroupName"></GroupCard>
                    </li>
                </ul>
            </div>
            <div class="hidden lg:col-span-2 lg:block" v-if="Object.keys(activeChatGroup).length > 0">
                <div class="w-full">
                    <div class="flex flex-row items-center p-3 border-b border-gray-300">
                        <span class="w-3 h-3 bg-green-600 rounded-full left-10 top-3"></span>
                        <span class="block ml-2 font-bold text-gray-600">{{ activeChatGroup.chatGroupName }}</span>
                    </div>
                    <div class="flex flex-col h-screen">
                        <div class="relative w-full p-6 overflow-y-auto h-5/6">
                            <ul v-for="message in activeChatGroup.messages" class="space-y-2">
                                <li v-if="message.hasOwnProperty('author')" class="flex justify-start">
                                    <div class="flex flex-col justify-between">
                                        <div class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow">
                                            <span class="block">{{ message.message }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500 px-4 py-2 italic">
                                            <span>~ {{ message.author }}</span>
                                        </div>
                                    </div>
                                </li>
                                <li v-else class="flex justify-end">
                                    <div class="flex flex-col justify-between">
                                        <div
                                            class="relative max-w-xl px-4 py-2 text-gray-700 bg-gray-100 rounded shadow">
                                            <span class="block">{{ message.message }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500 px-4 py-2 italic">

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="flex  items-centerjustify-between w-full p-3 border-t border-gray-300">
                            <input type="text" placeholder="Message" v-on:keyup.enter="sendMessage"
                                   class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700"
                                   name="message" id="message-box" required/>
                            <button v-on:click="sendMessage">
                                <svg class="w-5 h-5 text-gray-500 origin-center transform rotate-90"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GroupCard from "./GroupCard";

export default {
    components: {GroupCard},
    data() {
        return {
            chatGroupList: [],
            searchTerm: "",
            userId: "",
            activeChatGroup: {}
        }
    },
    computed: {
        filterBySearch() {
            return this.chatGroupList.filter(chatGroup => {
                return chatGroup.chatGroupName.toLowerCase().includes(this.searchTerm);
            });
        }
    },
    methods: {
        createChatGroup() {
            Swal.fire({
                title: 'Create Chat Group',
                html: `<input type="text" id="chat-group-name" name="chatGroupName" class="swal2-input" placeholder="Chat Group Name">`,
                confirmButtonText: 'Create',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    const self = this
                    const chatGroupName = Swal.getPopup().querySelector('#chat-group-name').value
                    let formData = new FormData()
                    formData.append('chatGroupName', chatGroupName)
                    await axios.post('chat-groups', formData)
                        .then(function (res) {
                            self.chatGroupList.push({
                                'chatGroupName': chatGroupName,
                                'chatGroupId': res.data.chatGroupId
                            })
                        })
                }
            })
        },
        sendMessage() {
            let message = document.getElementById('message-box').value
            if (message !== "") {
                let formData = new FormData()
                formData.append('message', message)
                formData.append('author', '#user-' + this.userId)
                formData.append('chatGroupId', this.activeChatGroup.chatGroupId)
                axios.post('send-message', formData)
                this.activeChatGroup.messages.push({
                    'message': message,
                })
                document.getElementById('message-box').value = ""
            }
        },

        setChatGroup(chatGroup) {
            if (this.activeChatGroup.chatGroupId !== chatGroup.chatGroupId) { // Invoke only if selected group is different from selected one
                window.Echo.leaveChannel('chat-group.' + this.activeChatGroup.chatGroupId) // The ChatGroupId here is previous id,the recent one (chatGroup argument) is not set yet

                // delete previous chatGroup properties
                Object.keys(this.activeChatGroup).forEach(key => {
                    delete this.activeChatGroup[key];
                })

                this.activeChatGroup = {
                    chatGroupName: chatGroup.chatGroupName,
                    chatGroupId: chatGroup.chatGroupId, // there goes the new chatGroupId assignment
                    messages: []
                }

                window.Echo.channel(`chat-group.${this.activeChatGroup.chatGroupId}`)
                    .listen('NewChatGroupMessage', (e) => {
                        this.activeChatGroup.messages.push({
                            'message': e.message,
                            'author': e.author
                        })
                    })
            }
        }

    },
    mounted() {
        axios.get('user-id')
            .then((response) => {
                this.userId = response.data.user_id
            })

        window.Echo.channel('global')
            .listen('ChatGroupCreated', (chatGroup) => {
                this.chatGroupList.push(chatGroup)
            })
    }
}
</script>
