

document.addEventListener('click', e => {
    if(e.target.matches('.close-modal3')){
        const par = e.target.parentElement.parentElement.parentElement
        par.classList.remove('show')
        document.body.style.overflow = 'scroll'
    }
})

window.addEventListener('click', e => {
    if(e.target.matches('.modal-wrapper3')){
        e.target.classList.remove('show')
        document.body.style.overflow = 'scroll'
    }
})

const ModalDisplayDetails = ( title = '', body='BODY AREA' ) => (
    `
    <div class="modal-wrapper3">
    
        <div class="modal-inner">
            <div class="modal-top">
                <h1 class="modal-heading">${ title }</h1> 
                <a href="javascript:void(0);" class="close-modal2">&times;</a>
            </div>
            <div class="modal-body">
                ${body}
            </div>
        </div>
    </div>
    `
)

export default ModalDisplayDetails