<template>
    <div>
        <h1>Esta é a pagina de exposição de produto unitário<br> <small>Aqui ficará exposto os produtos de forma a permitir a compra do usuario</small></h1>
        {{$route.params.usuario}} : {{ $route.params.produto }}
    </div>
</template>