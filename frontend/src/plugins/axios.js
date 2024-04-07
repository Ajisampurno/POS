import axios from "axios";
//import router from "@/router"
//import { useUserStore } from '@/stores/user';
//const request = axios.create({
//    baseURL: 'http://127.0.0.1:8000/api',
//  })

  
  axios.interceptors.request.use((config)=>{
    //const store = useUserStore()
    //let tokenAuth='Bearer '+store.token
    //config.headers["Authorization"]=tokenAuth
    return config
})

axios.interceptors.response.use(response=>{
    //console.log("sukses dari plugins",response.data);
    //return Promise.resolve(response.data);
    return response
},async error=>{
    console.log("error dari plugins",error);
    //if(error.response.status==401){
    //    const store = useUserStore()
    //    store.$reset();
    //    router.push("/login"); 
    //}else{
        return Promise.reject(error.response)
    //}
})


export default axios