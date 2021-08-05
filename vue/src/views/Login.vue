<template>
    <div class="container bg-light p-4">
        <h1 class="h2">Login</h1>
        <form @submit.prevent="Logar">

            <label class="form-group mt-2">
                Email
                <input class="form-control" placeholder="Email" type="email" v-model="usuario.email">
            </label>
            <label class="form-group mb-3 mt-2">
                Senha
                <input class="form-control" placeholder="Senha de acesso" type="password" v-model="usuario.senha">
            </label>
            <div>
                <button class="btn btn-primary ml-auto mr-auto">Logar</button>
            </div>
        </form>
    </div>
</template>

<script>
import $config from '../assets/config/config'

export default {
    data(){return {
        usuario:{
            email:"",
            senha:""
        },
        userKey:''
    }},
    methods:{
        Logar(){
            console.table([{usuario:this.usuario.email, senha:this.usuario.senha}])

            let $login = {
                "email":this.usuario.email,
                "pass":this.usuario.senha,
                "appKey":$config.appKey
            }
            let $options = {
                "method":"POST",
                "body":JSON.stringify($login)
            } 
            fetch($config.URLAPI+"/login", $options)
                .then(response=>response.json())
                .then(response=>{
                    /******verifica se foi retornado erro***/
                    if(response["error"]!==undefined){
                        throw new Error(response["error"])
                    }
                    return(response)
                })
                .then(response=>{
                    this.userKey = response
                })
                .catch(error=>alert(error))
        }
    },

    watch:{
        userKey(novoValor){
            novoValor.email = this.usuario.email
            localStorage.userKey = JSON.stringify(novoValor)
            if(this.$route.query.redirect){
                this.$router.push(this.$route.query.redirect)
            }else{
                this.$router.push('/')
            }
        }
    },
    mounted(){
        
        if(localStorage.userKey) this.userKey = JSON.parse ( localStorage.userKey )
        console.log(this);
        
    }
}
</script>