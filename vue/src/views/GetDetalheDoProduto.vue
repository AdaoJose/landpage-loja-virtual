<template>
    <div class="col-md-6 center">
        <div class="text-start col-12 p-2 h3">{{nomeProduto}}</div>
        <Galeria :imgs="imagens"/>
        <p class="col-4 text-end float-end"> <small>{{ quantidadeDisponivel }} disponíveis</small></p>
        
        <p class="text-start">tamanho  
            ( <select class="btn text-primary" v-model="tamanhoProdutoSelecionado">
                <option v-for="( tamanho, index) of tamanhosDisponiveis" :key=index>{{tamanho}}</option>
            </select> )
        </p>

        <p class="text-start">{{ parseFloat(valorProduto).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) }}
            <br><small class="text-success">12 X {{ (parseFloat(valorProduto)/12).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) }}</small>
        </p>
        <p>{{descricaoProduto}}</p>
        
        <router-link class="btn btn-primary col-12" :to="'/pagamento/'+idProduto">Comprar</router-link>
        
    </div>
</template>

<script>
import $config from '../assets/config/config.js'
import Galeria from '../components/Galeria.vue'
export default {
    components:{
        Galeria,
    },
    
    data(){
        return{
            idProduto: this.$route.params.idProduto,
            imagens:[],
            nomeProduto:"",
            valorProduto:0.00,
            quantidadeDisponivel:0,
            tamanhosProduto:[],
            descricaoProduto:"",
            tamanhoProdutoSelecionado:undefined,
            tamanhosDisponiveis:[],
        }
    },
    watch:{
        tamanhoProdutoSelecionado(){
            this.montarProduto(this.produtoJson.item);
        }
    },
    mounted(){
        fetch($config.URLAPI+"/"+this.idProduto)
            .then(e=>e.json())
            .then(e=>{
                this.produtoJson = e
                console.log(e)
                this.montarProduto(e.item);
                this.nomeProduto = e.item.nome
                this.descricaoProduto = e.item.descricao
                this.imagens = e.item.imagens.map(imagem=>{
                    return imagem.url
                })
                console.log(this.imagens);
            })
            .catch(e=>console.log(e))
    },
    methods:{
        montarProduto(item){
            if(!this.tamanhoProdutoSelecionado){
                this.tamanhoProdutoSelecionado = Object.keys(this.menorValor(item))[0]
                this.valorProduto = ( Object.values(this.menorValor(item))[0] )
                let qtdDisponivel
                this.quantidadeDisponivel = item.quantidade.forEach(element => {
                    console.log(this.tamanhoProdutoSelecionado);
                    if(Object.keys(element)[0] == this.tamanhoProdutoSelecionado) qtdDisponivel = Object.values(element)[0]
                });
                this.quantidadeDisponivel = qtdDisponivel
                this.tamanhosDisponiveis = this.getTamanhosDisponiveis(item)
            }else{
                this.valorProduto = this.getValorProduto(item)
                let qtdDisponivel
                this.quantidadeDisponivel = item.quantidade.forEach(element => {
                    if(Object.keys(element)[0] == this.tamanhoProdutoSelecionado) qtdDisponivel = Object.values(element)[0]
                });
                this.quantidadeDisponivel = qtdDisponivel
                
            }
            
        },
        getValorProduto(item){
            return Object.values(item.tamanho.filter(tamanho=>{
                return Object.keys(tamanho)[0] === this.tamanhoProdutoSelecionado;
            })[0]) [0];
        },
        getTamanhosDisponiveis(item){
            let tamanhosDisponiveis = []
            item.tamanho.forEach(element=>{
                tamanhosDisponiveis.push(Object.keys(element)[0])
            })
            return tamanhosDisponiveis
        },
        menorValor(item){
            let menor = 0;
            let menorChave = "";
            let retorno = {}
            item.tamanho.forEach(element => {
            let chave =  Object.keys(element)
            if (menor==0) 
            {
                menor = element[chave]
                menorChave = chave
            }
            if( menor > element[chave]) 
            {
                menor = element[chave]
                menorChave = chave
            }
            
            });
            retorno[menorChave] = menor
            return retorno
      }
    }
}
</script>





<style scoped>
.center {
    margin-right:auto ;
    margin-left:auto ;
}
</style>