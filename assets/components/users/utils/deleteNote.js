

// deleteNote(
//     e,
//     getUsers,
//     classSelector,
//     populateUserTabs,
//     Table,
//     formatDate
// )

const deleteNote = (
    e,
    getUsers,
    classSelector,
    populateUserTabs,
    Table,
    formatDate
) => {
    const  id  = e.target.dataset.id
    const user_id = classSelector('uid').value

    if(confirm('Are you sure you want to delete!')){
        fetch(`router.php?controller=Note&task=delete_note&note_id=${id}`)

        getUsers( data => {
            populateUserTabs(classSelector,data,Table,formatDate,user_id)
        })
    }
    else{ }

}

export default deleteNote