<template>
    <div class="container-fluid">
        <h1>Esta é uma pagina de produtos</h1>
        <main>
    <div class="lista">
      <router-link :to="'produto/'+produto.id" v-for="(produto) of produtos" :key="produto.id" class="col-6 col-sm-3 col-md-2 p-1 border">
        <div class="item"  :id="produto.id">
            <img v-bind:src="produto.item.imagens[0].url">
            <p class="estado-envio">chega em 2 dias</p>
            <p class="descricao"> {{ produto.item.nome }} uma longa descrição para este pruduto</p>
            
            <p class="price">{{ parseInt(menorPreco(produto)).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }) }} <br><small>12x {{(menorPreco(produto)/12).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}}</small></p>
        </div>
      </router-link>

    </div>
  </main>
    </div>
</template>

<script>
import $config from '../assets/config/config'
export default {
    data(){
        return{
            produtos:[],
            localDeEntrega:{
              cidade:"",
              estado:"",
              pais:"",
              rua:"",
              numero:"",
              complemento:"",
              cep:""
            }
            
        }
    },
    mounted(){
      // var header = new Headers();
      var opecaoDeRequisicao = {
          method: 'GET',
          redirect: 'follow'
      }
      fetch($config.URLAPI, opecaoDeRequisicao)
        .then(e=>e.json())
        .then(e=>{
            this.produtos = e.data;
            console.log(e)
        })
        .catch(error=>console.error(error));
      

      if(localStorage.getItem("localDeEntrega") != null){
        this.localDeEntrega = localStorage.getItem("localDeEntrega");
      }
    },
    methods:{
      menorPreco(produto){
        let menor = 0;
        produto.item.tamanho.forEach(element => {
          let chave =  Object.keys(element)
          if (menor==0) menor = element[chave]
          if( menor > element[chave]) menor = element[chave]
          
        });
        return menor
      }
    }
}
</script>
<style scoped>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;0,500;1,300&display=swap');
html, body{
  margin:0px;
  padding:0px;
  box-sizing:border-box;
  font-family: 'Roboto', sans-serif;
}

@media screen and (min-width:720px) {
  .lista > a >div.item > p.descricao{
    font-size: .7rem !important;
  }
}
@media screen and (max-width:720px ) {
  .lista > a >div.item > p.descricao{
    font-weight: bold;
    line-height: 20px;
    color: #666666;
    font-size: 20px;
  }
  .lista > a > div.item .price{
    font-size: 24px !important;
    line-height: 30px;
    font-weight: 400 !important;
    color: rgba(0, 0, 0, .8);
  } 
  .lista > a > div.item .price small{
    font-size: 12px !important;
    font-weight: 300 !important;
  }
}


header{
  background:red;
  grid-area:header;
}

aside{
  background:white;
  grid-area:aside;
}
footer{
  background:black;
  grid-area:footer;
}

.lista{
  display:flex;
  flex-wrap:wrap;
  align-items: stretch;
  justify-content:space-around;
}
.lista > a > div.item{
  background:white;
  border-radius:15px;
  /* padding:10px; */
  font-family: 'Open Sans', sans-serif;
  text-align:center;
  cursor:pointer;
}
.lista > a > div.item > img{
  max-width: 100%;
  border-radius:15px 15px 0px 0px;
  
}

.lista > a > div.item > .price{
  text-align:center;
  font-weight:100;
  font-size:.6rem;
  font-family: 'Open Sans', sans-serif;
}
.lista > a > div.item > p.descricao{
  text-align: left;
  font-size: .6rem;
}

.lista > a > div.item > .estado-envio{
  margin:0px;
  background-color: rgb(255, 239, 229);      
  width: 120px;
  padding: 2px;
  border-radius: 20px;
  position: relative;
  top: -10px;
  color: rgb(251, 79, 8);
  font-weight:bold;
  font-size: .6rem;

}
a{
  text-decoration: none;
}
</style>