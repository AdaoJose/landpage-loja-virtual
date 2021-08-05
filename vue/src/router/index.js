import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import cadastroProduto from '../views/cadastroProduto.vue'
import Usuario from '../views/Usuario.vue'
import ExpositorDeProduto from '../views/ExpositorDeProduto.vue'
import Login from '../views/Login.vue'
import Sair from '../views/Sair.vue'
import GetDetalheDoProduto from '../views/GetDetalheDoProduto.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/user/:usuario',
    name:'Usuario',
    component:Usuario
  },
  {
    path:'/user/:usuario/product/:produto',
    name:"ExpositorDeProduto",
    component:ExpositorDeProduto
  },
  {
    path: '/produtos',
    name: 'Produtos',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "produtos" */ '../views/Produtos.vue')
  },
  {
    path:'/produto/:idProduto',
    name:'DetalheDoProduto',
    component:GetDetalheDoProduto
  },
  {
    path: '/user/:user/new/product',
    name: 'cadastroProduto',
    component: cadastroProduto
  },
  {
    path:"/login/sair",
    name:"logout",
    component:Sair
  },
  {
    path:"/login",
    name:"Login",
    component:Login
  },
  {
    path:'/pagamento/:idProduto',
    name:'Pagamento',
    component:() => import(/* webpackChunkName: "pagamento" */ '../views/Pagamento.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
