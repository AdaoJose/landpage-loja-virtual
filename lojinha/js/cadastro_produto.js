
function cadastrar_produto(){
  var $produto = {
    img:[]
  }
  var $imgs = document.querySelectorAll(".imgs > img");
  $imgs.forEach(el=>{
    $produto.img.push(el.getAttribute("src"));
  });
  $produto.nome = document.querySelector("#nome-produto").value;
  $produto.categoria = document.querySelector("#val-categorias").innerText;
  $produto.genero = document.querySelector('input[name="sexo"]:checked').value;
  $produto.tamanho = tamanho_para_json();
  console.log($produto);
  
}


function tamanho_para_json(){
  let $div_tamanho = document.querySelectorAll(".tamanho_valor_val > span");
  let $tamanho = [];
  console.log($div_tamanho);
  $div_tamanho.forEach((element_span)=>{
    $tamanho.push(element_span.innerText);
    console.log(element_span.innerText);
  });
  return($tamanho);
}
var img = document.querySelector("[class='file']");


if(img){
    img.addEventListener('change', (e)=>{
    var files = e.target.files;
    console.log(files);
    
    var fileReader = new FileReader();
    fileReader.onloadend = ()=>{
    var imgRead = document.querySelector('.img');
        // imgRead.setAttribute('src', fileReader.result)
        var imgLoad = document.createElement("img");
        imgLoad.setAttribute("src", fileReader.result);
        document.querySelector('.imgs').prepend(imgLoad);
        // document.querySelector('.uploadImg').textContent = "Selecionar outra imagem";
    }
    fileReader.readAsDataURL(files[0]);
    });
}

var bloco = document.querySelectorAll(".bloco");
console.log(bloco);
bloco.forEach(obj=>{
  obj.classList.add("display-none");
});


var bloco = document.querySelectorAll(".bloco");
var contador = 0;
const btn = document.querySelector(".btn");
var contador = 0;

function proximoBloco(){
  let anterior = contador - 1;
  console.log(bloco.length, contador);
  if(contador >= bloco.length){
    cadastrar_produto();
  }
  if(contador < bloco.length){
    bloco[contador].classList.remove("display-none");
  }
  if(anterior>=0  &&  contador < bloco.length){
    bloco[anterior].classList.add("display-none");
  }
  contador++;
}
console.log(btn);


btn.addEventListener('click', proximoBloco);

proximoBloco();



// ##########CATEGIRIA CONFIGURAÇÃO#################

var $btnCategoria = document.querySelector(".btn-categoria");
$btnCategoria.addEventListener("click",()=>{
  var select = document.querySelector("#categoria");
  var opcaoTexto = select.options[select.selectedIndex].text;
  var val_categoria = document.getElementById("val-categorias");
  val_categoria.innerHTML = (val_categoria.innerText== "")?opcaoTexto:val_categoria.innerText+" > "+opcaoTexto;
});

// ##########TAMANHO VALOR COMPORTAMENTO############

var $btn_tamanho_valor = document.querySelector("#btn_tam_val");
$btn_tamanho_valor.addEventListener("click",()=>{
  let $tamanho = document.getElementById("tamanho").value;
  document.getElementById("tamanho").value = "";
  let $valor = document.getElementById("valor").value;
  document.getElementById("valor").value = "";
  let $saveVal = document.querySelector(".tamanho_valor_val");

  var $newDiv = document.createElement("span");
  $newDiv.append($tamanho+":"+$valor);
  $saveVal.append($newDiv);
  console.log($tamanho, $valor);
});

// ######## TAMANHO ESTOQUE ##########################

var $btn_tamanho_estoque = document.querySelector("#btn_tamanho_estoque");
$btn_tamanho_estoque.addEventListener("click", ()=>{
  let $val_quantidade_em_estoque = document.querySelector("#val_quantidade_em_estoque");
  let $div_quantidade_em_estoque =  $val_quantidade_em_estoque.innerText;
  let $select_tamanho = document.querySelector("#estoque-tamanho");
  // console.log($select_tamanho);
  let $tamanho_selecionado = $select_tamanho.options[$select_tamanho.selectedIndex].text;
  console.log($select_tamanho.selectedIndex);
  let $quantidade_produto_em_estoque = document.querySelector("#quantidade").value;
  let newDiv = document.createElement("span");
  newDiv.append($tamanho_selecionado+" : "+ $quantidade_produto_em_estoque);
  $val_quantidade_em_estoque.append(newDiv);
  
  $select_tamanho.remove($select_tamanho.options[$select_tamanho.selectedIndex]);
  document.querySelector("#quantidade").value  = "";
})

 


