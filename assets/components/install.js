function getClass( arg ){
    return document.querySelector(`.${arg}`)?.value 
}

document.querySelector('.install-btn').addEventListener('click', e => {

    const data = {
        dbname: getClass('dbname'),
        dbuser: getClass('dbuser'),
        dbpwd: getClass('dbpwd'),
        firstname: getClass('firstname'),
        lastname: getClass('lastname'),
        email: getClass('email'),
        username: getClass('username'),
        password: getClass('password')
    }


    const keys = Object.values(data).map( v => v).filter(Boolean).length

    e.target.innerHtml = '<i class="fa fa-spinner fa-lg"></i>'

    if( keys < 8){
       e.target.textContent = 'All fields required!'
       return 
    }

    const fd = new FormData()
    fd.append('data',JSON.stringify(data))

    fetch('router.php?controller=Installer&task=install',{
        method: 'Post',
        body: new URLSearchParams(fd)
    })
    .then( resp => resp.text())
    .then( data => {
        const err = data.indexOf('errors')
        if(err != -1){
            e.target.innerHTML = data
            return 
        }
        window.location = '?index.php'
    })

})


document.addEventListener('click', e =>{
    if(e.target.matches('.fminpt')){
        e.target.removeAttribute('readonly')
    }
})


