<template>
    <div></div>
</template>
<script>
export default {
    mounted(){
        localStorage.removeItem("userKey")
        this.$router.push('/login')
    }
}
</script>
