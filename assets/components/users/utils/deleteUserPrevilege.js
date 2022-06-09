// deleteUserPrevilege(e)

const deleteUserPrevilege = async (e) => {
    const { menu_id, user_id } = e.target.dataset 

    if(confirm('Are you sure you want to remove!')){
        const f = await fetch(`router.php?controller=User&task=delete_menu&u=${user_id}&m=${menu_id}`)
        e.target.classList.remove('checkClick')
        e.target.removeAttribute('data-menu_id')
        e.target.removeAttribute('data-user_id')
    }
    else{
        e.target.checked = true
    }
}

export default deleteUserPrevilege