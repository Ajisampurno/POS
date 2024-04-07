
import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useUserStore = defineStore('user', () => {
  const user = ref(null)
  const token = ref("")
  function login(user_data,data_token) {
    console.log("USER Is",user_data)
    user.value=user_data;
    token.value=data_token;
  }
  function logout() {
    user.value=null;
    token.value="";
  }

  return { user,token,login,logout }
})
