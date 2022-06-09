
//viewNoteForm(textInput,textArea )

const viewNoteForm = (textInput,textArea ) => (`
    <br><br>
    ${
        textInput({
            type: 'date',
            classname: 'vnotedate',
            required: true,
            label: 'Date'
        })
    }

    ${
        textArea({
            classname: 'vnotemessage',
            placeholder: 'Message'
        })
    }
    <br>
`)

export default viewNoteForm
