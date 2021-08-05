// desenhe um loader de pagamento
// esse componente é responsável por mostrar o pagamento
// e por chamar o metodo de pagamento
// ele é usado no modal de pagamento
<template>
    <div>
        <div class="text-center" v-if="!quantidadeDeCartoens">
            <p>carregando pagamento...</p>
            <div class="spinner-border text-primary text-center" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <MeusCartoes/>


    </div>
</template>

<script>
import MeusCartoes from '../components/MeusCartoes.vue';
export default {
    components:{
        MeusCartoes
    },
    data(){
        return {
            cartoens: ["ola", "mundo"],
            quantidadeDeCartoens: 0
        }
    },
    mounted(){
        this.quantidadeDeCartoens = this.cartoens.length
    }
}
</script>