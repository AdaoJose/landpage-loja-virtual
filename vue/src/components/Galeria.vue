<template>
    <div>
        <div id="app" class="images">
            <img class="image" v-for="(image, i) in imgs" :src="image" @click="onClick(i)" :key="i" width="150">
        </div>
        <vue-gallery-slideshow :images="imgs" :index="index" @close="index = null"></vue-gallery-slideshow>
    </div>
</template>
<script>
import VueGallerySlideshow from 'vue-gallery-slideshow'
export default {
    components:{
        VueGallerySlideshow,
    },
    methods: {
    onClick(i) {
      this.index = i;
    }
  },
  props:['imgs'],
    data(){
        return{
            index: 0
        }
    }
    
}
</script>

<style scoped>
    .imgs{
        width: 100%;
        position: relative;
    }
    .image:nth-child(1){
        /* position: absolute; */
    }
    .image:nth-child(2){
        width: 100px !important;
        border: black solid 1px !important;
        /* position: absolute; */
        float: left;
    }
    .image:nth-child(3){
        width: 100px !important;
        border: black solid 1px !important;
        /* position: absolute; */
        float: right;
    }
    .image:nth-child(n + 4){
        display: none;
    }
    
</style>