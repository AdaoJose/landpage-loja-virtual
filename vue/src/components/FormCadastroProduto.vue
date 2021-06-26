<template>
    <form v-on:submit.prevent="">
        <label v-if="imgs.length<=0" class="div-img bg-dark text-light text-center align-center justifi-center display-flex">
                Selecionar imagem
                <input v-on:change="previwImage" type="file" name="" id="input-img" class="input-img" multiple>
        </label>
        <span class="painel-prev-imgs">
                    <img class="prev-img" v-for="(img, index) of imgs" v-bind:src="img.url" :key="index">
        </span>
        <label class="for-group col-8 mt-5">
            Nome do produto
            <input placeholder="De um bom nome ao seu produto" class="form-control" type="text" v-model="nomeProduto">{{ nomeProduto }}
        </label>

        <label class="form-group col-8 mt-2 row">
            <span class="col-12">Escolhas a categoria a qual o seu produto pertence</span>
            <select class="form-control col select-categoria" v-model="optionsCategoria.categoriaAtualSelecionadaNoSelect">
                <option v-for="(option, index) of optionsCategoria.categoriasAtuais" :key="index">{{ option }}</option> 
            </select>
            <button class="btn btn-primary col-2" type="menu" v-on:click="addCategoria">Ok</button>
            <div class="txt-categoria bg-dark text-light p-2 mt-2" v-if="categoriaSelecionada!=''">{{ categoriaSelecionada }}</div>
        </label>

        <div class="form-group col-12 text-center">
            <div class="div-tamanho-valor mt-4">
                <span class="bg-dark text-light mt-4" v-for="(tamanho, index) of tamanhoValor" :key="index">{{ Object.keys(tamanho)[0] }} : {{ Object.values(tamanho)[0] }}</span>
            </div>
            <label class="col-4">
                tamanho
                <input type="text" placeholder="tamanho" class="form-control" v-model="inputTamanho">
            </label>
            <label class="col-3">
                valor
                <input type="text" placeholder="valor" class="form-control" v-model="inputTamanhoValor">
            </label>
            <button class="btn btn-primary " v-on:click="adicionarTamanho">Ok</button>
        </div>
        <div class="form-group col-12 text-center" v-if="tamanhoValor.length >=1 ">
            <div class="tamanhoQuantidade mt-4">
                <span class="bg-dark text-light m-2" v-for="(quantidade, index) of quantidadeProduto" :key="index"> {{ Object.keys(quantidade)[0] }} :  {{ Object.values(quantidade)[0] }} </span>
            </div>
            <label class="col-4">
                tamanho
                <select class="form-control" v-model="inputsTamanhoQauntidade.tamanho">
                    <option v-for="(tamanho, index) of optionsParaEstoque" :key="index">{{ tamanho }}</option>
                </select>
            </label>
            <label class="col-3">
                Quantidade
                <input class="form-control" type="number" v-model="inputsTamanhoQauntidade.quantidade">
            </label>
            <button class="btn btn-primary" v-on:click="AdicionarQuantidade">Ok</button>
        </div>

        <label class="form-group col-8 mt-3">
            Escolha uma boa descrição para seu produto
            <textarea class="form-control mt-3" placeholder="Uma boa descrição sobre este produto"  rows="8" v-model="descricaoProduto"></textarea>
        </label>

        <button class="btn btn-primary mt-3 mb-5" v-on:click="cadastrarProduto">ADICIONAR PRODUTO</button>
    </form>

</template>

