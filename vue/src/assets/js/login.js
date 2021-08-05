
    import $config from '../config/config.js'

export default{ 
    logado(){
        if(localStorage.userKey){
            var $userRequest = JSON.parse(localStorage.userKey)
            $userRequest.appKey = $config.appKey
            var $options  = {
                "method":"PUT",
                "body":JSON.stringify($userRequest)
            }
            return fetch($config.URLAPI+"/login", $options)
                .then(e=>e.json())
                .then(e=>{
                    if(e.error) throw new Error("Usuario não esta logado")
                    $userRequest.userKey = e.userKey
                    $userRequest.expiration = e.expiration
                    delete $userRequest.appKey
                    localStorage.userKey = JSON.stringify($userRequest)
                    console.log(JSON.parse(localStorage.userKey))
                    return $userRequest
                })
                .catch(e=>{
                    console.log(e)
                    
                })
        }else{
            return false;
        }
    }
}
   