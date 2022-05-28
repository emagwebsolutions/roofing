    import {classValueSelector} from '../utils/Selectors.js'
    import FormSubmitUtils from '../utils/FormSubmitUtils.js'

    const InputFields = ()=>{
        return {
            username: classValueSelector('username'),
            password: classValueSelector('password')
        }
    }

    document.addEventListener('click', e => {
        if(e.target.matches('.login-btn')){
            const { username,password } = InputFields()
            const {	Loader, ErrorResult} = FormSubmitUtils()

            Loader('output1')

            const fd = new FormData()
            fd.append('data', JSON.stringify({username,password}))

            fetch('router.php?controller=Login&task=signin',{
                method: 'Post',
                body: new URLSearchParams(fd)
            })
            .then(resp => resp.text())
            .then(data => {
                const indx = data.indexOf('error')
                if(indx != -1){
                    ErrorResult('output1',data)
                }
                else{
                    sessionStorage.setItem('zsdf', data)
                    const sess = sessionStorage.getItem('zsdf')
                    if(sess !== data) return ErrorResult('output1','Access denied!')
                    window.location = 'index.php'
                }
            })
        }
 
    }) 
    
    document.addEventListener('keyup', e => {

        if(e.target.matches('.lgn')){
            const { username,password } = InputFields()
            const evry = [username,password].every(v => v)
            if(evry){
                document.querySelector('.button-rounded').style.display = 'block'
            }
            else{
                document.querySelector('.button-rounded').style.display = 'none'
            }
        }


    })