<script>
export default {
    data(){
        return{
            imgs:[],
            nomeProduto:"",
            optionsCategoria: {
                categoriaAtualSelecionadaNoSelect:"",
                subcategorias:{},
                ultimaCategotiaSelecionada:"",
                categoriasAtuais:[]
                },
            categoriaSelecionada: "",
            tamanhoValor: [], /*[{p:2500}, {m:7000}],*/
            inputTamanho: "",
            inputTamanhoValor: "",
            inputsTamanhoQauntidade: {quantidade:1, tamanho:""},
            quantidadeProduto: [], /** [{p:25}]  reflete o estoque disponivel para o produto selecionado*/
            optionsParaEstoque: [],
            descricaoProduto:"",
            inputsOk(){
                if(
                    (this.imgs.length<=0) ||
                    (this.tamanhoValor.length<=0) ||
                    (this.nomeProduto=="") ||
                    (this.categoriaSelecionada=="") ||
                    (this.quantidadeProduto.length<=0) ||
                    (this.descricaoProduto == "")
                ){
                    alert("Todos os campos obigatorio devem ser preenchidos !");
                    return(false);
                }
                
                if(
                    (this.optionsParaEstoque.length>0)
                ){
                    alert("Verifique se foi adicionado as quantidades aos respectivos tamanhos")
                    return(false)
                }
                return(true);
            },
            forJSON(){
                return{
                    "imagens":this.imgs,
                    "tamanho_valor": this.tamanhoValor,
                    "produto": this.nomeProduto,
                    "descricao": this.descricaoProduto,
                    "categoria": this.categoriaSelecionada,
                    "quantidade":this.quantidadeProduto
                }
            }
        }
    },
    methods:{
        previwImage(event){
            var urlTodasImagens = [];
            event.target.files.forEach(element => {
                // console.log(event.target.files);
                const reader = new FileReader();

                reader.addEventListener("load", function () {
                    // convert image file to base64 string
                    // console.log(reader.result);
                    urlTodasImagens.push({url:reader.result});
                    // console.log(this.imgs);
                }, false);

                reader.readAsDataURL(element);
            });
            this.imgs = urlTodasImagens;
            // console.log(this.imgs);
            
        },

        addCategoria(){
            var categoria = this.optionsCategoria.categoriaAtualSelecionadaNoSelect;
            if(!Array.isArray(this.optionsCategoria.subcategorias)){ //array é o utimo elemento da fila por isso verifico se o ultimo item é um array
                
                var subcategoria = this.optionsCategoria.subcategorias[categoria];
                var eUltimo = (!Array.isArray(subcategoria));
                
                this.optionsCategoria.ultimaCategotiaSelecionada = this.optionsCategoria.categoriaAtualSelecionadaNoSelect;
                this.optionsCategoria.categoriasAtuais = eUltimo?Object.keys(subcategoria):subcategoria;
                this.optionsCategoria.subcategorias = subcategoria;
                // console.log(subcategoria);
                this.categoriaSelecionada = (this.categoriaSelecionada=="") ? categoria : this.categoriaSelecionada+ " > " +categoria;
                // document.querySelector(".txt-categoria").scroll(0, 1000);
            }else{
                this.categoriaSelecionada = (this.categoriaSelecionada=="") ? categoria : this.categoriaSelecionada+ " > " +categoria;
                this.optionsCategoria.categoriasAtuais = [];
            }

            // if(!eUltimo){
            //     subcategoria = []
            // }
        },

        adicionarTamanho(){
            
            var obj = {};
            this.optionsParaEstoque.push(this.inputTamanho);
            obj[this.inputTamanho] = this.inputTamanhoValor;
            if(this.inputTamanho != "" && this.inputTamanhoValor != ""){
                this.tamanhoValor.push(obj);
                this.inputTamanho = "";
            this.inputTamanhoValor = "";
            }else{
                alert("Tamanho e valor são obrigatorio!");
            }
            
        },
        AdicionarQuantidade(){
            let obj = {};
            obj[this.inputsTamanhoQauntidade.tamanho] = this.inputsTamanhoQauntidade.quantidade;
            this.quantidadeProduto.push(obj);
            var posicaoARemover = this.optionsParaEstoque.indexOf( this.inputsTamanhoQauntidade.tamanho );
            this.optionsParaEstoque.splice( posicaoARemover, 1 );
        },
        cadastrarProduto(){
            if(!(this.inputsOk())){
                return false;
            }else{
                var jsoProduto = this.forJSON();
                console.log(jsoProduto);
            }
        }
    },
    mounted(){
        fetch('http://localhost:8080/categoria.json')
        .then(response=>response.json())
        .then(e=>{
            this.optionsCategoria.subcategorias = e.categoria
            this.optionsCategoria.categoriasAtuais = Object.keys(e.categoria);
            // console.log(e.categoria);
        })
    }
}
</script>

<style scoped>
    .div-img{
        position: relative;
        width: 80%;
        height: 200px;
        /* background-color: #c2c2c2; */
        display: flex;
        align-content: center;
        justify-content: center;
        align-items: center;
        justify-items: center;
    }
    .div-img input{
        position: absolute;
        height: 100%;
        width: 100%;
        opacity: 0;
    }
    form{
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center; align-content: center;justify-items: center; align-items: center;

    }

    
    .prev-img{
        max-width: 150px;
        margin: 10px;
    }
    .painel-prev-imgs{
        display: flex;
        flex-wrap: wrap;
        
        align-content: stretch;
        align-items: stretch;
        justify-content: center;
        justify-items: center;
    }

    .txt-categoria{
        display: inline;
        flex-wrap: nowrap;
        overflow-y: auto;
        overflow-x: hidden;
        text-overflow: clip;
        max-height: 60px;
        border-radius: 10px;
    }
    
    
    .div-tamanho-valor span, .tamanhoQuantidade span{
        margin: 5px;
        padding: 5px;
        border-radius: 10px;
        text-transform: uppercase;
    }
</style>