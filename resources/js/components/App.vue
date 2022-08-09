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
