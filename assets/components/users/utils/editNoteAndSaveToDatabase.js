
// editNoteAndSaveToDatabase(
//     classSelector,
//     getUsers,
//     populateUserTabs,
//     Error,
//     Success,
//     Table,
//     formatDate
// )

const editNoteAndSaveToDatabase = async (
    classSelector,
    getUsers,
    populateUserTabs,
    Error,
    Success,
    Table,
    formatDate
) => {
    const fd = new FormData()
    const note_id = classSelector('noteid').value
    const user_id = classSelector('uid').value

    fd.append('note_id', note_id)
    fd.append('message', classSelector('notemessage').value)
    fd.append('date', classSelector('notedate').value)

    const resp = await fetch('router.php?controller=Note&task=edit_note',
    {
        method: 'Post',
        body: new URLSearchParams(fd)
    })

    const data = await resp.text()

    if( data.indexOf('errors') != -1 ){
        Error('addNoteModalClass', data)
    }
    else{
        Success('addNoteModalClass',data,'modal-wrapper2')
        getUsers( data => {
            populateUserTabs(classSelector,data,Table,formatDate,user_id)
        })
    }
}

export default editNoteAndSaveToDatabase