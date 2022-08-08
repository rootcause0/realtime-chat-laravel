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
                    <li v-for="chatGroup in filterBySearch" :key="chatGroup.id" v-on:click="setChatGroup(chatGroup.chatGroupId)">
                        <GroupCard :name="chatGroup.chatGroupName" :online-count="12"></GroupCard>
                    </li>
                </ul>
            </div>
            <div class="hidden lg:col-span-2 lg:block">
                <div class="w-full">
                    <div class="relative flex items-center p-3 border-b border-gray-300">
                        <img class="object-cover w-10 h-10 rounded-full"
                             src="https://cdn.pixabay.com/photo/2018/01/15/07/51/woman-3083383__340.jpg"
                             alt="username"/>
                        <span class="block ml-2 font-bold text-gray-600">Emma</span>
                        <span class="absolute w-3 h-3 bg-green-600 rounded-full left-10 top-3">
              </span>
                    </div>
                    <div class="flex flex-col h-screen">
                        <div class="relative w-full p-6 overflow-y-auto h-5/6">
                            <ul class="space-y-2">
                                <li class="flex justify-start">
                                    <div class="flex flex-col justify-between">
                                        <div class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow">
                                            <span class="block">Hi</span>
                                        </div>
                                        <div class="text-sm text-gray-500 px-4 py-2 italic">
                                            <span>~ #user-66064</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex justify-end">
                                    <div class="flex flex-col justify-between">
                                        <div
                                            class="relative max-w-xl px-4 py-2 text-gray-700 bg-gray-100 rounded shadow">
                                            <span class="block">Hi</span>
                                        </div>
                                        <div class="text-sm text-gray-500 px-4 py-2 italic">
                                            <span>~ #user-66064</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex justify-end">
                                    <div class="flex flex-col justify-between">
                                        <div
                                            class="relative max-w-xl px-4 py-2 text-gray-700 bg-gray-100 rounded shadow">
                                            <span class="block">Hi</span>
                                        </div>
                                        <div class="text-sm text-gray-500 px-4 py-2 italic">
                                            <span>~ #user-66064</span>
                                        </div>
                                    </div>
                                </li>
                                <li class="flex justify-start">
                                    <div class="flex flex-col justify-between">
                                        <div class="relative max-w-xl px-4 py-2 text-gray-700 rounded shadow">
                                            <span class="block">Hi</span>
                                        </div>
                                        <div class="text-sm text-gray-500 px-4 py-2 italic">
                                            <span>~ #user-66064</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="flex  items-centerjustify-between w-full p-3 border-t border-gray-300">
                            <input type="text" placeholder="Message"
                                   class="block w-full py-2 pl-4 mx-3 bg-gray-100 rounded-full outline-none focus:text-gray-700"
                                   name="message" required/>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                </svg>
                            </button>
                            <button type="submit">
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
            userId: ""
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
                    const chatGroupName = Swal.getPopup().querySelector('#chat-group-name').value
                    let formData = new FormData()
                    formData.append('chatGroupName', chatGroupName)
                    await axios.post('chat-groups', formData)
                }
            })
        },
        setChatGroup(chatGroupId) {
            console.log(chatGroupId)
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
