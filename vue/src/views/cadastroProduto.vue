<template>
    <div>
        <div v-if="logado">
            <FormCadastroProd/>
        </div>
        <div v-else>
            {{$router.push('/login')}}
        </div>
        
    </div>
    
</template>
<script>
import FormCadastroProd from '../components/FormCadastroProduto.vue';
import estouLogado from '../components/js/etouLogado.js';
import login from '../assets/js/login'

export default {
    data(){
        return{
            logado:estouLogado()
        }
    },
    name:"FormCadastroProduto",
    components:{
        FormCadastroProd,
    },
    mounted(){
        if(!login.logado()){
            this.$router.push("/login?redirect="+this.$route.path);
            // console.log(this.$route);
        }
    }
    
}
</script>
